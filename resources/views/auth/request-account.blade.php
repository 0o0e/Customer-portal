<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Account - Özgazi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .request-container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
        }

        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #2196f3;
            text-align: left;
        }

        .info-box p {
            margin: 0;
            color: #1976d2;
            font-size: 14px;
            line-height: 1.5;
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

        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            margin-top: 5px;
            transition: border 0.3s;
        }

        input:focus {
            border-color: #2f60d3;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #2f60d3;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            text-align: left;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 480px) {
            .request-container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
<div class="request-container">
    <h2>Request New Account</h2>

    <div class="info-box">
        <p><strong>Account Request Process:</strong></p>
        <p>• Submit your company information below</p>
        <p>• Your request will be reviewed by our team</p>
        <p>• Once approved, you'll receive login credentials via email</p>
        <p>• A unique client number will be automatically generated</p>
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('account.request.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Company Name *</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" required 
                   placeholder="Enter your company name">
            @error('company_name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Customer Number *</label>
            <input type="text" name="customer_number" value="{{ old('customer_number') }}" required 
                   placeholder="Enter your customer number">
            @error('customer_number')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Business Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   placeholder="Enter your business email address">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Submit Request</button>
    </form>

    <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
</div>
</body>
</html> 