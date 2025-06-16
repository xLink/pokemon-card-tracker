<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use \Illuminate\Support\Str;

class AuthController extends Controller
{
    public function getLogin() 
    {
        return inertia('Pages/LoginPage');
    }

    public function postLogin(Request $request) 
    {
        // validate user creds and log the user in
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        // log the user in 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('pages.dashboard'));
        }
        
        return back()->withErrors([
            'email' => 'Please provide correct credentials.',
        ])->onlyInput('email');
    }

    public function getLogout(Request $request) 
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

       public function getRegister() 
    {
        return inertia('Pages/RegisterPage');
    }

      public function postRegister(Request $request) 
    {
        //validate user inputs before adding to the database
        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // create new user if the email is not already registered and log in
        if (!User::where('email', $request->input('email'))->exists()) {
            $user = new User();
            $user->uuid = (string) Str::uuid();; 
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            Auth::login($user);
            return redirect()->intended(route('pages.dashboard'));
        }

        // if the email is already registered, return an error
        else {
            return back()->withErrors([
                'email' => 'This email is already registered.',
            ])->onlyInput('email');
        }
    }


}