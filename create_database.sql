CREATE TABLE KuesionersTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_responden VARCHAR(255),
    jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
    usia INT,
    jabatan VARCHAR(100),
    nama_bumdesa VARCHAR(255),
    kabupaten_kota VARCHAR(100),
    lama_menjabat VARCHAR(50),
    pendidikan_terakhir VARCHAR(50),
    pernah_pelatihan ENUM('Ya', 'Tidak'),
    menggunakan_aplikasi ENUM('Ya', 'Tidak'),
    frekuensi_pelatihan VARCHAR(50),
    -- Variabel X1 s.d Y (20 item)
    x1_1 INT, x1_2 INT, x1_3 INT, x1_4 INT, x1_5 INT,
    x2_1 INT, x2_2 INT, x2_3 INT, x2_4 INT, x2_5 INT,
    x3_1 INT, x3_2 INT, x3_3 INT, x3_4 INT, x3_5 INT,
    y1 INT, y2 INT, y3 INT, y4 INT, y5 INT,
    -- Pertanyaan Terbuka
    hambatan_besar TEXT,
    pengaruh_budaya TEXT,
    perbaikan_dibutuhkan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);