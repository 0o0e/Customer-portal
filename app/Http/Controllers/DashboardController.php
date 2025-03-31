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
        
        // Get related customers from catalog table
        $relatedCustomers = DB::table('catalog')
            ->where('MAIN CUSTOMER', $user->No)
            ->select('Customer No#')
            ->distinct()
            ->get();

        // Get products for the current user
        $products = DB::table('catalog')
            ->where('MAIN CUSTOMER', $user->No)
            ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
            ->get();

        return view('dashboard', compact('products', 'relatedCustomers'));
    }

}
