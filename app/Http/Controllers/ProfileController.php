<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {

        // validate the date
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string','confirmed',
            Password::min(12)->mixedCase()->numbers()->symbols()],
        ]);

        $user = Auth::user();

        // return with error if new password is the same as  old password
        if(Hash::check($request->password, $user->password)){
            return back()->withErrors(['password' => 'New password cannot be the same as old password.']);
        }


        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
