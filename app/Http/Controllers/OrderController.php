<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display new order view.
     * 
     * @return Illuminate\Contracts\View\View
     */
    public function new() : View
    {
        $clients = Client::where('active', true)
            ->orderBy('last_name', 'asc')
            ->get();

        $types = Type::where('active', true)
            ->orderBy('type', 'asc')
            ->get();
            
        return view('order.new')
            ->with(['clients' => $clients])
            ->with(['types' => $types]);
    }


    /**
     * Store new order in database.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) : RedirectResponse
    {
        // Validate form inputs. If there is an error, return back with the errors.
        $validated = $request->validateWithBag('create', [
            'client' => ['required'],
            'equipment' => ['required'],
            'accessories' => ['required', 'max:255'],
            'failure' => ['required', 'max:65535'],
        ]);

        // Create a new order with the provided data.
        $order = $this->create_order($request);

        // Check if the order was created successfully and set a flash message.
        if(!$order->id) {
            session()->flash('problem', 'No se pudo crear la nueva orden');
        } else {
            session()->flash('success', 'La nueva orden fue creada correctamente');
        }

        // Redirect to the new order route.
        return to_route('new-order');
    }


    /**
     * Create a new order with the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Order
     */
    private function create_order(Request $request) : Order
    {
        return Order::create([
            'client_id' => $request->input('client'),
            'equipment_id' => $request->input('equipment'),
            'accessories' => $request->input('accessories'),
            'failure' => $request->input('failure'),
            'user_id' => auth()->user()->id,
        ]);
    }
}
