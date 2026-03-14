<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WalletTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalCredit = $transactions->where('type', 'CREDIT')->where('status', 'COMPLETED')->sum('amount');
        $totalDebit = $transactions->where('type', 'DEBIT')->where('status', '!=', 'FAILED')->sum('amount');
        
        $availableLiquidity = $totalCredit - $totalDebit;

        return response()->json([
            'success' => true,
            'available_liquidity' => $availableLiquidity,
            'transactions' => $transactions->map(function ($tx) {
                return [
                    'id' => $tx->id,
                    'type' => $tx->type,
                    'amount' => $tx->amount,
                    'title' => $tx->description,
                    'date' => $tx->created_at->format('M d, Y'),
                    'time' => $tx->created_at->format('h:i A'),
                    'status' => $tx->status
                ];
            })
        ]);
    }

    public function downloadStatement(Request $request)
    {
        // Simple manual token check for public URL access from mobile Linking
        $token = $request->query('token');
        if (!$token) return response()->json(['message' => 'Unauthorized'], 401);

        $tokenRecord = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (!$tokenRecord) return response()->json(['message' => 'Invalid Token'], 401);

        $user = $tokenRecord->tokenable;
        
        $transactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $startDate = $transactions->isEmpty() ? now() : $transactions->last()->created_at;
        $endDate = $transactions->isEmpty() ? now() : $transactions->first()->created_at;

        $totalCredit = $transactions->where('type', 'CREDIT')->where('status', 'COMPLETED')->sum('amount');
        $totalDebit = $transactions->where('type', 'DEBIT')->where('status', '!=', 'FAILED')->sum('amount');
        $balance = $totalCredit - $totalDebit;

        $pdf = Pdf::loadView('pdf.wallet_statement', compact('user', 'transactions', 'balance', 'startDate', 'endDate'));
        
        return $pdf->download('Shreeji_Statement_' . now()->format('YmdHis') . '.pdf');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();

        // Calculate current balance
        $totalCredit = WalletTransaction::where('user_id', $user->id)->where('type', 'CREDIT')->where('status', 'COMPLETED')->sum('amount');
        $totalDebit = WalletTransaction::where('user_id', $user->id)->where('type', 'DEBIT')->where('status', '!=', 'FAILED')->sum('amount');
        $availableLiquidity = $totalCredit - $totalDebit;

        if ($request->amount > $availableLiquidity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient liquidity for this withdrawal.'
            ], 400);
        }

        // --- RAZORPAY PAYOUT LINK INTEGRATION ---
        try {
            $key = config('services.razorpay.key');
            $secret = config('services.razorpay.secret');
            $payoutAccount = config('services.razorpay.payout_account');

            if (!$key || !$secret) {
                throw new \Exception("Razorpay credentials (Key/Secret) are missing in system configuration.");
            }

            $response = \Illuminate\Support\Facades\Http::withBasicAuth($key, $secret)
                ->post('https://api.razorpay.com/v1/payout-links', [
                    'account_number' => $payoutAccount, 
                    'contact' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'contact' => $user->phone,
                        'type' => 'customer'
                    ],
                    'amount' => $request->amount * 100, // Amount in paise
                    'currency' => 'INR',
                    'purpose' => 'payout',
                    'description' => "Withdrawal request for {$user->name}",
                    'receipt' => 'rec_' . time(),
                    'send_sms' => true,
                    'send_email' => true
                ]);

            if (!$response->successful()) {
                throw new \Exception("Razorpay Error: " . $response->body());
            }

            $payoutLink = $response->json();

            // Create a PENDING debit transaction with payout link data
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'DEBIT',
                'description' => 'Withdrawal via Payout Link',
                'status' => 'PENDING',
                'payout_link_id' => $payoutLink['id'],
                'payout_link_url' => $payoutLink['short_url']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payout Gateway link generated! Please complete the transfer on Razorpay.',
                'payout_url' => $payoutLink['short_url'],
                'data' => $transaction
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Payout Link Creation Failed: " . $e->getMessage());
            
            // Fallback to manual request if API fails (optional, but keep it robust)
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'DEBIT',
                'description' => 'Withdrawal (Manual Request)',
                'status' => 'PENDING',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal request submitted manually (API busy). Administration will process it soon.',
                'data' => $transaction
            ]);
        }
    }
}
