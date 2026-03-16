<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'inquiry_type' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $inquiry = Inquiry::create($request->all());

        // Notify Admin
        \App\Models\Notification::create([
            'user_id' => null, // Admin
            'title' => 'New Support Inquiry',
            'message' => "Received a new {$request->inquiry_type} inquiry from {$request->first_name} {$request->last_name}.",
            'type' => 'INQUIRY'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Inquiry submitted successfully',
            'data' => $inquiry
        ], 201);
    }
}
