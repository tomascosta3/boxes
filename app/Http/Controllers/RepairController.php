<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Equipment;
use App\Models\Message;
use App\Models\Order;
use App\Models\Repair;
use App\Models\Type;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
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
     * Search for filtered repairs based on the provided search parameters.
     *
     * @param  string  $search
     * @param  string  $search_option
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function search_repairs($search, $search_option)
    {
        // Initialize repairs variable.
        $repairs = collect();

        // Search for repairs based on the specified search option.
        if($search_option == 'order') {
            // Search for orders that match the search criteria.
            $orders = Order::where('number', 'LIKE', "%$search%")
                ->where('active', true)
                ->get();

            // Get the IDs of the matching orders.
            $orders_ids = $orders->pluck('id')->toArray();

            if($orders_ids !== null) {
                // Retrieve repairs based on the matching order number.
                $repairs = Repair::where('active', true)
                    ->whereIn('order_id', $orders_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        } else if($search_option == 'type') {
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
                    ->get();

                // Get the IDs of the matching equipments.
                $equipments_ids = $equipments->pluck('id')->toArray();

                if($equipments_ids !== null) {
                    // Retrieve orders base on the matching equipment IDs.
                    $orders = Order::where('active', true)
                        ->whereIn('equipment_id', $equipments_ids)
                        ->get();

                    // Get the IDs of the matching orders.
                    $orders_ids = $orders->pluck('id')->toArray();

                    if($orders_ids !== null) {
                        // Retrieve repairs based on the matching order number.
                        $repairs = Repair::where('active', true)
                            ->whereIn('order_id', $orders_ids)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
                    }
                }
            }
        } else if($search_option == 'client') {
            // Search for clients that match the search criteria.
            $clients = Client::where('active', true)
                ->whereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                ->get();

            // Get the IDs of the matching clients.
            $clients_ids = $clients->pluck('id')->toArray();

            if($clients_ids !== null) {
                // Retrieve orders based on the matching clients IDs.
                $orders = Order::where('active', true)
                    ->whereIn('client_id', $clients_ids)
                    ->get();

                // Get the IDs of the matching orders.
                $orders_ids = $orders->pluck('id')->toArray();

                if($orders_ids !== null) {
                    // Retrieve repairs based on the matching orders IDs.
                    $repairs = Repair::where('active', true)
                        ->whereIn('order_id', $orders_ids)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
                }
            }
        } else if($search_option == 'technician') {
            // Search for technicians that match the search criteria.
            $technicians = User::where('active', true)
                ->whereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"])
                ->get();

            // Get the IDs of the matching technicians.
            $technicians_ids = $technicians->pluck('id')->toArray();

            if($technicians_ids !== null) {
                // Retrieve repairs based on the matching technicians IDs.
                $repairs = Repair::where('active', true)
                    ->whereIn('technician_id', $technicians_ids)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        }

        return $repairs;
    }


    /**
     * Retrieve all active clients.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    private function get_all_active_repairs()
    {
        // Retrieve all active clients.
        return Repair::where('active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }


    /**
     * Display the details of a specific repair.
     *
     * @param int $id The ID of the repair.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        // Find the repair by ID.
        $repair = Repair::find($id);

        // If the repair doesn't exist, show an error message.
        if (!$repair) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra la reparación');

            // Redirect to the repairs index route.
            return to_route('repairs');
        }

        // Get all active technicians.
        $technicians = User::where('active', true)
            ->get();

        // Return the repairs view with the repair's data.
        return view('repairs.show')
            ->with(['repair' => $repair])
            ->with(['technicians' => $technicians]);
    }


    /**
     * Search for repair associated with a specific order number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quick_search(Request $request)
    {
        // Initialize repairs variable.
        $repairs = collect();

        // Get search parameters from the request.
        $order_number = $request->input('searchedOrder');
        
        // Search for the order that matches the search criteria.
        $order = Order::where('number', $order_number)
            ->where('active', true)
            ->first();

        if ($order !== null) {
            // Retrieve repairs based on the matching order number.
            $repairs = Repair::where('active', true)
                ->where('order_id', $order->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Return JSON response with repairs data.
        return response()->json(['repairs' => $repairs]);
    }


    /**
     * Edit the details of a repair based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The request instance containing the form data.
     * @param int $id The ID of the repair to be edited.
     * @return \Illuminate\Http\RedirectResponse A redirect response after editing the repair.
     */
    public function edit(Request $request, $id) : RedirectResponse
    {
        // Validate form inputs. If there is an error, return back with the errors.
        $validated = $request->validateWithBag('edit', [
            'client-report' => ['nullable', 'max:65535'],
        ]);

        // Find the repair by ID.
        $repair = Repair::find($id);

        // If the repair doesn't exist, show an error message.
        if (!$repair) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra la reparación');

            // Redirect to the repairs index route.
            return to_route('repairs');
        }

        // Update repair.
        $this->update_repair($repair, $request);

        // Redirect to the equipment details page.
        return to_route('repairs.show', ['id' => $id]);
    }


    /**
     * Update the basic information of a repair.
     *
     * @param \App\Models\Repair $repair The repair instance.
     * @param \Illuminate\Http\Request $request The request instance.
     * @return void
     */
    private function update_repair(Repair $repair, Request $request): void
    {
        // Update status if changed.
        if($request->input('status') && $repair->status !== $request->input('status')) {
            $old_status = $repair->get_spanish_status();
            $repair->update(['status' => $request->input('status')]);
            // Save change as a system message in binnacle.
            $this->status_changed_message($repair, $request, $old_status);
        }

        // Update client report if changed.
        if($repair->conclusion !== $request->input('client-report')) {
            $repair->update(['conclusion' => $request->input('client-report')]);
        }
        
        // Update technician if changed.
        if($request->input('technician') && $repair->technician_id != $request->input('technician')) {
            // If there is none technician, assign null technician ID.
            if ($request->input('technician') == 'none') {
                $repair->update(['technician_id' => null]);
            } else {
                $repair->update(['technician_id' => $request->input('technician')]);
            }
            // Save change as a system message in binnacle.
            $this->technician_changed_message($request);
        }
    }


    /**
     * Mark the repair as delivered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliver(Request $request)
    {

        // Get search parameters from the request.
        $repair_id = $request->input('repairId');

        // Find the repair by its ID.
        $repair = Repair::find($repair_id);

        // If the repair doesn't exist, return an error response.
        if (!$repair) {
            return response()->json(['error' => 'The repair does not exist.'], 404);
        }

        // Update the status of the repair to 'delivered' and set the delivery date.
        $repair->update([
            'status' => 'delivered',
            'delivery_date' => now(),
        ]);

        // Return a success response.
        return response()->json([
            'deliveryDate' => $repair->delivery_formatted_date(),
            'deliveryTime' => $repair->delivery_formatted_time(),
        ], 200);
    }


    /**
     * Generate a message when the status of a repair is changed.
     *
     * @param  \App\Models\Repair  $repair
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $old_status
     * @return void
     */
    private function status_changed_message(Repair $repair, Request $request, $old_status)
    {
        $message = auth()->user()->last_name . ' ' . auth()->user()->first_name . ' changed the status of the repair from "'
            . $old_status . '" to "' . $repair->get_spanish_status() . '"';

        // Create a new message.
        $new_message = Message::create([
            'binnacle_id' => $request->input('binnacle-id'),
            'message' => $message,
        ]);
    }

    /**
     * Generate a message when the technician of a repair is changed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function technician_changed_message(Request $request)
    {
        $message = '';
        $new_technician = $request->input('technician');

        if ($new_technician == 'none') {
            $message = 'Técnico asignado -> Ninguno.';
        } else {
            $technician = User::find($new_technician);
            $message = 'Técnico asignado -> ' . $technician->last_name . ' ' . $technician->first_name . '.';
        }

        // Create a new message.
        $new_message = Message::create([
            'binnacle_id' => $request->input('binnacle-id'),
            'message' => $message,
        ]);
    }


    /**
     * 
     */
    public function print($id)
    {
        // Find the repair by ID.
        $repair = Repair::find($id);

        // If the repair doesn't exist, show an error message.
        if (!$repair) {
            // Flash an error message for the session.
            session()->flash('problem', 'No se encuentra la reparación');

            // Redirect to the repairs index route.
            return to_route('repairs');
        }

        // Get all active technicians.
        $technicians = User::where('active', true)
            ->get();

        // Return the repairs view with the repair's data.
        return view('repairs.print')
            ->with(['repair' => $repair])
            ->with(['technicians' => $technicians]);
    }
}
