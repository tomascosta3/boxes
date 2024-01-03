<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Display clients index view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        $clients = Client::where('active', true)
            ->orderBy('last_name', 'asc')
            ->get();

        return view('clients.index')
            ->with(['clients' => $clients]);
    }


    /**
     * Display clients creation view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function create() {

        return view('clients.create');
    }


    /**
     * Store a new client based on the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) : RedirectResponse {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('create', [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['nullable', 'email'],
        ]);

        // Create a new client with the provided data.
        $client = Client::create([
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

        // Check if the client is subscribed and if its true change client type.
        if($request->input('subscribed_client') == true) {
            $client->subscribed_client = true;
            $client->end_client = false;
            $client->save();
        }

        // Check if the user was created successfully.
        if(!$client->id) {

            // If creation fails, flash an error message.
            session()->flash('problem', 'No se pudo crear el cliente');

        } else {

            // Flash a success message.
            session()->flash('success', 'Cliente creado correctamente');
        }

        // Redirect to the client creation route.
        return to_route('clients.create');
    }

}
