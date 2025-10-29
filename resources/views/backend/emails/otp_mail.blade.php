<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Verifikasi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #0b63f6;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .content {
            padding: 30px;
            text-align: center;
        }

        .otp {
            font-size: 32px;
            font-weight: bold;
            color: #0b63f6;
            letter-spacing: 5px;
            margin: 20px 0;
        }

        .footer {
            background-color: #f4f6f8;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
        }

        .note {
            font-size: 14px;
            color: #444;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pandu App - Verifikasi Akun</h2>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $name }}</strong>,</p>
            <p>Berikut adalah kode OTP Anda:</p>
            <div class="otp">{{ $otp }}</div>
            <p class="note">
                Kode ini hanya berlaku selama <strong>1 menit</strong>.<br>
                Jangan bagikan kode ini kepada siapa pun.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Pandu App — Bengkulu Utara<br>
            <small>Pesan otomatis, mohon tidak membalas email ini.</small>
        </div>
    </div>
</body>
</html>
