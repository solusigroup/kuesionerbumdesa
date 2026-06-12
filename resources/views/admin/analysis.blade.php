<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Kuesioner - Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            <div class="header" style="margin-top: 60px;">
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
                    <div style="font-weight: 600; color: rgba(255,255,255,0.8); text-align: center; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em;">Persamaan Regresi</div>
                    <div class="formula-display">
                        Y = {{ $regression['a'] }} 
                        {{ $regression['b1'] >= 0 ? '+' : '' }} {{ $regression['b1'] }}X₁ 
                        {{ $regression['b2'] >= 0 ? '+' : '' }} {{ $regression['b2'] }}X₂ 
                        {{ $regression['b3'] >= 0 ? '+' : '' }} {{ $regression['b3'] }}X₃ 
                        + e
                    </div>
                    
                    <div class="coeff-grid">
                        <div class="coeff-item">
                            <div class="coeff-label">Konstanta (a)</div>
                            <div class="coeff-value">{{ $regression['a'] }}</div>
                            @if(isset($regression['t_a']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ $regression['se_a'] }} <br>
                                t-hitung: {{ $regression['t_a'] }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₁ (b₁)</div>
                            <div class="coeff-value">{{ $regression['b1'] }}</div>
                            @if(isset($regression['t_b1']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ $regression['se_b1'] }} <br>
                                t-hitung: {{ $regression['t_b1'] }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₂ (b₂)</div>
                            <div class="coeff-value">{{ $regression['b2'] }}</div>
                            @if(isset($regression['t_b2']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ $regression['se_b2'] }} <br>
                                t-hitung: {{ $regression['t_b2'] }}
                            </div>
                            @endif
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₃ (b₃)</div>
                            <div class="coeff-value">{{ $regression['b3'] }}</div>
                            @if(isset($regression['t_b3']))
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.7); margin-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 8px;">
                                SE: {{ $regression['se_b3'] }} <br>
                                t-hitung: {{ $regression['t_b3'] }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 32px; display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap;">
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px; text-align: center;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">R-Squared (R²)</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ $regression['r2'] }}</span>
                        </div>
                        @if(isset($regression['f_value']))
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px; text-align: center;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">F-hitung</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ $regression['f_value'] }}</span>
                        </div>
                        @endif
                        <div style="max-width: 400px; font-size: 0.85rem; color: rgba(255,255,255,0.8);">
                            Nilai $R^2$ sebesar {{ $regression['r2'] }} menunjukkan bahwa variabel independen mampu menjelaskan {{ $regression['r2'] * 100 }}% variasi dari variabel dependen. @if(isset($regression['f_value'])) Nilai F-hitung menguji signifikansi pengaruh secara simultan. @endif
                        </div>
                    </div>
                </div>

                <div class="narration-box" style="margin-top: 24px;">
                    <strong>Interpretasi Regresi Linear Berganda:</strong><br>
                    Persamaan regresi menunjukkan nilai konstanta (a) sebesar {{ $regression['a'] }}.<br>
                    Koefisien <strong>Kapasitas (X1)</strong> sebesar {{ $regression['b1'] }} menunjukkan bahwa peningkatan 1 satuan kapasitas akan {{ $regression['b1'] >= 0 ? 'meningkatkan' : 'menurunkan' }} kualitas pelaporan sebesar {{ abs($regression['b1']) }}.<br>
                    Koefisien <strong>Budaya (X2)</strong> sebesar {{ $regression['b2'] }} berarti peningkatan 1 satuan tekanan budaya akan {{ $regression['b2'] >= 0 ? 'meningkatkan' : 'menurunkan' }} kualitas pelaporan sebesar {{ abs($regression['b2']) }}.<br>
                    Koefisien <strong>Tata Kelola (X3)</strong> sebesar {{ $regression['b3'] }} berarti peningkatan 1 satuan kelemahan tata kelola akan {{ $regression['b3'] >= 0 ? 'meningkatkan' : 'menurunkan' }} kualitas pelaporan sebesar {{ abs($regression['b3']) }}.<br>
                    Nilai R-Squared ({{ $regression['r2'] }}) mengindikasikan bahwa ketiga variabel independen secara simultan memengaruhi Kualitas Pelaporan sebesar {{ $regression['r2'] * 100 }}%.
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
                        <p style="color: var(--text-light);">Evaluasi rumusan hipotesis (H1-H4) berdasarkan arah dan nilai koefisien regresi.</p>
                    </div>
                </div>

                <div class="chart-card" style="padding: 0; overflow: hidden;">
                    <table class="table-stats" style="margin-top: 0;">
                        <thead style="background: #f8fafc;">
                            <tr>
                                <th style="width: 5%;">Kode</th>
                                <th style="width: 50%; text-align: left; padding-left: 20px;">Rumusan Hipotesis</th>
                                <th style="width: 10%;">Arah</th>
                                <th style="width: 15%;">Hasil Regresi</th>
                                <th style="width: 20%;">Kesimpulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-weight: 700;">H1</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5;">Kapasitas manajerial pengelola, tekanan budaya relasional lokal, dan kelemahan tata kelola keuangan secara simultan berpengaruh signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Simultan</td>
                                <td>$R^2$ = {{ $regression['r2'] }}</td>
                                <td>
                                    <span class="{{ $regression['r2'] > 0 ? 'badge-success' : 'badge-danger' }}" style="display: inline-block;">
                                        {{ $regression['r2'] > 0 ? 'Terdukung' : 'Tidak Terdukung' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700;">H2</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5;">Kapasitas manajerial pengelola berpengaruh positif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Positif</td>
                                <td>$b_1$ = {{ $regression['b1'] }}</td>
                                <td>
                                    <span class="{{ $regression['b1'] > 0 ? 'badge-success' : 'badge-danger' }}" style="display: inline-block;">
                                        {{ $regression['b1'] > 0 ? 'Terdukung' : 'Tidak Terdukung' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700;">H3</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5;">Tekanan budaya relasional lokal berpengaruh negatif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Negatif</td>
                                <td>$b_2$ = {{ $regression['b2'] }}</td>
                                <td>
                                    <span class="{{ $regression['b2'] < 0 ? 'badge-success' : 'badge-danger' }}" style="display: inline-block;">
                                        {{ $regression['b2'] < 0 ? 'Terdukung' : 'Tidak Terdukung' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: 700;">H4</td>
                                <td style="text-align: left; padding-left: 20px; line-height: 1.5;">Kelemahan tata kelola keuangan berpengaruh negatif dan signifikan terhadap kualitas implementasi pelaporan keuangan BUMDesa.</td>
                                <td>Negatif</td>
                                <td>$b_3$ = {{ $regression['b3'] }}</td>
                                <td>
                                    <span class="{{ $regression['b3'] < 0 ? 'badge-success' : 'badge-danger' }}" style="display: inline-block;">
                                        {{ $regression['b3'] < 0 ? 'Terdukung' : 'Tidak Terdukung' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="narration-box" style="margin-top: 16px;">
                    <strong>Interpretasi Uji Hipotesis:</strong><br>
                    <strong>H1 (Simultan):</strong> Nilai $R^2$ sebesar {{ $regression['r2'] }} menunjukkan bahwa ketiga variabel independen secara bersama-sama memengaruhi Kualitas Pelaporan (Y), sehingga hipotesis <strong>{{ $regression['r2'] > 0 ? 'terdukung' : 'tidak terdukung' }}</strong>.<br>
                    <strong>H2 (Parsial X1):</strong> Koefisien $b_1$ bernilai {{ $regression['b1'] }}. Arah koefisien ini <strong>{{ $regression['b1'] > 0 ? 'positif (searah)' : 'negatif (berlawanan)' }}</strong> dengan hipotesis awal, sehingga H2 <strong>{{ $regression['b1'] > 0 ? 'terdukung' : 'tidak terdukung' }}</strong>.<br>
                    <strong>H3 (Parsial X2):</strong> Koefisien $b_2$ bernilai {{ $regression['b2'] }}. Arah koefisien ini <strong>{{ $regression['b2'] < 0 ? 'negatif (searah)' : 'positif (berlawanan)' }}</strong> dengan hipotesis awal, sehingga H3 <strong>{{ $regression['b2'] < 0 ? 'terdukung' : 'tidak terdukung' }}</strong>.<br>
                    <strong>H4 (Parsial X3):</strong> Koefisien $b_3$ bernilai {{ $regression['b3'] }}. Arah koefisien ini <strong>{{ $regression['b3'] < 0 ? 'negatif (searah)' : 'positif (berlawanan)' }}</strong> dengan hipotesis awal, sehingga H4 <strong>{{ $regression['b3'] < 0 ? 'terdukung' : 'tidak terdukung' }}</strong>.<br>
                    <span style="font-size: 0.8rem; color: var(--text-light); margin-top: 8px; display: block;"><em>*Catatan: Kesimpulan "Terdukung/Tidak Terdukung" ditarik murni berdasarkan perbandingan arah koefisien prediksi dengan arah hipotesis.</em></span>
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
