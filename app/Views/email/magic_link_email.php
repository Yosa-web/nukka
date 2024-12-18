<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Permintaan Reset Password - Balitbang Pesawaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333333;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h2 {
            color: #007bff;
            text-align: center;
        }
        .email-footer {
            font-size: 12px;
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            color: #666666;
        }
        .action-button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 20px;
            margin: 20px auto;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            text-align: center;
        }
        .action-button:hover {
            background-color: #0056b3;
        }
        .info-section {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Balitbang Pesawaran</h1>
            <p>Permintaan Reset Password</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mengatur ulang password akun Anda. Jika Anda melakukan permintaan ini, silakan gunakan tautan di bawah ini untuk melanjutkan proses reset password:</p>
            <div style="text-align: center;">
                <a href="<?= url_to('verify-magic-link') ?>?token=<?= $token ?>" class="action-button">Atur Ulang Password</a>
            </div>
            <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Password Anda tidak akan berubah kecuali Anda menggunakan tautan di atas.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; <?= date('Y') ?> Balitbang Pesawaran. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
