@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-container {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        padding: 1rem;
    }

    .welcome-header h1 {
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 1rem;
        font-weight: 700;
        position: relative;
        animation: fadeInDown 0.8s ease-out;
    }

    .welcome-header p {
        color: #666;
        font-size: 1.2rem;
        position: relative;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .dashboard-box {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .dashboard-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #1a1a1a, #2d2d2d);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .dashboard-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .dashboard-box:hover::before {
        transform: scaleX(1);
    }

    .dashboard-box h3 {
        font-size: 1.5rem;
        color: #1f2937;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .dashboard-box p {
        font-size: 1rem;
        color: #6b7280;
        margin: 0;
    }

    .dashboard-box i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #1a1a1a;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .welcome-header {
            margin-bottom: 2rem;
        }

        .welcome-header h1 {
            font-size: 20px;
        }

        .stats-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .dashboard-box {
            padding: 1.5rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="welcome-header">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
        <p>Here's an overview of your dashboard.</p>
    </div>

    <div class="stats-container">
        <div class="dashboard-box" onclick="window.location.href='/orders'">
            <i class="fas fa-shopping-cart"></i>
            <h3>Orders</h3>
            <p>View and manage your orders</p>
        </div>
        <div class="dashboard-box" onclick="window.location.href='/invoices'">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3>Invoices</h3>
            <p>Access your billing history</p>
        </div>
        <div class="dashboard-box" onclick="window.location.href='/products'">
            <i class="fas fa-box"></i>
            <h3>All Products</h3>
            <p>Browse our product catalog</p>
        </div>
    </div>
</div>
@endsection
