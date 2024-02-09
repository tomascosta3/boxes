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
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        if (!$equipment || !$equipment->id) {
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
    private function create_equipment(Request $request) : ?Equipment
    {
        // Verify if serial number is already in database.
        $existing_equipment = Equipment::where('serial_number', $request->input('serial_number'))->first();

        if ($existing_equipment) {
            // If exists, return null.
            return null;
        }

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


    /**
     * Create images and associate them with equipment.
     *
     * @param \App\Models\Equipment $equipment
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Equipment
     */
    private function create_images(Equipment $equipment, Request $request) {
        // Get images from the request.
        $images = $request->input('images');

        if($images) {
            foreach ($images as $imgBase64) {
                // Remove type header and blank spaces.
                $img = str_replace('data:image/png;base64,', '', $imgBase64);
                $img = str_replace(' ', '+', $img);
    
                // Decode base64 data.
                $data = base64_decode($img);
    
                // Path where images will be saved.
                $uploadDir = public_path('storage/equipments/');
    
                // Ensure the directory exists, if not, create it.
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                // Generate a unique filename for the image.
                $filename = 'equipment_' . $equipment->id . '_' . Str::uuid() . '.png';
    
                // Full path to the file.
                $filePath = $uploadDir . $filename;
    
                // Save the image on the server.
                $success = file_put_contents($filePath, $data);
    
                // Create a record in the Image model.
                Image::create([
                    'equipment_id' => $equipment->id,
                    'path' => 'storage/equipments/' . $filename,
                    'created_by' => auth()->user()->id,
                ]);
            }
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


    /**
     * Display the details of a specific equipment.
     *
     * @param int $id The ID of the equipment.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        // Find the equipment by ID.
        $equipment = Equipment::find($id);

        // If the equipment doesn't exist, show an error message.
        if (!$equipment) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra el equipo');

            // Redirect to the equipments index route.
            return to_route('equipments');
        }

        // Get all active types.
        $types = Type::where('active', true)->get();

        // Get equipment type's brands.
        $brands = $equipment->type->active_brands();

        // Get equipment brand's models.
        $models = $equipment->brand->active_models();

        // Get active clients.
        $clients = Client::where('active', true)
            ->orderBy('last_name', 'asc')
            ->get();

        // Return the equipments view with the equipment's data.
        return view('equipments.show')
            ->with(['equipment' => $equipment])
            ->with(['types' => $types])
            ->with(['brands' => $brands])
            ->with(['models' => $models])
            ->with(['clients' => $clients]);
    }


    /**
     * Soft delete a equipment by setting the 'active' field to false.
     * 
     * @param int $id The ID of the equipment to be soft deleted.
     * @return \Illuminate\Http\RedirectResponse A redirect response after soft deleting the client.
     */
    public function delete($id): RedirectResponse
    {
        try {
            // Find the equipment or throw an exception.
            $equipment = Equipment::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra el equipo seleccionado');
            return to_route('equipments');
        }

        // Soft delete the equipment by setting 'active' field to false.
        $equipment->update(['active' => false]);

        // Get equipment's active images.
        $images = $equipment->active_images();

        // Soft delete each image.
        foreach($images as $image) {
            $image->update(['active' => false]);
        } 

        // Flash a success message for the session.
        session()->flash('success', 'Equipo eliminado.');

        // Redirect to the equipment index router.
        return to_route('equipments');
    }


    /**
     * Edit the details of a equipment based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The request instance containing the form data.
     * @param int $id The ID of the equipment to be edited.
     * @return \Illuminate\Http\RedirectResponse A redirect response after editing the client.
     */
    public function edit(Request $request, $id) : RedirectResponse
    {
        // Validate form inputs. If there is an error, return back with the errors.
        $validated = $request->validateWithBag('edit', [
            'type' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'serial_number' => ['required'],
            'client' => ['required'],
            'observations' => ['nullable'],
        ]);

        // Find the equipment by ID.
        $equipment = Equipment::find($id);

        // If the equipment doesn't exist, show an error message.
        if (!$equipment) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra el equipo');

            // Redirect to the equipments index route.
            return to_route('equipments');
        }

        // Update equipment.
        $this->update_equipment($equipment, $request);

        // Flash a success message for the session.
        session()->flash('success', 'Equipo actualizado!');

        // Redirect to the equipment details page.
        return to_route('equipments.show', ['id' => $id]);
    }


    /**
     * Update the basic information of a equipment.
     *
     * @param \App\Models\Equipment $equipment The equipment instance.
     * @param \Illuminate\Http\Request $request The request instance.
     * @return void
     */
    private function update_equipment(Equipment $equipment, Request $request): void
    {
        $equipment->update([
            'client_id' => $request->input('client'),
            'type_id' => $request->input('type'),
            'brand_id' => $request->input('brand'),
            'model_id' => $request->input('model'),
            'serial_number' => $request->input('serial_number'),
            'observations' => $request->input('observations'),
        ]);
    }


    /**
     * Get equipments that belong to the specified client id.
     *
     * @param int $id Client id.
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_equipments_by_client($id)
    {
        try {
            // Get all updated equipments after saving.
            $equipments = Equipment::where('active', true)
                ->where('client_id', $id)
                ->orderBy('updated_at', 'desc')
                ->with('type', 'brand', 'model')
                ->get();

            return response()->json(['equipments' => $equipments]);
        } catch (\Exception $e) {
            // Handle internal server error.
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
