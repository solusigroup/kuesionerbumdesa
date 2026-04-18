<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
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
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.25rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-links a {
            font-size: 0.9rem;
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }

        .btn-export { background: var(--success); color: white; }
        .btn-export:hover { opacity: 0.9; }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            padding: 16px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #e0f2fe;
            color: #0369a1;
        }

        .empty {
            padding: 60px;
            text-align: center;
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .container { padding: 0 20px; }
            nav { padding: 16px 20px; }
            .header { flex-direction: column; align-items: flex-start; gap: 16px; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">BUMDesa Admin</a>
        <div class="nav-links">
            <span>{{ auth()->user()->name }} (Superadmin)</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <div>
                <h1>Data Hasil Kuesioner</h1>
                <p style="color: var(--text-light); margin-top: 4px;">Monitor dan ekspor seluruh hasil isian dari responden.</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.analysis') }}" class="btn btn-primary" style="background: #ffffff; color: var(--primary); border: 1px solid var(--primary);">
                    📈 Lihat Analisis
                </a>
                <a href="{{ route('admin.export') }}" class="btn btn-export">
                    📊 Ekspor ke Excel (CSV)
                </a>
            </div>
        </div>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu Submit</th>
                            <th>Email Responden</th>
                            <th>Nama Responden</th>
                            <th>Desa / Kec.</th>
                            <th>BUMDesa</th>
                            <th>Jabatan</th>
                            <th>Total Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuesioners as $k)
                        @php
                            $totalScore = $k->x1_1 + $k->x1_2 + $k->x1_3 + $k->x1_4 + $k->x1_5 +
                                          $k->x2_1 + $k->x2_2 + $k->x2_3 + $k->x2_4 + $k->x2_5 +
                                          $k->x3_1 + $k->x3_2 + $k->x3_3 + $k->x3_4 + $k->x3_5 +
                                          $k->y1 + $k->y2 + $k->y3 + $k->y4 + $k->y5;
                        @endphp
                        <tr>
                            <td>{{ $k->created_at->format('d/m/Y H:i') }}</td>
                            <td><span class="badge">{{ $k->user->email ?? '-' }}</span></td>
                            <td>
                                <a href="{{ route('admin.show', $k->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                    {{ $k->nama_responden }}
                                </a>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--text-light);">
                                {{ $k->nama_desa }} / {{ $k->kecamatan }}
                            </td>
                            <td>{{ $k->nama_bumdesa }}</td>
                            <td>{{ $k->jabatan }}</td>
                            <td style="font-weight: 600; color: var(--primary);">{{ $totalScore }} / 100</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty">Belum ada data kuesioner yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
