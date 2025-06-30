@extends('layouts.app')

@section('title', 'Create Quote')

@section('content')
<style>
    /* Existing styles remain largely the same */
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

    /* New/Modified styles for checklist layout */
    .items-checklist-container {
        margin-top: 2rem;
    }

    .product-checklist-row {
        display: grid;
        /* Columns: Checkbox/Product Name, Quantity, Unit Price, Amount */
        grid-template-columns: 2.5fr 1fr 1fr 1fr; 
        gap: 1rem;
        align-items: center; /* Vertically align items */
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0; /* Added a border to clearly see each row */
    }

    .product-checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px; /* Space between checkbox and label */
        /* Ensure labels within this group don't have bottom margin */
        margin-bottom: 0; 
    }

    .product-checkbox {
        /* Basic checkbox styling, can be customized */
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .product-description-label {
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 0; /* Override default form-label margin */
    }

    /* Disable original add/remove item buttons as they are no longer needed */
    .add-item, .remove-item {
        display: none !important; 
    }

    .unit-price { /* This class is now unused in HTML, but kept in CSS if needed elsewhere */
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
        <div class="items-checklist-container">
            {{-- Temporarily dump the customerProducts variable to debug --}}
            @forelse($customerProducts as $product)
                <div class="product-checklist-row" data-product-id="{{ $product->{'Item No#'} }}"
                                                data-unit-price="{{ $product->Unit_Price }}">
                    {{-- Checkbox and Product Description --}}
                    <div class="form-group product-checkbox-group">
                        <input type="checkbox" class="product-checkbox">
                        <label class="product-description-label">{{ $product->{'Item Description'} }}</label>
                    </div>

                    {{-- Quantity Input --}}
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number"
                               name="items[{{ $product->{'Item No#'} }}][quantity]"
                               class="form-control quantity-input"
                               min="0.01" step="0.01" value="1" disabled> {{-- Initially disabled --}}
                    </div>

                    {{-- Unit Price Display and Hidden Input --}}
                    <div class="form-group">
                        <label class="form-label">Unit Price</label>
                        <input type="text"
                               class="form-control unit-price-display"
                               value="{{ number_format($product->Unit_Price, 2) }}" readonly>
                        <input type="hidden"
                               name="items[{{ $product->{'Item No#'} }}][unit_price]"
                               class="unit-price-input"
                               value="{{ $product->Unit_Price }}" disabled> {{-- Initially disabled --}}
                        {{-- Hidden input for product_id --}}
                        <input type="hidden"
                               name="items[{{ $product->{'Item No#'} }}][product_id]"
                               class="product-id-input"
                               value="{{ $product->{'Item No#'} }}" disabled> {{-- Initially disabled --}}
                    </div>

                    {{-- Amount Display --}}
                    <div class="form-group">
                        <label class="form-label">Amount</label>
                        <input type="text" class="form-control line-amount" value="0.00" readonly>
                    </div>
                </div>
            @empty
                <p>No products available for this customer.</p>
            @endforelse
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Create Quote</button>
            <a href="{{ route('client-orders.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all product rows in the checklist
    const allProductRows = document.querySelectorAll('.product-checklist-row');

    function updateLineAmount(row) {
        // Get quantity and unit price from their respective inputs in the current row
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const unitPrice = parseFloat(row.dataset.unitPrice) || 0; // Get unit price from data attribute

        // Calculate the total amount for the line
        const lineAmount = quantity * unitPrice;

        // Update the display field with the calculated amount, formatted to 2 decimal places
        row.querySelector('.line-amount').value = lineAmount.toFixed(2);
    }

    // Iterate over each product row to attach event listeners
    allProductRows.forEach(row => {
        const checkbox = row.querySelector('.product-checkbox');
        const quantityInput = row.querySelector('.quantity-input');
        const unitPriceHiddenInput = row.querySelector('.unit-price-input');
        const productIdHiddenInput = row.querySelector('.product-id-input');
        const lineAmountDisplay = row.querySelector('.line-amount');

        // Event listener for when the checkbox is checked or unchecked
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // If checkbox is checked, enable the quantity and hidden price/ID inputs
                quantityInput.disabled = false;
                unitPriceHiddenInput.disabled = false;
                productIdHiddenInput.disabled = false;

                // Ensure quantity is at least 1 if checked (to meet validation min:0.01)
                if (parseFloat(quantityInput.value) < 0.01) {
                    quantityInput.value = 1;
                }
                
                // Recalculate amount based on enabled quantity
                updateLineAmount(row);
            } else {
                // If checkbox is unchecked, disable inputs, reset quantity, and clear amount display
                quantityInput.disabled = true;
                unitPriceHiddenInput.disabled = true;
                productIdHiddenInput.disabled = true;
                
                quantityInput.value = '0'; // Optionally reset quantity to 0
                lineAmountDisplay.value = '0.00'; // Reset amount display
            }
        });

        // Event listener for changes in the quantity input field
        quantityInput.addEventListener('input', function() {
            // Only update amount if the input is enabled (meaning the checkbox is checked)
            if (!this.disabled) {
                updateLineAmount(row);
            }
        });

        // Initial setup on page load: ensure inputs are disabled if checkbox is not checked
        // This handles cases where a user might navigate back or form state is preserved by browser
        if (!checkbox.checked) {
            quantityInput.disabled = true;
            unitPriceHiddenInput.disabled = true;
            productIdHiddenInput.disabled = true;
            lineAmountDisplay.value = '0.00';
        }
    });
});
</script>
@endsection
