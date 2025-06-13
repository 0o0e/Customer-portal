<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'No' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            ActivityLogger::logLogin(Auth::user(), $request, true);
            return redirect()->intended('/dashboard');
        }

        $user = \App\Models\User::where('name', $credentials['name'])
            ->where('No', $credentials['No'])
            ->first();

        if($user){
            ActivityLogger::logLogin($user, $request, false);
        }


        return back()->withErrors(['login' => 'Invalid login details']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}