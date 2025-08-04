<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResolutionModel;
use Illuminate\Support\Facades\Validator;

class ResolutionController extends Controller
{
    public function fetchResolutionByAbstract($abstract_id)
    {
        $resolution = ResolutionModel::where('abstract_id', $abstract_id)->latest()->first();
        if (!$resolution) {
            return response()->json(['message' => 'No resolution found for this abstract'], 404);
        }
        return response()->json($resolution);
    }

    public function fetchResolution()
    {
        $resolution = ResolutionModel::latest()->first();
        if (!$resolution) {
            return response()->json(['message' => 'No resolutions found'], 404);
        }
        return response()->json($resolution);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'abstract_id' => 'required|integer|exists:tbl_abstract,id',
            'rfq_id' => 'nullable|integer|exists:tbl_rfq,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $resolution = ResolutionModel::create([
                'reso_no' => $request->reso_no ?? null,
                'abstract_id' => $request->abstract_id,
                'rfq_id' => $request->rfq_id ?? null,
                'reso_date' => now(),
                'reso_content' => $request->content,
            ]);

            return response()->json([
                'message' => 'Resolution saved successfully',
                'data' => $resolution,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to save resolution',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'abstract_id' => 'required|integer|exists:tbl_abstract,id',
            'rfq_id' => 'nullable|integer|exists:tbl_rfq,id',
            'reso_no' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Find the existing resolution by ID
            $resolution = ResolutionModel::find($id);

            if (!$resolution) {
                return response()->json(['message' => 'Resolution not found'], 404);
            }

            // Update the resolution with new data
            $resolution->update([
                'reso_no' => $request->reso_no ?? $resolution->reso_no,
                'abstract_id' => $request->abstract_id,
                'rfq_id' => $request->rfq_id ?? $resolution->rfq_id,
                'reso_date' => $request->reso_date ? now() : $resolution->reso_date, // Only update date if provided
                'reso_content' => $request->content,
            ]);

            return response()->json([
                'message' => 'Resolution updated successfully',
                'data' => $resolution->fresh(), // Return the updated record
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update resolution',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
