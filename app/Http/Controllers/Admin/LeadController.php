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
        
        $query = Lead::with('user');

        if ($request->has('employee_id') && $request->employee_id != '') {
            $query->where('user_id', $request->employee_id);
        }

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $leads = $query->latest()->get();

        return view('admin.leads.index', compact('leads', 'employees'));
    }

    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => 'required|in:OPEN,PENDING,APPROVED,REJECTED'
        ]);

        $lead->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Lead status updated to ' . $request->status);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead purged successfully.');
    }
}
