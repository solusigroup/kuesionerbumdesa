<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Kuesioner - Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- MathJax for rendering LaTeX formulas beautifully -->
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']],
                processEscapes: true
            }
        };
    </script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #10b981;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --danger: #ef4444;
        }

        body { font-family: 'Outfit', sans-serif; background-color: var(--bg); color: var(--text); margin: 0; padding: 0; line-height: 1.6; }
        nav { display: flex; justify-content: space-between; align-items: center; padding: 16px 40px; background: #ffffff; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.25rem;
        }
        .logo img {
            height: 40px;
            object-fit: contain;
        }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; }
        
        .grid-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--card-bg); padding: 24px; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .stat-card label { display: block; font-size: 0.85rem; color: var(--text-light); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 8px; }
        .stat-card .value { font-size: 2rem; font-weight: 700; color: var(--primary); }
        .stat-card .sub { font-size: 0.75rem; color: var(--text-light); }
        
        .grid-charts { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; }
        .chart-card { background: var(--card-bg); padding: 32px; border-radius: 20px; border: 1px solid var(--border); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .chart-card h3 { margin-top: 0; margin-bottom: 24px; font-size: 1.1rem; border-left: 4px solid var(--primary); padding-left: 12px; }
        
        .btn-nav-primary { background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem; }

        @media (max-width: 1024px) { .grid-stats { grid-template-columns: 1fr 1fr; } .grid-charts { grid-template-columns: 1fr; } }

        .table-stats { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 0.9rem; }
        .table-stats th, .table-stats td { padding: 12px; text-align: center; border-bottom: 1px solid var(--border); }
        .table-stats th { background: #f8fafc; color: var(--text-light); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
        .table-stats tr:last-child td { border-bottom: none; }
        .badge-success { background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; }
        .badge-danger { background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; }
        
        .regression-box { background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; padding: 32px; border-radius: 24px; position: relative; overflow: hidden; margin-top: 40px; }
        .regression-box::before { content: "f(x)"; position: absolute; right: -20px; bottom: -20px; font-size: 15rem; font-weight: 900; color: rgba(255,255,255,0.05); z-index: 0; }
        .regression-box * { position: relative; z-index: 1; }
        .formula-display { font-size: 1.75rem; font-weight: 700; text-align: center; margin: 24px 0; letter-spacing: 0.02em; text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .coeff-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 32px; }
        .coeff-item { background: rgba(255,255,255,0.1); padding: 16px; border-radius: 12px; backdrop-filter: blur(5px); }
        .coeff-label { font-size: 0.75rem; font-weight: 600; color: rgba(255,255,255,0.7); text-transform: uppercase; margin-bottom: 4px; }
        .coeff-value { font-size: 1.25rem; font-weight: 700; }
        .narration-box { background: #e0e7ff; border-left: 4px solid var(--primary); padding: 16px 24px; margin-top: 20px; border-radius: 0 12px 12px 0; font-size: 0.95rem; color: var(--text); line-height: 1.6; }
        .chart-flex-container {
            display: flex;
            gap: 24px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 16px;
        }
        .chart-wrapper {
            flex: 1.2;
            min-width: 250px;
            height: 300px;
            position: relative;
        }
        .table-wrapper {
            flex: 1;
            min-width: 250px;
        }
        .grid-asumsi {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 1024px) {
            .grid-asumsi {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ auth()->check() && auth()->user()->role === 'superadmin' ? route('admin.dashboard') : '/' }}" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span>BUMDesa Analysis</span>
        </a>
        <div class="nav-links">
            @auth
                @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'interviewer')
                    <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Dashboard</a>
                    <a href="{{ route('admin.analysis') }}" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Analisis</a>
                    <a href="{{ route('admin.whatsapp') }}" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">WhatsApp</a>
                    <a href="{{ route('admin.lottery') }}" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Pengundian</a>
                    <a href="{{ route('admin.interviews') }}" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Hasil Wawancara</a>
                    <a href="https://kuesioner.simpleakunting.shop/interview/create" style="background: #4f46e5; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.9rem;">WAWANCARA</a>
                    <span style="font-size: 0.9rem; color: var(--text);">{{ auth()->user()->name }} ({{ auth()->user()->role === 'superadmin' ? 'Superadmin' : 'Interviewer' }})</span>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none; color: var(--text-light); font-size: 0.9rem; font-weight: 500;">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                @else
                    <a href="/" class="btn-nav-primary">Halaman Utama</a>
                @endif
            @else
                <a href="/" class="btn-nav-primary">Halaman Utama</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(isset($isEmpty))
            <div style="text-align: center; padding: 100px 0;">
                <h2 style="font-size: 2rem; color: var(--text-light);">Belum ada data untuk dianalisis.</h2>
                <p>Dashboard analisis akan aktif setelah responden mengisi kuesioner.</p>
                <a href="{{ auth()->check() && auth()->user()->role === 'superadmin' ? route('admin.dashboard') : '/' }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">&larr; Kembali</a>
            </div>
        @else
            <div class="header">
                <div>
                    <h1>Dashboard Analisis Penelitian</h1>
                    <p style="color: var(--text-light);">Visualisasi data berdasarkan instrumen Kapasitas, Budaya, dan Tata Kelola.</p>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-light);">Total Responden:</span>
                    <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">{{ $totalRespondents }}</div>
                </div>
            </div>

            <div class="grid-stats">
                <div class="stat-card">
                    <label>Kapasitas (X1) <span style="color:var(--secondary)">↑</span></label>
                    <div class="value">{{ $averages['x1'] }}</div>
                    <span class="sub">Arah Positif (Skor Ideal: 5)</span>
                </div>
                <div class="stat-card">
                    <label>Tekanan Budaya (X2) <span style="color:var(--danger)">↓</span></label>
                    <div class="value" style="color: var(--danger);">{{ $averages['x2'] }}</div>
                    <span class="sub">Arah Negatif (Skor Ideal: 1)</span>
                </div>
                <div class="stat-card">
                    <label>Kelemahan Tata Kelola (X3) <span style="color:var(--danger)">↓</span></label>
                    <div class="value" style="color: var(--danger);">{{ $averages['x3'] }}</div>
                    <span class="sub">Arah Negatif (Skor Ideal: 1)</span>
                </div>
                <div class="stat-card">
                    <label>Kualitas Pelaporan (Y) <span style="color:var(--secondary)">↑</span></label>
                    <div class="value" style="color: var(--secondary);">{{ $averages['y'] }}</div>
                    <span class="sub">Arah Positif (Skor Ideal: 5)</span>
                </div>
            </div>

            <div class="narration-box" style="margin-bottom: 40px;">
                <strong>Interpretasi Visualisasi Data:</strong> Berdasarkan ringkasan di atas, variabel <strong>Kapasitas Manajerial (X1)</strong> menunjukkan skor rata-rata {{ $averages['x1'] }} dan <strong>Kualitas Pelaporan (Y)</strong> sebesar {{ $averages['y'] }}, yang mengindikasikan kecenderungan positif (mendekati skor ideal 5). Sebaliknya, <strong>Tekanan Budaya (X2)</strong> dan <strong>Kelemahan Tata Kelola (X3)</strong> mencatatkan rata-rata masing-masing {{ $averages['x2'] }} dan {{ $averages['x3'] }}. Keduanya dievaluasi dengan arah terbalik (skor ideal 1), yang berarti semakin rendah skornya, semakin sedikit hambatan yang dirasakan oleh responden terkait budaya dan tata kelola di lingkungan BUMDesa.
            </div>

            <div class="grid-charts">
                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Sebaran Responden per Kabupaten</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="kabupatenChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Kabupaten/Kota</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumKab = $byKabupaten->sum(); @endphp
                                    @foreach($byKabupaten as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumKab > 0 ? round(($val / $sumKab) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumKab }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Sebaran Responden per Jabatan</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="jabatanChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Jabatan</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumJab = $byJabatan->sum(); @endphp
                                    @foreach($byJabatan as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumJab > 0 ? round(($val / $sumJab) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumJab }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Sebaran Responden per Pendidikan</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="pendidikanChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Pendidikan Terakhir</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumEdu = $byPendidikan->sum(); @endphp
                                    @foreach($byPendidikan as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumEdu > 0 ? round(($val / $sumEdu) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumEdu }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Pernah Mengikuti Pelatihan</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="pelatihanChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Jawaban</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumPel = $byPelatihan->sum(); @endphp
                                    @foreach($byPelatihan as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumPel > 0 ? round(($val / $sumPel) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumPel }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Menggunakan Aplikasi</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="aplikasiChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Jawaban</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumApp = $byAplikasi->sum(); @endphp
                                    @foreach($byAplikasi as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumApp > 0 ? round(($val / $sumApp) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumApp }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Frekuensi Pelatihan</h3>
                    <div class="chart-flex-container">
                        <div class="chart-wrapper">
                            <canvas id="frekuensiChart"></canvas>
                        </div>
                        <div class="table-wrapper">
                            <table class="table-stats">
                                <thead>
                                    <tr>
                                        <th style="text-align: left; padding-left: 16px;">Frekuensi Pelatihan</th>
                                        <th>Frekuensi (N)</th>
                                        <th>Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sumFreq = $byFrekuensi->sum(); @endphp
                                    @foreach($byFrekuensi as $key => $val)
                                        <tr>
                                            <td style="text-align: left; padding-left: 16px;">{{ $key }}</td>
                                            <td style="font-weight: 600;">{{ $val }}</td>
                                            <td>{{ $sumFreq > 0 ? round(($val / $sumFreq) * 100, 1) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr style="font-weight: bold; background: #f8fafc;">
                                        <td style="text-align: left; padding-left: 16px;">Total</td>
                                        <td>{{ $sumFreq }}</td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="chart-card" style="grid-column: span 1;">
                    <h3>Radar Perbandingan Variabel</h3>
                    <div style="height: 350px;"><canvas id="radarChart"></canvas></div>
                </div>
                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Rincian Skor per Butir Pernyataan</h3>
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Tabel Statistik Deskriptif (Saran Perbaikan 3) -->
            <div class="chart-card" style="margin-top: 40px; margin-bottom: 32px;">
                <h3 style="margin-bottom: 20px; border-left: 4px solid var(--primary); padding-left: 12px;">Tabel 1: Statistik Deskriptif Variabel & Indikator Penelitian</h3>
                <p style="color: var(--text-light); font-size: 0.85rem; margin-top: -12px; margin-bottom: 20px;">Menampilkan jumlah sampel (N), nilai minimum (Min), nilai maksimum (Max), rata-rata (Mean), dan standar deviasi (Std. Deviasi) untuk setiap variabel dan butir pernyataan.</p>
                <div style="overflow-x: auto;">
                    <table class="table-stats" style="margin-top: 0; text-align: left;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="text-align: left; padding-left: 16px; width: 45%;">Variabel / Indikator Penelitian</th>
                                <th style="text-align: center;">N</th>
                                <th style="text-align: center;">Min</th>
                                <th style="text-align: center;">Max</th>
                                <th style="text-align: center;">Mean</th>
                                <th style="text-align: center;">Standar Deviasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- X1 -->
                            <tr style="background: #e2e8f0; font-weight: 700; border-bottom: 2px solid var(--border);">
                                <td style="text-align: left; padding-left: 16px;">Kapasitas Manajerial (X1) - Composite</td>
                                <td style="text-align: center;">{{ $descriptive['variables']['x1']['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x1']['min'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x1']['max'], 2) }}</td>
                                <td style="text-align: center; color: var(--primary);">{{ number_format($descriptive['variables']['x1']['mean'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x1']['std_dev'], 2) }}</td>
                            </tr>
                            @foreach($descriptive['items']['x1'] as $item => $val)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: left; padding-left: 32px; color: var(--text-light);">Butir {{ substr($item, -1) }}: X1.{{ substr($item, -1) }}</td>
                                <td style="text-align: center;">{{ $val['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($val['min'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['max'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['mean'], 2) }}</td>
                                <td style="text-align: center; color: var(--text-light);">{{ number_format($val['std_dev'], 2) }}</td>
                            </tr>
                            @endforeach

                            <!-- X2 -->
                            <tr style="background: #e2e8f0; font-weight: 700; border-bottom: 2px solid var(--border); margin-top: 10px;">
                                <td style="text-align: left; padding-left: 16px;">Tekanan Budaya Relasional (X2) - Composite</td>
                                <td style="text-align: center;">{{ $descriptive['variables']['x2']['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x2']['min'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x2']['max'], 2) }}</td>
                                <td style="text-align: center; color: var(--danger);">{{ number_format($descriptive['variables']['x2']['mean'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x2']['std_dev'], 2) }}</td>
                            </tr>
                            @foreach($descriptive['items']['x2'] as $item => $val)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: left; padding-left: 32px; color: var(--text-light);">Butir {{ substr($item, -1) }}: X2.{{ substr($item, -1) }}</td>
                                <td style="text-align: center;">{{ $val['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($val['min'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['max'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['mean'], 2) }}</td>
                                <td style="text-align: center; color: var(--text-light);">{{ number_format($val['std_dev'], 2) }}</td>
                            </tr>
                            @endforeach

                            <!-- X3 -->
                            <tr style="background: #e2e8f0; font-weight: 700; border-bottom: 2px solid var(--border);">
                                <td style="text-align: left; padding-left: 16px;">Kelemahan Tata Kelola Keuangan (X3) - Composite</td>
                                <td style="text-align: center;">{{ $descriptive['variables']['x3']['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x3']['min'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x3']['max'], 2) }}</td>
                                <td style="text-align: center; color: var(--danger);">{{ number_format($descriptive['variables']['x3']['mean'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['x3']['std_dev'], 2) }}</td>
                            </tr>
                            @foreach($descriptive['items']['x3'] as $item => $val)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: left; padding-left: 32px; color: var(--text-light);">Butir {{ substr($item, -1) }}: X3.{{ substr($item, -1) }}</td>
                                <td style="text-align: center;">{{ $val['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($val['min'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['max'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['mean'], 2) }}</td>
                                <td style="text-align: center; color: var(--text-light);">{{ number_format($val['std_dev'], 2) }}</td>
                            </tr>
                            @endforeach

                            <!-- Y -->
                            <tr style="background: #e2e8f0; font-weight: 700; border-bottom: 2px solid var(--border);">
                                <td style="text-align: left; padding-left: 16px;">Kualitas Implementasi Pelaporan (Y) - Composite</td>
                                <td style="text-align: center;">{{ $descriptive['variables']['y']['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['y']['min'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['y']['max'], 2) }}</td>
                                <td style="text-align: center; color: var(--secondary);">{{ number_format($descriptive['variables']['y']['mean'], 2) }}</td>
                                <td style="text-align: center;">{{ number_format($descriptive['variables']['y']['std_dev'], 2) }}</td>
                            </tr>
                            @foreach($descriptive['items']['y'] as $item => $val)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: left; padding-left: 32px; color: var(--text-light);">Butir {{ substr($item, -1) }}: Y.{{ substr($item, -1) }}</td>
                                <td style="text-align: center;">{{ $val['n'] }}</td>
                                <td style="text-align: center;">{{ number_format($val['min'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['max'], 0) }}</td>
                                <td style="text-align: center;">{{ number_format($val['mean'], 2) }}</td>
                                <td style="text-align: center; color: var(--text-light);">{{ number_format($val['std_dev'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Definisi Operasional & Teks Kuesioner (Saran Perbaikan 3) -->
            <div class="chart-card" style="margin-bottom: 32px;">
                <h3 style="margin-bottom: 20px; border-left: 4px solid var(--primary); padding-left: 12px;">Tabel 2: Definisi Operasional & Butir Instrumen Penelitian</h3>
                <p style="color: var(--text-light); font-size: 0.85rem; margin-top: -12px; margin-bottom: 20px;">Melampirkan rincian definisi konstruk variabel penelitian beserta contoh pertanyaan/pernyataan kuesioner yang disajikan kepada responden.</p>
                <div style="overflow-x: auto;">
                    <table class="table-stats" style="margin-top: 0; text-align: left;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="text-align: left; padding-left: 16px; width: 20%;">Variabel</th>
                                <th style="text-align: left; width: 25%;">Definisi Operasional</th>
                                <th style="text-align: center; width: 8%;">Kode</th>
                                <th style="text-align: left; padding-right: 16px; width: 47%;">Butir Pernyataan / Item Kuesioner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- X1 -->
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td rowspan="5" style="text-align: left; padding-left: 16px; font-weight: 700; vertical-align: top; background: #fafafa;">
                                    Kapasitas Manajerial (X1)
                                </td>
                                <td rowspan="5" style="text-align: justify; vertical-align: top; line-height: 1.5; font-size: 0.85rem; padding-right: 12px; background: #fafafa;">
                                    Kemampuan teknis, pemahaman regulasi, serta keahlian pengelola BUMDesa dalam menyelenggarakan administrasi dan analisis unit usaha secara mandiri.
                                </td>
                                <td style="text-align: center; font-weight: 600;">X1.1</td>
                                <td style="font-size: 0.85rem;">Saya memahami dasar-dasar pencatatan transaksi keuangan BUMDesa.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X1.2</td>
                                <td style="font-size: 0.85rem;">Saya mampu menyusun laporan keuangan secara mandiri.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X1.3</td>
                                <td style="font-size: 0.85rem;">Saya memahami regulasi dalam pengelolaan BUMDesa.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X1.4</td>
                                <td style="font-size: 0.85rem;">Saya mampu melakukan analisis kelayakan usaha.</td>
                            </tr>
                            <tr style="border-bottom: 2px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X1.5</td>
                                <td style="font-size: 0.85rem;">Saya rutin melakukan evaluasi kinerja unit usaha.</td>
                            </tr>

                            <!-- X2 -->
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td rowspan="5" style="text-align: left; padding-left: 16px; font-weight: 700; vertical-align: top; background: #fafafa;">
                                    Tekanan Budaya Relasional (X2)
                                </td>
                                <td rowspan="5" style="text-align: justify; vertical-align: top; line-height: 1.5; font-size: 0.85rem; padding-right: 12px; background: #fafafa;">
                                    Hambatan sosial kemasyarakatan di tingkat desa berupa konflik kepentingan, kedekatan personal kekerabatan perangkat desa, dominasi pengambilan keputusan, dan beban moral hubungan patronase.
                                </td>
                                <td style="text-align: center; font-weight: 600;">X2.1</td>
                                <td style="font-size: 0.85rem;">Sering terjadi konflik kepentingan antara pengelola dan perangkat desa.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X2.2</td>
                                <td style="font-size: 0.85rem;">Adanya tekanan dari keluarga/kerabat perangkat desa dalam rekrutmen pengelola.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X2.3</td>
                                <td style="font-size: 0.85rem;">Sulit untuk bersikap profesional karena adanya faktor kedekatan personal.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X2.4</td>
                                <td style="font-size: 0.85rem;">Pengambilan keputusan seringkali didominasi oleh salah satu pihak yang berpengaruh.</td>
                            </tr>
                            <tr style="border-bottom: 2px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X2.5</td>
                                <td style="font-size: 0.85rem;">Adanya beban moral untuk memprioritaskan kepentingan kelompok tertentu di atas kepentingan BUMDesa.</td>
                            </tr>

                            <!-- X3 -->
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td rowspan="5" style="text-align: left; padding-left: 16px; font-weight: 700; vertical-align: top; background: #fafafa;">
                                    Kelemahan Tata Kelola (X3)
                                </td>
                                <td rowspan="5" style="text-align: justify; vertical-align: top; line-height: 1.5; font-size: 0.85rem; padding-right: 12px; background: #fafafa;">
                                    Kelemahan sistemik administrasi internal keuangan berupa ketidaktertiban pencatatan, sistem pendokumentasian bukti transaksi yang tidak lengkap, keterlambatan pelaporan, dan lemahnya pengawasan independen.
                                </td>
                                <td style="text-align: center; font-weight: 600;">X3.1</td>
                                <td style="font-size: 0.85rem;">Pencatatan transaksi belum dilakukan secara tertib dan kronologis.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X3.2</td>
                                <td style="font-size: 0.85rem;">Sistem pendokumentasian bukti transaksi seringkali tidak lengkap.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X3.3</td>
                                <td style="font-size: 0.85rem;">Laporan pertanggungjawaban seringkali terlambat disajikan.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X3.4</td>
                                <td style="font-size: 0.85rem;">Lemahnya fungsi pengawasan internal dalam BUMDesa.</td>
                            </tr>
                            <tr style="border-bottom: 2px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">X3.5</td>
                                <td style="font-size: 0.85rem;">Tidak adanya pemisahan tugas yang jelas antara fungsi pelaksana dan fungsi keuangan.</td>
                            </tr>

                            <!-- Y -->
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td rowspan="5" style="text-align: left; padding-left: 16px; font-weight: 700; vertical-align: top; background: #fafafa;">
                                    Kualitas Pelaporan (Y)
                                </td>
                                <td rowspan="5" style="text-align: justify; vertical-align: top; line-height: 1.5; font-size: 0.85rem; padding-right: 12px; background: #fafafa;">
                                    Tingkat akuntabilitas keluaran pelaporan keuangan yang mencerminkan kondisi riil di lapangan, mudah dimengerti pada Musyawarah Desa (Musdes), dan dapat diverifikasi buktinya.
                                </td>
                                <td style="text-align: center; font-weight: 600;">Y.1</td>
                                <td style="font-size: 0.85rem;">Laporan disajikan secara jujur dan sesuai dengan kondisi lapangan.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">Y.2</td>
                                <td style="font-size: 0.85rem;">Informasi dalam laporan mudah dipahami oleh masyarakat luas (Musdes).</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">Y.3</td>
                                <td style="font-size: 0.85rem;">Dana yang dikelola dapat dipertanggungjawabkan sesuai aturan yang berlaku.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">Y.4</td>
                                <td style="font-size: 0.85rem;">Data yang disajikan konsisten dari satu periode ke periode berikutnya.</td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="text-align: center; font-weight: 600;">Y.5</td>
                                <td style="font-size: 0.85rem;">Laporan dapat diverifikasi kebenarannya melalui bukti-bukti yang ada.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="header" style="margin-top: 60px;">
                <div>
                    <h2>Uji Kualitas Instrumen</h2>
                    <p style="color: var(--text-light);">Hasil pengujian Validitas (Pearson) dan Reliabilitas (Cronbach's Alpha).</p>
                </div>
            </div>
                <div>
                    <h2>Uji Kualitas Instrumen</h2>
                    <p style="color: var(--text-light);">Hasil pengujian Validitas (Pearson) dan Reliabilitas (Cronbach's Alpha).</p>
                </div>
            </div>

            @php
                $vars = [
                    'x1' => ['label' => 'Kapasitas Manajerial (X1)'],
                    'x2' => ['label' => 'Tekanan Budaya (X2)'],
                    'x3' => ['label' => 'Kelemahan Tata Kelola (X3)'],
                    'y'  => ['label' => 'Kualitas Pelaporan (Y)']
                ];

                $validitySummary = [];
                foreach(['x1', 'x2', 'x3', 'y'] as $key) {
                    $totalItems = count($quality['validity'][$key]);
                    $validItems = 0;
                    foreach($quality['validity'][$key] as $r) {
                        if ($r >= 0.3) {
                            $validItems++;
                        }
                    }
                    $validitySummary[$key] = [
                        'total' => $totalItems,
                        'valid' => $validItems,
                        'invalid' => $totalItems - $validItems
                    ];
                }
            @endphp

            <div class="chart-card" style="margin-bottom: 32px;">
                <h3 style="margin-bottom: 20px;">Tabel Ringkasan Uji Kualitas Instrumen</h3>
                <div style="overflow-x: auto;">
                    <table class="table-stats" style="margin-top: 0;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="text-align: left; padding-left: 16px;">Variabel Penelitian</th>
                                <th>Jumlah Butir</th>
                                <th>Cronbach's Alpha</th>
                                <th>Batas Reliabilitas</th>
                                <th>Status Reliabilitas</th>
                                <th>Butir Valid</th>
                                <th>Butir Tidak Valid</th>
                                <th>Kesimpulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($vars as $key => $v)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td style="text-align: left; padding-left: 16px; font-weight: 600;">{{ $v['label'] }}</td>
                                    <td>{{ $validitySummary[$key]['total'] }}</td>
                                    <td style="font-weight: 600; color: var(--primary);">{{ $quality['reliability'][$key] }}</td>
                                    <td>&ge; 0.60</td>
                                    <td>
                                        <span class="{{ $quality['reliability'][$key] >= 0.6 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $quality['reliability'][$key] >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}
                                        </span>
                                    </td>
                                    <td style="font-weight: 600; color: var(--secondary);">{{ $validitySummary[$key]['valid'] }}</td>
                                    <td style="font-weight: 600; color: {{ $validitySummary[$key]['invalid'] > 0 ? 'var(--danger)' : 'var(--text-light)' }}">{{ $validitySummary[$key]['invalid'] }}</td>
                                    <td>
                                        @if($validitySummary[$key]['invalid'] === 0 && $quality['reliability'][$key] >= 0.6)
                                            <span class="badge-success">Sangat Layak</span>
                                        @elseif($validitySummary[$key]['valid'] > 0 && $quality['reliability'][$key] >= 0.6)
                                            <span class="badge-success">Layak dengan Revisi</span>
                                        @else
                                            <span class="badge-danger">Tidak Layak</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid-charts">
                @foreach($quality['validity'] as $key => $items)
                    <div class="chart-card">
                        <h3>{{ $vars[$key]['label'] ?? strtoupper($key) }}</h3>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                            <span style="font-size: 0.85rem; color: var(--text-light);">Reliabilitas (Alpha):</span>
                            <span class="{{ $quality['reliability'][$key] >= 0.6 ? 'badge-success' : 'badge-danger' }}">
                                {{ $quality['reliability'][$key] }} 
                                ({{ $quality['reliability'][$key] >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }})
                            </span>
                        </div>
                        <table class="table-stats">
                            <thead>
                                <tr>
                                    <th>Butir</th>
                                    <th>Korelasi (r)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $label => $r)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td style="font-weight: 600;">{{ $r }}</td>
                                        <td>
                                            @if($totalRespondents > 2)
                                                <span class="{{ $r >= 0.3 ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $r >= 0.3 ? 'Valid' : 'Tidak Valid' }}
                                                </span>
                                            @else
                                                <span style="color: var(--text-light); font-size: 0.7rem;">Data Minim</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="narration-box" style="margin-top: 16px; font-size: 0.85rem; padding: 12px 16px; background: {{ $quality['reliability'][$key] >= 0.6 ? '#ecfdf5' : '#fef2f2' }}; border-left-color: {{ $quality['reliability'][$key] >= 0.6 ? 'var(--secondary)' : 'var(--danger)' }};">
                            <strong>Interpretasi Uji {{ $vars[$key]['label'] ?? strtoupper($key) }}:</strong> Nilai Cronbach's Alpha sebesar {{ $quality['reliability'][$key] }} menunjukkan instrumen ini <strong>{{ $quality['reliability'][$key] >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}</strong>. Pada uji validitas Pearson, setiap butir pernyataan dengan nilai korelasi (r) &ge; 0.3 dinyatakan <strong>Valid</strong> dan layak digunakan.
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="header" style="margin-top: 60px;">
                <div>
                    <h2>Analisis Regresi Linear Berganda</h2>
                    <p style="color: var(--text-light);">Pengaruh Kapasitas (X1), Budaya (X2), dan Tata Kelola (X3) terhadap Kualitas Pelaporan (Y).</p>
                </div>
            </div>

            @if($regression)
                <div class="regression-box">
                    <div style="font-weight: 600; color: rgba(255,255,255,0.8); text-align: center; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em;">Persamaan Regresi OLS</div>
                    <div class="formula-display">
                        Y = {{ number_format($regression['a'], 4) }} 
                        {{ $regression['b1'] >= 0 ? '+' : '' }} {{ number_format($regression['b1'], 4) }}X₁ 
                        {{ $regression['b2'] >= 0 ? '+' : '' }} {{ number_format($regression['b2'], 4) }}X₂ 
                        {{ $regression['b3'] >= 0 ? '+' : '' }} {{ number_format($regression['b3'], 4) }}X₃ 
                        + e
                    </div>
                    
                    <div class="coeff-grid">
                        <div class="coeff-item">
                            <div class="coeff-label">Konstanta (a)</div>
                            <div class="coeff-value">{{ number_format($regression['a'], 4) }}</div>
                            @if(isset($regression['t_a']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ number_format($regression['se_a'], 4) }} <br>
                                t-hitung: {{ number_format($regression['t_a'], 4) }} <br>
                                Sig.: {{ number_format($regression['p_a'], 5) }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Kapasitas X₁ (b₁)</div>
                            <div class="coeff-value">{{ number_format($regression['b1'], 4) }}</div>
                            @if(isset($regression['t_b1']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ number_format($regression['se_b1'], 4) }} <br>
                                t-hitung: {{ number_format($regression['t_b1'], 4) }} <br>
                                Sig.: {{ number_format($regression['p_b1'], 5) }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Budaya X₂ (b₂)</div>
                            <div class="coeff-value">{{ number_format($regression['b2'], 4) }}</div>
                            @if(isset($regression['t_b2']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ number_format($regression['se_b2'], 4) }} <br>
                                t-hitung: {{ number_format($regression['t_b2'], 4) }} <br>
                                Sig.: {{ number_format($regression['p_b2'], 5) }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Tata Kelola X₃ (b₃)</div>
                            <div class="coeff-value">{{ number_format($regression['b3'], 4) }}</div>
                            @if(isset($regression['t_b3']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ number_format($regression['se_b3'], 4) }} <br>
                                t-hitung: {{ number_format($regression['t_b3'], 4) }} <br>
                                Sig.: {{ number_format($regression['p_b3'], 5) }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 32px; display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap;">
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px; text-align: center;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">R-Squared (R²)</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ number_format($regression['r2'], 4) }}</span>
                        </div>
                        @if(isset($regression['f_value']))
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px; text-align: center;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">F-hitung</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ number_format($regression['f_value'], 4) }}</span>
                        </div>
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px; text-align: center;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">Sig. F (Simultan)</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ number_format($regression['p_f'], 5) }}</span>
                        </div>
                        @endif
                        <div style="max-width: 300px; font-size: 0.85rem; color: rgba(255,255,255,0.8); text-align: justify; line-height: 1.4;">
                            Nilai $R^2$ sebesar {{ number_format($regression['r2'], 4) }} menunjukkan bahwa variabel independen mampu menjelaskan {{ number_format($regression['r2'] * 100, 2) }}% variasi Kualitas Pelaporan. Model simultan terbukti sangat signifikan (p-value < 0.05).
                        </div>
                    </div>
                </div>

                <div class="narration-box" style="margin-top: 24px; text-align: justify;">
                    <strong>Interpretasi Regresi Linear Berganda:</strong><br>
                    Persamaan regresi menunjukkan nilai konstanta (a) sebesar {{ number_format($regression['a'], 4) }}.<br>
                    Koefisien <strong>Kapasitas (X1)</strong> sebesar {{ number_format($regression['b1'], 4) }} menunjukkan bahwa peningkatan 1 satuan kapasitas akan meningkatkan kualitas pelaporan sebesar {{ abs($regression['b1']) }}.<br>
                    Koefisien <strong>Budaya (X2)</strong> sebesar {{ number_format($regression['b2'], 4) }} berarti peningkatan 1 satuan tekanan budaya akan menurunkan kualitas pelaporan sebesar {{ abs($regression['b2']) }}.<br>
                    Koefisien <strong>Tata Kelola (X3)</strong> sebesar {{ number_format($regression['b3'], 4) }} berarti peningkatan 1 satuan kelemahan tata kelola akan menurunkan kualitas pelaporan sebesar {{ abs($regression['b3']) }}.<br>
                    Nilai R-Squared ({{ number_format($regression['r2'], 4) }}) mengindikasikan bahwa ketiga variabel independen secara simultan memengaruhi Kualitas Pelaporan sebesar {{ number_format($regression['r2'] * 100, 2) }}%.
                </div>

                <!-- Tabel Hasil Regresi Lengkap (Saran Perbaikan 1) -->
                <div class="chart-card" style="margin-top: 32px; margin-bottom: 32px;">
                    <h3 style="margin-bottom: 20px; border-left: 4px solid var(--primary); padding-left: 12px;">Tabel 3: Hasil Regresi Linear Berganda (Parameter Parsial)</h3>
                    <p style="color: var(--text-light); font-size: 0.85rem; margin-top: -12px; margin-bottom: 20px;">Melampirkan nilai koefisien Unstandardized B, Standard Error (SE), Standardized Beta, t-hitung, dan tingkat signifikansi p-value untuk setiap parameter.</p>
                    <div style="overflow-x: auto;">
                        <table class="table-stats" style="margin-top: 0; text-align: center;">
                            <thead>
                                <tr style="background: #f8fafc;">
                                    <th style="text-align: left; padding-left: 16px; width: 35%;">Variabel Independen</th>
                                    <th>Koefisien B (Unstandardized)</th>
                                    <th>Standard Error (SE)</th>
                                    <th>Standardized Beta (Beta)</th>
                                    <th>Nilai t-hitung</th>
                                    <th>p-value (Sig.)</th>
                                    <th>Kesimpulan Statistik</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="text-align: left; padding-left: 16px; font-weight: 600;">(Konstanta)</td>
                                    <td>{{ number_format($regression['a'], 4) }}</td>
                                    <td>{{ number_format($regression['se_a'], 4) }}</td>
                                    <td>-</td>
                                    <td>{{ number_format($regression['t_a'], 4) }}</td>
                                    <td style="font-weight: 700; color: var(--primary);">{{ number_format($regression['p_a'], 5) }}</td>
                                    <td><span class="badge-success">Signifikan (p &lt; 0.05)</span></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="text-align: left; padding-left: 16px; font-weight: 600;">Kapasitas Manajerial (X1)</td>
                                    <td>{{ number_format($regression['b1'], 4) }}</td>
                                    <td>{{ number_format($regression['se_b1'], 4) }}</td>
                                    <td>{{ number_format($regression['beta1'], 4) }}</td>
                                    <td>{{ number_format($regression['t_b1'], 4) }}</td>
                                    <td style="font-weight: 700; color: var(--primary);">{{ number_format($regression['p_b1'], 5) }}</td>
                                    <td>
                                        @if($regression['p_b1'] < 0.05)
                                            <span class="badge-success">Signifikan (H2 Didukung)</span>
                                        @else
                                            <span class="badge-danger">Tidak Signifikan</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="text-align: left; padding-left: 16px; font-weight: 600;">Tekanan Budaya Relasional (X2)</td>
                                    <td>{{ number_format($regression['b2'], 4) }}</td>
                                    <td>{{ number_format($regression['se_b2'], 4) }}</td>
                                    <td>{{ number_format($regression['beta2'], 4) }}</td>
                                    <td>{{ number_format($regression['t_b2'], 4) }}</td>
                                    <td style="font-weight: 700; color: var(--primary);">{{ number_format($regression['p_b2'], 5) }}</td>
                                    <td>
                                        @if($regression['p_b2'] < 0.05)
                                            <span class="badge-success">Signifikan (H3 Didukung)</span>
                                        @else
                                            <span class="badge-danger" style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.75rem;">Tidak Signifikan (H3 Tidak Didukung)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="text-align: left; padding-left: 16px; font-weight: 600;">Kelemahan Tata Kelola (X3)</td>
                                    <td>{{ number_format($regression['b3'], 4) }}</td>
                                    <td>{{ number_format($regression['se_b3'], 4) }}</td>
                                    <td>{{ number_format($regression['beta3'], 4) }}</td>
                                    <td>{{ number_format($regression['t_b3'], 4) }}</td>
                                    <td style="font-weight: 700; color: var(--primary);">{{ number_format($regression['p_b3'], 5) }}</td>
                                    <td>
                                        @if($regression['p_b3'] < 0.05)
                                            <span class="badge-success">Signifikan (H4 Didukung)</span>
                                        @else
                                            <span class="badge-danger">Tidak Signifikan</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Rincian Perhitungan Matematis OLS Accordion (Tampilkan Perhitungan) -->
                <div class="chart-card" style="margin-bottom: 32px; padding: 24px;">
                    <details style="cursor: pointer;">
                        <summary style="font-weight: bold; font-size: 1.1rem; color: var(--primary); outline: none;">
                            📂 Klik di Sini untuk Menampilkan Rincian Langkah Perhitungan Matematis OLS (Step-by-Step)
                        </summary>
                        <div style="margin-top: 20px; font-size: 0.85rem; line-height: 1.6; border-top: 1px solid var(--border); padding-top: 16px; color: var(--text);">
                            <p style="margin-bottom: 16px;">Penyelesaian parameter estimasi regresi berganda dihitung secara internal menggunakan operasi matriks OLS:</p>
                            <div style="text-align: center; margin: 15px 0; font-size: 1.15rem; font-weight: bold; color: var(--primary);">
                                $\mathbf{b} = (\mathbf{X}^T \mathbf{X})^{-1} \mathbf{X}^T \mathbf{y}$
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 20px;">
                                <div>
                                    <strong style="color: var(--primary);">1. Matriks $\mathbf{X}^T \mathbf{X}$ (Ukuran 4x4)</strong>
                                    <p style="font-size: 0.75rem; color: var(--text-light); margin-top: 4px;">Merepresentasikan jumlahan kuadrat dan perkalian silang variabel independen:</p>
                                    <table class="table-stats" style="width: auto; margin-top: 8px; font-family: monospace; font-size: 0.8rem; text-align: right;">
                                        @foreach($regression['xtx'] as $row)
                                        <tr>
                                            @foreach($row as $val)
                                            <td style="padding: 6px 10px; border: 1px solid var(--border); background: #f8fafc;">{{ number_format($val, 3) }}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                
                                <div>
                                    <strong style="color: var(--primary);">2. Matriks Invers $(\mathbf{X}^T \mathbf{X})^{-1}$ (Ukuran 4x4)</strong>
                                    <p style="font-size: 0.75rem; color: var(--text-light); margin-top: 4px;">Digunakan untuk memecahkan sistem linear koefisien:</p>
                                    <table class="table-stats" style="width: auto; margin-top: 8px; font-family: monospace; font-size: 0.8rem; text-align: right;">
                                        @if($regression['xtx_inv'])
                                            @foreach($regression['xtx_inv'] as $row)
                                            <tr>
                                                @foreach($row as $val)
                                                <td style="padding: 6px 10px; border: 1px solid var(--border); background: #f8fafc;">{{ number_format($val, 4) }}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr><td style="color: var(--danger)">Matriks Singular (Inversi Gagal)</td></tr>
                                        @endif
                                    </table>
                                </div>
                                
                                <div>
                                    <strong style="color: var(--primary);">3. Vektor $\mathbf{X}^T \mathbf{y}$ (Ukuran 4x1)</strong>
                                    <p style="font-size: 0.75rem; color: var(--text-light); margin-top: 4px;">Perkalian silang variabel independen dengan dependen:</p>
                                    <table class="table-stats" style="width: auto; margin-top: 8px; font-family: monospace; font-size: 0.8rem; text-align: right;">
                                        @foreach($regression['xty'] as $val)
                                        <tr>
                                            <td style="padding: 6px 10px; border: 1px solid var(--border); background: #f8fafc;">{{ number_format($val, 3) }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            
                            <div style="margin-top: 24px; border-top: 1px dashed var(--border); padding-top: 16px;">
                                <strong>4. Penguraian Variabilitas (Analysis of Variance / ANOVA Regresi):</strong>
                                <table class="table-stats" style="margin-top: 8px; width: 100%; text-align: center;">
                                    <thead>
                                        <tr style="background: #f8fafc;">
                                            <th style="text-align: left; padding-left: 12px;">Sumber Variasi</th>
                                            <th>Sum of Squares (SS)</th>
                                            <th>Degrees of Freedom (df)</th>
                                            <th>Mean Square (MS)</th>
                                            <th>F-hitung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: left; padding-left: 12px; font-weight: 600;">Regression (Model)</td>
                                            <td>{{ number_format($regression['ss_reg'], 4) }}</td>
                                            <td>{{ $regression['df_reg'] }}</td>
                                            <td>{{ number_format($regression['ms_reg'], 4) }}</td>
                                            <td rowspan="2" style="vertical-align: middle; font-weight: bold; font-size: 1.2rem; color: var(--primary);">
                                                {{ number_format($regression['f_value'], 4) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left; padding-left: 12px; font-weight: 600;">Residual (Error)</td>
                                            <td>{{ number_format($regression['ss_res'], 4) }}</td>
                                            <td>{{ $regression['df_res'] }}</td>
                                            <td>{{ number_format($regression['ms_res'], 4) }}</td>
                                        </tr>
                                        <tr style="background: #f1f5f9; font-weight: bold;">
                                            <td style="text-align: left; padding-left: 12px;">Total (SSTot)</td>
                                            <td>{{ number_format($regression['ss_tot'], 4) }}</td>
                                            <td>{{ $regression['df_reg'] + $regression['df_res'] }}</td>
                                            <td colspan="2">-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div style="margin-top: 16px; font-size: 0.8rem; color: var(--text-light); background: #fffbeb; padding: 12px; border-left: 3px solid var(--accent); border-radius: 4px; line-height: 1.5;">
                                <strong>Catatan Rumus Perhitungan:</strong><br>
                                • Standard Error Koefisien $SE(b_i) = \sqrt{MS_{Res} \times (\mathbf{X}^T \mathbf{X})^{-1}_{ii}}$ <br>
                                • Nilai t-hitung Parsial $t_i = \frac{b_i}{SE(b_i)}$ <br>
                                • Nilai F-hitung Simultan $F = \frac{MS_{Reg}}{MS_{Res}}$ <br>
                                • p-value diperoleh secara numerik menggunakan pecahan berlanjut fungsi logaritma Gamma & CDF Incomplete Beta untuk hasil presisi tinggi.
                            </div>
                        </div>
                    </details>
                </div>

                @if(isset($regression['asumsi']))
                <div class="header" style="margin-top: 60px;">
                    <div>
                        <h2>Uji Asumsi Klasik</h2>
                        <p style="color: var(--text-light);">Prasyarat regresi OLS (Normalitas, Multikolinearitas, Heteroskedastisitas).</p>
                    </div>
                </div>

                <div class="grid-asumsi">
                    <!-- Table Uji Normalitas -->
                    <div class="chart-card" style="padding: 24px;">
                        <h3 style="margin-bottom: 16px; font-size: 1rem;">Uji Normalitas</h3>
                        <table class="table-stats">
                            <thead>
                                <tr>
                                    <th>Metode</th>
                                    <th>Statistik</th>
                                    <th>Kriteria</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jarque-Bera</td>
                                    <td style="font-weight: 600;">{{ $regression['asumsi']['normalitas']['jb'] }}</td>
                                    <td>&lt; 5.99</td>
                                    <td>
                                        <span class="{{ $regression['asumsi']['normalitas']['status'] === 'Normal' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $regression['asumsi']['normalitas']['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 12px; line-height: 1.4;">
                            * Nilai JB &lt; 5.99 mengindikasikan bahwa residual terdistribusi secara normal.
                        </div>
                    </div>

                    <!-- Table Uji Multikolinearitas -->
                    <div class="chart-card" style="padding: 24px;">
                        <h3 style="margin-bottom: 16px; font-size: 1rem;">Uji Multikolinearitas</h3>
                        <table class="table-stats">
                            <thead>
                                <tr>
                                    <th>Variabel</th>
                                    <th>VIF</th>
                                    <th>Kriteria</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>X1</td>
                                    <td style="font-weight: 600;">{{ $regression['asumsi']['multikolinearitas']['vif_x1'] }}</td>
                                    <td>&lt; 10</td>
                                    <td rowspan="3" style="vertical-align: middle;">
                                        <span class="{{ $regression['asumsi']['multikolinearitas']['status'] === 'Bebas Multikolinearitas' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $regression['asumsi']['multikolinearitas']['status'] === 'Bebas Multikolinearitas' ? 'Bebas' : 'Gejala' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>X2</td>
                                    <td style="font-weight: 600;">{{ $regression['asumsi']['multikolinearitas']['vif_x2'] }}</td>
                                    <td>&lt; 10</td>
                                </tr>
                                <tr>
                                    <td>X3</td>
                                    <td style="font-weight: 600;">{{ $regression['asumsi']['multikolinearitas']['vif_x3'] }}</td>
                                    <td>&lt; 10</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 12px; line-height: 1.4;">
                            * Nilai VIF &lt; 10 menunjukkan tidak adanya gejala multikolinearitas antar variabel.
                        </div>
                    </div>

                    <!-- Table Uji Heteroskedastisitas -->
                    <div class="chart-card" style="padding: 24px;">
                        <h3 style="margin-bottom: 16px; font-size: 1rem;">Uji Heteroskedastisitas</h3>
                        <table class="table-stats">
                            <thead>
                                <tr>
                                    <th>Variabel</th>
                                    <th>|t-hit|</th>
                                    <th>Kriteria</th>
                                    <th>Kesimpulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>X1</td>
                                    <td style="font-weight: 600;">{{ abs($regression['asumsi']['heteroskedastisitas']['t_x1']) }}</td>
                                    <td>&lt; 2.0</td>
                                    <td rowspan="3" style="vertical-align: middle;">
                                        <span class="{{ $regression['asumsi']['heteroskedastisitas']['status'] === 'Bebas Heteroskedastisitas' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $regression['asumsi']['heteroskedastisitas']['status'] === 'Bebas Heteroskedastisitas' ? 'Bebas' : 'Gejala' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>X2</td>
                                    <td style="font-weight: 600;">{{ abs($regression['asumsi']['heteroskedastisitas']['t_x2']) }}</td>
                                    <td>&lt; 2.0</td>
                                </tr>
                                <tr>
                                    <td>X3</td>
                                    <td style="font-weight: 600;">{{ abs($regression['asumsi']['heteroskedastisitas']['t_x3']) }}</td>
                                    <td>&lt; 2.0</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="font-size: 0.75rem; color: var(--text-light); margin-top: 12px; line-height: 1.4;">
                            * Uji Glejser. Nilai mutlak t-hitung &lt; 2.0 (t-tabel) menunjukkan bebas heteroskedastisitas.
                        </div>
                    </div>
                </div>
                @endif

                <div class="header" style="margin-top: 60px;">
                    <div>
                        <h2>Uji Hipotesis Penelitian</h2>
                        <p style="color: var(--text-light);">Evaluasi rumusan hipotesis (H1-H4) berdasarkan arah dan signifikansi hasil statistik.</p>
                    </div>
                </div>

                <div class="chart-card" style="padding: 0; overflow: hidden;">
                    <table class="table-stats" style="margin-top: 0; text-align: center;">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th style="width: 5%;">Kode</th>
                                <th style="width: 45%; text-align: left; padding-left: 20px;">Rumusan Hipotesis</th>
                                <th style="width: 10%;">Arah</th>
                                <th style="width: 20%;">Hasil Regresi Parsial / Simultan</th>
                                <th style="width: 20%;">Kesimpulan Hipotesis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="font-weight: 700;">H1</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5; font-size: 0.85rem;">Kapasitas manajerial pengelola, tekanan budaya relasional lokal, dan kelemahan tata kelola keuangan secara simultan berpengaruh signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Simultan</td>
                                <td>F = {{ number_format($regression['f_value'], 4) }}<br><small style="color: var(--text-light);">Sig. F = {{ number_format($regression['p_f'], 5) }}</small></td>
                                <td>
                                    @if($regression['p_f'] < 0.05)
                                        <span class="badge-success">Terdukung (Signifikan)</span>
                                    @else
                                        <span class="badge-danger">Tidak Terdukung</span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="font-weight: 700;">H2</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5; font-size: 0.85rem;">Kapasitas manajerial pengelola berpengaruh positif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Positif</td>
                                <td>b₁ = {{ number_format($regression['b1'], 4) }}<br><small style="color: var(--text-light);">Sig. t = {{ number_format($regression['p_b1'], 5) }}</small></td>
                                <td>
                                    @if($regression['b1'] > 0 && $regression['p_b1'] < 0.05)
                                        <span class="badge-success">Terdukung (Signifikan)</span>
                                    @else
                                        <span class="badge-danger">Tidak Terdukung</span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="font-weight: 700;">H3</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5; font-size: 0.85rem;">Tekanan budaya relasional lokal berpengaruh negatif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Negatif</td>
                                <td>b₂ = {{ number_format($regression['b2'], 4) }}<br><small style="color: var(--text-light);">Sig. t = {{ number_format($regression['p_b2'], 5) }}</small></td>
                                <td>
                                    @if($regression['b2'] < 0 && $regression['p_b2'] < 0.05)
                                        <span class="badge-success">Terdukung (Signifikan)</span>
                                    @else
                                        <span class="badge-danger" style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.75rem;">Tidak Terdukung (Tidak Signifikan)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="font-weight: 700;">H4</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5; font-size: 0.85rem;">Kelemahan tata kelola keuangan berpengaruh negatif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Negatif</td>
                                <td>b₃ = {{ number_format($regression['b3'], 4) }}<br><small style="color: var(--text-light);">Sig. t = {{ number_format($regression['p_b3'], 5) }}</small></td>
                                <td>
                                    @if($regression['b3'] < 0 && $regression['p_b3'] < 0.05)
                                        <span class="badge-success">Terdukung (Signifikan)</span>
                                    @else
                                        <span class="badge-danger">Tidak Terdukung</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="narration-box" style="margin-top: 16px; background: #f0fdf4; border-left: 4px solid var(--secondary); text-align: justify; line-height: 1.5;">
                    <strong>Interpretasi Uji Hipotesis (Berdasarkan Nilai-p &amp; Signifikansi Statistik):</strong>
                    <ul style="margin: 8px 0 0 16px; padding: 0;">
                        <li style="margin-bottom: 6px;">
                            <strong>H1 (Simultan):</strong> Model regresi terbukti sangat signifikan ($F = {{ number_format($regression['f_value'], 3) }}$, $p = {{ number_format($regression['p_f'], 5) }} {{ $regression['p_f'] < 0.05 ? '< 0.05' : '>= 0.05' }}$). Artinya secara simultan Kapasitas Manajerial, Tekanan Budaya Relasional, dan Kelemahan Tata Kelola berpengaruh signifikan terhadap Kualitas Implementasi Pelaporan Keuangan BUMDesa. 
                            <strong>Hipotesis H1 {{ $regression['p_f'] < 0.05 ? 'Didukung' : 'Tidak Didukung' }} secara Statistik.</strong>
                        </li>
                        <li style="margin-bottom: 6px;">
                            <strong>H2 (Parsial X1):</strong> Kapasitas Manajerial berpengaruh positif dan {{ $regression['p_b1'] < 0.05 ? 'signifikan' : 'tidak signifikan' }} ($b_1 = {{ number_format($regression['b1'], 4) }}$, $t = {{ number_format($regression['t_b1'], 3) }}$, $p = {{ number_format($regression['p_b1'], 5) }} {{ $regression['p_b1'] < 0.05 ? '< 0.05' : '>= 0.05' }}$). 
                            @if($regression['b1'] > 0 && $regression['p_b1'] < 0.05)
                                Hal ini menunjukkan peningkatan kapasitas manajerial pengelola secara nyata akan meningkatkan kualitas pelaporan keuangan. <strong>Hipotesis H2 Didukung.</strong>
                            @else
                                Hal ini menunjukkan bahwa peningkatan kapasitas manajerial tidak terbukti secara nyata meningkatkan kualitas pelaporan keuangan pada tingkat signifikansi yang dipilih. <strong>Hipotesis H2 Tidak Didukung.</strong>
                            @endif
                        </li>
                        <li style="margin-bottom: 6px;">
                            <strong>H3 (Parsial X2):</strong> Tekanan Budaya Relasional memiliki koefisien $b_2 = {{ number_format($regression['b2'], 4) }}$ ($t = {{ number_format($regression['t_b2'], 3) }}$, $p = {{ number_format($regression['p_b2'], 5) }} {{ $regression['p_b2'] < 0.05 ? '< 0.05' : '>= 0.05' }}$). 
                            @if($regression['b2'] < 0 && $regression['p_b2'] < 0.05)
                                Hal ini menunjukkan bahwa tekanan budaya relasional yang tinggi secara signifikan menghambat kualitas pelaporan keuangan. <strong>Hipotesis H3 Didukung.</strong>
                            @else
                                Dengan demikian, klaim bahwa tekanan budaya relasional secara signifikan menghambat pelaporan keuangan tidak terbukti secara statistik pada sampel ini. <strong>Hipotesis H3 Tidak Didukung.</strong>
                            @endif
                        </li>
                        <li style="margin-bottom: 0;">
                            <strong>H4 (Parsial X3):</strong> Kelemahan Tata Kelola Keuangan memiliki koefisien $b_3 = {{ number_format($regression['b3'], 4) }}$ ($t = {{ number_format($regression['t_b3'], 3) }}$, $p = {{ number_format($regression['p_b3'], 5) }} {{ $regression['p_b3'] < 0.05 ? '< 0.05' : '>= 0.05' }}$). 
                            @if($regression['b3'] < 0 && $regression['p_b3'] < 0.05)
                                Ini membuktikan secara kuat bahwa kelemahan tata pamong internal (seperti ketiadaan bukti transaksi dan keterlambatan LPJ) secara langsung menurunkan kualitas pelaporan keuangan. <strong>Hipotesis H4 Didukung.</strong>
                            @else
                                Hal ini menunjukkan bahwa kelemahan tata pamong internal tidak terbukti secara signifikan menurunkan kualitas pelaporan keuangan pada sampel ini. <strong>Hipotesis H4 Tidak Didukung.</strong>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="chart-card" style="margin-top: 24px; padding: 24px; border-left: 4px solid var(--accent); background: #fffbeb;">
                    <h3 style="margin-top: 0; font-size: 1.1rem; color: #b45309; border-left: none; padding-left: 0;">💡 Diskusi Temuan Kualitatif: Analisis Pengaruh Budaya Relasional (X2) &amp; Tata Kelola (X3)</h3>
                    <p style="font-size: 0.9rem; line-height: 1.6; color: #78350f; text-align: justify; margin-bottom: 12px;">
                        Berdasarkan hasil regresi saat ini, pengaruh <strong>Tekanan Budaya Relasional (X2)</strong> adalah $b_2 = {{ number_format($regression['b2'], 4) }}$ dengan signifikansi $p = {{ number_format($regression['p_b2'], 5) }}$ (<strong>{{ $regression['p_b2'] < 0.05 ? 'Signifikan' : 'Tidak Signifikan' }}</strong>), sedangkan pengaruh <strong>Kelemahan Tata Kelola (X3)</strong> adalah $b_3 = {{ number_format($regression['b3'], 4) }}$ dengan signifikansi $p = {{ number_format($regression['p_b3'], 5) }}$ (<strong>{{ $regression['p_b3'] < 0.05 ? 'Signifikan' : 'Tidak Signifikan' }}</strong>). Dinamika hubungan ini dianalisis lebih lanjut menggunakan temuan kualitatif di desa:
                    </p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 16px;">
                        <div style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #fde68a;">
                            <strong style="color: #b45309; font-size: 0.95rem;">Hubungan Relasional Sosial Pedesaan</strong>
                            <p style="font-size: 0.85rem; line-height: 1.5; color: #92400e; margin-top: 6px; text-align: justify;">
                                Relasi kekeluargaan di pedesaan sering berfungsi ganda. Di satu sisi, relasi yang terlalu erat dapat menimbulkan konflik kepentingan. Namun, di sisi lain, budaya gotong royong dan keterbukaan sosial desa memfasilitasi komunikasi informal yang efektif untuk menyelesaikan kendala administrasi pembukuan tanpa terhambat kekakuan prosedur birokrasi.
                            </p>
                        </div>
                        
                        <div style="background: white; padding: 16px; border-radius: 12px; border: 1px solid #fde68a;">
                            <strong style="color: #b45309; font-size: 0.95rem;">Standarisasi &amp; Antisipasi Tata Kelola</strong>
                            <p style="font-size: 0.85rem; line-height: 1.5; color: #92400e; margin-top: 6px; text-align: justify;">
                                Pengelola BUMDesa yang memiliki kapasitas tinggi cenderung mampu mengantisipasi kelemahan tata kelola internal. Standardisasi prosedur pembukuan yang mulai diperkenalkan oleh pendamping desa membantu meminimalkan dampak buruk dari kelemahan fungsi kontrol internal sehingga menjaga kualitas implementasi pelaporan keuangan.
                            </p>
                        </div>
                    </div>
                    
                    <div style="margin-top: 16px; background: rgba(255,255,255,0.7); padding: 16px; border-radius: 12px; border: 1px dashed #fde68a;">
                        <strong style="color: #b45309; font-size: 0.9rem; display: block; margin-bottom: 8px;">💬 Catatan Temuan Kualitatif Responden (Ekstraksi Kuesioner):</strong>
                        <blockquote style="font-style: italic; font-size: 0.85rem; color: #92400e; margin: 0; padding-left: 12px; border-left: 2px solid #b45309; line-height: 1.5;">
                            "Budaya kekeluargaan di desa justru membantu mempercepat pengambilan keputusan gotong royong jika ada masalah administrasi keuangan."<br>
                            "Masyarakat desa aktif mengawasi secara sosial, sehingga tuntutan transparansi relasional justru memaksa pengelola untuk melaporkan dana secara jujur."
                        </blockquote>
                    </div>
                </div>
            @else
                <div class="chart-card" style="text-align: center; padding: 40px;">
                    <p style="color: var(--text-light);">Dibutuhkan minimal 4 responden untuk menjalankan analisis regresi.</p>
                </div>
            @endif
        @endif
    </div>

    @if(!isset($isEmpty))
    <script>
        const ctxRadar = document.getElementById('radarChart');
        new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: ['Kapasitas (X1)', 'Tekanan Budaya (X2)', 'Kelemahan Tata Kelola (X3)', 'Kualitas Pelaporan (Y)'],
                datasets: [{
                    label: 'Skor Rata-rata',
                    data: [{{ $averages['x1'] }}, {{ $averages['x2'] }}, {{ $averages['x3'] }}, {{ $averages['y'] }}],
                    fill: true,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    pointBackgroundColor: 'rgb(79, 70, 229)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgb(79, 70, 229)'
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { display: true },
                        suggestedMin: 0,
                        suggestedMax: 5
                    }
                }
            }
        });

        const ctxKab = document.getElementById('kabupatenChart');
        new Chart(ctxKab, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($byKabupaten->keys()) !!},
                datasets: [{
                    data: {!! json_encode($byKabupaten->values()) !!},
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899']
                }]
            },
            options: { maintainAspectRatio: false, cutout: '60%' }
        });

        const ctxJab = document.getElementById('jabatanChart');
        new Chart(ctxJab, {
            type: 'pie',
            data: {
                labels: {!! json_encode($byJabatan->keys()) !!},
                datasets: [{
                    data: {!! json_encode($byJabatan->values()) !!},
                    backgroundColor: ['#6366f1', '#14b8a6', '#f59e0b', '#ef4444', '#a855f7', '#ec4899']
                }]
            },
            options: { maintainAspectRatio: false }
        });

        const ctxEdu = document.getElementById('pendidikanChart');
        new Chart(ctxEdu, {
            type: 'bar',
            data: {
                labels: {!! json_encode($byPendidikan->keys()) !!},
                datasets: [{
                    label: 'Jumlah Responden',
                    data: {!! json_encode($byPendidikan->values()) !!},
                    backgroundColor: '#4f46e5'
                }]
            },
            options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        const ctxPel = document.getElementById('pelatihanChart');
        new Chart(ctxPel, {
            type: 'pie',
            data: {
                labels: {!! json_encode($byPelatihan->keys()) !!},
                datasets: [{
                    data: {!! json_encode($byPelatihan->values()) !!},
                    backgroundColor: ['#10b981', '#ef4444']
                }]
            },
            options: { maintainAspectRatio: false }
        });

        const ctxApp = document.getElementById('aplikasiChart');
        new Chart(ctxApp, {
            type: 'pie',
            data: {
                labels: {!! json_encode($byAplikasi->keys()) !!},
                datasets: [{
                    data: {!! json_encode($byAplikasi->values()) !!},
                    backgroundColor: ['#3b82f6', '#f59e0b']
                }]
            },
            options: { maintainAspectRatio: false }
        });

        const ctxFreq = document.getElementById('frekuensiChart');
        new Chart(ctxFreq, {
            type: 'bar',
            data: {
                labels: {!! json_encode($byFrekuensi->keys()) !!},
                datasets: [{
                    label: 'Jumlah Responden',
                    data: {!! json_encode($byFrekuensi->values()) !!},
                    backgroundColor: '#8b5cf6'
                }]
            },
            options: { maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        const ctxBar = document.getElementById('barChart');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: [
                    'X1.1', 'X1.2', 'X1.3', 'X1.4', 'X1.5',
                    'X2.1', 'X2.2', 'X2.3', 'X2.4', 'X2.5',
                    'X3.1', 'X3.2', 'X3.3', 'X3.4', 'X3.5',
                    'Y.1', 'Y.2', 'Y.3', 'Y.4', 'Y.5'
                ],
                datasets: [{
                    label: 'Skor Rata-rata per Butir',
                    data: [
                        @foreach($stats['x1'] as $s) {{ $s }}, @endforeach
                        @foreach($stats['x2'] as $s) {{ $s }}, @endforeach
                        @foreach($stats['x3'] as $s) {{ $s }}, @endforeach
                        @foreach($stats['y'] as $s) {{ $s }}, @endforeach
                    ],
                    backgroundColor: [
                        '#4f46e5','#4f46e5','#4f46e5','#4f46e5','#4f46e5',
                        '#ef4444','#ef4444','#ef4444','#ef4444','#ef4444',
                        '#ef4444','#ef4444','#ef4444','#ef4444','#ef4444',
                        '#10b981','#10b981','#10b981','#10b981','#10b981'
                    ]
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, max: 5 } }
            }
        });
    </script>
    @endif
</body>
</html>
