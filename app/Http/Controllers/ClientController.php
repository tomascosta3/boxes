<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Display clients index view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        // Get search parameters from the request.
        $search = $request->input('search');
        $search_option = $request->input('search_option');

        // If both search and search option are defined, perform a filtered search for clients.
        if ($search && $search_option) {
            $clients = $this->search_clients($search, $search_option);
        } else {
            // If no search parameters are provided, retrieve all active clients.
            $clients = $this->get_all_active_clients();
        }

        // Return the clients index view with the clients data.
        return view('clients.index')->with(['clients' => $clients]);
    }

    /**
     * Search for filtered clients based on the provided search parameters.
     *
     * @param  string  $search
     * @param  string  $search_option
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function search_clients($search, $search_option) : Collection
    {
        // Initialize clients variable.
        $clients = collect();

        // Search for clients based on the specified search option.
        if ($search_option == 'name') {
            $clients = Client::where('active', true)
                ->whereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                ->orderBy('last_name', 'asc')
                ->get();
        } elseif ($search_option == 'phone_number') {
            $clients = Client::where('active', true)
                ->where('phone_number', 'like', '%' . $search . '%')
                ->orderBy('last_name', 'asc')
                ->get();
        } elseif ($search_option == 'email') {
            $clients = Client::where('active', true)
                ->where('email', 'like', '%' . $search . '%')
                ->orderBy('last_name', 'asc')
                ->get();
        }

        return $clients;
    }

    /**
     * Retrieve all active clients.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function get_all_active_clients() : Collection
    {
        // Retrieve all active clients.
        return Client::where('active', true)
            ->orderBy('last_name', 'asc')
            ->get();
    }


    /**
     * Display clients creation view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View 
    {

        return view('clients.create');
    }


    /**
     * Store a new client based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form inputs. If there is an error, return back with the errors.
        $validated = $request->validateWithBag('create', [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required', 'email'],
        ]);

        // Create a new client with the provided data.
        $client = $this->create_client($request);

        // Check if the client is subscribed and update client type accordingly.
        $this->update_client_type($client, $request);

        // Check if the client was created successfully.
        if (!$client->id) {
            // If creation fails, flash an error message.
            session()->flash('problem', 'No se pudo crear el cliente');
        } else {
            // Flash a success message.
            session()->flash('success', 'Cliente creado correctamente');
        }

        // Redirect to the client creation route.
        return to_route('clients.create');
    }

    /**
     * Create a new client with the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Client
     */
    private function create_client(Request $request) : Client
    {
        return Client::create([
            'first_name' => mb_convert_case($request->input('first_name'), MB_CASE_TITLE, "UTF-8"),
            'last_name' => mb_convert_case($request->input('last_name'), MB_CASE_TITLE, "UTF-8"),
            'phone_number' => $request->input('phone_number'),
            'email' => strtolower($request->input('email')),
            'address' => mb_convert_case($request->input('address'), MB_CASE_TITLE, "UTF-8"),
            'locality' => mb_convert_case($request->input('locality'), MB_CASE_TITLE, "UTF-8"),
            'province' => mb_convert_case($request->input('province'), MB_CASE_TITLE, "UTF-8"),
            'postal_code' => $request->input('postal_code'),
            'cuit' => $request->input('cuit'),
        ]);
    }

    /**
     * Check if the client is subscribed and update client type accordingly.
     *
     * @param  \App\Models\Client  $client
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function update_client_type(Client $client, Request $request) : void
    {
        if ($request->input('subscribed_client') == true) {
            $client->subscribed_client = true;
            $client->end_client = false;
            $client->save();
        }
    }


    /**
     * Display the details of a specific client.
     *
     * @param int $id The ID of the client.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id) : View
    {
        // Find the client by ID.
        $client = Client::findOrFail($id);

        // If the client doesn't exist, show an error message.
        if (!$client) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra el cliente');

            // Redirect to the clients index route.
            return to_route('clients');
        }

        // Return the clients view with the client's data.
        return view('clients.show')->with(['client' => $client]);
    }
}
