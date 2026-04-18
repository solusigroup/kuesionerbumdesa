<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penelitian Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --dark: #0f172a;
            --light: #f8fafc;
            --accent: #f59e0b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 80px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-sizing: border-box;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
        }

        .nav-links a {
            margin-left: 32px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 80px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
        }

        .hero-content {
            max-width: 700px;
            text-align: center;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .cta-btns {
            display: flex;
            gap: 16px;
            justify-content: center;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: rgba(79, 70, 229, 0.05);
            transform: translateY(-2px);
        }

        .floating-shapes div {
            position: absolute;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }

        .shape-1 { width: 400px; height: 400px; top: -100px; right: -100px; }
        .shape-2 { width: 300px; height: 300px; bottom: -50px; left: -50px; }

        @media (max-width: 768px) {
            nav { padding: 20px 40px; }
            .hero { padding: 0 40px; }
            .hero h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">BUMDesa Research</a>
        <div class="nav-links">
            @auth
                <a href="{{ route('kuesioner.index') }}">Dashboard</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    <div class="hero">
        <div class="floating-shapes">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
        </div>
        <div class="hero-content">
            <h1>Optimalkan Kinerja BUMDesa Anda</h1>
            <p>Berikan kontribusi Anda dalam penelitian mengenai efektivitas dan tata kelola BUMDesa untuk masa depan desa yang lebih mandiri.</p>
            <div class="cta-btns">
                @auth
                    <a href="{{ route('kuesioner.create') }}" class="btn btn-primary">Mulai Kuesioner</a>
                    <a href="{{ route('kuesioner.index') }}" class="btn btn-outline">Lihat Hasil</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Ikut Berpartisipasi</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Sudah Ada Akun</a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
