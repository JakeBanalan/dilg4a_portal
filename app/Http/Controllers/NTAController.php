<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NTA;

class NTAController extends Controller
{
    public function fetchAll(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = ($perPage > 0 && $perPage <= 100) ? $perPage : 10;

        // ✅ 2) You can scope to user if needed:
        // $ntas = NTA::where('user_id', auth()->id())->paginate($perPage);

        // If all users can see all NTAs (e.g., admin tool), remove this scope.
        $ntas = NTA::orderBy('date_created', 'desc')->paginate($perPage);

        return response()->json($ntas);
    }

    public function fetchById($id)
    {
        $nta = NTA::find($id);

        if (!$nta) {
            return response()->json(['message' => 'NTA not found'], 404);
        }

        // ✅ If needed, check authorization:
        // if ($nta->user_id !== auth()->id()) {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        return response()->json($nta);
    }

    public function show($id)
    {
        $nta = NTA::find($id);

        if (!$nta) {
            return response()->json(['message' => 'NTA not found'], 404);
        }

        return response()->json($nta);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nta_number' => 'required|string|max:255',
            'saro_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'particular' => 'required|string',
            'quarter' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
        ]);

        $validatedData['created_by'] = auth()->id();
        $validatedData['date_created'] = now();
        $validatedData['status'] = 0;
        $validatedData['is_lock'] = 0;

        $nta = NTA::create($validatedData);

        return response()->json(['message' => 'NTA created successfully', 'nta' => $nta], 201);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nta_number' => 'required|string|max:255',
            'saro_number' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'particular' => 'required|string',
            'quarter' => 'required|string|max:255',
            'amount' => 'required|integer|min:0',
        ]);

        $validatedData['created_by'] = auth()->id();
        $validatedData['date_created'] = now();
        $validatedData['status'] = 0;
        $validatedData['is_lock'] = 0;

        $nta = NTA::create($validatedData);

        return response()->json(['message' => 'NTA created successfully', 'nta' => $nta], 201);
    }
}
