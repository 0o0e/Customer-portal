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
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        try {
            $user = Auth::user();
            $quoteLines = [];

            foreach ($request->items as $item) {
                // Get product details including price
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

                if (!$selectedProduct) {
                    return back()->with('error', 'Product not found or not available for your account.');
                }

                // Convert special characters to their normal form
                $description = html_entity_decode($selectedProduct->{'Item Description'}, ENT_QUOTES, 'UTF-8');
                
                $quoteLines[] = [
                    'lineType' => 'Item',
                    'description' => $description,
                    'quantity' => (float) $item['quantity'],
                    'unitPrice' => (float) $item['unit_price']
                ];
            }

            $quoteData = [
                'customerNumber' => $selectedProduct->{'Customer No#'},
                'shipToName' => $user->name,
                'externalDocumentNumber' => '123',
                'salesQuoteLines' => $quoteLines
            ];

            $response = SalesQuotes::create($quoteData);

            if (!$response->successful()) {
                return back()->with('error', 'Quote creation failed: ' . $response->json()['error']['message']);
            }

            return redirect()->route('client-orders.index')->with('success', 'Quote created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Could not create quote: ' . $e->getMessage());
        }
    }

    public function index()
    {
        try {
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