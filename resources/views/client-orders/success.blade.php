@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order Submitted</div>

                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
                    </div>
                    
                    <h4 class="mb-3">Thank you for your order!</h4>
                    <p>Your order has been successfully submitted to Business Central.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('client-orders.create') }}" class="btn btn-primary">Place Another Order</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Return to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 