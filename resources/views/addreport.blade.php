@extends('layouts.app')

@section('title', 'Submit Report')

@section('content')
<style>

    
    .card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        width: 60%;
        margin: 0 auto;
        margin-top: 20px;
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .card-header i {
        font-size: 1.5rem;
        color: #2f60d3;
        margin-right: 0.75rem;
        text-align: center;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        text-align: center;

    }    
    h1{

        text-align: center;

    }
    .form-group {
        margin-bottom: 1.5rem;
        width: 60%;
        align-items: center;
        margin: 0 auto;
        margin-bottom: 20px;


        text-align: center;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #1e293b;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #2f60d3;
        box-shadow: 0 0 0 3px rgba(47, 96, 211, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        gap: 0.5rem;
        width: 60%;
        margin: 0 auto;
        align-items: center;
        text-align: center;
        justify-content: center;
        display: block;
        margin-top: 25px;
    }

    .btn-primary {
        background: #2f60d3;
        color: white;
    }

    .btn-primary:hover {
        background: #1e4ba3;
        transform: translateY(-1px);
    }

</style>
<h1>Submit Report</h1>

<div class="card">
    <form method="POST" action="{{ route('reports.store') }}">
         @csrf
         <div class="form-group">
             <label for="Customer_No">Customer Number</label>
             <input type="text" class="form-control" id="Customer_No" name="Customer_No" required>
         </div>
         <div class="form-group">
             <label for="link">Report Link</label>
             <input type="text" class="form-control" id="Link" name="Link" required>
         </div>
         <button type="submit" class="btn btn-primary">Submit</button>
     </form>
    </div>
@endsection
