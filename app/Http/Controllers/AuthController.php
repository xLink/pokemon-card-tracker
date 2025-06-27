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

    public function getPasswordReset() 
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
