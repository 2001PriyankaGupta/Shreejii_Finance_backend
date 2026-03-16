<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    public function downloadPdf()
    {
        $customers = User::where('role', 'CUSTOMER')->latest()->get();
        $pdf = Pdf::loadView('pdf.customers', compact('customers'));
        return $pdf->download('Shreeja_Customers_' . now()->format('YmdHis') . '.pdf');
    }

    public function index()
    {
        $customers = User::where('role', 'CUSTOMER')->latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'CUSTOMER')->findOrFail($id);
        // Load related data if needed
        $customer->load(['loans', 'leads']);
        return view('admin.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'CUSTOMER')->findOrFail($id);
        $customer->delete();
        return back()->with('success', 'Customer deleted successfully.');
    }

    public function updateLoanStatus(Request $request, $id)
    {
        $loan = \App\Models\Loan::findOrFail($id);
        $request->validate([
            'status' => 'required|in:PENDING,APPROVED,REJECTED,DISBURSED'
        ]);

        $loan->update([
            'status' => $request->status
        ]);

        // Create Notification for User
        \App\Models\Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Loan Status Updated',
            'message' => "Your {$loan->loan_type} loan request (#LN-{$loan->id}) state has been shifted to {$request->status}.",
            'type' => 'LOAN'
        ]);

        return back()->with('success', 'Loan status updated successfully.');
    }

    public function getNotifications()
    {
        $notifications = \App\Models\Notification::latest()->get();
        // Mark admin notifications as read
        \App\Models\Notification::whereNull('user_id')->where('is_read', false)->update(['is_read' => true]);
        return view('admin.notifications.index', compact('notifications'));
    }
}
