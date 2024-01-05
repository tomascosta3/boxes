<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display equipments index view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        // Get search parameters from the request.
        $search = $request->input('search');
        $search_option = $request->input('search_option');

        // If both search and search option are defined, perform a filtered search for equipments.
        if ($search && $search_option) {
            $equipments = $this->search_equipments($search, $search_option);
        } else {
            // If no search parameters are provided, retrieve all active equipments.
            $equipments = $this->get_all_active_equipments();
        }

        // Return the equipments index view with the equipments data.
        return view('equipments.index')->with(['equipments' => $equipments]);
    }


    /**
     * Search for filtered equipments based on the provided search parameters.
     *
     * @param  string  $search
     * @param  string  $search_option
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function search_equipments($search, $search_option) : Collection
    {
        // Initialize equipments variable.
        $equipments = collect();

        // Search for equipments based on the specified search option.


        return $equipments;
    }


    /**
     * Retrieve all active equipments.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function get_all_active_equipments() : Collection
    {
        // Retrieve all active equipments.
        return Equipment::where('active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    /**
     * Display equipment creation view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View 
    {
        // Retrieve all active types from the database.
        $types = Type::where('active', true)
            ->orderBy('type', 'asc')
            ->get();

        // Pass the active types to the equipment creation view.
        return view('equipments.create')->with(['types' => $types]);
    }
}
