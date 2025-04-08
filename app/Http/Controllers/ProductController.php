<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalog;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Refresh the user data from the database
        $user = Auth::user();
        $user->refresh();
        
        $catalog = new Catalog();
        
        // Clear any existing selected clients from session
        session()->forget('selected_clients');
        
        // Set the current user's No as the default selected client
        $selectedClients = [$user->No];
        session(['selected_clients' => $selectedClients]);
        
        // If this is a POST request with selected clients, update the session
        if ($request->isMethod('post')) {
            $selectedClients = $request->input('selected_clients', [$user->No]);
            session(['selected_clients' => $selectedClients]);
        }
        
        if (empty($selectedClients)) {
            $products = collect([]);
        } else {
            if (count($selectedClients) === 1 && $selectedClients[0] === $user->No) {
                $products = $catalog->where('MAIN CUSTOMER', $user->No)
                    ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
                    ->get();
            } else {
                $products = $catalog->whereIn('Customer No#', $selectedClients)
                    ->select('Item Description', 'Item Catalog', 'Description', 'Sales Unit of Measure', 'Valid from Date', 'Valid to Date')
                    ->get();
            }
        }
            
        $hasProducts = !$products->isEmpty();

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
        // Refresh the user data from the database
        $user = Auth::user();
        $user->refresh();
        
        // Get selected clients from request, default to current user if none selected
        $selectedClients = $request->input('selected_clients', [$user->No]);
        
        // Store in session
        session(['selected_clients' => $selectedClients]);
        
        return response()->json(['success' => true]);
    }
}

