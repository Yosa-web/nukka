<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Anda - Balitbang Pesawaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            text-align: center;
        }
        .email-body p {
            margin: 10px 0;
            font-size: 16px;
        }
        .otp-code {
            display: inline-block;
            background-color: #f8f9fa;
            color: #007bff;
            font-size: 28px;
            font-weight: bold;
            padding: 10px 20px;
            margin: 20px auto;
            border-radius: 6px;
            border: 1px solid #007bff;
        }
        .email-footer {
            background-color: #f4f4f4;
            color: #666666;
            font-size: 12px;
            text-align: center;
            padding: 10px;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Balitbang Pesawaran</h1>
            <p>Rumah Inovasi</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Halo,</p>
            <p>Berikut adalah kode OTP untuk mengaktifkan akun Anda di Rumah Inovasi Balitbang Pesawaran:</p>
            <div class="otp-code"><?= esc($code) ?></div>
            <p>Jangan berikan kode ini kepada siapa pun. Kode ini berlaku untuk satu kali penggunaan saja.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; <?= date('Y') ?> Balitbang Pesawaran. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon untuk tidak membalas.</p>
        </div>
    </div>
</body>
</html>
