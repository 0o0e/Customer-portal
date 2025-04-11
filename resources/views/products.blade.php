@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<style>
    .products-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 20px auto;
        width: 95%;
    }

    .products-container h1 {
        font-size: 28px;
        color: #1e293b;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
    }

    .no-products-message {
        background-color: #fee2e2;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
        font-size: 18px;
        color: #dc2626;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0;
        padding: 0;
    }

    .products-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        min-width: 800px;
    }

    .products-table th, .products-table td {
        padding: 15px;
        text-align: left;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
    }

    .products-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }

    .products-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .products-table td {
        background-color: #fff;
    }

    .search-section {
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        min-width: 300px;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        outline: none;
        background: #f8fafc;
    }

    .search-input:focus {
        border-color: #2f60d3;
        box-shadow: 0 0 0 3px rgba(47, 96, 211, 0.1);
    }

    .search-button {
        padding: 12px 30px;
        background-color: #2f60d3;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background-color: #1e4ba3;
        transform: translateY(-1px);
    }

    .search-button:active {
        transform: translateY(0);
    }

    .product-card {
        display: none;
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .product-card .field {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .product-card .field:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .product-card .label {
        font-weight: 500;
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .product-card .value {
        color: #1e293b;
        font-size: 1rem;
        font-weight: 
    }

    .search-form {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .client-filter {
        position: relative;
        min-width: 200px;
        z-index: 100;
    }

    .client-filter-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 200px;
        justify-content: space-between;
    }

    .client-filter-header:hover {
        border-color: #2f60d3;
        background: #f1f5f9;
    }

    .client-filter-header i {
        margin-left: auto;
        transition: transform 0.3s;
    }

    .client-filter.active .client-filter-header i {
        transform: rotate(180deg);
    }

    .client-filter-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 5px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        width: 250px;
    }

    .client-filter.active .client-filter-content {
        display: block;
    }

    .client-filter-item {
        padding: 10px 15px;
        border-bottom: 1px solid #e2e8f0;
        transition: background 0.3s ease;
    }

    .client-filter-item:hover {
        background: #f8fafc;
    }

    .client-filter-item:last-child {
        border-bottom: none;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        position: relative;
        padding-left: 35px;
        margin-bottom: 0;
        cursor: pointer;
        font-size: 14px;
        user-select: none;
        width: 100%;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .checkbox-container:hover input ~ .checkmark {
        border-color: #2f60d3;
    }

    .checkbox-container input:checked ~ .checkmark {
        background-color: #2f60d3;
        border-color: #2f60d3;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    .client-label {
        margin-left: 15px;
        color: #1e293b;
    }

    .apply-filter-btn {
        width: 100%;
        padding: 10px;
        background: #2f60d3;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .apply-filter-btn:hover {
        background: #1e4ba3;
    }

    .apply-filter-btn i {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .products-container {
            padding: 0;
            margin: 0;
            width: 100%;
            border-radius: 0;
            background: none;
            box-shadow: none;
        }

        .products-container h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding: 0 1rem;
        }

        .search-section {
            flex-direction: column;
            gap: 0.75rem;
            padding: 0 1rem;
        }

        .search-input {
            width: 100%;
            min-width: unset;
        }

        .search-button {
            width: 100%;
            padding: 0.75rem 1rem;
        }

        .table-responsive {
            display: none;
        }

        .product-card {
            display: block;
            padding: 1rem;
            margin: 0.5rem 1rem;
            border-radius: 0.75rem;
        }

        .mobile-products {
            padding: 0.5rem 0;
        }

        .client-filter {
            width: 100%;
        }
    }
</style>

<div class="products-container">
    <h1>All Products</h1>

    <div class="search-section">
        <form id="searchForm" method="POST" action="{{ route('products.search') }}" class="search-form">
            @csrf
            <input type="text" class="search-input" name="search" value="{{ session('search') }}" placeholder="Search products...">
            <button type="submit" class="search-button">Search</button>
        </form>
        
        <div class="client-filter">
            <div class="client-filter-header">
                <span>Filter by Client</span>
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
    </div>
    

    @if(!$hasProducts)
        <div class="no-products-message">
            <p>No products found.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="products-table" id="productsTable">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Item Catalog</th>
                        <th>Item Unit</th>
                        <th>Valid From Date</th>
                        <th>Valid To Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allProducts as $product)
                    <tr>
                        <td>{{ $product['Description'] }}</td>
                        <td>{{ $product['Catalog'] }}</td>
                        <td>{{ $product['Unit'] }}</td>
                        <td>{{ $product['Valid from Date'] }}</td>
                        <td>{{ $product['Valid to Date'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mobile-products">
            @foreach($allProducts as $product)
            <div class="product-card">
                <div class="field">
                    <div class="label">Item Description</div>
                    <div class="value">{{ $product['Description'] }}</div>
                </div>
                <div class="field">
                    <div class="label">Item Catalog</div>
                    <div class="value">{{ $product['Catalog'] }}</div>
                </div>
                <div class="field">
                    <div class="label">Item Unit</div>
                    <div class="value">{{ $product['Unit'] }}</div>
                </div>
                <div class="field">
                    <div class="label">Valid From Date</div>
                    <div class="value">{{ $product['Valid from Date'] }}</div>
                </div>
                <div class="field">
                    <div class="label">Valid To Date</div>
                    <div class="value">{{ $product['Valid to Date'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    // Debug info
    console.log("Client filter initialization starting...");
    
    // Check if elements exist
    const clientFilterHeader = document.querySelector('.client-filter-header');
    const clientFilterContent = document.querySelector('.client-filter-content');
    const clientFilterForm = document.getElementById('clientFilterForm');
    
    if (!clientFilterHeader) {
        console.error("Client filter header not found!");
    }
    
    if (!clientFilterContent) {
        console.error("Client filter content not found!");
    }
    
    if (!clientFilterForm) {
        console.error("Client filter form not found!");
    }
    
    // Add client filter dropdown functionality
    if (clientFilterHeader) {
        console.log("Adding click event to client filter header");
        clientFilterHeader.addEventListener('click', function(e) {
            e.stopPropagation();
            const clientFilter = document.querySelector('.client-filter');
            clientFilter.classList.toggle('active');
            console.log("Client filter toggled:", clientFilter.classList.contains('active'));
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const clientFilter = document.querySelector('.client-filter');
        if (clientFilter && !e.target.closest('.client-filter')) {
            clientFilter.classList.remove('active');
            console.log("Client filter closed by outside click");
        }
    });

    // Prevent dropdown from closing when clicking inside
    if (clientFilterContent) {
        clientFilterContent.addEventListener('click', function(e) {
            e.stopPropagation();
            console.log("Click inside client filter content detected");
        });
    }

    // Handle client filter form submission
    if (clientFilterForm) {
        console.log("Adding submit event to client filter form");
        clientFilterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log("Client filter form submitted");
            
            const formData = new FormData(this);
            // Debug selected checkboxes
            const selectedClients = [];
            formData.getAll('selected_clients[]').forEach(client => {
                selectedClients.push(client);
            });
            console.log("Selected clients:", selectedClients);
            
            // Add the CSRF token from meta tag if it's not already in the form
            if (!formData.has('_token')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    formData.append('_token', csrfToken.content);
                } else {
                    console.error("CSRF token not found!");
                }
            }
            
            fetch('{{ route("products.update-clients") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log("Response status:", response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log("Response data:", data);
                if (data.success) {
                    console.log("Client filter applied successfully, reloading page");
                    window.location.reload();
                } else {
                    console.error("Server returned success:false", data);
                    alert("Error applying filter. Please try again.");
                }
            })
            .catch(error => {
                console.error("Error applying client filter:", error);
                alert("Error applying filter: " + error.message);
            });
        });
    }

    // Search form submission
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            this.submit();
        });
    } else {
        console.error("Search form not found!");
    }
    
    // Make sure all checkboxes are clickable
    const checkboxContainers = document.querySelectorAll('.checkbox-container');
    console.log("Found " + checkboxContainers.length + " checkbox containers");
    
    checkboxContainers.forEach(container => {
        const checkbox = container.querySelector('input[type="checkbox"]');
        const label = container.querySelector('.client-label');
        
        if (checkbox && label) {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
                console.log("Checkbox toggled via label:", checkbox.checked);
            });
        }
    });
</script>
@endsection

