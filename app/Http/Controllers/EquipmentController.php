<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\EquipmentModel;
use App\Models\Image;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function search_equipments($search, $search_option)
    {
        // Initialize equipments variable.
        $equipments = collect();

        // Search for equipments based on the specified search option.
        if($search_option == 'type') {
            // Search for types that match the search criteria.
            $types = Type::where('type', 'LIKE', "%$search%")
                ->where('active', true)
                ->get();

            // Get the IDs of the matching types.
            $types_ids = $types->pluck('id')->toArray();

            if($types_ids !== null) {
                // Retrieve equipments based on the matching type IDs.
                $equipments = Equipment::where('active', true)
                    ->whereIn('type_id', $types_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        } else if($search_option == 'brand') {
            // Search for brands that match the search criteria.
            $brands = Brand::where('brand', 'LIKE', "%$search%")
                ->where('active', true)
                ->get();

            // Get the IDs of the matching brands.
            $brands_ids = $brands->pluck('id')->toArray();

            if($brands_ids !== null) {
                // Retrieve equipments based on the matching brand IDs.
                $equipments = Equipment::where('active', true)
                    ->whereIn('brand_id', $brands_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        
        } else if($search_option == 'model') {
            // Search for models that match the search criteria.
            $models = EquipmentModel::where('model', 'LIKE', "%$search%")
                ->where('active', true)
                ->get();

            // Get the IDs of the matching models.
            $models_ids = $models->pluck('id')->toArray();

            if($models_ids !== null) {
                // Retrieve equipments based on the matching models IDs.
                $equipments = Equipment::where('active', true)
                    ->whereIn('model_id', $models_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        
        } else if($search_option == 'serial_number') {
            // Search for equipments with the specified serial number.
            $equipments = Equipment::where('serial_number', 'LIKE', "%$search%")
                ->where('active', true)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        
        } else if($search_option == 'client') {
            // Search for clients that match the search criteria.
            $clients = Client::where('active', true)
                ->whereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                ->get();

            // Get the IDs of the matching clients.
            $clients_ids = $clients->pluck('id')->toArray();

            if($clients_ids !== null) {
                // Retrieve equipments based on the matching client IDs.
                $equipments = Equipment::where('active', true)
                    ->whereIn('client_id', $clients_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        }

        return $equipments;
    }


    /**
     * Retrieve all active equipments.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function get_all_active_equipments()
    {
        // Retrieve all active equipments.
        return Equipment::where('active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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
        $equipment = Equipment::create([
            'client_id' => $request->input('client'),
            'type_id' => $request->input('type'),
            'brand_id' => $request->input('brand'),
            'model_id' => $request->input('model'),
            'serial_number' => $request->input('serial_number'),
            'observations' => $request->input('observations'),
            'created_by' => auth()->user()->id,
        ]);

        $this->create_images($equipment, $request);

        return $equipment;
    }


    private function create_images(Equipment $equipment, Request $request) {
        // Obtiene la imagen en base64 desde la solicitud
        $images = $request->input('images');

        foreach($images as $imgBase64) {
            
            // Elimina el encabezado de tipo y espacios en blanco
            $img = str_replace('data:image/png;base64,', '', $imgBase64);
            $img = str_replace(' ', '+', $img);
    
            // Decodifica los datos base64
            $data = base64_decode($img);
    
            // Ruta donde se guardarán las imágenes
            $uploadDir = public_path('storage/equipments/');
    
            // Asegúrate de que el directorio exista, si no, créalo
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Nombre único para el archivo
            $filename = 'equipment_' . $equipment->id . '_' . Str::uuid() . '.png';
    
            // Ruta completa del archivo
            $filePath = $uploadDir . $filename;
    
            // Guarda la imagen en el servidor
            $success = file_put_contents($filePath, $data);

            Image::create([
                'equipment_id' => $equipment->id,
                'path' => 'equipments/' . $filename,
                'created_by' => auth()->user()->id,
            ]);
        }
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
            $serial_number = strtoupper(Str::random(15));
        } while (Equipment::where('serial_number', $serial_number)->exists());

        // Return a JSON response with the updated types
        return response()->json(['serialNumber' => $serial_number]);
    }
}
