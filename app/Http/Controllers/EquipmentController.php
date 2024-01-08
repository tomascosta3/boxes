<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Equipment;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        // Retrieve all active clients from database.
        $clients = Client::where('active', true)
            ->orderBy('last_name', 'asc')
            ->get();

        // Pass the active types to the equipment creation view.
        return view('equipments.create')
            ->with(['types' => $types])
            ->with(['clients' => $clients]);
    }


    /**
     * Store a new equipment based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form inputs. If there is an error, return back with the errors.
        $validated = $request->validateWithBag('create', [
            'type' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'serial_number' => ['required'],
            'client' => ['required'],
            'observations' => ['nullable'],
        ]);

        // Create a new equipment with the provided data.
        $equipment = $this->create_equipment($request);

        // Check if the equipment was created successfully.
        if (!$equipment->id) {
            // If creation fails, flash an error message.
            session()->flash('problem', 'No se pudo crear el equipo');
        } else {
            // Flash a success message.
            session()->flash('success', 'Equipo creado correctamente');
        }

        // Redirect to the equipment creation route.
        return to_route('equipments.create');
    }


    /**
     * Create a new equipment with the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Equipment
     */
    private function create_equipment(Request $request) : Equipment
    {
        return Equipment::create([
            'client_id' => $request->input('client'),
            'type_id' => $request->input('type'),
            'brand_id' => $request->input('brand'),
            'model_id' => $request->input('model'),
            'serial_number' => $request->input('serial_number'),
            'observations' => $request->input('observations'),
            'created_by' => auth()->user()->id,
        ]);
    }


    /**
     * Generate unique serial number.
     *
     * @return string Unique serial number.
     */
    public function generate_unique_serial_number()
    {
        do {
            // Generate serial number.
            $serial_number = Str::random(20);
        } while (Equipment::where('serial_number', $serial_number)->exists());

        // Return a JSON response with the updated types
        return response()->json(['serialNumber' => $serial_number]);
    }
}
