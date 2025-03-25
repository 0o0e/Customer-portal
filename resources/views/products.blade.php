@extends('layouts.app')
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
        color: #333;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
    }

    .no-products-message {
        background-color: #fce4e4;
        padding: 20px;
        border-radius: 8px;
        margin-top: 30px;
        font-size: 18px;
        color: #d32f2f;
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
        color: #555;
        border-bottom: 1px solid #eee;
    }

    .products-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }

    .products-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .products-table td {
        background-color: #fff;
    }

    @media (max-width: 768px) {
        .products-container {
            padding: 20px;
            margin: 10px auto;
            width: 90%;
        }

        .products-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table-responsive {
            margin: 0;
            padding: 0;
        }

        .products-table th, .products-table td {
            padding: 12px;
            font-size: 13px;
        }
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
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        outline: none;
    }

    .search-input:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .search-button {
        padding: 12px 30px;
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-button:hover {
        background-color: #357abd;
        transform: translateY(-1px);
    }

    .search-button:active {
        transform: translateY(0);
    }
</style>

@section('title', 'All Products')

@section('content')
    <div class="products-container">
        <h1>All Products</h1>

        <div class="search-section">
            <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
            <button class="search-button" onclick="filterProducts()">Search</button>
        </div>

        @if($products->isEmpty())
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
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->{'Item Description'} }}</td>
                            <td>{{ $product->{'Item Catalog'} }}</td>
                            <td>{{ $product->{'Sales Unit of Measure'} }}</td>
                            <td>{{ $product->{'Valid from Date'} }}</td>
                            <td>{{ $product->{'Valid to Date'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        function filterProducts() {
            const searchInput = document.getElementById('searchInput');
            const searchText = searchInput.value.toLowerCase();
            const table = document.getElementById('productsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let cell of cells) {
                    const cellText = cell.textContent.toLowerCase();
                    if (cellText.includes(searchText)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        }

        // Add event listener for Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterProducts();
            }
        });
    </script>
@endsection

