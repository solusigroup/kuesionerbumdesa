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
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span>BUMDesa Admin</span>
        </a>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-nav-primary">Kembali ke Dashboard</a>
        </div>
    </nav>

    <div class="container">
        @if(isset($isEmpty))
            <div style="text-align: center; padding: 100px 0;">
                <h2 style="font-size: 2rem; color: var(--text-light);">Belum ada data untuk dianalisis.</h2>
                <p>Dashboard analisis akan aktif setelah responden mengisi kuesioner.</p>
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary); text-decoration: none; font-weight: 700;">&larr; Kembali</a>
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

            <div class="grid-charts">
                <div class="chart-card">
                    <h3>Sebaran Responden per Kabupaten</h3>
                    <div style="height: 350px;"><canvas id="kabupatenChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Sebaran Responden per Jabatan</h3>
                    <div style="height: 350px;"><canvas id="jabatanChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Sebaran Responden per Pendidikan</h3>
                    <div style="height: 350px;"><canvas id="pendidikanChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Pernah Mengikuti Pelatihan</h3>
                    <div style="height: 350px;"><canvas id="pelatihanChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Menggunakan Aplikasi</h3>
                    <div style="height: 350px;"><canvas id="aplikasiChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Frekuensi Pelatihan</h3>
                    <div style="height: 350px;"><canvas id="frekuensiChart"></canvas></div>
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
                    </div>
                @endforeach
            </div>

            @php
                $vars = [
                    'x1' => ['label' => 'Kapasitas Manajerial (X1)'],
                    'x2' => ['label' => 'Tekanan Budaya (X2)'],
                    'x3' => ['label' => 'Kelemahan Tata Kelola (X3)'],
                    'y'  => ['label' => 'Kualitas Pelaporan (Y)']
                ];
            @endphp

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
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₁ (b₁)</div>
                            <div class="coeff-value">{{ $regression['b1'] }}</div>
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₂ (b₂)</div>
                            <div class="coeff-value">{{ $regression['b2'] }}</div>
                        </div>
                        <div class="coeff-item">
                            <div class="coeff-label">Koefisien X₃ (b₃)</div>
                            <div class="coeff-value">{{ $regression['b3'] }}</div>
                        </div>
                    </div>

                    <div style="margin-top: 32px; display: flex; align-items: center; justify-content: center; gap: 24px;">
                        <div style="background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 12px;">
                            <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7); display: block;">R-Squared (R²)</span>
                            <span style="font-size: 1.5rem; font-weight: 700;">{{ $regression['r2'] }}</span>
                        </div>
                        <div style="max-width: 400px; font-size: 0.85rem; color: rgba(255,255,255,0.8);">
                            Nilai $R^2$ sebesar {{ $regression['r2'] }} menunjukkan bahwa variabel independen mampu menjelaskan {{ $regression['r2'] * 100 }}% variasi dari variabel dependen.
                        </div>
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
