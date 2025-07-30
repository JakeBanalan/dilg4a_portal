<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResolutionModel;

class ResolutionController extends Controller
{
    public function PostResolution(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|array', // Quill Delta JSON
        ]);

        $resolution = new ResolutionModel([
            'id' => null, // let DB auto-increment
            'reso_content' => $validated['content'],
        ]);

        $resolution->save();

        return response()->json([
            'message' => 'Resolution saved successfully',
            'id' => $resolution->id
        ]);
    }

    public function fetchResolution($id)
    {
        $resolution = ResolutionModel::findOrFail($id);
        return response()->json($resolution);
    }
}
