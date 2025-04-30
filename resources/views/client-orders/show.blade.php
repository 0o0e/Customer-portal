@extends('layouts.app')

@section('title', 'Quote Details')

@section('content')
<style>
    .quote-details-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 20px auto;
        width: 95%;
    }

    .quote-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .quote-header h1 {
        font-size: 1.875rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .quote-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-group {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
    }

    .info-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #1e293b;
        font-weight: 500;
    }

    .items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 1.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .items-table th,
    .items-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .items-table th {
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
    }

    .items-table tr:last-child td {
        border-bottom: none;
    }

    .numeric {
        text-align: right;
    }

    .back-button {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #475569;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.875rem;
        margin-top: 1.5rem;
        transition: background 0.2s;
    }

    .back-button:hover {
        background: #334155;
        color: white;
        text-decoration: none;
    }

    .total-row {
        font-weight: 600;
        background: #f8fafc;
    }
</style>

<div class="quote-details-container">
    <div class="quote-header">
        <h1>Quote Details</h1>
        <div>Quote Number: {{ $quote['number'] }}</div>
    </div>

    <div class="quote-info">
        <div class="info-group">
            <div class="info-label">Customer</div>
            <div class="info-value">{{ $quote['customerName'] }}</div>
        </div>
        <div class="info-group">
            <div class="info-label">Document Date</div>
            <div class="info-value">{{ $quote['documentDate'] }}</div>
        </div>
        <div class="info-group">
            <div class="info-label">Status</div>
            <div class="info-value">{{ $quote['status'] }}</div>
        </div>
    </div>

    <h2>Items</h2>
    <div class="table-responsive">
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="numeric">Quantity</th>
                    <th class="numeric">Unit Price</th>
                    <th class="numeric">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote['salesQuoteLines'] as $line)
                    <tr>
                        <td>{{ $line['description'] }}</td>
                        <td class="numeric">{{ number_format($line['quantity'], 2) }}</td>
                        <td class="numeric">{{ number_format($line['unitPrice'], 2) }}</td>
                        <td class="numeric">{{ number_format($line['quantity'] * $line['unitPrice'], 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">Total Amount (Including Tax)</td>
                    <td class="numeric">{{ number_format($quote['totalAmountIncludingTax'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('client-orders.index') }}" class="back-button">
        Back to Quotes
    </a>
</div>
@endsection 