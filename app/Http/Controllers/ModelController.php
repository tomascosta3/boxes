<?php

namespace App\Http\Controllers;

use App\Models\EquipmentModel;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Save a new model to the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_model(Request $request)
    {
        // Validate the request (customize as per your needs)
        $request->validate([
            'model' => ['required'],
            'brand_id' => ['required']
        ]);

        // Save the new model to the database
        $new_model = EquipmentModel::create([
            'brand_id' => $request->input('brand_id'),
            'model' => $request->input('model')
        ]);

        // Get updated models after saving that belongs to brand_id.
        $models = EquipmentModel::where('active', true)
            ->where('brand_id', $request->input('brand_id'))
            ->orderBy('model', 'asc')
            ->get();

        // Return a JSON response with the updated brands
        return response()->json(['models' => $models]);
    }
    

    /**
     * Get models that belong to the specified brand id.
     *
     * @param int $id Brand id.
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_models_by_brand($id)
    {
        try {
            // Get all updated models after saving
            $models = EquipmentModel::where('active', true)
                ->where('brand_id', $id)
                ->orderBy('model', 'asc')
                ->get();

            return response()->json(['models' => $models]);
        } catch (\Exception $e) {
            // Handle internal server error
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
