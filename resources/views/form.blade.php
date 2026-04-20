<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
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
            padding: 16px 80px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.2rem;
        }

        .nav-links a { font-size: 0.9rem; text-decoration: none; color: var(--text-light); font-weight: 500; transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary); }

        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); padding: 40px; border: 1px solid var(--border); }
        h1 { font-size: 2rem; font-weight: 600; margin-bottom: 8px; color: var(--primary); text-align: center; }
        p.subtitle { text-align: center; color: var(--text-light); margin-bottom: 32px; }

        .section-title { font-size: 1.25rem; font-weight: 600; margin: 32px 0 16px; padding: 12px; background: #f1f5f9; border-radius: 8px; color: var(--primary); }
        .form-group { margin-bottom: 24px; }
        label { display: block; font-weight: 600; margin-bottom: 12px; font-size: 0.95rem; }

        input[type="text"], input[type="number"], input[type="email"], select, textarea { width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border); background-color: #f8fafc; font-family: inherit; font-size: 1rem; box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }

        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .question-card { background: #ffffff; padding: 24px; border-radius: 12px; margin-bottom: 16px; border: 1px solid var(--border); }
        .question-text { font-weight: 500; margin-bottom: 16px; display: block; color: var(--text); }
        .scale-options { display: flex; justify-content: space-between; align-items: center; max-width: 500px; }
        .scale-option { display: flex; flex-direction: column; align-items: center; cursor: pointer; gap: 8px; }
        .scale-option input { width: 20px; height: 20px; accent-color: var(--primary); cursor: pointer; }
        .scale-label { font-size: 0.75rem; font-weight: 600; color: var(--text-light); }

        button.btn-submit { background-color: var(--primary); color: white; border: none; padding: 16px 32px; border-radius: 12px; font-size: 1.1rem; font-weight: 600; cursor: pointer; width: 100%; transition: all 0.2s; margin-top: 40px; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); }
        button.btn-submit:hover { background-color: var(--primary-hover); transform: translateY(-2px); }

        .format-note { font-size: 0.75rem; color: var(--text-light); margin-top: 4px; font-style: italic; }

        .format-note { font-size: 0.75rem; color: var(--text-light); margin-top: 4px; font-style: italic; }

        @media (max-width: 640px) { .grid { grid-template-columns: 1fr; } nav { padding: 16px 20px; } .card { padding: 20px; } }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">BUMDesa Research</a>
        <div class="nav-links">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h1>Kuesioner Paradoks Akuntabilitas</h1>
            <p class="subtitle">Silakan isi instrumen penelitian berikut sesuai dengan kondisi di BUMDesa Anda.</p>

            @if ($errors->any())
                <div class="alert-error" style="background:#fee2e2; color:#b91c1c; padding:16px; border-radius:12px; margin-bottom:24px;">
                    <ul style="margin:0;">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('kuesioner.store') }}" method="POST">
                @csrf
                
                <div class="section-title">I. Profil Responden</div>
                
                <div class="grid">
                    <div class="form-group">
                        <label for="nama_responden">Nama Lengkap</label>
                        <input type="text" id="nama_responden" name="nama_responden" required value="{{ old('nama_responden') }}">
                    </div>
                    <div class="form-group">
                        <label for="nomor_wa">Nomor WhatsApp</label>
                        <input type="text" id="nomor_wa" name="nomor_wa" required value="{{ old('nomor_wa') }}" placeholder="Contoh: 081234567890">
                        <div class="format-note">Gunakan format angka tanpa spasi/simbol</div>
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="email_bumdesa">Email BUMDesa</label>
                        <input type="email" id="email_bumdesa" name="email_bumdesa" required value="{{ old('email_bumdesa') }}" placeholder="bumdesa@desa.id">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="usia">Usia (Tahun)</label>
                        <input type="number" id="usia" name="usia" required value="{{ old('usia') }}">
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <select id="jabatan" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach(['Direktur', 'Sekretaris', 'Bendahara', 'Pengawas', 'Staff', 'Lainnya'] as $j)
                                <option value="{{ $j }}" {{ old('jabatan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="nama_bumdesa">Nama BUMDesa</label>
                        <input type="text" id="nama_bumdesa" name="nama_bumdesa" required value="{{ old('nama_bumdesa') }}">
                    </div>
                    <div class="form-group">
                        <label for="nama_desa">Nama Desa</label>
                        <input type="text" id="nama_desa" name="nama_desa" required value="{{ old('nama_desa') }}">
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" id="kecamatan" name="kecamatan" required value="{{ old('kecamatan') }}">
                    </div>
                    <div class="form-group">
                        <label for="kabupaten_kota">Kabupaten/Kota</label>
                        <select id="kabupaten_kota" name="kabupaten_kota" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach([
                                'Kabupaten Bangkalan', 'Kabupaten Banyuwangi', 'Kabupaten Blitar', 'Kabupaten Bojonegoro',
                                'Kabupaten Bondowoso', 'Kabupaten Gresik', 'Kabupaten Jember', 'Kabupaten Jombang',
                                'Kabupaten Kediri', 'Kabupaten Lamongan', 'Kabupaten Lumajang', 'Kabupaten Madiun',
                                'Kabupaten Magetan', 'Kabupaten Malang', 'Kabupaten Mojokerto', 'Kabupaten Nganjuk',
                                'Kabupaten Ngawi', 'Kabupaten Pacitan', 'Kabupaten Pamekasan', 'Kabupaten Pasuruan',
                                'Kabupaten Ponorogo', 'Kabupaten Probolinggo', 'Kabupaten Sampang', 'Kabupaten Sidoarjo',
                                'Kabupaten Situbondo', 'Kabupaten Sumenep', 'Kabupaten Trenggalek', 'Kabupaten Tuban',
                                'Kabupaten Tulungagung', 'Kota Batu', 'Kota Blitar', 'Kota Kediri',
                                'Kota Madiun', 'Kota Malang', 'Kota Mojokerto', 'Kota Pasuruan',
                                'Kota Probolinggo', 'Kota Surabaya'
                            ] as $kota)
                                <option value="{{ $kota }}" {{ old('kabupaten_kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="lama_menjabat">Lama Menjabat</label>
                        <select id="lama_menjabat" name="lama_menjabat" required>
                            <option value="">Pilih Lama Menjabat</option>
                            @foreach(['Kurang dari 1 tahun', '1 sampai 3 tahun', '4 sampai 6 tahun', 'Lebih dari 6 tahun'] as $lama)
                                <option value="{{ $lama }}" {{ old('lama_menjabat') == $lama ? 'selected' : '' }}>{{ $lama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pendidikan_terakhir">Pendidikan Terakhir</label>
                        <select id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['SD', 'SMP', 'SMA/SMK', 'Diploma', 'S1', 'S2', 'S3'] as $p)
                                <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid">
                    <div class="form-group">
                        <label for="pernah_pelatihan">Pernah Ikut Pelatihan Akuntansi?</label>
                        <select id="pernah_pelatihan" name="pernah_pelatihan" required>
                            <option value="">Pilih</option>
                            <option value="Ya" {{ old('pernah_pelatihan') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('pernah_pelatihan') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="menggunakan_aplikasi">Menggunakan Aplikasi Akuntansi?</label>
                        <select id="menggunakan_aplikasi" name="menggunakan_aplikasi" required>
                            <option value="">Pilih</option>
                            <option value="Ya" {{ old('menggunakan_aplikasi') == 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('menggunakan_aplikasi') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="frekuensi_pelatihan">Frekuensi pelatihan atau pendampingan dua tahun terakhir</label>
                    <select id="frekuensi_pelatihan" name="frekuensi_pelatihan" required>
                        <option value="">Pilih Frekuensi</option>
                        @foreach(['Tidak pernah', '1 kali', '2 sampai 3 kali', 'Lebih dari 3 kali'] as $f)
                            <option value="{{ $f }}" {{ old('frekuensi_pelatihan') == $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="section-title">II. Instrumen Penelitian</div>
                <p style="font-size: 0.9rem; color: var(--text-light); margin-bottom: 24px; padding: 0 12px;">Skala Likert: 1 (Sangat Tidak Setuju) s.d 5 (Sangat Setuju)</p>

                @php
                    $instrumen = [
                        [
                            'label' => 'X1. Kapasitas Manajerial',
                            'prefix' => 'x1',
                            'type' => 'pos',
                            'questions' => [
                                'Saya memahami dasar-dasar pencatatan transaksi keuangan BUMDesa.',
                                'Saya mampu menyusun laporan keuangan secara mandiri.',
                                'Saya memahami regulasi dalam pengelolaan BUMDesa.',
                                'Saya mampu melakukan analisis kelayakan usaha.',
                                'Saya rutin melakukan evaluasi kinerja unit usaha.'
                            ]
                        ],
                        [
                            'label' => 'X2. Tekanan Budaya Relasional',
                            'prefix' => 'x2',
                            'type' => 'neg',
                            'questions' => [
                                'Sering terjadi konflik kepentingan antara pengelola dan perangkat desa.',
                                'Adanya tekanan dari keluarga/kerabat perangkat desa dalam rekrutmen pengelola.',
                                'Sulit untuk bersikap profesional karena adanya faktor kedekatan personal.',
                                'Pengambilan keputusan seringkali didominasi oleh salah satu pihak yang berpengaruh.',
                                'Adanya beban moral untuk memprioritaskan kepentingan kelompok tertentu di atas kepentingan BUMDesa.'
                            ]
                        ],
                        [
                            'label' => 'X3. Kelemahan Tata Kelola',
                            'prefix' => 'x3',
                            'type' => 'neg',
                            'questions' => [
                                'Pencatatan transaksi belum dilakukan secara tertib dan kronologis.',
                                'Sistem pendokumentasian bukti transaksi seringkali tidak lengkap.',
                                'Laporan pertanggungjawaban seringkali terlambat disajikan.',
                                'Lemahnya fungsi pengawasan internal dalam BUMDesa.',
                                'Tidak adanya pemisahan tugas yang jelas antara fungsi pelaksana dan fungsi keuangan.'
                            ]
                        ],
                        [
                            'label' => 'Y. Kualitas Implementasi Pelaporan',
                            'prefix' => 'y',
                            'type' => 'pos',
                            'questions' => [
                                'Laporan disajikan secara jujur dan sesuai dengan kondisi lapangan.',
                                'Informasi dalam laporan mudah dipahami oleh masyarakat luas (Musdes).',
                                'Dana yang dikelola dapat dipertanggungjawabkan sesuai aturan yang berlaku.',
                                'Data yang disajikan konsisten dari satu periode ke periode berikutnya.',
                                'Laporan dapat diverifikasi kebenarannya melalui bukti-bukti yang ada.'
                            ]
                        ]
                    ];
                @endphp

                @foreach($instrumen as $group)
                    <div style="margin: 32px 0 16px;">
                        <h3 style="margin: 0; font-size: 1.1rem; color: var(--text);">{{ $group['label'] }}</h3>
                    </div>
                    @foreach($group['questions'] as $idx => $q)
                        @php $name = ($group['prefix'] == 'y' ? 'y' : $group['prefix'] . '_') . ($idx + 1); @endphp
                        <div class="question-card">
                            <span class="question-text">{{ ($idx + 1) }}. {{ $q }}</span>
                            <div class="scale-options">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="scale-option">
                                        <input type="radio" name="{{ $name }}" value="{{ $i }}" required {{ old($name) == $i ? 'checked' : '' }}>
                                        <span class="scale-label">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                @endforeach

                <div class="section-title">III. Pendapat Tambahan</div>
                <div class="form-group"><label for="hambatan_besar">Apa hambatan terbesar dalam pengelolaan administrasi?</label><textarea id="hambatan_besar" name="hambatan_besar" rows="3" required>{{ old('hambatan_besar') }}</textarea></div>
                <div class="form-group"><label for="pengaruh_budaya">Bagaimana pengaruh budaya lokal terhadap kepatuhan pelaporan?</label><textarea id="pengaruh_budaya" name="pengaruh_budaya" rows="3" required>{{ old('pengaruh_budaya') }}</textarea></div>
                <div class="form-group"><label for="perbaikan_dibutuhkan">Perbaikan apa yang menurut Anda paling mendesak?</label><textarea id="perbaikan_dibutuhkan" name="perbaikan_dibutuhkan" rows="3" required>{{ old('perbaikan_dibutuhkan') }}</textarea></div>

                <button type="submit" class="btn-submit">Simpan & Kirim Kuesioner</button>
            </form>
        </div>
    </div>
</body>
</html>