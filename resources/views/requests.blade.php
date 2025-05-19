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


    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .details-section {
        background: white;
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .details-list dt {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .details-list dd {
        color: #1e293b;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .btn-details {
        padding: 6px 12px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-details:hover {
        background-color: #2563eb;
    }

    .details-row {
    display: none;
    background-color: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    margin: 10px 0;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    padding: 15px;
}

.details-section {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #e5e7eb;
}

.details-title {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 15px;
    font-size: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e5e7eb;
}

.details-list {
    display: grid;
    grid-template-columns: 150px 1fr;
    gap: 8px;
}

.details-list dt {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
    padding: 4px 8px;
    background-color: #f8fafc;
    border-radius: 4px;
    align-self: start;
}

.details-list dd {
    color: #1e293b;
    font-size: 14px;
    padding: 4px 0;
    margin: 0;
}

.btn-details {
    padding: 6px 12px;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
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
                        <th>Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->Description }}</td>
                            <td>{{ $request->Search_Description }}</td>
                            <td>
                                <div>{{ $request->user_name }}</div>
                            </td>
                            <td>
                                <button class="btn-details" onclick="toggleDetails('{{ $request->No_2 }}')">
                                    View Details
                                </button>
                            </td>
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

                        <tr>
                            <td colspan="5">
                                <div id="details-{{ $request->No_2 }}" class="details-row">
                                    <div class="details-grid">
                                        <div class="details-section">
                                            <div class="details-title">Product Information</div>
                                            <dl class="details-list">
                                                <dt>Description 2</dt>
                                                <dd>{{ $request->Description_2 }}</dd>
                                                <dt>Base Unit of Measure</dt>
                                                <dd>{{ $request->Base_Unit_of_Measure }}</dd>
                                                <dt>Vendor Item No</dt>
                                                <dd>{{ $request->Vendor_Item_No }}</dd>
                                                <dt>Alternative Item No</dt>
                                                <dd>{{ $request->Alternative_Item_No }}</dd>
                                                <dt>GTIN</dt>
                                                <dd>{{ $request->GTIN ?? 'N/A' }}</dd>
                                            </dl>
                                        </div>
                                        <div class="details-section">
                                            <div class="details-title">Technical Details</div>
                                            <dl class="details-list">
                                                <dt>Gross Weight</dt>
                                                <dd>{{ $request->Gross_Weight }}</dd>
                                                <dt>Net Weight</dt>
                                                <dd>{{ $request->Net_Weight }}</dd>
                                                <dt>Tariff No</dt>
                                                <dd>{{ $request->Tariff_No }}</dd>
                                                <dt>Sales Quantity</dt>
                                                <dd>{{ $request->Sales__Qty_ }}</dd>
                                            </dl>
                                        </div>
                                        @if($request->Comment)
                                            <div class="details-section" style="grid-column: span 2;">
                                                <div class="details-title">Additional Comments</div>
                                                <p>{{ $request->Comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
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

<script>
function toggleDetails(id) {
    const detailsRow = document.getElementById(`details-${id}`);
    if (detailsRow.style.display === 'none' || !detailsRow.style.display) {
        detailsRow.style.display = 'block';
    } else {
        detailsRow.style.display = 'none';
    }
}
</script>
@endsection
