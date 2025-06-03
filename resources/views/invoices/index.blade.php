@extends('layouts.app')

@section('content')
<style>
    .invoices-box {
        background: #fff;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        max-width: 900px;
        margin: 40px auto;
        font-size: 16px;
        color: #333;
    }
    .invoices-title {
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: 2px;
        color: #2c3e50;
        margin-bottom: 30px;
    }
    .invoices-table th, .invoices-table td {
        vertical-align: middle;
        text-align: left;
    }
    .invoices-table th {
        background: #f8f9fa;
        font-weight: 600;
        border-top: 2px solid #dee2e6;
    }
    .invoices-table tr {
        transition: background 0.15s;
    }
    .invoices-table tbody tr:hover {
        background: #f3f6fa;
    }
    .doc-badge {
        background: #eaf6ff;
        color: #007bff;
        font-weight: 600;
        border-radius: 6px;
        padding: 4px 12px;
        font-size: 1rem;
        letter-spacing: 1px;
        display: inline-block;
        min-width: 110px;
        text-align: center;
    }
    .pagination {
        justify-content: center;
    }
</style>
<div class="invoices-box">
    <div class="invoices-title">All Invoices</div>
    <div class="table-responsive">
        <table class="table invoices-table mb-0">
            <thead>
                <tr>
                    <th>Document No</th>
                    <th>Customer No</th>
                    <th>Posting Date</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td><span class="doc-badge">{{ $invoice->Document_No }}</span></td>
                    <td>{{ $invoice->{'Sell-to_Customer_No'} }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->Posting_Date)->format('d/m/Y') }}</td>
                    <td>{{ $invoice->Description }}</td>
                    <td>{{ number_format($invoice->Quantity, 2) }}</td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice->Document_No) }}" 
                           class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $invoices->links() }}
    </div>
</div>
@endsection 