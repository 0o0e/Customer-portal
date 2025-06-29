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

    .filters-section {
        padding: 1rem;
        border-bottom: 1px solid #edf2f7;
        background: #f7fafc;
        border-radius: 6px;
        margin-bottom: 1rem;
    }

    .filters-form {
        width: 100%;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .filter-group label {
        font-weight: 500;
        color: #4a5568;
        font-size: 0.875rem;
    }

    .filter-group input {
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .filter-actions {
        display: flex;
        gap: 0.5rem;
        align-items: end;
    }

    .filter-actions .btn {
        background: #4299e1;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        text-decoration: none;
        text-align: center;
        white-space: nowrap;
        font-size: 0.875rem;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }

    .filter-actions .btn:hover {
        background: #3182ce;
    }

    .filter-actions .btn-clear {
        background: #e2e8f0;
        color: #2d3748;
    }

    .filter-actions .btn-clear:hover {
        background: #cbd5e0;
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

    <div class="filters-section">
        <form id="filterForm" method="GET" action="{{ route('client-orders.index') }}" class="filters-form">
            <div class="filters-grid">
                
                <div class="filter-group">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>

                <div class="filter-group">
                    <label for="date_to">To Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>

                <div class="filter-group">
                    <label for="quantity_min">Min Quantity</label>
                    <input type="number" step="0.01" name="quantity_min" id="quantity_min" class="form-control" value="{{ request('quantity_min') }}">
                </div>

                <div class="filter-group">
                    <label for="quantity_max">Max Quantity</label>
                    <input type="number" step="0.01" name="quantity_max" id="quantity_max" class="form-control" value="{{ request('quantity_max') }}">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('client-orders.index') }}" class="btn btn-clear">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    @forelse($quotes as $quote)
        @if($loop->first)
            <div class="table-wrapper">
                <table class="quotes-table">
                    <thead>
                        <tr>
                            <th>Quote No</th>
                            <th>Customer</th>
                            <th>Document Date</th>
                            <th>Status</th>
                            <th>Total Quantity</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
        @endif
                        <tr>
                            <td>{{ $quote['number'] }}</td>
                            <td>{{ $quote['customerName'] }}</td>
                            <td class="date-cell">{{ $quote['documentDate'] }}</td>
                            <td>{{ $quote['status'] }}</td>
                            <td class="numeric-cell">
                                @php
                                    $totalQuantity = 0;
                                    if (isset($quote['salesQuoteLines']) && is_array($quote['salesQuoteLines'])) {
                                        foreach ($quote['salesQuoteLines'] as $line) {
                                            $totalQuantity += isset($line['quantity']) ? (float)$line['quantity'] : 0;
                                        }
                                    }
                                @endphp
                                {{ number_format($totalQuantity, 2) }}
                            </td>
                            <td class="numeric-cell">{{ number_format($quote['totalAmountIncludingTax'], 2) }}</td>
                            <td>
                                <a href="{{ route('client-orders.show', $quote['id']) }}" class="view-link">View Details</a>
                            </td>
                        </tr>
        @if($loop->last)
                    </tbody>
                </table>
            </div>
        @endif
    @empty
        <div class="alert alert-info" style="background: #e0f2fe; color: #0277bd; border: 1px solid #b3e5fc;">
            <i class="fas fa-info-circle"></i>
            <div>No quotes found. <a href="{{ route('client-orders.create') }}" style="color: #0277bd; text-decoration: underline;">Create your first quote</a>.</div>
        </div>
    @endforelse
</div>
@endsection