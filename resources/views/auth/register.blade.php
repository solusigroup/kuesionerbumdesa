<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-card {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--border);
        }

        h2 {
            margin: 0 0 8px;
            color: var(--primary);
            text-align: center;
            font-weight: 600;
        }

        p.subtitle {
            text-align: center;
            color: var(--text-light);
            margin-bottom: 32px;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background-color: #f8fafc;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            padding-right: 48px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            padding: 4px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            width: auto;
            height: auto;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <h2>Daftar Akun</h2>
        <p class="subtitle">Buat akun untuk berpartisipasi dalam penelitian.</p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" required autofocus value="{{ old('name') }}" style="{{ $errors->has('name') ? 'border-color: #ef4444;' : '' }}">
                @error('name')
                    <div style="color: #ef4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" style="{{ $errors->has('email') ? 'border-color: #ef4444;' : '' }}">
                @error('email')
                    <div style="color: #ef4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <p style="font-size: 0.85rem; color: var(--text-light); margin-bottom: 20px;">
                * Verifikasi akan dikirimkan ke email Anda. Password hanya diperlukan saat melihat hasil penelitian.
            </p>
            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="links">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk Disini</a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🔒';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }
    </script>
</body>
</html>
