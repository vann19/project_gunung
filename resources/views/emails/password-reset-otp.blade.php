<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9fafb; padding: 32px 16px; margin: 0;">
    <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e5e7eb;">
        <p style="font-size: 12px; letter-spacing: 0.15em; text-transform: uppercase; color: #005E97; font-weight: 700; margin: 0 0 8px;">
            Reset Password
        </p>
        <h1 style="font-size: 24px; color: #1c1917; margin: 0 0 12px;">
            Halo, {{ $name }}
        </h1>
        <p style="font-size: 14px; color: #57534e; line-height: 1.6; margin: 0 0 24px;">
            Gunakan kode OTP berikut untuk melanjutkan proses reset password. Kode ini berlaku selama 10 menit.
        </p>

        <div style="background: #53BEFF1A; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 24px;">
            <span style="font-size: 32px; font-weight: 800; letter-spacing: 0.35em; color: #005E97;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 12px; color: #78716c; line-height: 1.6; margin: 0;">
            Jika Anda tidak meminta reset password, abaikan email ini. Jangan bagikan kode OTP kepada siapa pun.
        </p>
    </div>
</body>
</html>
