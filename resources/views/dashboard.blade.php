@extends('layouts.app')

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Özgazi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Top Navigation Bar -->



    
    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-header">
        <h1>Welcome, {{ auth()->user()->name }}</h1>

            <p>Here’s an overview of your dashboard.</p>
        </div>

        <!-- Dashboard Boxes Section -->
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
    </div>

    <script>
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > lastScrollTop) {
                navbar.classList.add('hidden');
            } else {
                navbar.classList.remove('hidden');
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });
    </script>

</body>
</html>
