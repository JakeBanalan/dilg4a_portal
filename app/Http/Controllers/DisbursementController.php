<?php

namespace App\Http\Controllers;

use App\Models\Disbursement;
use Illuminate\Http\Request;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = ($perPage > 0 && $perPage <= 100) ? $perPage : 10;

        // Use caching to optimize repeated queries
        $cacheKey = "disbursements_page_{$request->query('page', 1)}_per_page_{$perPage}";
        $disbursements = cache()->remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
            return Disbursement::select('ID', 'dv', 'ors', 'payee', 'particular', 'amount', 'net', 'status')
                ->withoutTrashed() // Exclude soft-deleted records
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage);
        });

        return response()->json($disbursements);
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
        $validatedData = $request->validate([
            'dv_number' => 'required|string|max:255',
            'payee' => 'required|string|max:255',
            'particular' => 'required|string|max:255',
            'obligated_amount' => 'required|numeric|min:0',
            'total_deductions' => 'required|numeric|min:0',
            'net_amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:255',
            'lddap_entries' => 'array',
            'lddap_entries.*.lddap_number' => 'required|string|max:255',
            'lddap_entries.*.lddap_date' => 'required|date',
            'lddap_entries.*.lddap_balance' => 'required|numeric|min:0',
            'lddap_entries.*.disburse_amount' => 'required|numeric|min:0',
        ]);
    
        $disbursement = Disbursement::create([
            'dv' => $validatedData['dv_number'],
            'payee' => $validatedData['payee'],
            'particular' => $validatedData['particular'],
            'amount' => $validatedData['obligated_amount'],
            'total' => $validatedData['total_deductions'],
            'net' => $validatedData['net_amount'],
            'remarks' => $validatedData['remarks'] ?? null,
        ]);
    
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
            'dv' => 'string|max:255',
            'ors' => 'string|max:255',
            'payee' => 'string|max:255',
            'particular' => 'string|max:255',
            'amount' => 'numeric|min:0',
            'tax' => 'numeric|min:0',
            'gsis' => 'numeric|min:0',
            'pagibig' => 'numeric|min:0',
            'philhealth' => 'numeric|min:0',
            'other' => 'numeric|min:0',
            'total' => 'numeric|min:0',
            'net' => 'numeric|min:0',
            'datereleased' => 'date',
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
