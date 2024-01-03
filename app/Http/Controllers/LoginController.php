<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    /**
     * Handle an authentication attempt.
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) : RedirectResponse{

        // Validate the incoming request data.
        $credentials = $request->validateWithBag('login', [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Attempt to authenticate the user using the provided credentials.
        if(Auth::Attempt($credentials, false)) {

            // Regenerate the session.
            $request->session()->regenerate();

            return to_route('home');
        }

        /**
         * If authentication failed, invalidate the session and regenerate 
         * the CSRF token.
         */
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('problem', 'Error al iniciar sesión, correo o contraseña incorrecta');

        // Redirect back to the login page with the error message.
        return to_route('auth.login');
    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Log the user out.
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page.
        return to_route('auth.login');
    }
}
