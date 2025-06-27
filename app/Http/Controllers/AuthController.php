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

         // if the email is already registered, return an error
        if (User::where('email', $credentials['email'])->exists()) {
            return back()->withErrors([
                'email' => 'This email is already registered.',
            ])->onlyInput('email');
        }

        // create a new user and log them in
        $user = new User();
        $user->uuid = (string) Str::uuid();; 
        $user->name = $credentials['name'];
        $user->email = $credentials['email'];
        $user->password = bcrypt($credentials['password']);
        $user->save();
        Auth::login($user);
        return redirect()->intended(route('pages.dashboard'));
    }    public function getPasswordReset() 
    {
        return inertia('Pages/LoginPage');
    }

    public function postPasswordReset(Request $request) 
    {
        //validate user inputs before adding to the database
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check if the user already exists
        if (!User::where('email', $request->input('email'))->exists()) {
            return ['error' => true, 'message' => 'This email is not registered with us.'];
        }

        // update the user's password        
        $user = User::where('email', $request->input('email'))->firstOrFail();

        $user->password = bcrypt($credentials('password'));
        $user->save();
        Auth::login($user);
        return inertia('Pages/Dashboard', ['error' => false, 'message' => 'Your Password has been reset!']);
    }
}
