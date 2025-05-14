<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Refresh the user data from the database
        $user = Auth::user();
        $user->refresh();

        $catalog = new Catalog();

        // Get related customers
        $relatedCustomers = $catalog->getRelatedCustomers($user->No);

        // If this is a POST request with selected clients, update the session
        if ($request->isMethod('post')) {
            $selectedClients = $request->input('selected_clients', [$user->No]);
            session(['selected_clients' => $selectedClients]);
        } else {
            // Get selected clients from session, default to current user if none selected
            $selectedClients = session('selected_clients', [$user->No]);
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

        return view('products', compact('hasProducts', 'allProducts', 'relatedCustomers'));
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

        // Log the selected clients for debugging
        \Log::info('Updating selected clients:', [
            'user_id' => $user->id,
            'user_no' => $user->No,
            'selected_clients' => $selectedClients,
            'request_data' => $request->all()
        ]);

        // Store in session
        session(['selected_clients' => $selectedClients]);

        return response()->json(['success' => true, 'selected_clients' => $selectedClients]);
    }

    public function showRequestForm()
    {
        return view('products.request');
    }
    public function storeRequest(Request $request)
    {
        try {
            // Log the incoming request data
            \Log::info('Received product request:', $request->all());

            $request->validate([
                'description' => 'required|string|max:255',         // Changed from Description
                'search_description' => 'required|string|max:255',  // Changed from Search_Description
                'Description_2' => 'required|string|max:255',
                'Base_Unit_of_Measure' => 'required|string|max:10',
                'Vendor_Item_No' => 'required|string|max:50',
                'Alternative_Item_No' => 'required|string|max:50',
                'Gross_Weight' => 'required|numeric|min:0',
                'Net_Weight' => 'required|numeric|min:0',
                'Tariff_No' => 'required|string|max:50',
                'Sales__Qty_' => 'required|numeric|min:0',
                'GTIN' => 'nullable|string|max:50',
                'Comment' => 'nullable|string|max:255'
            ]);

            \Log::info('Validation passed');

            do {
                $randomNo = 'PRQ' . str_pad(random_int(1, 99999), 5, '0', STR_PAD_LEFT);
                $exists = DB::table('item_request')->where('No', $randomNo)->exists();
            } while ($exists);

            DB::table('item_request')->insert([
                'Description' => $request->description,              // Changed to match form field names
                'Search_Description' => $request->search_description,
                'Description_2' => $request->Description_2,
                'Base_Unit_of_Measure' => $request->Base_Unit_of_Measure,
                'Vendor_Item_No' => $request->Vendor_Item_No,
                'Alternative_Item_No' => $request->Alternative_Item_No,
                'Gross_Weight' => $request->Gross_Weight,
                'Net_Weight' => $request->Net_Weight,
                'Tariff_No' => $request->Tariff_No,
                'Comment' => $request->Comment,
                'Sales__Qty_' => $request->Sales__Qty_,
                'GTIN' => $request->GTIN,
                'SystemModifiedBy' => '3C6DC059-6478-474A-B8E1-EA112F6A9FCA',
                'No' => Auth::user()->No,
                'No_2' => $randomNo,
                'Assembly_BOM' => '0',
                'Price_Unit_Conversion' => '1',
                'Type' => '1',
                'Inventory_Posting_Group' => 'Z-INV'
            ]);

            \Log::info('Product request stored successfully');
            return back()->with('success', 'Product request submitted successfully');

        } catch (\Exception $e) {
            \Log::error('Error storing product request: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit product request: ' . $e->getMessage())
                ->withInput();
        }
    }
        // Add these methods to your existing ProductController class
        public function adminRequests()
        {
            if (!Auth::user()->is_admin) {
                abort(403);
            }

            $requests = DB::table('item_request')
                ->join('users', 'item_request.No', '=', 'users.No') // This is correct now - joining on user No
                ->select('item_request.*', 'users.name as user_name')
                ->get();

            return view('requests', compact('requests'));
        }
        public function handleRequest(Request $request, $no)
        {
            if (!Auth::user()->is_admin) {
                abort(403);
            }

            try {
                DB::beginTransaction();

                $action = $request->input('action');

                // Use No_2 to find the request
                $itemRequest = DB::table('item_request')->where('No_2', $no)->first();

                if (!$itemRequest) {
                    return back()->with('error', 'Request not found.');
                }

                if ($action === 'approve') {
                    DB::table('item')->insert([
                        'Description' => $itemRequest->Description,
                        'Search_Description' => $itemRequest->Search_Description,
                        'Description_2' => $itemRequest->Description_2,
                        'SystemModifiedBy' => $itemRequest->SystemModifiedBy,
                        'No' => $itemRequest->No,
                        'No_2' => $itemRequest->No_2,
                        'Assembly_BOM' => $itemRequest->Assembly_BOM,
                        'Base_Unit_of_Measure' => $itemRequest->Base_Unit_of_Measure,
                        'Price_Unit_Conversion' => $itemRequest->Price_Unit_Conversion,
                        'Type' => $itemRequest->Type,
                        'Inventory_Posting_Group' => $itemRequest->Inventory_Posting_Group,
                        'SystemCreatedAt' => now() // Add current timestamp


                                ]);
                                            // Insert into Catalog table
                        DB::table('Catalog')->insert([
                            'Item No#' => $itemRequest->No_2,
                            'Item Description' => $itemRequest->Description,
                            'Customer No#' => $itemRequest->No, // The customer who requested it
                            'Item Catalog' => $itemRequest->No_2, // Using same as Item No
                            'Description' => $itemRequest->Description_2,
                            'Sales Unit of Measure' => $itemRequest->Base_Unit_of_Measure,
                            'Variant Code' => '', // Default empty
                            'Valid from Date' => now(),
                            'Valid to Date' => null, // Set validity for 10 years
                            'MAIN CUSTOMER' => $itemRequest->No // The customer who requested it
                        ]);
                }

                // Delete the request
                DB::table('item_request')->where('No_2', $no)->delete();

                DB::commit();
                return redirect()->route('admin.product-requests')
                    ->with('success', 'Request ' . ($action === 'approve' ? 'approved' : 'denied') . ' successfully');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error handling product request: ' . $e->getMessage());
                return back()->with('error', 'An error occurred while processing the request.');
            }
        }

}
