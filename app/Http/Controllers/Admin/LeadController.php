<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('role', 'EMPLOYEE')->get();
        $partners = User::where('role', 'PARTNER')->get();
        
        $query = Lead::with('user');

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        // Backward compatibility for employee_id if any old links exist
        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->where('user_id', $request->employee_id);
        }

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $leads = $query->latest()->get();

        return view('admin.leads.index', compact('leads', 'employees', 'partners'));
    }

    public function disbursements()
    {
        $leads = Lead::where('status', 'APPROVED')
            ->with(['user', 'walletTransactions'])
            ->latest()
            ->get();
            
        return view('admin.leads.disbursements', compact('leads'));
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => 'required|in:OPEN,PENDING,APPROVED,REJECTED',
            'disbursed_amount' => 'nullable|numeric',
            'tenure_months' => 'nullable|integer',
            'commission_override' => 'nullable|numeric'
        ]);

        $oldStatus = $lead->status;
        
        $updateData = ['status' => $request->status];
        if ($request->has('disbursed_amount') && $request->disbursed_amount != '') {
            $updateData['disbursed_amount'] = $request->disbursed_amount;
        }
        if ($request->has('tenure_months') && $request->tenure_months != '') {
            $updateData['tenure_months'] = $request->tenure_months;
        }

        $lead->update($updateData);

        // Commission Logic: If lead changed to APPROVED, grant commission
        if ($oldStatus !== 'APPROVED' && $request->status === 'APPROVED') {
            // Priority: Override > Formula (Default logic)
            $commissionAmount = $request->commission_override;

            if (!$commissionAmount) {
                // Default slab-based commission if no override or formula provided
                $commissionAmount = match(strtoupper($lead->loan_type)) {
                    'PERSONAL' => 1500,
                    'HOME' => 5000,
                    'VEHICLE' => 2000,
                    'BUSINESS' => 3000,
                    default => 1000,
                };
            }

            \App\Models\WalletTransaction::create([
                'user_id' => $lead->user_id,
                'amount' => $commissionAmount,
                'type' => 'CREDIT',
                'description' => $lead->id, // Store Lead ID for reference
                'status' => 'COMPLETED'
            ]);

            \App\Models\Notification::create([
                'user_id' => $lead->user_id,
                'title' => 'Commission Earned! 🎉',
                'message' => "You have earned ₹{$commissionAmount} commission for Lead #{$lead->id} conversion.",
                'type' => 'WALLET'
            ]);
        }

        return redirect()->back()->with('success', 'Lead status updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead purged successfully.');
    }
}
