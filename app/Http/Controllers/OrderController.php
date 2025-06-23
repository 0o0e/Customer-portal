<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $customerNo = auth()->user()->No;

        // $orders = DB::table('Sales_Header')
        //     ->where('Sell-to_Customer_No', $customerNo)
        //     ->orWhere('Bill-to_Customer_No', $customerNo)
        //     ->orderBy('Order_Date', 'desc')  // Most recent first
        //     ->paginate(10); // 10 orders per page

        // $query = DB::table('Sales_Header')
        //     ->where(function($q) use ($customerNo){
        //         $q->where('Sell-to_Customer_No', $customerNo)
        //             ->orWhere('Bill-to_Customer_No', $customerNo);
        //     })
        $query = DB::table('Sales_Header')
        ->where(function($q) use ($customerNo) {
            $q->where('Sell-to_Customer_No', $customerNo)
              ->orWhere('Bill-to_Customer_No', $customerNo);
        });

        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $quantityMin = $request->query('quantity_min');
        $quantityMax = $request->query('quantity_max');

        if ($dateFrom){
            $query->whereDate('Order_Date', '>=', $dateFrom);
        }
        if ($dateTo){
            $query->whereDate('Order_Date', '<=', $dateTo);
        }
        if ($quantityMin != null && $quantityMin != ''){
            $query->where('Total_Quantity', '>=',  (float)$quantityMin);
        }
        if ($quantityMax != null && $quantityMax != ''){
            $query->where('Total_Quantity', '<=',  (float)$quantityMax);
        }

        $orders = $query->orderBy('Order_Date', 'desc')->paginate(10)->appends($request->query());


        return view('orders.index', ['orders' => $orders]);
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
