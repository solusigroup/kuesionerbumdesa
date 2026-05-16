<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Password - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4f46e5; --bg: #f8fafc; --card-bg: #ffffff; --text: #1e293b; --text-light: #64748b; --border: #e2e8f0; }
        body { font-family: 'Outfit', sans-serif; background-color: var(--bg); display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: var(--card-bg); padding: 40px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; }
        h2 { color: var(--primary); text-align: center; margin-bottom: 8px; }
        p { text-align: center; color: var(--text-light); margin-bottom: 24px; font-size: 0.9rem; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 0.9rem; }
        input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border); box-sizing: border-box; }
        button { width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Konfirmasi Password</h2>
        <p>Silakan masukkan password Anda untuk melihat hasil.</p>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.confirm_action') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>
            <button type="submit">Konfirmasi</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('kuesioner.create') }}" style="color: var(--text-light); font-size: 0.85rem;">Kembali ke Form</a>
        </div>
    </div>
</body>
</html>
