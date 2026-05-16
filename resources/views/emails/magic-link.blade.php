<!DOCTYPE html>
<html>
<head>
    <title>Link Akses Kuesioner</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo!</h2>
    <p>Anda menerima email ini karena kami menerima permintaan akses masuk ke aplikasi Kuesioner BUMDesa menggunakan email Anda.</p>
    <p>Silakan klik tombol di bawah ini untuk masuk:</p>
    <div style="margin: 30px 0;">
        <a href="{{ $url }}" style="background-color: #4f46e5; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold;">Masuk ke Aplikasi</a>
    </div>
    <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan saja email ini.</p>
    <p>Terima kasih,<br>Tim Kuesioner BUMDesa</p>
    <hr>
    <p style="font-size: 0.8rem; color: #666;">Jika tombol di atas tidak berfungsi, salin dan tempel link berikut ke browser Anda:<br>{{ $url }}</p>
</body>
</html>
