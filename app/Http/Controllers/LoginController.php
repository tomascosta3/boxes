<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display login view.
     * 
     * @return Illuminate\Contracts\View\View
     */
    public function view() : View {

        return view('auth.login');
    }
}
