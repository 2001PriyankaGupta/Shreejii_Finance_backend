<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmployeeDetail;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeWelcomeMail;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'EMPLOYEE')->with('employeeDetail')->latest()->get();
        return view('employee.pages.index', compact('employees'));
    }

    public function create()
    {
        return view('employee.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'salary' => 'nullable|numeric',
            'designation' => 'nullable|string|max:255',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar_url')) {
            $avatarPath = $request->file('avatar_url')->store('avatars', 'public');
        }

        // Generate Employee ID (EMP-001, EMP-002...)
        $lastEmployee = User::whereNotNull('employee_id')
            ->where('employee_id', 'LIKE', 'EMP-%')
            ->orderBy('id', 'desc')
            ->first();

        $nextId = 1;
        if ($lastEmployee) {
            $lastId = (int) str_replace('EMP-', '', $lastEmployee->employee_id);
            $nextId = $lastId + 1;
        }
        $employeeId = 'EMP-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'employee_id' => $employeeId,
            'role' => 'EMPLOYEE',
            'avatar_url' => $avatarPath,
            'password' => Hash::make('password'), // Static password for now
        ]);

        EmployeeDetail::create([
            'user_id' => $user->id,
            'salary' => $request->salary,
            'joining_date' => $request->joining_date,
            'designation' => $request->designation,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'emergency_contact' => $request->emergency_contact,
            'address' => $request->address,
        ]);

        // Send Welcome Email
        try {
            Mail::to($user->email)->send(new EmployeeWelcomeMail($user));
        } catch (\Exception $e) {
            // Log error or handle silently to not break user creation
        }

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(User $employee)
    {
        $employee->load(['employeeDetail', 'employeeDocuments']);
        return view('employee.pages.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $employee->load('employeeDetail');
        return view('employee.pages.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'phone' => 'required|string|max:15|unique:users,phone,' . $employee->id,
            'salary' => 'nullable|numeric',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar_url')) {
            // Delete old avatar if exists
            if ($employee->avatar_url) {
                Storage::disk('public')->delete($employee->avatar_url);
            }
            $avatarPath = $request->file('avatar_url')->store('avatars', 'public');
            $employee->avatar_url = $avatarPath;
            $employee->save();
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $employee->employeeDetail()->updateOrCreate(
            ['user_id' => $employee->id],
            [
                'salary' => $request->salary,
                'joining_date' => $request->joining_date,
                'designation' => $request->designation,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
            ]
        );

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function uploadDocument(Request $request, User $employee)
    {
        $request->validate([
            'type' => 'required|string',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('document')->store('employee_documents', 'public');

        EmployeeDocument::create([
            'user_id' => $employee->id,
            'type' => $request->type,
            'document_number' => $request->document_number,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function deleteDocument(EmployeeDocument $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Document deleted successfully.');
    }
}
