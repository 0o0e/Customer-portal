@extends('layouts.app')

@section('content')
<style>
    .invoice-box {
        background: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        max-width: 900px;
        margin: 40px auto;
        font-size: 16px;
        color: #333;
    }
    .invoice-header {
        border-bottom: 2px solid #eee;
        margin-bottom: 30px;
        padding-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .company-details {
        font-weight: bold;
        font-size: 1.2rem;
    }
    .invoice-title {
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: 2px;
        color: #2c3e50;
    }
    .info-table th {
        width: 160px;
        color: #888;
        font-weight: 500;
        background: none;
        border: none;
        padding-left: 0;
    }
    .info-table td {
        border: none;
        background: none;
        padding-left: 0;
    }
    .invoice-lines th, .invoice-lines td {
        vertical-align: middle;
        text-align: left;
    }
    .invoice-lines th {
        background: #f8f9fa;
        font-weight: 600;
        border-top: 2px solid #dee2e6;
    }
    .invoice-lines td {
        border-bottom: 1px solid #f0f0f0;
    }
    .summary-table th, .summary-table td {
        border: none;
        background: none;
        font-size: 1.1rem;
    }
    .summary-table th {
        text-align: right;
        color: #555;
        font-weight: 500;
    }
    .summary-table td {
        text-align: right;
        font-weight: bold;
    }
    .invoice-footer {
        margin-top: 40px;
        color: #888;
        font-size: 0.95rem;
        text-align: center;
    }
</style>
<div class="invoice-box">
    
    <div class="invoice-header">
        <div class="company-details">
            <div style="font-size:1.5rem; font-weight:bold;">Özgazi dairy foods</div>
            <div>Nijverheidsweg 39, 4879 AP Etten-Leur</div>
            <div>Phone: +31765036992</div>
            <div>Email: info@ozgazi.nl</div>
        </div>
        <div class="invoice-title">
            INVOICE
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <table class="table table-borderless info-table mb-0">
                <tr>
                    <th>Bill To:</th>
                    <td>{{ $invoiceHeader->{'Sell-to_Customer_No'} }}</td>
                </tr>
                <tr>
                    <th>Document No:</th>
                    <td>{{ $invoiceHeader->Document_No }}</td>
                </tr>
                <tr>
                    <th>Posting Date:</th>
                    <td>{{ \Carbon\Carbon::parse($invoiceHeader->Posting_Date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Shipment Date:</th>
                    <td>{{ $invoiceHeader->Shipment_Date ? \Carbon\Carbon::parse($invoiceHeader->Shipment_Date)->format('d/m/Y') : 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-borderless info-table mb-0">
                <tr>
                    <th>Transport Method:</th>
                    <td>{{ $invoiceHeader->Transport_Method }}</td>
                </tr>
                <tr>
                    <th>Responsibility Center:</th>
                    <td>{{ $invoiceHeader->Responsibility_Center }}</td>
                </tr>
            </table>
        </div>
    </div>
    <h5 class="mt-4 mb-3" style="font-weight:600;">Invoice Items</h5>
    <div class="table-responsive">
        <table class="table invoice-lines mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>VAT %</th>
                    <th>Discount %</th>
                    <th>Amount</th>
                    <th>Amount (Inc. VAT)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceLines as $i => $line)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $line->Description }}</td>
                    <td>{{ $line->Location_Code }}</td>
                    <td>{{ number_format($line->Quantity, 2) }}</td>
                    <td>{{ $line->Unit_of_Measure }}</td>
                    <td>{{ number_format($line->Unit_Price, 2) }}</td>
                    <td>{{ number_format($line->VAT__, 2) }}%</td>
                    <td>{{ number_format($line->Line_Discount__, 2) }}%</td>
                    <td>{{ number_format($line->Amount, 2) }}</td>
                    <td>{{ number_format($line->Amount_Including_VAT, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-end mt-4">
        <div class="col-md-6">
            <table class="table summary-table">
                <tr>
                    <th>Subtotal:</th>
                    <td>{{ number_format($invoiceLines->sum('Amount'), 2) }}</td>
                </tr>
                <tr>
                    <th>Total VAT:</th>
                    <td>{{ number_format($invoiceLines->sum('Amount_Including_VAT') - $invoiceLines->sum('Amount'), 2) }}</td>
                </tr>
                <tr style="border-top:2px solid #333;">
                    <th style="font-size:1.2rem;">Total:</th>
                    <td style="font-size:1.2rem;">{{ number_format($invoiceLines->sum('Amount_Including_VAT'), 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="invoice-footer">
        Thank you for your business!<br>
    </div>
    <div class="mt-3">
        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Back to Invoices</a>
    </div>
</div>
@endsection 