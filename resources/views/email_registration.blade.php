<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Successful</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0px 2px 5px rgba(0,0,0,0.1);">
        <div class="logo_template" style="text-align: center;">
            <img src="{{ url('public/assets/images/Frame.png') }}" alt="Logo">
        </div>
        <h2 style="color:#333; text-align:center;">Registration Successful</h2>
        <p style="font-size:16px; color:#555;">Hello {{ $user->first_name ?? 'User' }},</p>
        <p style="font-size:16px; color:#555;">
            Thank you for registering on our platform. Your account has been created successfully!
        </p>
        <p style="font-size:14px; color:#888; text-align:center;">
            We are excited to have you on board.
        </p>
    </div>
</body>
</html>
