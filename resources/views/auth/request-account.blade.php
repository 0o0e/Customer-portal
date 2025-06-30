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

        /* GDPR Section Styling */
        .gdpr-section {
            margin: 30px 0;
            padding: 25px;
            border: 2px solid #e3f2fd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .gdpr-section h3 {
            color: #1976d2;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
            border-bottom: 2px solid #e3f2fd;
            padding-bottom: 10px;
        }

        .privacy-info {
            margin-bottom: 25px;
        }

        .privacy-info h4 {
            color: #333;
            margin: 20px 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .privacy-info ul {
            margin: 10px 0 20px 20px;
            padding: 0;
        }

        .privacy-info li {
            margin-bottom: 8px;
            line-height: 1.5;
            color: #555;
        }

        .privacy-info p {
            margin: 10px 0;
            line-height: 1.5;
            color: #555;
        }

        .gdpr-consent {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            cursor: pointer;
            font-weight: normal;
            margin-bottom: 0;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin-right: 12px;
            margin-top: 4px;
            transform: scale(1.2);
            flex-shrink: 0;
        }

        .consent-text {
            line-height: 1.6;
            color: #333;
            font-size: 14px;
        }

        .checkmark {
            display: none;
        }

        /* Simple GDPR Consent Styling */
        .gdpr-consent-simple {
            margin: 25px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            cursor: pointer;
            font-weight: normal;
            margin-bottom: 0;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
            margin-top: 2px;
            transform: scale(1.2);
            flex-shrink: 0;
        }

        .consent-text {
            line-height: 1.5;
            color: #333;
            font-size: 14px;
        }

        .privacy-link {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
        }

        .privacy-link:hover {
            color: #0056b3;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border: none;
            border-radius: 8px;
            width: 90%;
            max-width: 700px;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #1976d2;
            font-size: 18px;
            font-weight: 600;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover,
        .close:focus {
            color: #000;
        }

        .modal-body {
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .modal-body .privacy-info h4 {
            color: #333;
            margin: 20px 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .modal-body .privacy-info ul {
            margin: 10px 0 20px 20px;
            padding: 0;
        }

        .modal-body .privacy-info li {
            margin-bottom: 8px;
            line-height: 1.5;
            color: #555;
        }

        .modal-body .privacy-info p {
            margin: 10px 0;
            line-height: 1.5;
            color: #555;
        }

        .modal-footer {
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            text-align: right;
        }

        .btn-close-modal {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-close-modal:hover {
            background-color: #545b62;
        }

        @media (max-width: 480px) {
            .request-container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 24px;
            }

            .gdpr-consent-simple {
                margin: 20px 0;
                padding: 12px;
            }

            .consent-text {
                font-size: 13px;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
                max-height: 85vh;
            }

            .modal-header,
            .modal-footer {
                padding: 15px;
            }

            .modal-header h3 {
                font-size: 16px;
            }

            .modal-body {
                padding: 15px;
                max-height: 65vh;
            }

            .modal-body .privacy-info h4 {
                font-size: 14px;
            }

            .modal-body .privacy-info ul {
                margin-left: 15px;
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

        <!-- GDPR Consent -->
        <div class="gdpr-consent-simple">
            <label class="checkbox-label">
                <input type="checkbox" name="gdpr_consent" value="1" {{ old('gdpr_consent') ? 'checked' : '' }} required>
                <span class="consent-text">
                    I agree to the processing of my personal data for account creation and service delivery. 
                    <a href="#" id="privacy-info-link" class="privacy-link">More Information</a> *
                </span>
            </label>
            @error('gdpr_consent')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Submit Request</button>
    </form>

    <a href="{{ route('login') }}" class="back-link">← Back to Login</a>
</div>

<!-- Privacy Information Modal -->
<div id="privacy-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Data Protection & Privacy (GDPR Compliance)</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <div class="privacy-info">
                <h4>How we use your information:</h4>
                <ul>
                    <li><strong>Account creation:</strong> Your company name, email, and customer number will be used to create and manage your account</li>
                    <li><strong>Communication:</strong> We'll use your email to send login credentials, order confirmations, and important account updates</li>
                    <li><strong>Service delivery:</strong> Your information helps us provide customer support and process your orders</li>
                    <li><strong>Legal compliance:</strong> We may use your data to comply with legal obligations and business requirements</li>
                </ul>

                <h4>Your Data Protection Rights:</h4>
                <ul>
                    <li>You can request a copy of the personal data we hold about you</li>
                    <li>You can ask us to correct any inaccurate or incomplete data</li>
                    <li>You can request deletion of your personal data (subject to legal requirements)</li>
                    <li>You can request your data in a machine-readable format</li>
                    <li>You can object to certain types of data processing</li>
                    <li>You can request limitation of data processing in certain circumstances</li>
                </ul>

                <h4>Data Storage & Security:</h4>
                <ul>
                    <li>Your data is stored securely on our servers with encryption and access controls</li>
                    <li>We retain your data only as long as necessary for business purposes and legal requirements</li>
                    <li>Your data will not be sold or shared with third parties for marketing purposes</li>
                    <li>We may share data with service providers who help us operate our business (under strict confidentiality agreements)</li>
                </ul>

                <h4>Contact Information:</h4>
                <p>For questions about your data or to exercise your rights, contact our us at: <strong>info@ozgazi.com</strong></p>
                
                <p><strong>Data Controller:</strong> Özgazi Dairy Foods.<br>
                <strong>Last Updated:</strong> {{ date('F Y') }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal">Close</button>
        </div>
    </div>
</div>

<script>
// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('privacy-modal');
    const privacyLink = document.getElementById('privacy-info-link');
    const closeBtn = document.querySelector('.close');
    const closeButton = document.querySelector('.btn-close-modal');

    // Open modal
    privacyLink.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    });

    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    closeBtn.addEventListener('click', closeModal);
    closeButton.addEventListener('click', closeModal);

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
});
</script>
</body>
</html> 