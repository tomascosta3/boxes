<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Display clients index view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        return view('clients.index');
    }
}
