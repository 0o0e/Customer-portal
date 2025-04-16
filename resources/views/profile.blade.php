@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<style>
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .card-header i {
        font-size: 1.5rem;
        color: #2f60d3;
        margin-right: 0.75rem;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
    }

    .info-group {
        margin-bottom: 1rem;
    }

    .info-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 500;
        color: #1e293b;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #1e293b;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #2f60d3;
        box-shadow: 0 0 0 3px rgba(47, 96, 211, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        gap: 0.5rem;
        width: 100%;
    }

    .btn-primary {
        background: #2f60d3;
        color: white;
    }

    .btn-primary:hover {
        background: #1e4ba3;
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .header {
        display: block;
        text-align: center;
        margin-bottom: 30px;
    }


    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
            padding: 0 1rem;
        }

        .card {
            padding: 1rem;
        }

        .form-control {
            font-size: 16px; /* Prevents zoom on iOS */
        }

        .btn {
            padding: 0.875rem 1.5rem;
            font-size: 16px;
        }
    }
</style>

<div class="header">
    <h1>Profile Settings</h1>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="content-grid">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-circle"></i>
            <h2>Account Information</h2>
        </div>
        <div class="info-group">
            <div class="info-label">Company Name</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
        <div class="info-group">
            <div class="info-label">Email Address</div>
            <div class="info-value">{{ $user->email }}</div>
        </div>
        <div class="info-group">
            <div class="info-label">Client Number</div>
            <div class="info-value">{{ $user->No }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-lock"></i>
            <h2>Change Password</h2>
        </div>
        <form action="{{ route('profile.update-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection
