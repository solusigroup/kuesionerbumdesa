<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 80px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.2rem;
        }
        .logo img {
            height: 40px;
            object-fit: contain;
        }

        .nav-links a {
            font-size: 0.9rem;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--primary); }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.95rem;
        }

        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-info { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

        .response-detail {
            padding: 40px;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .info-item label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .info-item span {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .no-data {
            padding: 60px;
            text-align: center;
            color: var(--text-light);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }

        @media (max-width: 768px) {
            .grid-info { grid-template-columns: 1fr; }
            nav { padding: 16px 20px; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span>BUMDesa Research</span>
        </a>
        <div class="nav-links">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Hasil Kuesioner Anda</h1>
        </div>

        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('info')) <div class="alert alert-info">{{ session('info') }}</div> @endif

        <div class="card">
            @if($kuesioners->isEmpty())
                <div class="no-data">
                    <p>Anda belum mengisi kuesioner.</p>
                    <a href="{{ route('kuesioner.create') }}" class="btn btn-primary">Isi Kuesioner Sekarang</a>
                </div>
            @else
                @foreach($kuesioners as $item)
                    <div class="response-detail">
                        <div class="grid-info">
                            <div class="info-item"><label>Nama Responden</label><span>{{ $item->nama_responden }}</span></div>
                            <div class="info-item"><label>Nomor WhatsApp</label><span>{{ $item->nomor_wa }}</span></div>
                            <div class="info-item"><label>Email BUMDesa</label><span>{{ $item->email_bumdesa }}</span></div>
                            <div class="info-item"><label>BUMDesa</label><span>{{ $item->nama_bumdesa }}</span></div>
                            <div class="info-item"><label>Desa / Kecamatan</label><span>{{ $item->nama_desa }} / {{ $item->kecamatan }}</span></div>
                            <div class="info-item"><label>Kabupaten/Kota</label><span>{{ $item->kabupaten_kota }}</span></div>
                            <div class="info-item"><label>Jabatan</label><span>{{ $item->jabatan }}</span></div>
                            <div class="info-item"><label>Tanggal Kirim</label><span>{{ $item->created_at->format('d F Y') }}</span></div>
                        </div>
                        
                        <div style="padding-top: 20px; border-top: 1px solid var(--border);">
                            <p style="color: var(--text-light);">Terima kasih telah berpartisipasi. Jawaban Anda telah tersimpan dengan aman di sistem kami.</p>
                            <a href="{{ route('kuesioner.thanks') }}" class="btn btn-primary" style="margin-top: 15px;">Lihat Tawaran Aplikasi / Promo</a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</body>
</html>