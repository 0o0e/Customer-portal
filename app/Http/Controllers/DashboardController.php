<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        // Retrieve the currently authenticated user

        // Pass the data to the view
            $products = DB::table('catalog')
        ->where('MAIN CUSTOMER', $user->No)
        ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
        ->get();

        return view('dashboard', compact('products'));

        // return view('dashboard', compact('user'));
    }

}
