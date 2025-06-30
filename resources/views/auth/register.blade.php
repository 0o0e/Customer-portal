@extends('layouts.app')
@section('title', 'Account Requests')

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

    .info-box {
        background: #e3f2fd;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 25px;
        border-left: 4px solid #2196f3;
    }

    .info-box p {
        margin: 0;
        color: #1976d2;
        font-size: 14px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #edf2f7;
        border-radius: 6px;
        background: white;
        margin-bottom: 1rem;
    }

    .requests-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
    }

    .requests-table th,
    .requests-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.875rem;
    }

    .requests-table th {
        background: #f7fafc;
        font-weight: 600;
        color: #4a5568;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .requests-table tbody tr:last-child td {
        border-bottom: none;
    }

    .requests-table tr:hover {
        background: #f7fafc;
    }

    .btn {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.875rem;
        transition: all 0.2s;
        text-align: center;
        white-space: nowrap;
        text-decoration: none;
        border: none;
        cursor: pointer;
        margin-right: 0.5rem;
    }

    .btn-approve {
        background: #10b981;
        color: white;
    }

    .btn-approve:hover {
        background: #059669;
    }

    .btn-reject {
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .date-cell {
        color: #4a5568;
        font-size: 0.875rem;
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

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }

    @media (max-width: 768px) {
        .requests-container {
            padding: 20px;
            margin: 10px auto;
        }

        .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            margin-bottom: 0.25rem;
        }
    }
</style>

<div class="requests-container">
    <h1>Account Requests</h1>

    <div class="info-box">
        <p><strong>Account Request Management:</strong> Review and approve/reject new account requests. Approved accounts will receive login credentials via email.</p>
    </div>

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

    @forelse($accountRequests as $request)
        @if($loop->first)
            <div class="table-wrapper">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Customer Number</th>
                            <th>Email</th>
                            <th>GDPR Consent</th>
                            <th>Request Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        @endif
                        <tr>
                            <td>{{ $request->company_name }}</td>
                            <td>{{ $request->customer_number }}</td>
                            <td>{{ $request->email }}</td>
                            <td>
                                @if($request->gdpr_consent)
                                    <span style="color: #10b981; font-weight: 600;">✓ Yes</span>
                                    <br><small style="color: #6b7280;">{{ $request->gdpr_consent_date ? $request->gdpr_consent_date->format('M d, Y H:i') : 'No date' }}</small>
                                @else
                                    <span style="color: #ef4444;">✗ No</span>
                                @endif
                            </td>
                            <td class="date-cell">{{ $request->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <span class="status-badge status-pending">{{ ucfirst($request->status) }}</span>
                            </td>
                            <td>
                                @if($request->status === 'pending')
                                    <form method="POST" action="{{ route('account.request.approve', $request) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-approve" 
                                                onclick="return confirm('Are you sure you want to approve this account request?')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('account.request.reject', $request) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-reject" 
                                                onclick="return confirm('Are you sure you want to reject this account request?')">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Processed</span>
                                @endif
                            </td>
                        </tr>
        @if($loop->last)
                    </tbody>
                </table>
            </div>
        @endif
    @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No Account Requests</h3>
            <p>There are currently no pending account requests to review.</p>
        </div>
        <tr>
            <td colspan="7" class="text-center">No account requests found.</td>
        </tr>
    @endforelse
</div>
@endsection