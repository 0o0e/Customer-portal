<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $catalog = new Catalog();
        
        $products = $catalog->where('MAIN CUSTOMER', $user->No)
            ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
            ->get();
            
        $hasProducts = !$products->isEmpty();

        // Apply search filter if search term exists in session
        if (session()->has('search')) {
            $searchTerm = session('search');
            $products = $products->filter(function($product) use ($searchTerm) {
                return stripos($product->{'Item Description'}, $searchTerm) !== false ||
                       stripos($product->{'Item Catalog'}, $searchTerm) !== false;
            });
        }

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

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255'
        ]);

        session(['search' => $request->search]);
        return redirect()->route('products.index');
    }
}

