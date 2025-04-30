@extends('layouts.app')

@section('title', 'Quotes')

@section('content')
<style>
    .quotes-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 20px auto;
        width: 95%;
    }

    .quotes-container h1 {
        font-size: 28px;
        color: #1e293b;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        background: white;
        margin-bottom: 1rem;
    }

    .quotes-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }

    .quotes-table th,
    .quotes-table td {
        padding: 0.75rem 0.75rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .quotes-table th {
        background: #f7fafc;
        font-weight: 600;
        color: #4a5568;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .quotes-table tbody tr:last-child td {
        border-bottom: none;
    }

    .quotes-table tr:hover {
        background: #f7fafc;
    }

    .edit-link {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        background: #4299e1;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: background 0.2s;
        text-align: center;
        white-space: nowrap;
    }

    .edit-link:hover {
        background: #3182ce;
    }

    .view-link {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        background: #10b981;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: background 0.2s;
        text-align: center;
        white-space: nowrap;
    }

    .view-link:hover {
        background: #059669;
        color: white;
        text-decoration: none;
    }

    .date-cell {
        color: #4a5568;
    }

    .numeric-cell {
        text-align: right;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    @media (max-width: 768px) {
        .quotes-container {
            padding: 20px;
            margin: 10px auto;
        }
    }
</style>

<div class="quotes-container">
    <h1>Quotes List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(empty($quotes))
        <p>No quotes found.</p>
    @else
        <div class="table-wrapper">
            <table class="quotes-table">
                <thead>
                    <tr>
                        <th>Quote No</th>
                        <th>Customer</th>
                        <th>Document Date</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotes as $quote)
                        <tr>
                            <td>{{ $quote['number'] }}</td>
                            <td>{{ $quote['customerName'] }}</td>
                            <td class="date-cell">{{ $quote['documentDate'] }}</td>
                            <td>{{ $quote['status'] }}</td>
                            <td class="numeric-cell">{{ $quote['salesQuoteLines'][0]['quantity'] ?? 0 }}</td>
                            <td class="numeric-cell">{{ number_format($quote['totalAmountIncludingTax'], 2) }}</td>
                            <td>
                                <a href="{{ route('client-orders.show', $quote['id']) }}" class="view-link">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 