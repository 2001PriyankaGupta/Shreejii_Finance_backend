<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = WalletTransaction::with('user.employeeDetail')
            ->where('type', 'DEBIT')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.wallet.index', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:COMPLETED,FAILED'
        ]);

        $transaction = WalletTransaction::with('user.employeeDetail')->findOrFail($id);
        
        // --- RAZORPAY / CASHFREE PAYOUT INTEGRATION ---
        if ($request->status === 'COMPLETED') {
            try {
                $user = $transaction->user;
                $key = env('RAZORPAY_KEY');
                $secret = env('RAZORPAY_SECRET');
                
                // User's Bank Details are now loaded automatically via the model mutators we created.
                $bankName = $user->bank_name;
                $accountNumber = $user->account_number;
                $ifsc = $user->ifsc_code;
                
                if (!$bankName || !$accountNumber || !$ifsc) {
                    throw new \Exception("User missing bank details. Transaction cannot be requested for automated payout.");
                }
                
                // Step 1: Create Contact in RazorpayX
                $contactRes = \Illuminate\Support\Facades\Http::withBasicAuth($key, $secret)
                    ->post('https://api.razorpay.com/v1/contacts', [
                        'name' => $user->name,
                        'email' => $user->email,
                        'contact' => $user->phone,
                        'type' => 'employee'
                    ]);
                    
                if (!$contactRes->successful()) {
                    throw new \Exception("Contact creation failed: " . $contactRes->body());
                }
                
                $contactId = $contactRes->json()['id'];
                
                // Step 2: Create Fund Account (Bank Account)
                $fundRes = \Illuminate\Support\Facades\Http::withBasicAuth($key, $secret)
                    ->post('https://api.razorpay.com/v1/fund_accounts', [
                        'contact_id' => $contactId,
                        'account_type' => 'bank_account',
                        'bank_account' => [
                            'name' => $user->name,
                            'ifsc' => $ifsc,
                            'account_number' => $accountNumber
                        ]
                    ]);
                    
                if (!$fundRes->successful()) {
                    throw new \Exception("Fund account creation failed: " . $fundRes->body());
                }
                
                $fundAccountId = $fundRes->json()['id'];
                
                // Step 3: Trigger Payout
                // Uses test RazorpayX account number or default dummy '7878780080316316' for sandbox
                $payoutRes = \Illuminate\Support\Facades\Http::withBasicAuth($key, $secret)
                    ->post('https://api.razorpay.com/v1/payouts', [
                        // Replace with your real RazorpayX virtual account generated from dashboard
                        'account_number' => env('RAZORPAYX_ACCOUNT_NUMBER', '7878780080316316'), 
                        'fund_account_id' => $fundAccountId,
                        'amount' => $transaction->amount * 100, // Amount in paise
                        'currency' => 'INR',
                        'mode' => 'IMPS',
                        'purpose' => 'payout',
                        'queueIfLowBalance' => true
                    ]);
                    
                if (!$payoutRes->successful()) {
                    throw new \Exception("Payout failed: " . $payoutRes->body());
                }

                \Illuminate\Support\Facades\Log::info("Razorpay payout created: " . $payoutRes->json()['id']);
                
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Razorpay Payout Error: " . $e->getMessage());
                // Stop the process and inform the admin of the API error.
                return back()->with('error', 'API Payout Error: ' . $e->getMessage());
            }
        }

        $transaction->update(['status' => $request->status]);

        // Send a notification to the user
        $message = $request->status == 'COMPLETED' 
            ? "Your withdrawal of ₹ {$transaction->amount} has been successfully credited to your bank account via Automated Payout."
            : "Your withdrawal of ₹ {$transaction->amount} has failed. The amount remains in your wallet.";

        \App\Models\Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Withdrawal ' . ucfirst(strtolower($request->status)),
            'message' => $message,
            'type' => 'WALLET'
        ]);

        return back()->with('success', 'Withdrawal status updated & ' . ($request->status == 'COMPLETED' ? 'payout triggered' : 'rejected') . ' successfully.');
    }
}
