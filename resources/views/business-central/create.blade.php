@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Sales Order</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('business-central.sales-orders.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="customerId" class="form-label">Customer ID</label>
                            <input type="text" class="form-control" id="customerId" name="customerId" required>
                        </div>

                        <div class="mb-3">
                            <label for="shipToName" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="shipToName" name="shipToName" required>
                        </div>

                        <div class="mb-3">
                            <label for="itemId" class="form-label">Item ID</label>
                            <input type="text" class="form-control" id="itemId" name="salesOrderLines[0][itemId]" required>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="salesOrderLines[0][quantity]" required>
                        </div>

                        <div class="mb-3">
                            <label for="unitPrice" class="form-label">Unit Price</label>
                            <input type="number" step="0.01" class="form-control" id="unitPrice" name="salesOrderLines[0][unitPrice]" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 