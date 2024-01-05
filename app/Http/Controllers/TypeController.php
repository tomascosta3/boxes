<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Save a new type to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_type(Request $request)
    {
        // Validate the request (customize as per your needs)
        $request->validate([
            'type' => ['required'],
        ]);

        // Save the new type to the database
        $new_type = Type::create([
            'type' => $request->input('type'),
        ]);

        // Get all updated types after saving
        $types = Type::where('active', true)
            ->orderBy('type', 'asc')
            ->get();

        // Return a JSON response with the updated types
        return response()->json(['types' => $types]);
    }

}
