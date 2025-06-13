@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')
<div class="header">
    <h1><i class="fas fa-history"></i> Account Activity Log</h1>
    <div class="user-profile">
        <span class="text-gray-600">Monitor your account activity for security</span>
    </div>
</div>

<div class="activity-log-container">
    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" action="{{ route('activity-log.index') }}" class="filters-form">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="activity_type">Activity Type:</label>
                    <select name="activity_type" id="activity_type" class="form-select">
                        <option value="">All Activities</option>
                        @foreach($activityTypes as $type)
                            <option value="{{ $type }}" {{ request('activity_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="date_from">From Date:</label>
                    <input type="date" name="date_from" id="date_from" 
                           value="{{ request('date_from') }}" class="form-input">
                </div>

                <div class="filter-group">
                    <label for="date_to">To Date:</label>
                    <input type="date" name="date_to" id="date_to" 
                           value="{{ request('date_to') }}" class="form-input">
                </div>

                <div class="filter-group">
                    <label for="search">Search:</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search in descriptions..." class="form-input">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('activity-log.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Activities Table -->
    <div class="activities-table-container">
        @if($activities->count() > 0)
            <div class="table-responsive">
                <table class="activities-table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr class="{{ $activity->isSuspicious() ? 'suspicious-activity' : '' }}">
                                <td>
                                    <div class="activity-info">
                                        <i class="{{ $activity->getActivityIcon() }}"></i>
                                        <span class="activity-type">{{ ucfirst(str_replace('_', ' ', $activity->activity_type)) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="activity-description">
                                        {{ $activity->getActivityDescription() }}
                                        @if($activity->isSuspicious())
                                            <span class="suspicious-badge">
                                                <i class="fas fa-exclamation-triangle"></i> Suspicious
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="ip-address">{{ $activity->ip_address ?? 'Unknown' }}</span>
                                </td>
                                <td>
                                    <div class="datetime-info">
                                        <div class="date">{{ $activity->created_at->format('M j, Y') }}</div>
                                        <div class="time">{{ $activity->created_at->format('g:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($activity->activity_type === 'failed_login')
                                        <span class="status-badge status-failed">
                                            <i class="fas fa-times"></i> Failed
                                        </span>
                                    @elseif($activity->activity_type === 'login')
                                        <span class="status-badge status-success">
                                            <i class="fas fa-check"></i> Success
                                        </span>
                                    @else
                                        <span class="status-badge status-info">
                                            <i class="fas fa-info"></i> Info
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        @else
            <div class="no-activities">
                <i class="fas fa-info-circle"></i>
                <h3>No activities found</h3>
                <p>No account activities match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<style>
.activity-log-container {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.filters-section {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
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
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 500;
    color: #374151;
    font-size: 0.875rem;
}

.form-select, .form-input {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s;
}

.form-select:focus, .form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    align-items: end;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.activities-table-container {
    padding: 1.5rem;
}

.table-responsive {
    overflow-x: auto;
}

.activities-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.activities-table th {
    background: #f9fafb;
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
}

.activities-table td {
    padding: 0.75rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: top;
}

.activities-table tr:hover {
    background: #f9fafb;
}

.suspicious-activity {
    background: #fef2f2;
}

.suspicious-activity:hover {
    background: #fee2e2;
}

.activity-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.activity-type {
    font-weight: 500;
    color: #374151;
}

.activity-description {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.suspicious-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #fef3c7;
    color: #92400e;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.ip-address {
    font-family: 'Courier New', monospace;
    color: #6b7280;
    font-size: 0.8rem;
}

.datetime-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.date {
    font-weight: 500;
    color: #374151;
}

.time {
    color: #6b7280;
    font-size: 0.8rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-success {
    background: #d1fae5;
    color: #065f46;
}

.status-failed {
    background: #fee2e2;
    color: #991b1b;
}

.status-info {
    background: #dbeafe;
    color: #1e40af;
}

.pagination-container {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
}

.no-activities {
    text-align: center;
    padding: 3rem 1.5rem;
    color: #6b7280;
}

.no-activities i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #d1d5db;
}

.no-activities h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #374151;
}

@media (max-width: 768px) {
    .filters-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        justify-content: center;
    }
    
    .activities-table {
        font-size: 0.8rem;
    }
    
    .activities-table th,
    .activities-table td {
        padding: 0.5rem;
    }
}
</style>
@endsection