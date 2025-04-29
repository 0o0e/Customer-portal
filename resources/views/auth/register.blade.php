@extends('layouts.app')
@section('title', 'Register New User')

@section('content')
<style>
    .register-container {
        width: 100%;
        max-width: 500px;
        padding: 30px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin: 0 auto;
    }

    h2 {
        color: #333;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 600;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        text-align: left;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
    }

    .register-container input {
        width: 100%;
        padding: 14px;
        border: 2px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        margin-top: 5px;
        transition: border 0.3s;
    }

    .register-container input:focus {
        border-color: #2f60d3;
        outline: none;
    }

    .register-container button {
        width: 100%;
        padding: 14px;
        background-color: #2f60d3;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .register-container button:hover {
        background-color: #1e4ba3;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    .success-message {
        color: #28a745;
        font-size: 14px;
        margin-top: 5px;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #2f60d3;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="register-container">
    <h2>Register New User</h2>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Company Name:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Client Number:</label>
            <input type="text" name="No" value="{{ old('No') }}" required>
        </div>

        <button type="submit">Register User</button>
    </form>

    <a href="{{ route('dashboard') }}" class="back-link">Back to Dashboard</a>
</div>
@endsection