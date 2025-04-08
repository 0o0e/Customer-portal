@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<style>
    body {
        background: #f8fafc;
        margin: 0;
        min-height: 100vh;
    }

    .orders-container {
        max-width: 95%;
        width: 1100px;
        margin: 0.5rem auto;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-size: 1.5rem;
        color: #2d3748;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #edf2f7;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        background: white;
        margin-bottom: 1rem;
    }

    .orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }

    .orders-table th,
    .orders-table td {
        padding: 0.75rem 0.75rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .orders-table th {
        background: #f7fafc;
        font-weight: 600;
        color: #4a5568;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .orders-table tbody tr:last-child td {
        border-bottom: none;
    }

    .orders-table tr:hover {
        background: #f7fafc;
    }

    .view-link {
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

    .view-link:hover {
        background: #3182ce;
    }

    .date-cell {
        color: #4a5568;
    }

    .numeric-cell {
        text-align: right;
    }

    .pagination-container {
        margin-top: 1.5rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 6px;
    }

    .pagination-info {
        margin-bottom: 0.75rem;
        color: #718096;
        font-size: 0.875rem;
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        padding: 0.4rem 0.8rem;
        border: 1px solid #e2e8f0;
        color: #4a5568;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: all 0.2s;
        background: white;
    }

    .pagination a:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    .pagination .current {
        background: #4299e1;
        color: white;
        border-color: #4299e1;
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
        .orders-container {
            margin: 0;
            border-radius: 0;
        }
    }
</style>

<div class="orders-container">
    <h1 class="page-title">Orders List</h1>

    @if($orders->isEmpty())
        <p>No orders found.</p>
    @else
        <div class="table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Bill To</th>
                        <th>Bill Address</th>
                        <th>Bill City</th>
                        <th>Ship To</th>
                        <th>Ship Address</th>
                        <th>Ship City</th>
                        <th>Order Date</th>
                        <th>Ship Date</th>
                        <th>External Doc</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->No }}</td>
                            <td>{{ $order->{'Bill-to_Name'} }}</td>
                            <td>{{ $order->{'Bill-to_Address'} }}</td>
                            <td>{{ $order->{'Bill-to_City'} }}</td>
                            <td>{{ $order->{'Ship-to_Name'} }}</td>
                            <td>{{ $order->{'Ship-to_Address'} }}</td>
                            <td>{{ $order->{'Ship-to_City'} }}</td>
                            <td class="date-cell">{{ $order->Order_Date }}</td>
                            <td class="date-cell">{{ $order->Shipment_Date }}</td>
                            <td>{{ $order->External_Document_No }}</td>
                            <td class="numeric-cell">{{ number_format($order->Total_Quantity, 2) }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->No) }}" class="view-link">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
            </div>
            <div class="pagination">
                @if ($orders->onFirstPage())
                    <span>« Previous</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}">« Previous</a>
                @endif

                @for ($i = 1; $i <= $orders->lastPage(); $i++)
                    @if ($i == $orders->currentPage())
                        <span class="current">{{ $i }}</span>
                    @else
                        <a href="{{ $orders->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}">Next »</a>
                @else
                    <span>Next »</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection 