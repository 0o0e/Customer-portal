<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Submitted - Özgazi</title>
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

        .success-container {
            width: 100%;
            max-width: 500px;
            padding: 40px 30px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #c3e6cb;
            line-height: 1.6;
        }

        .info-box {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #2196f3;
            text-align: left;
        }

        .info-box h4 {
            margin: 0 0 10px 0;
            color: #1976d2;
            font-size: 16px;
        }

        .info-box ul {
            margin: 0;
            padding-left: 20px;
            color: #1976d2;
            font-size: 14px;
        }

        .info-box li {
            margin-bottom: 5px;
        }

        .back-link {
            display: inline-block;
            padding: 14px 28px;
            background-color: #2f60d3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .back-link:hover {
            background-color: #1e4ba3;
        }

        @media (max-width: 480px) {
            .success-container {
                padding: 30px 20px;
                width: 90%;
            }

            h2 {
                font-size: 24px;
            }

            .success-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>
<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    
    <h2>Request Submitted Successfully!</h2>

    <div class="success-message">
        <strong>Thank you for your interest in Özgazi!</strong><br>
        Your account request has been received and is being reviewed by our team.
    </div>

    <div class="info-box">
        <h4>What happens next?</h4>
        <ul>
            <li>Our team will review your request within 1-2 business days</li>
            <li>You'll receive an email notification once your request is processed</li>
            <li>If approved, you'll receive your login credentials and client number</li>
            <li>You can then access your personalized product catalog and place orders</li>
        </ul>
    </div>

    <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
</div>

<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
</body>
</html> 