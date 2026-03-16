<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhoneOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnerAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Phone number is required'], 422);
        }

        // --- NEW: CLEANUP INCOMPLETE ATTEMPTS ---
        $existingUser = User::where('phone', $request->phone)->first();
        if ($existingUser) {
            // If already approved/active, don't let them register again
            if ($existingUser->status !== 'SIGNUP_INCOMPLETE') {
                return response()->json([
                    'error' => 'Mobile number already registered. Please login to your account.'
                ], 403);
            }

            // If incomplete, delete partial profile data and user to start fresh as requested
            DB::table('employee_details')->where('user_id', $existingUser->id)->delete();
            $existingUser->delete();
        }

        $user = User::create([
            'phone' => $request->phone,
            'name' => 'New Partner',
            'role' => 'PARTNER',
            'status' => 'SIGNUP_INCOMPLETE', // Don't show in admin yet
            'password' => Hash::make(Str::random(10)),
        ]);

        $otpCode = rand(100000, 999999);
        
        PhoneOtp::where('phone', $request->phone)->delete();
        PhoneOtp::create([
            'phone' => $request->phone,
            'otp' => $otpCode,
            'expires_at' => now()->addMinutes(10),
        ]);

        return response()->json([
            'message' => 'Partner registration successful. OTP sent.',
            'phone' => $request->phone,
            'otp_simulated' => $otpCode
        ]);
    }

    /**
     * Terminate and delete an incomplete signup (Called when user clicks BACK to start)
     */
    public function resetRegistration(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->role === 'PARTNER' && $user->status === 'SIGNUP_INCOMPLETE') {
            DB::table('employee_details')->where('user_id', $user->id)->delete();
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Registration sequence terminated. Entry deleted.']);
        }
        return response()->json(['error' => 'No active incomplete registration sequence found.'], 404);
    }

    public function createProfile(Request $request)
    {
        Log::info('Create Partner Profile Request:', $request->all());
        $user = Auth::user();
        
        $data = $request->all();
        if (isset($data['bank_details']) && is_string($data['bank_details'])) {
            $data['bank_details'] = json_decode($data['bank_details'], true);
        }
        if (isset($data['references']) && is_string($data['references'])) {
            $data['references'] = json_decode($data['references'], true);
        }

        $validator = Validator::make($data, [
            'full_name' => 'required',
            'business_name' => 'required',
            'bank_details' => 'array',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for partner profile:', $validator->errors()->toArray());
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Update basic user
        $user->update([
            'name' => $request->full_name,
            'role' => 'PARTNER',
            'status' => 'PENDING',
            'location' => $request->location,
        ]);

        // Use the decoded data from $data array
        $bank = $data['bank_details'] ?? [];
        $refs = $data['references'] ?? [];

        $docPaths = [];
        $docFields = ['pan_identity' => 'panIdentity', 'aadhaar_front' => 'aadhaarFront', 'aadhaar_back' => 'aadhaarBack', 'live_handshake' => 'liveHandshake', 'business_identity' => 'businessIdentity', 'banking_proof' => 'bankingProof'];

        foreach ($docFields as $dbField => $reqField) {
            if ($request->hasFile($reqField)) {
                $docPaths[$dbField] = $request->file($reqField)->store('partner_docs', 'public');
            } else {
                $docPaths[$dbField] = null;
            }
        }

        // Insert or update employee_details
        DB::table('employee_details')->updateOrInsert(
            ['user_id' => $user->id],
            array_merge([
                'business_name' => $request->business_name,
                'referral_code' => $request->referral_code,
                'address' => $request->address,
                'bank_name' => $bank['bank_name'] ?? null,
                'account_number' => $bank['account_number'] ?? null,
                'ifsc_code' => $bank['ifsc_code'] ?? null,
                'account_holder' => $bank['account_holder'] ?? null,
                'reference_1_name' => $refs['ref1_name'] ?? null,
                'reference_1_phone' => $refs['ref1_phone'] ?? null,
                'reference_2_name' => $refs['ref2_name'] ?? null,
                'reference_2_phone' => $refs['ref2_phone'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ], $docPaths)
        );

        // Notify Admin of new partner signup
        \App\Models\Notification::create([
            'user_id' => null, // Admin
            'title' => 'New Partner Signup',
            'message' => "Partner {$user->name} ({$request->business_name}) has completed registration and is pending approval.",
            'type' => 'PARTNER'
        ]);

        return response()->json([
            'message' => 'Partner profile created successfully. Under review.',
            'profile' => $user
        ]);
    }

    // Admin endpoint to manage partners
    public function getPartners()
    {
        // Must be moved to an AdminController ideally, but we will create a separate AdminPartnerController
        // as per user instruction "dashboard ka ek new controller file bna lena"
    }
}
