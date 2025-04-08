@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<style>
    body {
        background: #f8fafc;
        margin: 0;
        min-height: 100vh;
    }

    .order-container {
        max-width: 95%;
        width: 1100px;
        margin: 0.5rem auto;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .order-header {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-header h1 {
        font-size: 1.5rem;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-header h1::before {
        content: '📦';
        font-size: 1.25rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        background: #4299e1;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: background 0.2s;
        gap: 0.25rem;
    }

    .back-link:hover {
        background: #3182ce;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        background: white;
        margin-bottom: 1rem;
    }

    .lines-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }

    .lines-table th,
    .lines-table td {
        padding: 0.75rem 0.75rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .lines-table th {
        background: #f7fafc;
        font-weight: 600;
        color: #4a5568;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .lines-table tbody tr:last-child td {
        border-bottom: none;
    }

    .lines-table tr:hover {
        background: #f7fafc;
    }

    .numeric-cell {
        text-align: right;
        font-family: monospace;
        font-size: 0.8125rem;
    }

    .date-cell {
        color: #4a5568;
        font-size: 0.8125rem;
    }

    /* Custom scrollbar for Webkit browsers */
    .table-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .table-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    @media (max-width: 768px) {
        .order-container {
            margin: 0;
            border-radius: 0;
        }

        .order-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .back-link {
            width: 100%;
            justify-content: center;
        }
    }

    .total-section {
        margin-top: 1rem;
        padding: 1rem;
        background: #f7fafc;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        font-size: 1rem;
    }

    .total-amount {
        margin-left: 1rem;
        font-weight: 600;
        color: #2d3748;
        font-family: monospace;
        font-size: 1.125rem;
    }
</style>

<div class="order-container">
    <div class="order-header">
        <h1>Order #{{ $order->No }}</h1>
        <a href="{{ route('orders.index') }}" class="back-link">
            <span>←</span>
            <span>Back to Orders</span>
        </a>
    </div>

    <div class="table-wrapper">
        <table class="lines-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Gross Weight</th>
                    <th>Net Weight</th>
                    <th>Item Category</th>
                    <th>Item Reference</th>
                    <th>Line Amount</th>
                    <th>Planned Delivery</th>
                    <th>Planned Shipment</th>
                    <th>Qty per Unit</th>
                    <th>Base Quantity</th>
                    <th>Shipment Date</th>
                    <th>Shipping Agent</th>
                    <th>Unit of Measure</th>
                    <th>UoM Code</th>
                    <th>Unit Price</th>
                    <th>VAT Bus. Group</th>
                    <th>VAT Prod. Group</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderLines as $line)
                    <tr>
                        <td>{{ $line->Description }}</td>
                        <td class="numeric-cell">{{ number_format($line->Quantity, 2) }}</td>
                        <td class="numeric-cell">{{ number_format($line->Gross_Weight, 2) }}</td>
                        <td class="numeric-cell">{{ number_format($line->Net_Weight, 2) }}</td>
                        <td>{{ $line->Item_Category_Code }}</td>
                        <td>{{ $line->Item_Reference_No }}</td>
                        <td class="numeric-cell">{{ number_format($line->Line_Amount, 2) }}</td>
                        <td class="date-cell">{{ $line->Planned_Delivery_Date }}</td>
                        <td class="date-cell">{{ $line->Planned_Shipment_Date }}</td>
                        <td class="numeric-cell">{{ number_format($line->Qty_per_Unit_of_Measure, 2) }}</td>
                        <td class="numeric-cell">{{ number_format($line->{'Quantity__Base_'}, 2) }}</td>
                        <td class="date-cell">{{ $line->Shipment_Date }}</td>
                        <td>{{ $line->Shipping_Agent_Code }}</td>
                        <td>{{ $line->Unit_of_Measure }}</td>
                        <td>{{ $line->Unit_of_Measure_Code }}</td>
                        <td class="numeric-cell">{{ number_format($line->Unit_Price, 2) }}</td>
                        <td>{{ $line->VAT_Bus_Posting_Group }}</td>
                        <td>{{ $line->VAT_Prod_Posting_Group }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <span>Total Amount:</span>
        <span class="total-amount">€ {{ number_format($orderLines->sum('Line_Amount'), 2) }}</span>
    </div>
</div>
@endsection 