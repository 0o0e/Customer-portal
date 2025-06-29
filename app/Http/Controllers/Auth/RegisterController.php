<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Get all pending account requests
        $accountRequests = AccountRequest::orderBy('created_at', 'desc')->get();
        
        return view('auth.register', compact('accountRequests'));
    }

    // This method is no longer used - account requests are handled by AccountRequestController
    // Keeping for backward compatibility if needed
    public function register(Request $request)
    {
        return redirect()->route('register')->with('error', 'Direct registration is no longer available. Please use the account request system.');
    }
}
