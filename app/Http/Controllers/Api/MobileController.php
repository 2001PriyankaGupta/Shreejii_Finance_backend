<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use App\Models\Lead;
use App\Models\Task;
use App\Models\WalletTransaction;
use App\Models\AppSetting;
use App\Models\PhoneOtp;
use App\Models\EliteApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MobileController extends Controller
{
    // --- AUTH ---

    public function sendEliteOtp(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->phone) {
            return response()->json(['message' => 'Valid phone number not found'], 400);
        }

        $phone = $user->phone;
        $otpCode = (string)rand(100000, 999999);
        
        DB::table('phone_otps')->where('phone', $phone)->delete();
        DB::table('phone_otps')->insert([
            'phone' => $phone,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("Elite Handshake OTP issued for $phone: $otpCode");

        return response()->json([
            'message' => 'Verification code sent',
            'phone' => (string)$phone,
            'otp_simulated' => (string)$otpCode
        ]);
    }

    public function login(Request $request)
    {
        // Check if it's an employee login (email/password) - Keeping existing just in case
        if ($request->has('email') && $request->has('password')) {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('mobile_app')->plainTextToken;
            return response()->json([
                'session' => [
                    'access_token' => $token,
                ],
                'user_id' => $user->id,
                'role' => $user->role,
                'status' => $user->status,
                'user' => $user
            ]);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable',
            'identifier' => 'nullable', // NEW: Support for EMP-ID or Phone
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ident = trim($request->identifier ?? $request->phone);
        
        Log::info("Login attempt - Identifier: $ident");

        if (!$ident) {
            return response()->json(['error' => 'Identifier required'], 422);
        }

        // Search by phone or employee_id
        $user = User::where('phone', $ident)
                    ->orWhere('employee_id', $ident)
                    ->orWhere('email', $ident)
                    ->first();

        if (!$user) {
            Log::warning("Identity NOT FOUND for: $ident");
            return response()->json(['message' => 'Identity not found. Please verify details.'], 404);
        }

        $phone = $user->phone;

        if (!$phone) {
             return response()->json(['message' => 'No mobile number linked to this account.'], 400);
        }

        // Generate 6-digit OTP
        $otpCode = (string)rand(100000, 999999);
        
        // Save OTP to DB using direct DB facade for maximum reliability
        DB::table('phone_otps')->where('phone', $phone)->delete();
        $otpCreated = DB::table('phone_otps')->insert([
            'phone' => $phone,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!$otpCreated) {
            Log::error("Failed to insert PhoneOtp record for $phone via DB Facade");
            return response()->json(['message' => 'Internal server error. Could not issue OTP.'], 500);
        }

        Log::info("PhoneOtp record inserted via DB Facade for $phone");

        return response()->json([
            'message' => 'OTP sent to your mobile number (Simulated)',
            'phone' => (string)$phone,
            'otp_simulated' => (string)$otpCode,
            'role' => $user->role // Help frontend know which role is logging in
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        Log::info("Verification attempt - Phone: {$request->phone}, OTP: {$request->otp}");

        // Check OTP in DB using DB Facade
        $otpRecord = DB::table('phone_otps')
            ->where('phone', (string)$request->phone)
            ->where('otp', (string)$request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            Log::warning("Verification failed - No matching OTP found for Phone: {$request->phone}, OTP: {$request->otp}");
            return response()->json(['message' => 'Invalid or expired OTP'], 401);
        }

        Log::info("Verification successful for Phone: {$request->phone}");

        // Clear OTP
        DB::table('phone_otps')->where('id', $otpRecord->id)->delete();

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

            $token = $user->createToken('mobile_app')->plainTextToken;

        return response()->json([
            'session' => [
                'access_token' => $token,
            ],
            'user_id' => $user->id,
            'role' => $user->role,
            'status' => $user->status,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Phone number already registered'], 422);
        }

        // Create the user entry so OTP verification works
        User::create([
            'phone' => $request->phone,
            'name' => $request->name ?? 'New User',
            'email' => $request->email ?? null,
            'role' => $request->role ?? 'CUSTOMER', // Use provided role or default to CUSTOMER
            'password' => Hash::make(Str::random(10)), // Generate a random password
        ]);

        // Generate 6-digit OTP
        $otpCode = rand(100000, 999999);
        
        // Save OTP to DB
        PhoneOtp::where('phone', $request->phone)->delete();
        PhoneOtp::create([
            'phone' => $request->phone,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(10),
        ]);

        return response()->json([
            'message' => 'Registration successful. OTP sent.',
            'phone' => $request->phone,
            'otp_simulated' => $otpCode
        ]);
    }

    public function createProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'nullable|email',
            'role' => 'required',
            'location' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user->update([
            'name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role,
            'location' => $request->location,
        ]);

        return response()->json([
            'message' => 'Profile created successfully',
            'profile' => $user
        ]);
    }

    // --- USER PROFILE ---

    public function getProfile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Authentication session invalid'], 401);
        }

        if ($user->role === 'PARTNER') {
            $user->load('employeeDetail');
        }

        // Add aliases for frontend compatibility
        $user->full_name = $user->name;
        
        // Priority: employeeDetail->address > location['address'] > location(formatted)
        $displayAddress = 'N/A';
        if ($user->employeeDetail && $user->employeeDetail->address) {
            $displayAddress = $user->employeeDetail->address;
        } elseif (is_array($user->location)) {
            if (isset($user->location['address'])) {
                $displayAddress = $user->location['address'];
            } elseif (isset($user->location['latitude']) && isset($user->location['longitude'])) {
                $displayAddress = "Lat: " . round($user->location['latitude'], 4) . ", Long: " . round($user->location['longitude'], 4);
            }
        } elseif (is_string($user->location) && $user->location !== '') {
            $displayAddress = $user->location;
        }

        $user->address = $displayAddress;
        
        // Ensure avatar_url is a full URL if it's just a path
        if ($user->avatar_url && !str_starts_with($user->avatar_url, 'http')) {
            $user->avatar_url = asset('storage/' . $user->avatar_url);
        }

        return response()->json([
            'profile' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        if ($request->has('full_name')) {
            $user->name = $request->full_name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('address')) {
            $user->location = ['address' => $request->address];
            
            // Sync to employee_details if partner
            if ($user->role === 'PARTNER') {
                DB::table('employee_details')
                    ->where('user_id', $user->id)
                    ->update(['address' => $request->address, 'updated_at' => now()]);
            }
        }

        // Support both 'image' and 'avatar_url' keys as requested
        $file = $request->file('image') ?: $request->file('avatar_url');

        if ($file) {
            // Delete old avatar if it's a local path
            if ($user->avatar_url && !str_starts_with($user->avatar_url, 'http')) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            
            // Store in the same 'avatars' folder as admin
            $path = $file->store('avatars', 'public');
            $user->avatar_url = $path; // Store only relative path in DB
        }

        $user->save();

        // Prepare response with aliases and full URL
        $user->full_name = $user->name;
        
        $displayAddress = 'N/A';
        if ($user->role === 'PARTNER') {
            $user->load('employeeDetail');
            $displayAddress = $user->employeeDetail->address ?? 'N/A';
        } elseif (is_array($user->location)) {
            $displayAddress = $user->location['address'] ?? 'N/A';
        }
        $user->address = $displayAddress;
        
        if ($user->avatar_url && !str_starts_with($user->avatar_url, 'http')) {
            $user->avatar_url = asset('storage/' . $user->avatar_url);
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $user
        ]);
    }

    public function updateProfileImage(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $user->avatar_url = asset('storage/' . $path);
            $user->save();
            
            return response()->json([
                'message' => 'Profile image updated',
                'avatar_url' => $user->avatar_url
            ]);
        }

        return response()->json(['message' => 'No image provided'], 400);
    }

    // --- LOANS ---

    public function applyLoan(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'loan_type' => 'required',
            'loan_amount' => 'required|numeric',
            'tenure' => 'required',
            'employment_status' => 'required',
            'monthly_income' => 'required',
            'customer_name' => 'required',
            'pan_number' => 'required',
            'pan_image' => 'nullable|file',
            'aadhaar_front_image' => 'nullable|file',
            'aadhaar_back_image' => 'nullable|file',
            'bank_statement' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = $request->only([
            'loan_type', 'loan_amount', 'tenure', 'employment_status', 
            'employer_name', 'monthly_income', 'existing_emis', 
            'city', 'current_city', 'customer_name', 
            'pan_number', 'aadhaar_number'
        ]);
        
        $data['user_id'] = $user->id;
        $data['status'] = 'PENDING';

        // Handle file uploads securely
        $fileFields = ['pan_image', 'aadhaar_front_image', 'aadhaar_back_image', 'bank_statement'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('loans/' . $user->id, 'public');
                $data[$field] = $path; // Store relative path
            }
        }

        $loan = Loan::create($data);

        // --- NEW: SEND NOTIFICATIONS ---
        
        // 1. To Customer
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title' => 'Loan Application Received',
            'message' => "Your application for a " . strtoupper($request->loan_type) . " loan of ₹" . $request->loan_amount . " is under review. Protocol ID: " . $loan->id,
            'type' => 'LOAN'
        ]);

        // 2. To Employees/Partners (Logically they might need to see it, for now system-wide)
        \App\Models\Notification::create([
            'user_id' => null, // Broadcast to all for now or filter by role in real app
            'title' => 'New Loan Application',
            'message' => "Customer {$user->name} has applied for a {$request->loan_type} loan.",
            'type' => 'ADMIN'
        ]);

        return response()->json([
            'message' => 'Loan application submitted successfully',
            'application' => $loan
        ]);
    }

    public function getNotifications()
    {
        $userId = Auth::id();
        $notifications = \App\Models\Notification::where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereNull('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 per page

        return response()->json([
            'notifications' => $notifications->items(),
            'pagination' => [
                'total' => $notifications->total(),
                'per_page' => $notifications->perPage(),
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
            ]
        ]);
    }

    public function getMyLoans(Request $request)
    {
        $query = Loan::where('user_id', Auth::id());

        if ($request->has('loan_type')) {
            $query->where('loan_type', $request->loan_type);
        }

        return response()->json([
            'loans' => $query->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function getEliteApplications()
    {
        $apps = EliteApplication::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'applications' => $apps
        ]);
    }

    // --- LEADS ---

    public function getLeads()
    {
        return response()->json([
            'leads' => Lead::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function createLead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'mobile_number' => 'required',
            'loan_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $lead = Lead::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'mobile_number' => $request->mobile_number,
            'loan_amount' => $request->loan_amount,
            'status' => 'OPEN',
        ]);

        return response()->json([
            'message' => 'Lead created successfully',
            'lead' => $lead
        ]);
    }

    // --- TASKS ---

    public function getTasks()
    {
        return response()->json([
            'tasks' => Task::where('user_id', Auth::id())->orderBy('due_date', 'asc')->get()
        ]);
    }

    // --- WALLET ---

    public function getWallet()
    {
        $transactions = WalletTransaction::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $balance = $transactions->where('type', 'CREDIT')->sum('amount') - $transactions->where('type', 'DEBIT')->sum('amount');

        return response()->json([
            'balance' => $balance,
            'transactions' => $transactions
        ]);
    }

    // --- APP SETTINGS / DYNAMIC CONTENT ---
    
    public function submitEliteApplication(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'score' => 'nullable',
            'interest_rate' => 'nullable',
            'loan_limit' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $application = EliteApplication::create([
            'user_id' => $user->id,
            'score' => $request->score,
            'interest_rate' => $request->interest_rate,
            'loan_limit' => $request->loan_limit,
            'status' => 'PENDING'
        ]);

        // Notify Admin
        \App\Models\Notification::create([
            'user_id' => null,
            'title' => 'ELITE PROTOCOL UNLOCKED',
            'message' => "Customer {$user->name} has authorized Elite Handshake. Interest Unlocked: {$request->interest_rate}%",
            'type' => 'ADMIN'
        ]);

        return response()->json([
            'message' => 'Elite Application Successful. Transmission verified.',
            'application' => $application
        ]);
    }

    public function getSettings()
    {
        return response()->json([
            'settings' => AppSetting::all()->pluck('value', 'key')
        ]);
    }
}
