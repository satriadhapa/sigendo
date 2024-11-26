<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Verifikasi Email</h1>
    <p>Silakan cek email Anda dan klik tautan untuk memverifikasi akun Anda.</p>
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>
</body>
</html>
