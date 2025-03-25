<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Özgazi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
        }

        /* Navbar */
        .navbar {
            background-color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a, .logout-btn {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover, .logout-btn:hover {
            background-color: #d32f2f;
            border-radius: 5px;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            padding: 10px;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: white;
            margin: 5px 0;
            transition: all 0.3s ease;
        }

        /* Main Content */
        .content {
            padding: 40px;
            margin-top: 80px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
        }

        /* Top Navigation Bar */
        .navbar {
            background-color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }

        .navbar.hidden {
            transform: translateY(-100%);
        }

        .nav-links {
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 15px;
            background-color: transparent;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #d32f2f;
            border-radius: 5px;
        }

        .logout-btn {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 15px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
            border-radius: 5px;
        }

        /* Main Content */
        .main-content {
            padding: 40px;
            text-align: center;
            margin-top: 80px;
        }

        .welcome-header h1 {
            font-size: 24px;
            color: #333;
        }

        .stats-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        /* Box Style for Orders, Invoices, Products */
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
        }

        .dashboard-box:hover {
            transform: scale(1.05);
            background-color: #f1f1f1;
        }

        .dashboard-box h3 {
            font-size: 20px;
            color: #333;
        }

        .dashboard-box p {
            font-size: 14px;
            color: #777;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: row;
                justify-content: space-between;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }

            .nav-links a {
                padding: 12px 0;
            }

            .logout-btn {
                margin-top: 10px;
                padding: 12px 0;
            }

            .stats-container {
                flex-direction: column;
            }

            .dashboard-box {
                width: 100%;
                margin-bottom: 20px;
            }
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="nav-links">
            <a href="/dashboard">Dashboard</a>
            <a href="/orders">Orders</a>
            <a href="/products">Products</a>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Main content -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
