<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Shreeja</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #0346cb;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.025em;
        }
        .content {
            padding: 40px;
        }
        .content h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 16px;
            color: #0f172a;
        }
        .content p {
            margin-bottom: 24px;
            font-size: 16px;
        }
        .credentials {
            background: #f1f5f9;
            padding: 24px;
            border-radius: 16px;
            margin-bottom: 24px;
        }
        .credentials-item {
            margin-bottom: 12px;
        }
        .label {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            display: block;
            margin-bottom: 4px;
        }
        .value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }
        .footer {
            padding: 40px;
            text-align: center;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            font-size: 12px;
            color: #94a3b8;
            margin: 0;
        }
        .button {
            display: inline-block;
            padding: 14px 32px;
            background-color: #0346cb;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SHREEJA</h1>
        </div>
        <div class="content">
            <h2>Welcome to the team, {{ $user->name }}!</h2>
            <p>Your employee account has been successfully created. We're excited to have you with us!</p>
            
            <div class="credentials">
                <div class="credentials-item">
                    <span class="label">Employee ID</span>
                    <span class="value" style="color: #0346cb;">{{ $user->employee_id }}</span>
                </div>
                <div class="credentials-item">
                    <span class="label">Login Identification</span>
                    <span class="value">{{ $user->phone }}</span>
                </div>
                <div class="credentials-item">
                    <span class="label">Access Status</span>
                    <span class="value" style="color: #059669;">Active & SECURED</span>
                </div>
            </div>

            <p>You can now log in to the <strong>Shreeja Mobile App</strong> using your phone number and the OTP verification process.</p>
            
            
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Shreeja. All rights reserved.</p>
            <p>If you didn't expect this email, please ignore it.</p>
        </div>
    </div>
</body>
</html>
