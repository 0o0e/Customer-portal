<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'No' => 'required',
            'email' => 'required|email',
        ]);

        // Find user by name, client number, and email
        $user = User::where('name', $request->name)
                   ->where('No', $request->No)
                   ->where('email', $request->email)
                   ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We cannot find a user with those credentials.',
            ]);
        }

        // Generate password reset token
        $token = Password::createToken($user);

        // Send reset email
        $user->sendPasswordResetNotification($token);

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'name' => 'required',
            'No' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'not_in:password,123456,admin,12345678,qwerty,111111',
            ],
        ]);

        $user = User::where('name', $request->name)
                   ->where('No', $request->No)
                   ->where('email', $request->email)
                   ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We cannot find a user with those credentials.',
            ]);
        }

        // Reset password
        $user->password = Hash::make($request->password);
        $user->remember_token = Str::random(60);
        $user->save();



        event(new PasswordReset($user));

        return redirect()->route('login')
            ->with('status', 'Your password has been reset successfully!');
    }
}
