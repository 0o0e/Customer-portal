<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SalesQuotes;

class ClientOrderController extends Controller
{
    public function create()
    {
        // gets the current user 
        $user = Auth::user();
        $customerNo = $user->No;

        
        if (!$customerNo) {
            return back()->with('error', 'No customer number found for your account.');
        }

        
        try {
            // Get selected clients from session, default to current user if none selected
            $selectedClients = session('selected_clients', [$user->No]);

            // Get products from Catalog table with prices from item table
            $customerProducts = DB::table('Catalog as c')
                ->join('item as i', 'c.Item No#', '=', 'i.No')
                ->whereIn('c.Customer No#', $selectedClients)
                ->select(
                    'c.Item No#',
                    'c.Item Description',
                    'c.Customer No#',
                    'i.Unit_Price'
                )
                ->get();

            return view('client-orders.create', [
                'customerNo' => $customerNo,
                'customerProducts' => $customerProducts
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Could not fetch products: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        // validate the request, required at least one item and required fields are product id quantity and unit price
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);
        
        try {
            // get the current user
            $user = Auth::user();

            // create empty array for storing quote lines
            $quoteLines = [];

            // loop through each item
            foreach ($request->items as $item) {

                // get product details from catalog and price from item table
                $selectedProduct = DB::table('Catalog as c')
                    ->join('item as i', 'c.Item No#', '=', 'i.No')
                    ->where('c.Item No#', $item['product_id'])
                    ->select(
                        'c.Item No#',
                        'c.Item Description',
                        'c.Customer No#',
                        'i.Unit_Price'
                    )
                    ->first();
                
                // if not selected product(not found or not available) return an error.
                if (!$selectedProduct) {
                    return back()->with('error', 'Product not found or not available for your account.');
                }

                // get the description of the product. this will be used in the detail page
                $description = $selectedProduct->{'Item Description'};
                
                // add the quote line to the array 
                $quoteLines[] = [
                    'lineType' => 'Item',
                    'description' => $description,
                    'quantity' => (float) $item['quantity'],
                    'unitPrice' => (float) $item['unit_price']
                ];
            }


            
            // all the data to send to business central
            $quoteData = [
                'customerNumber' => $selectedProduct->{'Customer No#'},
                'shipToName' => $user->name,
                'externalDocumentNumber' => '123',
                'salesQuoteLines' => $quoteLines
            ];

            // sends data to business central
            $response = SalesQuotes::create($quoteData);

            // if it wasnt a successful creation return error
            if (!$response->successful()) {
                return back()->with('error', 'Quote creation failed: ' . $response->json()['error']['message']);
            }

            // redirext to the quotes page
            return redirect()->route('client-orders.index')->with('success', 'Quote created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Could not create quote: ' . $e->getMessage());
        }
    }

    // shows list of all quotes
    public function index()
    {

        try {
            // get current user and selected clients from session default to current user No if theres no selecetd clients
            $user = Auth::user();
            $selectedClients = session('selected_clients', [$user->No]);

            // Get all quotes for selected clients
            $quotes = [];
            foreach ($selectedClients as $clientNo) {
                $quotes = array_merge($quotes, SalesQuotes::all("customerNumber eq '$clientNo'")->toArray());
            }

            return view('client-orders.index', compact('quotes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Could not fetch quotes: ' . $e->getMessage());
        }
    }

    
    // shows details of one quote
    public function show($id)
    {
        try {
            $quote = SalesQuotes::find($id);
            
            if (!$quote) {
                return back()->with('error', 'Quote not found.');
            }

            return view('client-orders.show', ['quote' => $quote]);
        } catch (\Exception $e) {
            return back()->with('error', 'Could not fetch quote details: ' . $e->getMessage());
        }
    }
} 