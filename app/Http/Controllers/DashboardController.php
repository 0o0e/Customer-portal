<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get selected clients from session, default to current user if none selected
        $selectedClients = session('selected_clients', [$user->No]);

        return view('dashboard', compact('selectedClients'));
    }

}
