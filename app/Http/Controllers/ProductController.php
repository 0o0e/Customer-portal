<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index() {
        $user = Auth::user();
        
        $query = DB::table('catalog')
            ->where('MAIN CUSTOMER', $user->No)
            ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date');

        // Apply search filter if search term exists in session
        if (session()->has('search') && session('search') != '') {
            $searchTerm = session('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('Item Description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('Item Catalog', 'like', '%' . $searchTerm . '%')
                  ->orWhere('Description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('Sales Unit of Measure', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->get();
        $hasProducts = !$products->isEmpty();

        $allProducts = $products->map(function($product){
            return [
                'Description' => $product->{'Item Description'},
                'Catalog' => $product->{'Item Catalog'},
                'Unit' => $product->{'Sales Unit of Measure'},
                'Valid from Date' => $product->{'Valid from Date'},
                'Valid to Date' => $product->{'Valid to Date'},
            ];
        })->toArray();

        return view('products', compact('hasProducts', 'allProducts'));
    }

    public function search(Request $request) {
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        session(['search' => $request->search]);
        return redirect()->route('products.index');
    }
    
}

