@extends('layouts.app')

@section('title', 'Create Quote')

@section('content')
<style>
    .quote-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 20px auto;
        width: 95%;
    }

    .quote-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .quote-header h1 {
        font-size: 1.875rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #4a5568;
    }

    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .items-container {
        margin-top: 2rem;
    }

    .item-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 1rem;
        align-items: start;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .remove-item {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .remove-item:hover {
        background: #dc2626;
    }

    .add-item {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s;
        margin-top: 1rem;
    }

    .add-item:hover {
        background: #059669;
    }

    .unit-price {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #4299e1;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background: #3182ce;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #4a5568;
        border: none;
    }

    .btn-secondary:hover {
        background: #cbd5e0;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
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
</style>

<div class="quote-container">
    <div class="quote-header">
        <h1>Create New Quote</h1>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <form action="{{ route('client-orders.store') }}" method="POST">
        @csrf
        <div class="items-container">
            <div class="item-rows">
                <div class="item-row">
                    <div class="form-group">
                        <label class="form-label">Product</label>
                        <select name="items[0][product_id]" class="form-control product-select" required>
                            <option value="">Select a product</option>
                            @foreach($customerProducts as $product)
                                <option value="{{ $product->{'Item No#'} }}" 
                                        data-price="{{ $product->Unit_Price }}">
                                    {{ $product->{'Item Description'} }}
                                </option>
                            @endforeach
                        </select>
                        <div class="unit-price"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="items[0][quantity]" class="form-control" min="1" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unit Price</label>
                        <input type="text" class="form-control unit-price-display" readonly>
                        <input type="hidden" name="items[0][unit_price]" class="unit-price-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control line-amount" readonly>
                    </div>

                    <button type="button" class="remove-item" style="display: none;">×</button>
                </div>
            </div>

            <button type="button" class="add-item">Add Another Item</button>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Create Quote</button>
            <a href="{{ route('client-orders.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.querySelector('.item-rows');
    const addItemButton = document.querySelector('.add-item');
    let itemCount = 1;

    function updateLineAmount(row) {
        const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
        const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
        const lineAmount = quantity * unitPrice;
        row.querySelector('.line-amount').value = lineAmount.toFixed(2);
    }

    function updateUnitPrice(select) {
        const row = select.closest('.item-row');
        const option = select.selectedOptions[0];
        const unitPrice = option.dataset.price || 0;
        const unitPriceInput = row.querySelector('.unit-price-input');
        const unitPriceDisplay = row.querySelector('.unit-price-display');
        
        unitPriceInput.value = unitPrice;
        unitPriceDisplay.value = parseFloat(unitPrice).toFixed(2);
        updateLineAmount(row);
    }

    function addItemRow() {
        const template = document.querySelector('.item-row').cloneNode(true);
        const newIndex = itemCount++;
        
        // Update names and IDs
        template.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace('[0]', `[${newIndex}]`);
            input.value = '';
        });
        
        // Clear values
        template.querySelector('.product-select').selectedIndex = 0;
        template.querySelector('.unit-price-display').value = '';
        template.querySelector('.unit-price-input').value = '';
        template.querySelector('.line-amount').value = '';
        
        // Show remove button
        template.querySelector('.remove-item').style.display = 'block';
        
        // Add event listeners
        template.querySelector('.product-select').addEventListener('change', function() {
            updateUnitPrice(this);
        });
        
        template.querySelector('input[name$="[quantity]"]').addEventListener('input', function() {
            updateLineAmount(this.closest('.item-row'));
        });
        
        template.querySelector('.remove-item').addEventListener('click', function() {
            template.remove();
        });
        
        itemsContainer.appendChild(template);
    }

    // Add event listeners to initial row
    document.querySelector('.product-select').addEventListener('change', function() {
        updateUnitPrice(this);
    });
    
    document.querySelector('input[name="items[0][quantity]"]').addEventListener('input', function() {
        updateLineAmount(this.closest('.item-row'));
    });

    // Add event listener to add item button
    addItemButton.addEventListener('click', addItemRow);
});
</script>
@endsection 