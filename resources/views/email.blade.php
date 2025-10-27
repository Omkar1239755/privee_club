<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0px 2px 5px rgba(0,0,0,0.1);">
        <div class="logo_template" style="text-align: center;"><img src="{{ url('public/assets/images/Frame.png') }}"></div>
        <h2 style="color:#333; text-align:center;">Password Reset Request</h2>
        <p style="font-size:16px; color:#555;">Hello {{ $user->first_name ?? 'User' }},</p>
        <p style="font-size:16px; color:#555;">
            Your One Time Password (OTP) for resetting your password is:
        </p>
        <h1 style="text-align:center; color:#2c3e50; background:#f0f0f0; padding:10px; border-radius:6px;">
            {{ $otp }}
        </h1>
        <p style="font-size:14px; color:#888;">If you didn’t request this, please ignore this email.</p>
    </div>
</body>
</html>
