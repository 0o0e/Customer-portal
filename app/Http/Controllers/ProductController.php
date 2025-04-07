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
        
        // Get selected clients from session, default to current user if none selected
        $selectedClients = session('selected_clients', [$user->No]);
        
        // If this is a POST request with selected clients, update the session
        if ($request->isMethod('post')) {
            $selectedClients = $request->input('selected_clients', []);
            session(['selected_clients' => $selectedClients]);
        }
        
        // If no clients are selected, return empty collection
        if (empty($selectedClients)) {
            $products = collect([]);
        } else {
            // If only main customer is selected, show all products where they are MAIN CUSTOMER
            if (count($selectedClients) === 1 && $selectedClients[0] === $user->No) {
                $products = $catalog->where('MAIN CUSTOMER', $user->No)
                    ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
                    ->get();
            } else {
                // Otherwise, show products for selected customers
                $products = $catalog->whereIn('Customer No#', $selectedClients)
                    ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
                    ->get();
            }
        }
            
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

    public function updateClients(Request $request)
    {
        $user = Auth::user();
        
        // Get selected clients from request, default to current user if none selected
        $selectedClients = $request->input('selected_clients', [$user->No]);
        
        // Store in session
        session(['selected_clients' => $selectedClients]);
        
        return response()->json(['success' => true]);
    }
}

