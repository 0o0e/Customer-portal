<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Özgazi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
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
            background-color: #2f60d3;
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
            background-color: #2f60d3;
        }

        .error-message {
            margin-top: 20px;
            color: #2f60d3;
            font-size: 14px;
            text-align: left;
        }

        .error-message p {
            margin: 5px 0;
        }


        .request-account-btn:hover {
            color:rgb(51, 50, 63);
        }

        .divider {
            margin: 20px 0;
            text-align: center;
            position: relative;
        }

        .divider::before {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #ddd;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #666;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .login-container {
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
<div class="login-container">
    <h2>Login</h2>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Client Number:</label>
            <input type="text" name="No" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
            <div style="text-align: right; margin-top: 5px;">
                <a href="{{ route('password.request') }}" style="color: #2f60d3; text-decoration: none; font-size: 14px;">
                    Forgot Password?
                </a>
            </div>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="divider">
        <span>Don't have an account?</span>
    </div>

    <a href="{{ route('account.request') }}" class="request-account-btn">
        Request New Account
    </a>
</div>
</body>
</html>