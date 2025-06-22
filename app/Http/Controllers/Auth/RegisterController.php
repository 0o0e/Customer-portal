<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // Generate random client number
        do {
            $clientNo = 'K' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
            $exists = User::where('No', $clientNo)->exists();
        } while ($exists);

        $password = Str::random(10);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'No' => $clientNo,
            'is_admin' => false,
        ]);

        // Send email with login credentials
        Mail::send('emails.credentials', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'client_number' => $user->No,
        ], function($message) use ($user) {
            $message->to($user->email)
                   ->subject('Your Özgazi Account Credentials');
        });

        return redirect()->route('dashboard')
            ->with('success', 'User registered successfully. Login credentials have been sent to their email.');
    }
}
