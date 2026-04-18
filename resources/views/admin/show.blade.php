<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kuesioner - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
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

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 24px;
            gap: 8px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 40px;
            border: 1px solid var(--border);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 32px 0 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--bg);
            color: var(--primary);
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item label {
            display: block;
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .info-item span {
            font-weight: 600;
        }

        .question-list {
            margin-top: 16px;
        }

        .question-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .score-badge {
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 700;
        }

        .essay-box {
            background: #f8fafc;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-top: 8px;
        }

        @media (max-width: 640px) {
            .grid-info { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('admin.dashboard') }}" class="logo">BUMDesa Admin</a>
    </nav>

    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>

        <div class="card">
            <h1>Detail Isian Kuesioner</h1>
            <p style="color: var(--text-light);">Data disubmit pada {{ $kuesioner->created_at->format('d F Y H:i') }}</p>

            <div class="section-title">I. Profil Responden</div>
            <div class="grid-info">
                <div class="info-item"><label>Nama Responden</label><span>{{ $kuesioner->nama_responden }}</span></div>
                <div class="info-item"><label>Email Akun</label><span>{{ $kuesioner->user->email ?? '-' }}</span></div>
                <div class="info-item"><label>Jenis Kelamin</label><span>{{ $kuesioner->jenis_kelamin }}</span></div>
                <div class="info-item"><label>Usia</label><span>{{ $kuesioner->usia }} Tahun</span></div>
                <div class="info-item"><label>Jabatan</label><span>{{ $kuesioner->jabatan }}</span></div>
                <div class="info-item"><label>Nama BUMDesa</label><span>{{ $kuesioner->nama_bumdesa }}</span></div>
                <div class="info-item"><label>Kabupaten/Kota</label><span>{{ $kuesioner->kabupaten_kota }}</span></div>
                <div class="info-item"><label>Lama Menjabat</label><span>{{ $kuesioner->lama_menjabat }}</span></div>
            </div>

            @php
                $sections = [
                    'A. Kapasitas Manajerial' => ['prefix' => 'x1_'],
                    'B. Budaya Organisasi' => ['prefix' => 'x2_'],
                    'C. Sistem Akuntansi' => ['prefix' => 'x3_'],
                    'D. Akuntabilitas BUMDesa' => ['prefix' => 'y']
                ];

                $qLabels = [
                    'x1_1' => 'Memahami dasar-dasar pencatatan keuangan',
                    'x1_2' => 'Mampu menyusun laporan keuangan mandiri',
                    'x1_3' => 'Memahami regulasi pengelolaan BUMDesa',
                    'x1_4' => 'Mampu melakukan analisis kelayakan usaha',
                    'x1_5' => 'Rutin melakukan evaluasi kinerja berkala',
                    'x2_1' => 'Terjadi konflik kepentingan pengelola dan perangkat',
                    'x2_2' => 'Tekanan keluarga/kerabat dalam rekrutmen',
                    'x2_3' => 'Sulit profesional karena kedekatan personal',
                    'x2_4' => 'Keputusan didominasi pihak berpengaruh',
                    'x2_5' => 'Beban moral prioritas kepentingan kelompok',
                    'x3_1' => 'Pencatatan transaksi belum tertib/kronologis',
                    'x3_2' => 'Sistem pendokumentasian bukti tidak lengkap',
                    'x3_3' => 'Laporan pertanggungjawaban terlambat disajikan',
                    'x3_4' => 'Lemahnya fungsi pengawasan internal',
                    'x3_5' => 'Tidak ada pemisahan tugas pelaksana dan keuangan',
                    'y1' => 'Laporan disajikan jujur sesuai kondisi lapangan',
                    'y2' => 'Informasi laporan mudah dipahami masyarakat',
                    'y3' => 'Penggunaan dana dapat dipertanggungjawabkan',
                    'y4' => 'Data disajikan konsisten antar periode',
                    'y5' => 'Laporan dapat diverifikasi melalui bukti nyata'
                ];
            @endphp

            @foreach($sections as $title => $data)
                <div class="section-title">{{ $title }}</div>
                <div class="question-list">
                    @for($i = 1; $i <= 5; $i++)
                        @php $key = ($data['prefix'] == 'y' ? 'y' : $data['prefix']) . $i; @endphp
                        <div class="question-item">
                            <span>{{ $qLabels[$key] ?? 'Pertanyaan ' . $key }}</span>
                            <span class="score-badge">{{ $kuesioner->$key }}</span>
                        </div>
                    @endfor
                </div>
            @endforeach

            <div class="section-title">III. Pendapat Tambahan</div>
            <div class="info-item" style="margin-bottom: 20px;">
                <label>Hambatan Terbesar</label>
                <div class="essay-box">{{ $kuesioner->hambatan_besar ?: '-' }}</div>
            </div>
            <div class="info-item" style="margin-bottom: 20px;">
                <label>Pengaruh Budaya Lokal</label>
                <div class="essay-box">{{ $kuesioner->pengaruh_budaya ?: '-' }}</div>
            </div>
            <div class="info-item" style="margin-bottom: 20px;">
                <label>Perbaikan Mendesak</label>
                <div class="essay-box">{{ $kuesioner->perbaikan_dibutuhkan ?: '-' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
