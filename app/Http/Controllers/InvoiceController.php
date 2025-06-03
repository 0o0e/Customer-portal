<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        // get logged in useer
        $customerNo = auth()->user()->No;

        $invoices = DB::table('Sales_Invoice_Line')
            ->where('Sell-to_Customer_No', $customerNo)
            ->select([
                'Document_No',
                'Sell-to_Customer_No',
                'Posting_Date',
                'Description',
                'Quantity',
                'Unit_Price',
                'Amount',
                'Amount_Including_VAT',
                'VAT__',
                'Line_Discount__'
            ])
            ->orderBy('Posting_Date', 'desc')
            ->paginate(15);

        return view('invoices.index', compact('invoices'));
    }

    public function show($documentNo)
    {
        $customerNo = auth()->user()->No;
        $invoice = DB::table('Sales_Invoice_Line')
            ->where('Document_No', $documentNo)
            ->where('Sell-to_Customer_No', $customerNo)
            ->get();

        if ($invoice->isEmpty()) {
            abort(404);
        }

        $invoiceHeader = $invoice->first();
        $invoiceLines = $invoice;

        return view('invoices.show', compact('invoiceHeader', 'invoiceLines'));
    }
}