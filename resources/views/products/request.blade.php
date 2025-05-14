@extends('layouts.app')

@section('title', 'Request New Product')

@section('content')
<style>
    .request-container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 20px auto;
        width: 95%;
    }

    .request-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .request-header h1 {
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

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
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

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .invalid-feedback {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>


<div class="request-container">
    <div class="request-header">
        <h1>Request New Product</h1>
        <p>Please fill out the form below to request a new product. Fields marked with * are required.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form action="{{ route('products.request.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="Description" class="form-label">Product Description *</label>
            <input type="text"
                   class="form-control @error('description') is-invalid @enderror"
                   id="description"
                   name="description"
                   value="{{ old('description') }}"
                   required>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Search_Description" class="form-label">Search Description *</label>
            <input type="text"
                   class="form-control @error('search_description') is-invalid @enderror"
                   id="search_description"
                   name="search_description"
                   value="{{ old('search_description') }}"
                   required>
            @error('search_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Description_2" class="form-label">Description 2 *</label>
            <input type="text"
                   class="form-control @error('Description_2') is-invalid @enderror"
                   id="Description_2"
                   name="Description_2"
                   value="{{ old('Description_2') }}"
                   required>
            @error('Description_2')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Base_Unit_of_Measure" class="form-label">Base Unit of Measure *</label>
            <input type="text"
                   class="form-control @error('Base_Unit_of_Measure') is-invalid @enderror"
                   id="Base_Unit_of_Measure"
                   name="Base_Unit_of_Measure"
                   value="{{ old('Base_Unit_of_Measure') }}"
                   required>
            @error('Base_Unit_of_Measure')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Vendor_Item_No" class="form-label">Vendor Item No *</label>
            <input type="text"
                   class="form-control @error('Vendor_Item_No') is-invalid @enderror"
                   id="Vendor_Item_No"
                   name="Vendor_Item_No"
                   value="{{ old('Vendor_Item_No') }}"
                   required>
            @error('Vendor_Item_No')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Alternative_Item_No" class="form-label">Alternative Item No *</label>
            <input type="text"
                   class="form-control @error('Alternative_Item_No') is-invalid @enderror"
                   id="Alternative_Item_No"
                   name="Alternative_Item_No"
                   value="{{ old('Alternative_Item_No') }}"
                   required>
            @error('Alternative_Item_No')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Gross_Weight" class="form-label">Gross Weight *</label>
            <input type="number"
                   class="form-control @error('Gross_Weight') is-invalid @enderror"
                   id="Gross_Weight"
                   name="Gross_Weight"
                   value="{{ old('Gross_Weight') }}"
                   step="0.01"
                   min="0"
                   required>
            @error('Gross_Weight')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Net_Weight" class="form-label">Net Weight *</label>
            <input type="number"
                   class="form-control @error('Net_Weight') is-invalid @enderror"
                   id="Net_Weight"
                   name="Net_Weight"
                   value="{{ old('Net_Weight') }}"
                   step="0.01"
                   min="0"
                   required>
            @error('Net_Weight')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Tariff_No" class="form-label">Tariff No *</label>
            <input type="text"
                   class="form-control @error('Tariff_No') is-invalid @enderror"
                   id="Tariff_No"
                   name="Tariff_No"
                   value="{{ old('Tariff_No') }}"
                   required>
            @error('Tariff_No')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Sales__Qty_" class="form-label">Sales Quantity *</label>
            <input type="number"
                   class="form-control @error('Sales__Qty_') is-invalid @enderror"
                   id="Sales__Qty_"
                   name="Sales__Qty_"
                   value="{{ old('Sales__Qty_') }}"
                   min="0"
                   required>
            @error('Sales__Qty_')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="GTIN" class="form-label">GTIN *</label>
            <input type="text"
                   class="form-control @error('GTIN') is-invalid @enderror"
                   id="GTIN"
                   name="GTIN"
                   value="{{ old('GTIN') }}"
                   required>
            @error('GTIN')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="Comment" class="form-label">Comment</label>
            <textarea
                class="form-control @error('Comment') is-invalid @enderror"
                id="Comment"
                name="Comment">{{ old('Comment') }}</textarea>
            @error('Comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Submit Request</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
