<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Type;
use Illuminate\Contracts\View\View;
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
}
