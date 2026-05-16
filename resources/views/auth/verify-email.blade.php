<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
        }
        body { font-family: 'Outfit', sans-serif; background-color: var(--bg); display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: var(--card-bg); padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; text-align: center; }
        h2 { color: var(--primary); margin-bottom: 16px; }
        p { color: var(--text-light); line-height: 1.6; margin-bottom: 24px; }
        .btn { background: var(--primary); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Verifikasi Email Anda</h2>
        <p>Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan mengklik link yang baru saja kami kirimkan ke email Anda.</p>
        <p>Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.</p>
        
        @if (session('status') == 'verification-link-sent')
            <p style="color: green; font-weight: bold;">Link verifikasi baru telah dikirim ke alamat email Anda.</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn">Kirim Ulang Email Verifikasi</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--text-light); text-decoration: underline; cursor: pointer;">Keluar</button>
        </form>
    </div>
</body>
</html>
