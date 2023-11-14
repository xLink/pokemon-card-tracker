<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


}