<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2f60d3;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .credentials {
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to Özgazi</h1>
    </div>

    <div class="content">
        <p>Dear {{ $name }},</p>

        <p>Your Özgazi account has been created successfully. Below are your login credentials:</p>

        <div class="credentials">
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Client Number:</strong> {{ $client_number }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
        </div>

        <p>Please login at <a href="{{ url('/login') }}">{{ url('/login') }}</a> and change your password immediately for security purposes.</p>

        <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

        <p>Best regards,<br>The Özgazi Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message, please do not reply to this email.</p>
    </div>
</body>
</html> 