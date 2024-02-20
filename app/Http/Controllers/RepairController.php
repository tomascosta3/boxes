<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    /**
     * Display repairs index view.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Contracts\View
     */
    public function index(Request $request): View
    {
        // Get search parameters from the request.
        $search = $request->input('search');
        $search_option = $request->input('search_option');

        // If both search and search option are defined, perform a filtered search for repairs.
        if ($search && $search_option) {
            $repairs = $this->search_repairs($search, $search_option);
        } else {
            // If no search parameters are provided, retrieve all active repairs.
            $repairs = $this->get_all_active_repairs();
        }

        // Return the repairs index view with the repairs data.
        return view('repairs.index')->with(['repairs' => $repairs]);
    }


    /**
     * Retrieve all active clients.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function get_all_active_repairs() : Collection
    {
        // Retrieve all active clients.
        return Repair::where('active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
