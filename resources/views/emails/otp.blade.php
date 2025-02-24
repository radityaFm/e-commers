<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
</head>
<body>
    <h1>Kode OTP Anda</h1>
    <p>Kode OTP Anda adalah: <strong>{{ $otpCode }}</strong></p>
    <p>Kode ini berlaku hingga: {{ $expiresAt->format('d M Y H:i') }}</p>
    <p>Jangan berikan kode ini kepada siapa pun.</p>
</body>
</html>