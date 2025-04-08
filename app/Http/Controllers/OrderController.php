<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        
        $customerNo = auth()->user()->No;
        
        $orders = DB::table('Sales_Header')
            ->where('Sell-to_Customer_No', $customerNo)
            ->orWhere('Bill-to_Customer_No', $customerNo)
            ->orderBy('Order_Date', 'desc')  // Most recent first
            ->paginate(10);                  // 10 orders per page

        return view('orders.index', compact('orders'));
    }

    public function show($orderNo)
    {
        $order = DB::table('Sales_Header')
            ->where('No', $orderNo)
            ->first();

        if (!$order) {
            abort(404);
        }

        $orderLines = DB::table('Sales_Line')
            ->where('Document_No', $orderNo)
            ->get();

        return view('orders.show', compact('order', 'orderLines'));
    }
} 