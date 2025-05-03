<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
Use App\Models\Admin;
use App\Models\Agent;
use App\Models\Message;
// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\NullableType;

class AuthController extends Controller
{
        public function showRegister () {
            return view('auth.register');
        }

        public function showLogin () {
            return view('auth.login');
        }

        public function register(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|min:2|max:55',
            'lname' => 'required|string|min:2|max:55',
            'email' => 'required|email|unique:clients,email',
            'contactno' => 'required|string|digits:11',
            'username' => 'required|string|min:2|max:55',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $client = Client::create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
            'email' => $validated['email'],
            'contact_number' => $validated['contactno'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ]);

        
        // Auth::guard('client')->login($client);

        return redirect()->route('show.login')->with('success', 'Registration successful!');
    }

    

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $credentials['username'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            return redirect()->route('adminDashboard');
        }// Change this route as needed

        $agent = Agent::where('username', $credentials['username'])->first();
        if ($agent && Hash::check($credentials['password'], $agent->password)) {
         
            Auth::guard('agent')->login($agent);
            $request->session()->regenerate();
            return redirect()->route('agentDashboard');
        }

        $client = Client::where('username', $credentials['username'])->first();
        if ($client && Hash::check($credentials['password'], $client->password)) {
            // Use the 'client' guard to login
            Auth::guard('client')->login($client);
            $request->session()->regenerate();
            return redirect()->route('clientsProfile');
        }

        return back()->with('error', 'Invalid username or password');
    }

    //     public function logout(Request $request)    
    // {

    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('show.login')->with('success', 'You have been logged out.');
    // }
    public function logout(Request $request)
    {
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    } elseif (Auth::guard('agent')->check()) {
        Auth::guard('agent')->logout();
    } elseif (Auth::guard('client')->check()) {
        Auth::guard('client')->logout();
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('show.login')->with('success', 'You have been logged out.');
}
}
