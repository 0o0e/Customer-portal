<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        }

        .user-dropdown {
            position: relative;
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s;
        }

        .user-dropdown:hover {
            background: #334155;
        }

        .user-dropdown-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
        }

        .user-dropdown.active .user-dropdown-content {
            display: block;
        }

        .user-dropdown-item {
            padding: 0.75rem 1rem;
            color: #e2e8f0;
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid #334155;
        }

        .user-dropdown-item:hover {
            background: #334155;
            color: white;
        }

        .user-dropdown-item i {
            width: 20px;
            text-align: center;
            color: #60a5fa;
        }

        .no-customers {
            padding: 1rem;
            color: #94a3b8;
            text-align: center;
            font-style: italic;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #334155;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e2e8f0;
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

        .user-dropdown-header i.fa-chevron-down {
            color: #94a3b8;
            transition: transform 0.3s;
        }

        .user-dropdown.active .user-dropdown-header i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: white;
            text-decoration: none;
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

        /* Custom scrollbar for the dropdown */
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
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="/dashboard" class="logo">Özgazi</a>
            
            <div class="user-section">
                <div class="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">Client #{{ Auth::user()->No }}</div>
                        </div>
                        <i class="fas fa-chevron-down" style="margin-left: auto;"></i>
                    </div>
                    <div class="user-dropdown-content">
                        @if(isset($relatedCustomers) && $relatedCustomers->count() > 0)
                            <form method="POST" action="{{ url()->current() }}">
                                @csrf
                                @foreach($relatedCustomers as $customer)
                                    <div class="user-dropdown-item">
                                        <label class="checkbox-container">
                                            <input type="checkbox" name="selected_clients[]" value="{{ $customer->{'Customer No#'} }}" 
                                                {{ in_array($customer->{'Customer No#'}, session('selected_clients', [Auth::user()->No])) ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                            Customer #{{ $customer->{'Customer No#'} }}
                                        </label>
                                    </div>
                                @endforeach
                                <div class="user-dropdown-item">
                                    <button type="submit" class="apply-filter-btn">
                                        <i class="fas fa-check"></i>
                                        Apply Filter
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="no-customers">
                                No related customers found
                            </div>
                        @endif
                    </div>
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
                    <a href="/products" class="{{ request()->is('products') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                </li>
                <li>
                    <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>

        <!-- Main Content -->
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

        // Add dropdown functionality
        document.querySelector('.user-dropdown').addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown-content')) {
                this.classList.toggle('active');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                document.querySelector('.user-dropdown').classList.remove('active');
            }
        });

        // Handle checkbox clicks
        document.querySelectorAll('.checkbox-container').forEach(container => {
            container.addEventListener('click', function(e) {
                if (e.target !== this.querySelector('input')) {
                    e.preventDefault();
                    const checkbox = this.querySelector('input');
                    checkbox.checked = !checkbox.checked;
                }
            });
        });

        // Handle form submission with AJAX
        document.getElementById('clientFilterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('{{ route("products.update-clients") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the dropdown
                    document.querySelector('.user-dropdown').classList.remove('active');
                    // Reload the page to show updated data
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
