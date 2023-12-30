<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /**
     * Display register view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function view() : View {

        return view('auth.register');
    }


    /**
     * Create a new user.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request) : RedirectResponse {

        /**
         * Validate form inputs.
         * If there is an error, returns back with the errors.
         */
        $validated = $request->validateWithBag('register', [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['nullable'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])[^ ]{6,}$/'],
            'password_confirmation' => ['required'],
        ]);

        try {

            // Create user.
            $user = User::create(
                [
                    'first_name' => mb_convert_case($request->input('first_name'), MB_CASE_TITLE, "UTF-8"),
                    'last_name' => mb_convert_case($request->input('last_name'), MB_CASE_TITLE, "UTF-8"),
                    'phone_number' => $request->input('phone_number'),
                    'email' => strtolower($request->input('email')),
                    'password' => bcrypt($request->input('password')),
                ]
            );

            if(!$user->id) {
                throw new \Exception('Error al crear el usuario');
            }

            $token = Str::random(60);

            // Create the login and link it to the user.
            $login = Login::create([
                'user_id' => $user->id,
                'verification_code' => $token,
                'verification_code_issue_date' => Carbon::now(),
                'verification_code_expiration_date' => Carbon::now()->addMinutes(30),
            ]);

            if(!$login->id) {
                throw new \Exception('Error al crear el login');
            }

            // Send email to account verification.
            // Mail::to($user->email)->queue(new AccountVerification($login, $user));

            $created = true;

            // $domain = explode('@', $user->email)[1];
            // $company = Company::where('domain', $domain)->first();

            // if($company) {

            //     $user->organizations()->attach($company->id);
            // }

            session()->flash($created ? 'success' : 'problem', $created ? 'Usuario creado correctamente!' : 'Error al crear el usuario.');

        } catch (\Exception $e) {

            session()->flash('problem', 'Error: ' . $e->getMessage());

        }

        return to_route('auth.login');
    }
}
