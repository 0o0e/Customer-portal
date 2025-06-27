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
        // Validate the request with proper Laravel validation
        $validatedData = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);
        
        try {
            // Get the current user
            $user = Auth::user();

            // Create empty array for storing quote lines
            $quoteLines = [];
            $customerNo = null;

            // Loop through each validated item
            foreach ($validatedData['items'] as $item) {
                // Get product details from catalog and price from item table
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
                
                // If product not found, return error with old input
                if (!$selectedProduct) {
                    return back()
                        ->withInput()
                        ->with('error', 'Product not found or not available for your account.');
                }

                // Store customer number from first product
                if (!$customerNo) {
                    $customerNo = $selectedProduct->{'Customer No#'};
                }

                // Get the description of the product
                $description = $selectedProduct->{'Item Description'};
                
                // Add the quote line to the array 
                $quoteLines[] = [
                    'lineType' => 'Item',
                    'description' => $description,
                    'quantity' => (float) $item['quantity'],
                    'unitPrice' => (float) $item['unit_price']
                ];
            }

            // Prepare data to send to business central
            $quoteData = [
                'customerNumber' => $customerNo,
                'shipToName' => $user->name,
                'externalDocumentNumber' => '123',
                'salesQuoteLines' => $quoteLines
            ];

            // Send data to business central
            $response = SalesQuotes::create($quoteData);

            // Check if creation was successful
            if (!$response->successful()) {
                $errorMessage = 'Quote creation failed.';
                if ($response->json() && isset($response->json()['error']['message'])) {
                    $errorMessage .= ' ' . $response->json()['error']['message'];
                }
                return back()->withInput()->with('error', $errorMessage);
            }

            // Redirect to the quotes page with success message
            return redirect()->route('client-orders.index')
                ->with('success', 'Quote created successfully!');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Quote creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Could not create quote. Please try again.');
        }
    }

    // shows list of all quotes
    public function index(Request $request)
    {
        try {
            // get current user and selected clients from session default to current user No if theres no selecetd clients
            $user = Auth::user();
            $selectedClients = session('selected_clients', [$user->No]);

            // Get all quotes for selected clients
            $quotes = [];
            foreach ($selectedClients as $clientNo) {
                $clientQuotes = SalesQuotes::all("customerNumber eq '$clientNo'")->toArray();
                $quotes = array_merge($quotes, $clientQuotes);
            }

            // Apply filters
            $dateFrom = $request->query('date_from');
            $dateTo = $request->query('date_to');
            $quantityMin = $request->query('quantity_min');
            $quantityMax = $request->query('quantity_max');
            $search = $request->query('search');


            if (!empty($quotes)) {


                // Filter by search term (search in quote number, customer name, description)
                if ($search) {
                    $quotes = array_filter($quotes, function($quote) use ($search) {
                        $searchTerm = strtolower($search);
                        
                        // Search in quote number
                        if (stripos($quote['number'], $searchTerm) !== false) {
                            return true;
                        }
                        
                        // Search in customer name
                        if (stripos($quote['customerName'], $searchTerm) !== false) {
                            return true;
                        }
                        
                        // Search in quote lines descriptions
                        if (isset($quote['salesQuoteLines']) && is_array($quote['salesQuoteLines'])) {
                            foreach ($quote['salesQuoteLines'] as $line) {
                                if (isset($line['description']) && stripos($line['description'], $searchTerm) !== false) {
                                    return true;
                                }
                            }
                        }
                        
                        return false;
                    });
                }



                // Filter by date range
                if ($dateFrom) {
                    $quotes = array_filter($quotes, function($quote) use ($dateFrom) {
                        return isset($quote['documentDate']) && $quote['documentDate'] >= $dateFrom;
                    });
                }

                if ($dateTo) {
                    $quotes = array_filter($quotes, function($quote) use ($dateTo) {
                        return isset($quote['documentDate']) && $quote['documentDate'] <= $dateTo;
                    });
                }

                // Filter by quantity range
                if ($quantityMin !== null && $quantityMin !== '') {
                    $quotes = array_filter($quotes, function($quote) use ($quantityMin) {
                        $totalQuantity = 0;
                        if (isset($quote['salesQuoteLines']) && is_array($quote['salesQuoteLines'])) {
                            foreach ($quote['salesQuoteLines'] as $line) {
                                $totalQuantity += isset($line['quantity']) ? (float)$line['quantity'] : 0;
                            }
                        }
                        return $totalQuantity >= (float)$quantityMin;
                    });
                }

                if ($quantityMax !== null && $quantityMax !== '') {
                    $quotes = array_filter($quotes, function($quote) use ($quantityMax) {
                        $totalQuantity = 0;
                        if (isset($quote['salesQuoteLines']) && is_array($quote['salesQuoteLines'])) {
                            foreach ($quote['salesQuoteLines'] as $line) {
                                $totalQuantity += isset($line['quantity']) ? (float)$line['quantity'] : 0;
                            }
                        }
                        return $totalQuantity <= (float)$quantityMax;
                    });
                }

                // Sort by document date (newest first)
                usort($quotes, function($a, $b) {
                    $dateA = $a['documentDate'] ?? '';
                    $dateB = $b['documentDate'] ?? '';
                    return strcmp($dateB, $dateA);
                });
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