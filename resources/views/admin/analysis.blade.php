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
        .logo { font-weight: 700; color: var(--primary); text-decoration: none; font-size: 1.25rem; }
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
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="logo">BUMDesa Admin</a>
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
                    <h3>Profil Perbandingan Variabel (Radar)</h3>
                    <div style="height: 350px;"><canvas id="radarChart"></canvas></div>
                </div>
                <div class="chart-card">
                    <h3>Sebaran Responden per Kabupaten</h3>
                    <div style="height: 350px;"><canvas id="kabupatenChart"></canvas></div>
                </div>
                <div class="chart-card" style="grid-column: span 2;">
                    <h3>Rincian Skor per Butir Pernyataan</h3>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
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
                    backgroundColor: [
                        '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'
                    ]
                }]
            },
            options: { maintainAspectRatio: false, cutout: '60%' }
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
