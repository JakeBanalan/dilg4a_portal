<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Disbursement;
use Illuminate\Http\Request;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = ($perPage > 0 && $perPage <= 100) ? $perPage : 10;

        $page = $request->query('page', 1);

        try {
            $disbursements = Disbursement::select('ID', 'dv', 'ors', 'payee', 'particular', 'amount', 'net', 'status')
                ->withoutTrashed()
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage);
            return response()->json($disbursements);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function show($id)
    {
        $disbursement = Disbursement::find($id);

        if (!$disbursement) {
            return response()->json(['message' => 'Disbursement not found'], 404);
        }

        return response()->json($disbursement);
    }

    public function store(Request $request)
    {
        // STEP 1: Add the missing fields to the validation rules.
        $validatedData = $request->validate([
            'dv_number' => 'required|string|max:255',
            'payee' => 'required|string|max:255',
            'particular' => 'required|string|max:255',
            'obligated_amount' => 'required|numeric|min:0',
            'total_deductions' => 'required|numeric|min:0',
            'net_amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
            'tax' => 'required|numeric|min:0',           // <-- Add this
            'gsis' => 'required|numeric|min:0',          // <-- Add this
            'pagibig' => 'required|numeric|min:0',       // <-- Add this
            'philhealth' => 'required|numeric|min:0',    // <-- Add this
            'other_payables' => 'required|numeric|min:0', // <-- Add this
            'lddap_entries' => 'array',
            'lddap_entries.*.lddap_number' => 'required|string|max:255',
            'lddap_entries.*.lddap_date' => 'required|date',
            'lddap_entries.*.lddap_balance' => 'required|numeric|min:0',
            'lddap_entries.*.disburse_amount' => 'required|numeric|min:0',
        ]);

        // STEP 2: Add the missing fields to the create() call.
        // Make sure the key on the left matches your database column name.
        $disbursement = Disbursement::create([
            'dv' => $validatedData['dv_number'],
            'payee' => $validatedData['payee'],
            'particular' => $validatedData['particular'],
            'amount' => $validatedData['obligated_amount'],
            'tax' => $validatedData['tax'],                 // <-- Add this
            'gsis' => $validatedData['gsis'],               // <-- Add this
            'pagibig' => $validatedData['pagibig'],         // <-- Add this
            'philhealth' => $validatedData['philhealth'],   // <-- Add this
            'other' => $validatedData['other_payables'], // <-- Add this (assuming db column is 'other')
            'total' => $validatedData['total_deductions'],
            'net' => $validatedData['net_amount'],
            'remarks' => $validatedData['remarks'] ?? null,
        ]);

        // This part for LDDAP entries is correct and doesn't need changes.
        if (isset($validatedData['lddap_entries'])) {
            foreach ($validatedData['lddap_entries'] as $entry) {
                $disbursement->lddapEntries()->create($entry);
            }
        }

        return response()->json([
            'message' => 'Disbursement created successfully',
            'disbursement' => $disbursement,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $disbursement = Disbursement::find($id);

        if (!$disbursement) {
            return response()->json(['message' => 'Disbursement not found'], 404);
        }

        $validatedData = $request->validate([
            'dv' => 'nullable|string|max:255',
            'ors' => 'nullable|string|max:255',
            'payee' => 'nullable|string|max:255',
            'particular' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'gsis' => 'nullable|numeric|min:0',
            'pagibig' => 'nullable|numeric|min:0',
            'philhealth' => 'nullable|numeric|min:0',
            'other' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'net' => 'nullable|numeric|min:0',
            'datereleased' => 'nullable|date',
            'timereleased' => '',
            'remarks' => 'nullable|string|max:255',
            'status' => 'string|max:255',
        ]);

        if ($request->has('lddap_entries')) {
            // Remove old entries
            $disbursement->lddapEntries()->delete();
            // Add new entries
            foreach ($request->lddap_entries as $entry) {
                $disbursement->lddapEntries()->create($entry);
            }
        }

        $disbursement->update($validatedData);

        return response()->json([
            'message' => 'Disbursement updated successfully',
            'disbursement' => $disbursement, // Return updated disbursement
        ]);
    }

    public function destroy($id)
    {
        $disbursement = Disbursement::find($id);

        if (!$disbursement) {
            return response()->json(['message' => 'Disbursement not found'], 404);
        }

        try {
            // Use soft delete (recommended) - this will set deleted_at timestamp
            $disbursement->delete();

            // Clear related cache entries
            cache()->forget('disbursements_page_1_per_page_10');

            return response()->json(['message' => 'Disbursement deleted successfully']);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to delete disbursement: ' . $e->getMessage()], 500);
        }
    }

    public function restore($id)
    {
        $disbursement = Disbursement::onlyTrashed()->find($id);

        if (!$disbursement) {
            return response()->json(['message' => 'Disbursement not found'], 404);
        }

        try {
            // Restore the soft-deleted record
            $disbursement->restore();
            return response()->json(['message' => 'Disbursement restored successfully']);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Failed to restore disbursement: ' . $e->getMessage()], 500);
        }
    }
}
