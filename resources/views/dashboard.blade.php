@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .stats-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .dashboard-box {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 200px;
        height: 200px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .dashboard-box:hover {
        transform: scale(1.05);
        background-color: #f1f1f1;
    }

    .dashboard-box h3 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
    }

    .dashboard-box p {
        font-size: 14px;
        color: #777;
    }

    .welcome-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .welcome-header h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 10px;
    }

    .welcome-header p {
        color: #666;
        font-size: 16px;
    }

    @media (max-width: 768px) {
        .stats-container {
            flex-direction: column;
            align-items: center;
        }

        .dashboard-box {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
    }
</style>

<div class="welcome-header">
    <h1>Welcome, {{ auth()->user()->name }}</h1>
    <p>Here's an overview of your dashboard.</p>
</div>

<div class="stats-container">
    <div class="dashboard-box" onclick="window.location.href='/orders'">
        <h3>Orders</h3>
        <p>Click to view your orders</p>
    </div>
    <div class="dashboard-box" onclick="window.location.href='/invoices'">
        <h3>Invoices</h3>
        <p>Click to view your invoices</p>
    </div>
    <div class="dashboard-box" onclick="window.location.href='/products'">
        <h3>All Products</h3>
        <p>Click to see available products</p>
    </div>
</div>
@endsection
