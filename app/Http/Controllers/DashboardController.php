<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();

        $selectedClients = session('selected_clients', [$user->No]);
        // If this is a POST request with selected clients, update the session
        // if ($request->isMethod('post')) {
        //     $selectedClients = $request->input('selected_clients', [$user->No]);
        //     session(['selected_clients' => $selectedClients]);

        // }

        // Get recent sales orders (using string 'Order' for Document_Type)
        $recentOrders = DB::table('Sales_Header')
            ->whereIn('Sell-to_Customer_No', $selectedClients)
            ->where('Document_Type', 1) // 1 = Order
            ->select('No', 'Order_Date', 'Status', 'Amount', 'Ship-to_Name')
            ->orderBy('Order_Date', 'desc')
            ->limit(5)
            ->get();

        // Get total products count
        $totalProducts = DB::table('catalog')
            ->whereIn('MAIN CUSTOMER', $selectedClients)
            ->count();

        // Get pending product requests
        $pendingRequests = DB::table('item_request')
            ->whereIn('No', function($query) use ($selectedClients) {
                $query->select('Item No#')
                    ->from('catalog')
                    ->whereIn('MAIN CUSTOMER', $selectedClients);
            })
            ->where('Blocked', false)
            ->count();

        // Get total orders count
        $totalOrders = DB::table('Sales_Header')
            ->whereIn('Sell-to_Customer_No', $selectedClients)
            ->where('Document_Type', 1) // 1 = Order
            ->count();

        // Get recent product requests
        $recentRequests = DB::table('item_request')
            ->whereIn('No', function($query) use ($selectedClients) {
                $query->select('Item No#')
                    ->from('catalog')
                    ->whereIn('MAIN CUSTOMER', $selectedClients);
            })
            ->select('No', 'Description', 'Base_Unit_of_Measure', 'Unit_Price')
            ->orderBy('SystemCreatedAt', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'recentOrders',
            'totalProducts',
            'pendingRequests',
            'totalOrders',
            'recentRequests'
        ));
    }

}
