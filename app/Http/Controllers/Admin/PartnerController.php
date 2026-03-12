<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = User::where('role', 'PARTNER')->with('employeeDetail')->latest()->get();
        return view('partner.pages.index', compact('partners'));
    }

    public function show(User $partner)
    {
        $partner->load('employeeDetail', 'employeeDocuments');
        return view('partner.pages.show', compact('partner'));
    }

    public function approve(User $partner)
    {
        $partner->update(['status' => 'APPROVED']);
        return back()->with('success', 'Partner application approved.');
    }

    public function reject(User $partner)
    {
        $partner->update(['status' => 'REJECTED']);
        return back()->with('success', 'Partner application rejected.');
    }

    public function pending(User $partner)
    {
        $partner->update(['status' => 'PENDING']);
        return back()->with('success', 'Partner application set to pending.');
    }

    public function destroy(User $partner)
    {
        $partner->delete();
        return back()->with('success', 'Partner deleted successfully.');
    }

}
