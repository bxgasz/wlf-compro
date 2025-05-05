<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
        }
        .header {
            background-color: #d10000;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f4f4f4;
            color: #555555;
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
        }
        a {
            color: #d10000;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $mailData['title'] }}</h1>
        </div>
        <div class="content">
            <p>Dear {{ $mailData['user_name'] }},</p>
            <p>🔹 Email: {{ $mailData['user_email'] }}</p>
            <p>🔹 Password: {{ $mailData['password'] }}</p>
            <p>For security reasons, please change your password upon first login.</p>
            <p>🔗 Login here: {{ $mailData['url'] }}</p>
            <p>Best regards,</p>
            <p>wlf@gmail.com</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 PT wlf. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
