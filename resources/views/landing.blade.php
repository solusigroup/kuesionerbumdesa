<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Penelitian BUMDesa</title>
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

        html {
            scroll-behavior: smooth;
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
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo img {
            height: 48px;
            object-fit: contain;
        }

        .logo span {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
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

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
        }

        .disclaimer-box {
            margin-top: 56px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(5px);
            border-radius: 16px;
            border: 1px dashed var(--primary);
            display: flex;
            align-items: center;
            gap: 20px;
            text-align: left;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .disclaimer-icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.1));
        }

        .disclaimer-text {
            font-size: 0.95rem;
            color: #475569;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            nav {
                padding: 20px 40px;
            }

            .hero {
                padding: 0 40px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }
        }

        .guide-section {
            padding: 100px 80px;
            background-color: #ffffff;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 64px auto;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 16px;
            font-weight: 800;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #64748b;
        }

        .guide-steps {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 60px;
        }

        .guide-step {
            display: flex;
            align-items: center;
            gap: 50px;
            background: #f8fafc;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            position: relative;
            border: 1px solid #e2e8f0;
        }

        .guide-step.reverse {
            flex-direction: row-reverse;
        }

        .step-number {
            position: absolute;
            top: -24px;
            left: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.75rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.4);
        }

        .guide-step.reverse .step-number {
            left: auto;
            right: 40px;
        }

        .step-content {
            flex: 1;
        }

        .step-content h3 {
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 16px;
            margin-top: 0;
            font-weight: 800;
        }

        .step-content p {
            font-size: 1.15rem;
            color: #475569;
            line-height: 1.6;
            margin: 0;
        }

        .step-image {
            flex: 1.2;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 6px solid white;
            background: white;
            height: 380px;
        }

        .step-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            display: block;
            object-position: top center;
        }

        .step-image img.crop-bottom {
            object-position: bottom center;
        }

        .step-image img.crop-center {
            object-position: center;
        }

        @media (max-width: 768px) {
            .guide-section {
                padding: 60px 24px;
            }

            .guide-step,
            .guide-step.reverse {
                flex-direction: column;
                padding: 50px 24px 32px;
                gap: 32px;
            }

            .step-image {
                width: 100%;
                box-sizing: border-box;
                height: 250px;
            }

            .step-number,
            .guide-step.reverse .step-number {
                left: 32px;
                right: auto;
            }
        }
    </style>
</head>

<body>
    <nav>
        <a href="/" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="UBS PPNI Logo">
            <span>UBS PPNI Research</span>
        </a>
        <div class="nav-links">
            <a href="#panduan">Panduan</a>
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
            <p>Berikan kontribusi Anda dalam penelitian mengenai efektivitas dan tata kelola BUMDesa untuk masa depan
                desa yang lebih mandiri.</p>
            <div class="cta-btns">
                @auth
                    <a href="{{ route('kuesioner.create') }}" class="btn btn-primary">Mulai Kuesioner</a>
                    <a href="{{ route('kuesioner.index') }}" class="btn btn-outline">Lihat Hasil</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">Ikut Berpartisipasi</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Sudah Ada Akun</a>
                @endauth
            </div>

            <div class="disclaimer-box">
                <div class="disclaimer-icon">🛡️</div>
                <div class="disclaimer-text">
                    <strong>Pernyataan Privasi & Etika:</strong> KERAHASIAAN data, identitas, dan privasi responden
                    sepenuhnya <strong>DILINDUNGI oleh "Ethical Clearance"</strong>. Partisipasi Anda sangat berharga
                    dan data Anda akan dikelola secara anonim untuk kepentingan akademik.
                </div>
            </div>
        </div>
    </div>

    <div id="panduan" class="guide-section">
        <div class="section-header">
            <h2>Panduan Pengisian</h2>
            <p>Ikuti 3 tahapan mudah di bawah ini untuk berpartisipasi dan menyelesaikan kuesioner BUMDesa.</p>
        </div>

        <div class="guide-steps">
            <!-- Step 1 -->
            <div class="guide-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Registrasi & Login</h3>
                    <p>Mulai langkah awal dengan membuat akun baru melalui tombol Register. Jika Anda sudah pernah
                        mendaftar, cukup gunakan menu Login untuk masuk ke dalam sistem dengan kredensial Anda.</p>
                </div>
                <div class="step-image">
                    <img src="{{ asset('img/guide/step1.png') }}" class="crop-center" alt="Registrasi dan Login">
                </div>
            </div>

            <!-- Step 2 -->
            <div class="guide-step reverse">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Isi Profil Responden</h3>
                    <p>Lengkapi informasi mulai dari data diri Anda sebagai responden secara anonim hingga data spesifik
                        mengenai letak operasional serta frekuensi pendampingan BUMDesa tempat Anda menjabat saat ini.
                    </p>
                </div>
                <div class="step-image">
                    <img src="{{ asset('img/guide/step3.png') }}" alt="Formulir Profil Responden">
                </div>
            </div>

            <!-- Step 3 -->
            <div class="guide-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Penilaian Instrumen</h3>
                    <p>Berikan penilaian objektif pada setiap pernyataan dalam instrumen penelitian tata kelola. Pilih
                        menggunakan skala dari 1 (Sangat Tidak Setuju) hingga 5 (Sangat Setuju). Pastikan seluruh
                        pernyataan terisi, kemudian klik <strong>Simpan & Kirim Kuesioner</strong>.</p>
                </div>
                <div class="step-image">
                    <img src="{{ asset('img/guide/step4.png') }}" class="crop-bottom"
                        alt="Formulir Instrumen Penilaian">
                </div>
            </div>
        </div>
    </div>
</body>

</html>