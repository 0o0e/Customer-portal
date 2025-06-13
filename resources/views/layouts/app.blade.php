    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard') - Özgazi</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        @php
            use App\Models\Catalog;
            use Illuminate\Support\Facades\Auth;
            $catalog = new Catalog();
            $relatedCustomers = $catalog->getRelatedCustomers(Auth::user()->No);
        @endphp
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background: #f8fafc;
                min-height: 100vh;
                color: #1e293b;
            }

            .page-container {
                display: flex;
                min-height: 100vh;
            }

            .sidebar {
                width: 280px;
                background: #1e293b;
                padding: 2rem;
                color: white;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
            }

            .user-section {
                padding: 1rem 0;
                border-bottom: 1px solid #334155;
                margin-bottom: 1.5rem;
                position: relative;
            }

            .user-info-static {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem;
                border-radius: 0.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
                justify-content: space-between;
            }

            .user-info-static:hover {
                background: #334155;
            }

            .user-info-static i {
                transition: transform 0.3s;
                color: #94a3b8;
            }

            .user-section.active .user-info-static i {
                transform: rotate(180deg);
            }

            .user-info {
                flex: 1;
            }

            .user-name {
                font-weight: 500;
                color: #e2e8f0;
            }

            .user-role {
                font-size: 0.875rem;
                color: #94a3b8;
            }

            .logo {
                display: flex;
                align-items: center;
                margin-bottom: 0rem;
                padding: 0.5rem;
                color: white;
            }

            .logo img {
                width: 53px;
                height: 53px;
                border-radius: 50%;
                margin-right: 10px;
            }

            .logo-text-container {
                display: flex;
                flex-direction: column;
            }

            .logo-text {
                font-size: 1.5rem;
                font-weight: 600;
                color: white;
                line-height: 1.2;
            }

            .logo-subtext {
                font-size: 0.75rem;
                color: #94a3b8;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .nav-links {
                list-style: none;
            }

            .nav-links li {
                margin-bottom: 0.5rem;
            }

            .nav-links a {
                color: #94a3b8;
                text-decoration: none;
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
            }

            .nav-links a:hover, .nav-links a.active {
                background: #334155;
                color: white;
            }

            .nav-links i {
                margin-right: 0.75rem;
                width: 20px;
            }

            .main-content {
                flex: 1;
                margin-left: 280px;
                padding: 2rem;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
            }

            .header h1 {
                font-size: 1.875rem;
                font-weight: 600;
                color: #1e293b;
            }

            .user-profile {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .logout-btn {
                color: #94a3b8;
                text-decoration: none;
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                background: none;
                border: none;
                cursor: pointer;
                width: 100%;
                text-align: left;
            }

            .logout-btn:hover {
                background: #334155;
                color: white;
            }

            .logout-btn i {
                margin-right: 0.75rem;
                width: 20px;
            }

            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                    transition: transform 0.3s ease;
                    z-index: 1000;
                }

                .sidebar {
                    padding-top: 60px;
                }
                .sidebar.active {
                    transform: translateX(0);
                }

                .main-content {
                    margin-left: 0;
                }

                .hamburger {
                    display: block;
                    position: fixed;
                    top: 1rem;
                    left: 1rem;
                    z-index: 1001;
                    background: #1e293b;
                    padding: 0.5rem;
                    border-radius: 0.5rem;
                    cursor: pointer;
                }

                .hamburger span {
                    display: block;
                    width: 25px;
                    height: 3px;
                    background-color: white;
                    margin: 5px 0;
                    transition: all 0.3s ease;
                }
            }

            .user-dropdown-content::-webkit-scrollbar {
                width: 6px;
            }

            .user-dropdown-content::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 3px;
            }

            .user-dropdown-content::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 3px;
            }

            .user-dropdown-content::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            .checkbox-container {
                display: flex;
                align-items: center;
                cursor: pointer;
                width: 100%;
                user-select: none;
            }

            .checkbox-container input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            .checkmark {
                position: relative;
                height: 18px;
                width: 18px;
                background-color: #334155;
                border-radius: 3px;
                margin-right: 10px;
            }

            .checkbox-container:hover input ~ .checkmark {
                background-color: #475569;
            }

            .checkbox-container input:checked ~ .checkmark {
                background-color: #2f60d3;
            }

            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
                left: 6px;
                top: 2px;
                width: 4px;
                height: 10px;
                border: solid white;
                border-width: 0 2px 2px 0;
                transform: rotate(45deg);
            }

            .checkbox-container input:checked ~ .checkmark:after {
                display: block;
            }

            .apply-filter-btn {
                margin-top: 0.5rem;
                background: #2f60d3;
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                cursor: pointer;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: background-color 0.3s;
            }

            .apply-filter-btn:hover {
                background: #1e4ba3;
            }

            .client-filter-section {
                margin-bottom: 1.5rem;
                border-bottom: 1px solid #334155;
                padding-bottom: 1.5rem;
            }

            .client-filter-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.75rem 1rem;
                background: #334155;
                border-radius: 0.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .client-filter-header:hover {
                background: #475569;
            }

            .client-filter-header i {
                transition: transform 0.3s;
            }

            .client-filter-section.active .client-filter-header i {
                transform: rotate(180deg);
            }

            .client-filter-content {
                display: none;
                padding: 1rem;
                background: #334155;
                border-radius: 0.5rem;
                margin-top: 0.5rem;
            }

            .user-section.active .client-filter-content {
                display: block;
            }

            .client-filter-item {
                padding: 0.5rem 0;
                border-bottom: 1px solid #475569;
            }

            .client-filter-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .client-label {
                color: #e2e8f0;
                font-size: 0.875rem;
            }
        </style>
    </head>
    <body>
        <div class="page-container">
            <div class="sidebar">
                <div class="logo">
                    @if(file_exists(public_path('images/ozgazi-logo.png')))
                        <img src="{{ asset('images/ozgazi-logo.png') }}" alt="Özgazi Dairy Foods">
                        <div class="logo-text-container">
                            <span class="logo-text">ÖZGAZI</span>
                            <span class="logo-subtext">DAIRY FOODS</span>
                        </div>
                    @else
                        <div class="logo-text-container">
                            <span class="logo-text">ÖZGAZI</span>
                            <span class="logo-subtext">DAIRY FOODS</span>
                        </div>
                    @endif
                </div>

                <div class="user-section">
                    <div class="user-info-static" id="userInfoTrigger">
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">
                                @if (Auth::user()->is_admin)
                                    Admin
                                @else
                                    Client #{{ Auth::user()->No }}
                                @endif
                            </div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </div>

                    <div class="client-filter-content">
                        <form id="clientFilterForm" method="POST" action="{{ route('products.update-clients') }}">
                            @csrf
                            @if(isset($relatedCustomers) && $relatedCustomers->count() > 0)
                                @foreach($relatedCustomers as $customer)
                                    <div class="client-filter-item">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="selected_clients[]" value="{{ $customer->{'Customer No#'} }}"
                                                {{ in_array($customer->{'Customer No#'}, session('selected_clients', [Auth::user()->No])) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            <span class="client-label">Client #{{ $customer->{'Customer No#'} }}</span>
                                        </label>
                                    </div>
                                @endforeach
                                <div class="client-filter-item">
                                    <button type="submit" class="apply-filter-btn">
                                        <i class="fas fa-check"></i>
                                        Apply Filters
                                    </button>
                                </div>
                            @else
                                <div class="client-filter-item">
                                    No related customers found
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <ul class="nav-links">
                    <li>
                        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/orders" class="{{ request()->is('orders') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="/quotes" class="{{ request()->is('quotes') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i>
                            Quotes
                        </a>
                    </li>
                    <li>
                        <a href="/order/create" class="{{ request()->is('order/create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            Create Quote
                        </a>
                    </li>
                    <li>
                        <a href="/products" class="{{ request()->is('products') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            Products
                        </a>
                    </li>


                    <li>
                        <a href="/reports" class="{{ request()->is('reports') ? 'active' : '' }}">
                            <i class="fas fa-file-text"></i>
                            Reports
                        </a>
                    </li>
                    <li>
                        <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="/activity-log" class="{{ request()->is('activity-log') ? 'active' : '' }}">
                            <i class="fas fa-user"></i>
                            Activity Logs
                        </a>
                    </li>



                    @if (Auth::user()->is_admin)
                    <li>
                        <a href="/admin/reports" class="{{ request()->is('admin/reports') ? 'active' : '' }}">
                            <i class="fas fa-lock"></i>
                            Add a report
                        </a>
                    </li>

                    <li>
                        <a href="/register" class="{{ request()->is('register') ? 'active' : '' }}">
                            <i class="fas fa-lock"></i>
                            Register a user
                        </a>
                    </li>

                    <li>
                        <a href="/admin/requests" class="{{ request()->is('admin/requests') ? 'active' : '' }}">
                            <i class="fas fa-lock"></i>
                            Product Requests
                        </a>
                    </li>

                    @endif
                </ul>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>

            <div class="main-content">

                @yield('content')
            </div>
        </div>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <script>
            document.querySelector('.hamburger').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            // Client filter
            const userInfoTrigger = document.getElementById('userInfoTrigger');
            const userSection = document.querySelector('.user-section');
            const clientFilterForm = document.getElementById('clientFilterForm');

            if (userInfoTrigger) {
                userInfoTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userSection.classList.toggle('active');
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (userSection && !e.target.closest('.user-section')) {
                    userSection.classList.remove('active');
                }
            });

            // Prevent dropdown from closing when clicking inside
            const clientFilterContent = document.querySelector('.client-filter-content');
            if (clientFilterContent) {
                clientFilterContent.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        </script>
    </body>
    </html>
