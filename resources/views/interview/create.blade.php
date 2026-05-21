<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Hasil Wawancara - Paradoks BUMDesa</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f6f8fb 0%, #e9edf5 100%);
            min-height: 100vh;
            color: #2D3748;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(160, 174, 192, 0.2);
            overflow: hidden;
            background: #ffffff;
            transition: transform 0.3s ease;
        }

        .card-header-gradient {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 2rem;
            border-bottom: none;
        }

        .card-header-gradient h5 {
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.5rem;
        }

        .card-body-custom {
            padding: 2.5rem;
        }

        .form-label-custom {
            font-weight: 600;
            color: #4A5568;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: #2D3748;
            background-color: #F8FAFC;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #3182ce;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .variable-section {
            background: #F8FAFC;
            border: 1px solid #EDF2F7;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s ease;
        }

        .variable-section:hover {
            border-color: #CBD5E0;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(160, 174, 192, 0.08);
        }

        .variable-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: #2B6CB0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .variable-badge {
            background: #EBF8FF;
            color: #2B6CB0;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .btn-submit {
            background: linear-gradient(135deg, #3182ce 0%, #2b6cb0 100%);
            border: none;
            color: white;
            padding: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
            background: linear-gradient(135deg, #2b6cb0 0%, #2c5282 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert-success-custom {
            background: #F0FFF4;
            border: 1px solid #C6F6D5;
            color: #22543D;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success-custom i {
            font-size: 1.25rem;
        }

        .header-icon {
            font-size: 1.8rem;
            margin-right: 0.75rem;
            vertical-align: middle;
            color: #63b3ed;
        }

        .btn-export {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.2);
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-export:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.3);
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
            color: white;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card main-card">
                <div class="card-header card-header-gradient text-white d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1"><i class="bi bi-journal-text header-icon"></i>Form Input Transkrip Wawancara Mendalam</h5>
                        <p class="mb-0 text-white-50 small">Studi Kasus: Kuesioner & Paradoks BUMDesa</p>
                    </div>
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill font-weight-bold">ADMIN PANEL</span>
                </div>
                <div class="card-body card-body-custom">
                    @if(session('success'))
                        <div class="alert alert-success-custom mb-4 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-3 border border-1">
                        <span class="text-muted small"><i class="bi bi-info-circle me-1"></i> Gunakan tombol di samping untuk mengunduh lampiran atau kembali ke dashboard</span>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-1 font-weight-semibold" style="border-radius: 10px; font-weight: 600; font-size: 0.95rem; padding: 0.6rem 1.2rem;">
                                <i class="bi bi-speedometer2"></i> Dashboard Admin
                            </a>
                            <a href="{{ route('interview.export') }}" class="btn-export">
                                <i class="bi bi-file-earmark-excel"></i> Unduh Lampiran Excel
                            </a>
                        </div>
                    </div>
                    <hr class="my-4" style="opacity: 0.15;">

                    <form action="/interview/store" method="POST">
                        @csrf
                        
                        <!-- Metadata Narasumber -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label class="form-label form-label-custom">Nama BUMDesa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 border-2" style="border-radius: 12px 0 0 12px;"><i class="bi bi-building text-muted"></i></span>
                                    <input type="text" name="nama_bumdesa" class="form-control border-start-0" placeholder="Contoh: Tirta Mandiri" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label form-label-custom">Nama Narasumber</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 border-2" style="border-radius: 12px 0 0 12px;"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="nama_narasumber" class="form-control border-start-0" placeholder="Nama Lengkap" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label form-label-custom">Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 border-2" style="border-radius: 12px 0 0 12px;"><i class="bi bi-briefcase text-muted"></i></span>
                                    <input type="text" name="jabatan" class="form-control border-start-0" placeholder="Contoh: Direktur" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted" style="opacity: 0.15;">

                        <!-- Transkrip Variabel X1 -->
                        <div class="variable-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="variable-title">
                                    <i class="bi bi-cpu text-primary"></i>
                                    <span>Variabel X1: Kapasitas Manajerial</span>
                                </div>
                                <span class="variable-badge">X1</span>
                            </div>
                            <label class="form-label form-label-custom small text-muted">Catatan / Transkrip Wawancara</label>
                            <textarea name="transkrip_kapasitas_x1" class="form-control" placeholder="Ketik poin-poin jawaban responden terkait Kapasitas Manajerial di sini..."></textarea>
                        </div>

                        <!-- Transkrip Variabel X2 -->
                        <div class="variable-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="variable-title">
                                    <i class="bi bi-people text-primary"></i>
                                    <span>Variabel X2: Tekanan Budaya Lokal</span>
                                </div>
                                <span class="variable-badge">X2</span>
                            </div>
                            <label class="form-label form-label-custom small text-muted">Catatan / Transkrip Wawancara</label>
                            <textarea name="transkrip_budaya_x2" class="form-control" placeholder="Ketik poin-poin jawaban responden terkait Tekanan Budaya Lokal di sini..."></textarea>
                        </div>

                        <!-- Transkrip Variabel X3 -->
                        <div class="variable-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="variable-title">
                                    <i class="bi bi-shield-exclamation text-primary"></i>
                                    <span>Variabel X3: Kelemahan Tata Kelola</span>
                                </div>
                                <span class="variable-badge">X3</span>
                            </div>
                            <label class="form-label form-label-custom small text-muted">Catatan / Transkrip Wawancara</label>
                            <textarea name="transkrip_tata_kelola_x3" class="form-control" placeholder="Ketik poin-poin jawaban responden terkait Kelemahan Tata Kelola di sini..."></textarea>
                        </div>

                        <!-- Transkrip Variabel Y -->
                        <div class="variable-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="variable-title">
                                    <i class="bi bi-file-earmark-bar-graph text-primary"></i>
                                    <span>Variabel Y: Kualitas Pelaporan</span>
                                </div>
                                <span class="variable-badge">Y</span>
                            </div>
                            <label class="form-label form-label-custom small text-muted">Catatan / Transkrip Wawancara</label>
                            <textarea name="transkrip_pelaporan_y" class="form-control" placeholder="Ketik poin-poin jawaban responden terkait Kualitas Pelaporan di sini..."></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-submit">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan Catatan Wawancara
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="/admin" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard Admin</a>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
