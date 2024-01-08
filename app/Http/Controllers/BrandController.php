<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Type;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Save a new brand to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_brand(Request $request)
    {
        // Validate the request (customize as per your needs).
        $request->validate([
            'brand' => ['required'],
            'type_id' => ['required']
        ]);

        // Save the new brand to the database.
        $new_brand = Brand::create([
            'type_id' => $request->input('type_id'),
            'brand' => $request->input('brand')
        ]);

        // Get updated brands after saving that belong to type_id.
        $brands = Brand::where('active', true)
            ->where('type_id', $request->input('type_id'))
            ->orderBy('brand', 'asc')
            ->get();

        // Return a JSON response with the updated brands.
        return response()->json(['brands' => $brands]);
    }


    /**
     * Get brands that belong to the specified type id.
     *
     * @param int $id Type id.
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_brands_by_type($id)
    {
        try {
            // Get all updated brands after saving.
            $brands = Brand::where('active', true)
                ->where('type_id', $id)
                ->orderBy('brand', 'asc')
                ->get();

            return response()->json(['brands' => $brands]);
        } catch (\Exception $e) {
            // Handle internal server error.
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
