<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WalletTransaction;

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

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();

        if ($user->role === 'PARTNER' || $user->role === 'EMPLOYEE') {
            $user->load('employeeDetail');
            if ($user->employeeDetail) {
                if (!$user->bank_name) $user->bank_name = $user->employeeDetail->bank_name;
                if (!$user->account_number) $user->account_number = $user->employeeDetail->account_number;
                if (!$user->ifsc_code) $user->ifsc_code = $user->employeeDetail->ifsc_code;
            }
        }

        // Check if user has bank details
        if (!$user->bank_name || !$user->account_number || !$user->ifsc_code) {
            return response()->json([
                'success' => false,
                'message' => 'Please update your bank details before requesting a withdrawal.'
            ], 400);
        }

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

        // Create a PENDING debit transaction
        $transaction = WalletTransaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'type' => 'DEBIT',
            'description' => 'Withdrawal to Bank',
            'status' => 'PENDING',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request submitted successfully! It will be processed soon.',
            'data' => $transaction
        ]);
    }
}
