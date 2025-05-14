@extends('layouts.app')

@section('title', 'Product Requests')

@section('content')
<style>
    .requests-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 20px auto;
        width: 95%;
    }

    .requests-container h1 {
        font-size: 28px;
        color: #1e293b;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
    }

    .no-requests-message {
        background-color: #fee2e2;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
        font-size: 18px;
        color: #dc2626;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .success-message {
        background-color: #dcfce7;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 16px;
        color: #166534;
        text-align: center;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .requests-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        min-width: 800px;
    }

    .requests-table th, .requests-table td {
        padding: 15px;
        text-align: left;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
    }

    .requests-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }

    .requests-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .btn-approve {
        padding: 8px 16px;
        background-color: #10b981;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-right: 8px;
    }

    .btn-deny {
        padding: 8px 16px;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-approve:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .btn-deny:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .requests-container {
            padding: 15px;
            margin: 10px;
            width: auto;
        }

        .requests-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn-approve, .btn-deny {
            width: 100%;
            margin-bottom: 8px;
        }
    }
</style>

<div class="requests-container">
    <h1>Product Requests</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if(count($requests) > 0)
        <div class="table-responsive">
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Search Description</th>
                        <th>Requested By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->Description }}</td>
                            <td>{{ $request->Search_Description }}</td>
                            <td>{{ $request->user_name }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.product-requests.handle', ['id' => $request->No_2]) }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn-approve">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.product-requests.handle', ['id' => $request->No_2]) }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="deny">
                                    <button type="submit" class="btn-deny">Deny</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-requests-message">
            <p>No product requests found.</p>
        </div>
    @endif
</div>
@endsection
