<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $leads
        ]);
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'mobile_number' => 'required|string',
            'loan_type' => 'required|string',
            'city' => 'nullable|string',
            'monthly_yield' => 'nullable|numeric',
            'vehicle_make' => 'nullable|string',
            'vehicle_model' => 'nullable|string',
            'mfg_year' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'asset_value' => 'nullable|numeric',
            'pan_number' => 'nullable|string',
            'aadhaar_number' => 'nullable|string',
        ]);

        $documents = [];
        if ($request->has('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store('leads/documents', 'public');
                $documents[$key] = Storage::url($path);
            }
        }

        $rcDocuments = [];
        if ($request->has('rc_documents')) {
            foreach ($request->file('rc_documents') as $key => $file) {
                $path = $file->store('leads/rc', 'public');
                $rcDocuments[$key] = Storage::url($path);
            }
        }

        $lead = Lead::create([
            ...$validated,
            'user_id' => Auth::id(),
            'documents' => $documents,
            'rc_documents' => $rcDocuments,
            'status' => 'OPEN',
            'loan_amount' => $request->asset_value ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully and synced with terminal.',
            'data' => $lead
        ], 201);
    }

   
    public function show(Lead $lead)
    {
        if ($lead->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $lead
        ]);
    }

   
    public function update(Request $request, Lead $lead)
    {
        if ($lead->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'customer_name' => 'sometimes|required|string',
            'mobile_number' => 'sometimes|required|string',
            'loan_type' => 'sometimes|required|string',
            'city' => 'nullable|string',
            'monthly_yield' => 'nullable|numeric',
            'status' => 'sometimes|required|string',
            'vehicle_make' => 'nullable|string',
            'vehicle_model' => 'nullable|string',
            'mfg_year' => 'nullable|string',
            'fuel_type' => 'nullable|string',
            'asset_value' => 'nullable|numeric',
            'pan_number' => 'nullable|string',
            'aadhaar_number' => 'nullable|string',
        ]);

        // Handle new documents if provided
        if ($request->hasFile('documents')) {
            $documents = (array)$lead->documents;
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store('leads/documents', 'public');
                $documents[$key] = Storage::url($path);
            }
            $lead->documents = $documents;
        }

        if ($request->hasFile('rc_documents')) {
            $rcDocuments = (array)$lead->rc_documents;
            foreach ($request->file('rc_documents') as $key => $file) {
                $path = $file->store('leads/rc', 'public');
                $rcDocuments[$key] = Storage::url($path);
            }
            $lead->rc_documents = $rcDocuments;
        }

        $lead->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lead updated successfully',
            'data' => $lead
        ]);
    }

    
    public function destroy(Lead $lead)
    {
        if ($lead->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $lead->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lead deleted successfully'
        ]);
    }
}
