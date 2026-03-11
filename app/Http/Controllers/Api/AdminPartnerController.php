<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPartnerController extends Controller
{
    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:APPROVED,REJECTED,PENDING',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::find($request->user_id);
        $user->update(['status' => $request->status]);

        return response()->json([
            'message' => "Partner status updated to {$request->status}",
            'user' => $user
        ]);
    }
}
