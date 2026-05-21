<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Wawancara - Admin Panel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
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
        .logo img {
            height: 40px;
            object-fit: contain;
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

        .btn-custom {
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

        .btn-primary-custom { background: var(--primary); color: white; }
        .btn-primary-custom:hover { background: var(--primary-hover); color: white; }

        .btn-export-custom { background: var(--success); color: white; }
        .btn-export-custom:hover { opacity: 0.9; color: white; }

        .card-custom {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
            padding: 24px;
        }

        .filter-section {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 24px;
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-light);
        }

        .filter-control {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .filter-control:focus {
            border-color: var(--primary);
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

        .empty {
            padding: 60px;
            text-align: center;
            color: var(--text-light);
        }

        /* Detail Modal Styles */
        .modal-header {
            background-color: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        .modal-title {
            font-weight: 700;
            color: var(--text);
        }
        .transcript-box {
            background-color: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            font-size: 0.9rem;
            white-space: pre-line;
            max-height: 200px;
            overflow-y: auto;
        }
        .transcript-label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 768px) {
            .container { padding: 0 20px; }
            nav { padding: 16px 20px; }
            .header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .filter-section { flex-direction: column; align-items: stretch; }
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
            <a href="{{ route('admin.lottery') }}">Pengundian</a>
            <a href="{{ route('admin.interviews') }}" style="font-weight: 600; color: var(--primary);">Hasil Wawancara</a>
            <a href="https://kuesioner.simpleakunting.shop/interview/create" style="background: #4f46e5; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600; text-decoration: none;">WAWANCARA</a>
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role === 'superadmin' ? 'Superadmin' : 'Interviewer' }})</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <div>
                <h1>Data Transkrip Wawancara</h1>
                <p style="color: var(--text-light); margin-top: 4px;">Akses dan review hasil wawancara mendalam yang dilakukan oleh Interviewer.</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('interview.export') }}" class="btn-custom btn-export-custom">
                    📊 Unduh Lampiran Excel (.xls)
                </a>
            </div>
        </div>

        @if(session('success')) 
            <div style="background: #dcfce7; color: #15803d; padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid #bbf7d0; font-weight: 500;">
                {{ session('success') }}
            </div> 
        @endif

        <form action="{{ route('admin.interviews') }}" method="GET" class="filter-section">
            <div class="filter-group">
                <label for="search">Pencarian</label>
                <input type="text" name="search" id="search" class="filter-control" placeholder="Cari BUMDesa, narasumber, jabatan..." value="{{ request('search') }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-custom btn-primary-custom">Cari</button>
                <a href="{{ route('admin.interviews') }}" class="btn-custom" style="background: #f1f5f9; color: var(--text);">Reset</a>
            </div>
        </form>

        <div class="card-custom">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu Input</th>
                            <th>Nama BUMDesa</th>
                            <th>Nama Narasumber</th>
                            <th>Jabatan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $log->nama_bumdesa }}</strong></td>
                            <td>{{ $log->nama_narasumber }}</td>
                            <td>{{ $log->jabatan }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-primary-custom" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailModal" 
                                    data-bumdesa="{{ $log->nama_bumdesa }}"
                                    data-narasumber="{{ $log->nama_narasumber }}"
                                    data-jabatan="{{ $log->jabatan }}"
                                    data-x1="{{ $log->transkrip_kapasitas_x1 ?? '(Kosong)' }}"
                                    data-x2="{{ $log->transkrip_budaya_x2 ?? '(Kosong)' }}"
                                    data-x3="{{ $log->transkrip_tata_kelola_x3 ?? '(Kosong)' }}"
                                    data-y="{{ $log->transkrip_pelaporan_y ?? '(Kosong)' }}">
                                    <i class="bi bi-eye-fill me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty">Belum ada data transkrip wawancara yang disubmit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Transkrip Wawancara</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <!-- Profil Responden/BUMDesa -->
                    <div class="row g-3 mb-4" style="background-color: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin: 0 0 20px 0;">
                        <div class="col-md-4">
                            <span class="text-muted d-block small text-uppercase font-weight-bold">BUMDesa</span>
                            <strong id="modalBumdesa" class="text-primary" style="font-size: 1.1rem;">-</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block small text-uppercase font-weight-bold">Narasumber</span>
                            <strong id="modalNarasumber">-</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="text-muted d-block small text-uppercase font-weight-bold">Jabatan</span>
                            <strong id="modalJabatan">-</strong>
                        </div>
                    </div>

                    <!-- Transkrip X1 -->
                    <div>
                        <div class="transcript-label">
                            <i class="bi bi-briefcase-fill"></i> X1: Kapasitas Manajerial
                        </div>
                        <div class="transcript-box" id="modalX1">-</div>
                    </div>

                    <!-- Transkrip X2 -->
                    <div>
                        <div class="transcript-label">
                            <i class="bi bi-people-fill"></i> X2: Budaya Organisasi
                        </div>
                        <div class="transcript-box" id="modalX2">-</div>
                    </div>

                    <!-- Transkrip X3 -->
                    <div>
                        <div class="transcript-label">
                            <i class="bi bi-shield-check"></i> X3: Tata Kelola
                        </div>
                        <div class="transcript-box" id="modalX3">-</div>
                    </div>

                    <!-- Transkrip Y -->
                    <div>
                        <div class="transcript-label">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Y: Kualitas Pelaporan
                        </div>
                        <div class="transcript-box" id="modalY">-</div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f8fafc;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                
                // Get data attributes
                const bumdesa = button.getAttribute('data-bumdesa');
                const narasumber = button.getAttribute('data-narasumber');
                const jabatan = button.getAttribute('data-jabatan');
                const x1 = button.getAttribute('data-x1');
                const x2 = button.getAttribute('data-x2');
                const x3 = button.getAttribute('data-x3');
                const y = button.getAttribute('data-y');

                // Set modal content
                document.getElementById('modalBumdesa').textContent = bumdesa;
                document.getElementById('modalNarasumber').textContent = narasumber;
                document.getElementById('modalJabatan').textContent = jabatan;
                
                document.getElementById('modalX1').textContent = x1;
                document.getElementById('modalX2').textContent = x2;
                document.getElementById('modalX3').textContent = x3;
                document.getElementById('modalY').textContent = y;
            });
        }
    </script>
</body>
</html>
