<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengundian Pemenang - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --accent: #f59e0b;
            --bg: #f8fafc;
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
            padding: 16px 40px;
            background: #ffffff;
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
            font-size: 1.25rem;
        }
        .logo img { height: 40px; object-fit: contain; }

        .nav-links { display: flex; align-items: center; gap: 24px; }
        .nav-links a { font-size: 0.9rem; text-decoration: none; color: var(--text-light); font-weight: 500; }

        .container { max-width: 1000px; margin: 40px auto; padding: 0 40px; }

        .header { text-align: center; margin-bottom: 48px; }
        h1 { font-size: 2.5rem; font-weight: 700; margin: 0; background: linear-gradient(to right, #6366f1, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .header p { color: var(--text-light); margin-top: 8px; font-size: 1.1rem; }

        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; }

        .card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
        }

        .card-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            width: 100%;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4); }

        .winner-list { list-style: none; padding: 0; margin: 0; }
        .winner-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: #f1f5f9;
            border-radius: 16px;
            margin-bottom: 12px;
            border: 1px solid var(--border);
        }
        .winner-rank {
            width: 40px;
            height: 40px;
            background: var(--accent);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        .winner-info h4 { margin: 0; font-size: 1rem; }
        .winner-info p { margin: 0; font-size: 0.85rem; color: var(--text-light); }

        .candidate-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
        }
        .candidate-item:last-child { border-bottom: none; }
        .score-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .confetti-placeholder {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: var(--text-light);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .grid { grid-template-columns: 1fr; }
            .container { padding: 0 20px; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span>BUMDesa Admin</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.analysis') }}">Analisis</a>
            <a href="{{ route('admin.whatsapp') }}">WhatsApp</a>
            <a href="{{ route('admin.lottery') }}" style="color: var(--primary); font-weight: 700;">Pengundian</a>
            <a href="{{ route('admin.interviews') }}">Hasil Wawancara</a>
            <a href="https://kuesioner.simpleakunting.shop/interview/create" style="background: #4f46e5; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; text-decoration: none;">WAWANCARA</a>
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role === 'superadmin' ? 'Superadmin' : 'Interviewer' }})</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>Lucky Draw Responden</h1>
            <p>Pilih 3 pemenang beruntung dari responden dengan nilai terbaik.</p>
        </div>

        @if(session('success')) 
            <div style="background: #dcfce7; color: #15803d; padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #bbf7d0; text-align: center; font-weight: 600;">
                🎉 {{ session('success') }}
            </div> 
        @endif

        <div class="grid">
            <div class="card">
                <div class="card-title">
                    <span>🏆</span> Pemenang Saat Ini
                </div>
                
                @if($winners->count() > 0)
                    <div class="winner-list">
                        @foreach($winners as $index => $winner)
                        <div class="winner-item">
                            <div class="winner-rank">{{ $index + 1 }}</div>
                            <div class="winner-info">
                                <h4>{{ $winner->kuesioner->nama_responden }}</h4>
                                <p>{{ $winner->kuesioner->nama_bumdesa }} ({{ $winner->kuesioner->kabupaten_kota }})</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 24px; text-align: center;">
                        <p style="font-size: 0.85rem; color: var(--text-light);">Hadiah: Software SimpleAkunting v3.5 Free 2 Tahun</p>
                    </div>
                @else
                    <div class="confetti-placeholder">
                        <p>Belum ada pemenang yang diundi.</p>
                        <p style="font-size: 0.8rem;">Klik tombol di bawah untuk memulai!</p>
                    </div>
                @endif

                <form action="{{ route('admin.lottery.draw') }}" method="POST" style="margin-top: 32px;" onsubmit="return confirm('Apakah Anda yakin ingin melakukan pengundian ulang? Pemenang sebelumnya akan diganti.')">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ $winners->count() > 0 ? '🔄 Undi Ulang' : '🎰 Mulai Pengundian' }}
                    </button>
                </form>
            </div>

            <div class="card">
                <div class="card-title">
                    <span>📋</span> Kandidat (Top 10 Skor)
                </div>
                <div class="candidate-list">
                    @forelse($candidates as $c)
                    <div class="candidate-item">
                        <div>
                            <div style="font-weight: 600;">{{ $c->nama_responden }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-light);">{{ $c->nama_bumdesa }}</div>
                        </div>
                        <div class="score-badge">Skor: {{ $c->total_score }}</div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px; color: var(--text-light);">
                        Belum ada data responden.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>
