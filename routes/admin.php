<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeadController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\WalletController;

Route::resource('employees', EmployeeController::class);
Route::get('employees-download-pdf', [EmployeeController::class, 'downloadPdf'])->name('employees.download-pdf');
Route::post('employees/{employee}/approve', [EmployeeController::class, 'approve'])->name('employees.approve');
Route::post('employees/{employee}/reject', [EmployeeController::class, 'reject'])->name('employees.reject');
Route::post('employees/{employee}/pending', [EmployeeController::class, 'pending'])->name('employees.pending');
Route::post('employees/{employee}/upload-document', [EmployeeController::class, 'uploadDocument'])->name('employees.upload-document');
Route::delete('employee-documents/{document}', [EmployeeController::class, 'deleteDocument'])->name('employees.delete-document');

// Leads Management
Route::get('leads/disbursements', [LeadController::class, 'disbursements'])->name('leads.disbursements');
Route::get('leads-download-pdf', [LeadController::class, 'downloadPdf'])->name('leads.download-pdf');
Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
Route::get('leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
Route::put('leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');

// Partner Management
Route::get('partners-download-pdf', [PartnerController::class, 'downloadPdf'])->name('partners.download-pdf');
Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
Route::get('partners/{partner}', [PartnerController::class, 'show'])->name('partners.show');
Route::post('partners/{partner}/approve', [PartnerController::class, 'approve'])->name('partners.approve');
Route::post('partners/{partner}/reject', [PartnerController::class, 'reject'])->name('partners.reject');
Route::post('partners/{partner}/pending', [PartnerController::class, 'pending'])->name('partners.pending');
Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');

// Customer Management
Route::get('customers-download-pdf', [CustomerController::class, 'downloadPdf'])->name('customers.download-pdf');
Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
Route::patch('loans/{loan}/status', [CustomerController::class, 'updateLoanStatus'])->name('loans.updateStatus');
Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

// Inquiry Management
Route::get('inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
Route::get('inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
Route::delete('inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

// Message Management
Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('messages/{id}', [MessageController::class, 'show'])->name('messages.show');
Route::post('messages/{id}/reply', [MessageController::class, 'reply'])->name('messages.reply');

// Notifications for Admin
Route::get('notifications', [CustomerController::class, 'getNotifications'])->name('notifications.index');

// Elite Protocol Management
Route::get('elite-protocol', function() {
    return view('admin.elite.index');
})->name('elite.index');
Route::post('elite-protocol/{id}/status', function($id, \Illuminate\Http\Request $request) {
    $app = \App\Models\EliteApplication::findOrFail($id);
    $app->update(['status' => $request->status]);

    // Notify user
    \App\Models\Notification::create([
        'user_id' => $app->user_id,
        'title' => 'Elite Protocol Update',
        'message' => "Your Credit Shield status has been updated to: " . $request->status,
        'type' => 'ELITE'
    ]);

    return back()->with('success', 'Status updated successfully.');
})->name('elite.update-status');

// Wallet Management
Route::get('wallet-download-pdf', [WalletController::class, 'downloadPdf'])->name('wallet.download-pdf');
Route::get('wallet', [WalletController::class, 'index'])->name('wallet.index');
Route::post('wallet/{id}/status', [WalletController::class, 'updateStatus'])->name('wallet.updateStatus');
