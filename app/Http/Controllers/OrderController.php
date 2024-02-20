<?php

namespace App\Http\Controllers;

use App\Models\Binnacle;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\Order;
use App\Models\Repair;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Bool_;

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

        if($this->already_has_open_repair($request->input('equipment'))) {
            session()->flash('problem', 'No se pudo crear la nueva orden, el equipo se encuentra en el taller');

            // Redirect to the new order route.
            return to_route('new-order');
        }

        // Create a new order with the provided data.
        $order = $this->create_order($request);

        // Check if the order was created successfully and set a flash message.
        if(!$order->id) {
            session()->flash('problem', 'No se pudo crear la nueva orden');
        } else {
            // Create a new repair associated with the order.
            $repair = $this->create_repair($order->id, $request);

            if($repair->id) {
                $binnacle = $this->create_binnacle($repair->id);
            }

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


    /**
     * Create a new repair associated with the order.
     * 
     * @param  int  $order_id
     * 
     * @return \App\Models\Repair
     */
    protected function create_repair(int $order_id) : Repair
    {
        // Create a new repair associated with the order.
        return Repair::create([
            'order_id' => $order_id,
            'technician_id'=> null,
        ]);
    }


    /**
     * Create a new binnacle associated with the repair.
     * 
     * @param  int  $repair_id
     * 
     * @return \App\Models\Binnacle
     */
    protected function create_binnacle(int $repair_id) : Binnacle
    {
        // Create a new binnacle associated with the repair.
        return Binnacle::create([
            'repair_id' => $repair_id,
        ]);
    }


    /**
     * Checks if there are any open repairs associated with the given equipment.
     *
     * @param  int  $equipment_id The ID of the equipment to check for open repairs.
     * @return bool True if there are open repairs, false otherwise.
     */
    private function already_has_open_repair(int $equipment_id): bool
    {
        // Get the specific equipment for which you want to check for open repairs.
        $equipment = Equipment::find($equipment_id);

        // Initialize a variable to indicate if there are any open repairs.
        $open_repairs = false;

        // Check if the equipment exists.
        if ($equipment) {
            // Get all the orders associated with this equipment.
            $orders = $equipment->orders;

            // Check each order to find pending repairs.
            foreach ($orders as $order) {
                // Check if there is at least one repair associated with this order that is not 'delivered'.
                if ($order->repair()->where('status', '!=', 'delivered')->exists()) {
                    $open_repairs = true;
                    // If you find such a repair, you can break out of the loop.
                    break;
                }
            }
        }

        return $open_repairs;
    }
}
