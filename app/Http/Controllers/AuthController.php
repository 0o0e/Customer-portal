<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the username and password
        $credentials = $request->validate([
            'username' => 'required|string', // Validate username instead of email
            'password' => 'required|string',
        ]);

        // Hardcoded credentials for testing (you can modify this)
        $validUsername = 'admin';
        $validPassword = 'password123';

        // Check if the provided username and password are correct
        if ($credentials['username'] === $validUsername && $credentials['password'] === $validPassword) {
            // If valid, log the user in (no need for Auth::attempt)
            session(['user' => $validUsername]);  // Store user in session for demo purpose
            return redirect('/customer/dashboard');
        }

        // If login fails
        return back()->withErrors([
            'username' => 'Invalid username or password.',
        ]);
    }

    // Handle the logout request
    public function logout()
    {
        // Clear session data on logout
        session()->forget('user');
        return redirect('/customer/login');
    }
}
