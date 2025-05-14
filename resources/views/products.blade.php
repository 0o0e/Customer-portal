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

    .request-button {
        padding: 12px 30px;
        background-color: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .request-button:hover {
        background-color: #059669;
        transform: translateY(-1px);
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
        <a href="{{ route('products.request') }}" class="request-button">Request New Product</a>
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
</script>
@endsection

