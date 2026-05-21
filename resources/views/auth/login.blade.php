<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kuesioner BUMDesa</title>
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
        <h2>Selamat Datang Kembali</h2>
        <p class="subtitle">Masuk ke akun Anda untuk melanjutkan.</p>

        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background-color: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required autofocus value="{{ old('email') }}" style="{{ $errors->has('email') ? 'border-color: #ef4444;' : '' }}">
                @error('email')
                    <div style="color: #ef4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div id="passwordSection" style="display: {{ $errors->has('password') ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" style="{{ $errors->has('password') ? 'border-color: #ef4444;' : '' }}" {{ $errors->has('password') ? 'required' : '' }}>
                        <input type="hidden" name="password_mode" id="passwordMode" value="{{ $errors->has('password') ? '1' : '0' }}">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" tabindex="-1">
                            👁️
                        </button>
                    </div>
                    @error('password')
                        <div style="color: #ef4444; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" id="submitBtn">Masuk</button>
            
            <div style="text-align: center; margin-top: 15px;">
                <button type="button" onclick="toggleMode()" style="background: none; border: none; color: var(--primary); cursor: pointer; font-size: 0.85rem;" id="modeToggle">
                    {{ $errors->has('password') ? 'Masuk tanpa Password' : 'Masuk dengan Password' }}
                </button>
            </div>
        </form>

        <div class="links">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
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

        function toggleMode() {
            const section = document.getElementById('passwordSection');
            const mode = document.getElementById('passwordMode');
            const btn = document.getElementById('submitBtn');
            const toggle = document.getElementById('modeToggle');
            const passwordInput = document.getElementById('password');

            if (section.style.display === 'none') {
                section.style.display = 'block';
                mode.value = '1';
                btn.textContent = 'Masuk';
                toggle.textContent = 'Masuk tanpa Password';
                passwordInput.required = true;
            } else {
                section.style.display = 'none';
                mode.value = '0';
                btn.textContent = 'Masuk';
                toggle.textContent = 'Masuk dengan Password';
                passwordInput.required = false;
            }
        }
    </script>
</body>
</html>
