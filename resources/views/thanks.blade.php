<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --accent: #f59e0b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container { max-width: 900px; margin: 60px auto; padding: 0 20px; text-align: center; }
        
        .success-icon { font-size: 5rem; margin-bottom: 24px; animation: bounce 2s infinite; }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translateY(0);} 40% {transform: translateY(-20px);} 60% {transform: translateY(-10px);} }

        h1 { font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 16px; }
        p.lead { font-size: 1.2rem; color: var(--text-light); margin-bottom: 40px; }

        .showcase-title { font-size: 1.5rem; font-weight: 700; margin: 60px 0 30px; position: relative; display: inline-block; }
        .showcase-title::after { content: ''; position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: var(--accent); border-radius: 2px; }

        .grid-showcase { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 30px; text-align: left; }
        
        .product-card { background: var(--card-bg); border-radius: 20px; padding: 32px; border: 1px solid var(--border); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; }
        .product-card::before { content: ""; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--primary); opacity: 0; transition: opacity 0.3s; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
        .product-card:hover::before { opacity: 1; }

        .version-badge { background: #eef2ff; color: var(--primary); font-weight: 700; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; margin-bottom: 16px; display: inline-block; }
        .product-name { font-size: 1.25rem; font-weight: 700; margin-bottom: 8px; color: var(--dark); }
        .product-desc { font-size: 0.9rem; color: var(--text-light); margin-bottom: 24px; }

        .credential-box { background: #f8fafc; border: 1px solid var(--border); border-radius: 12px; padding: 16px; margin-bottom: 24px; font-size: 0.85rem; }
        .credential-item { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .credential-item span:first-child { font-weight: 600; color: var(--text-light); }
        .credential-item span:last-child { font-family: monospace; color: var(--primary); font-weight: 600; }

        .btn-visit { display: block; background: var(--primary); color: white; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: background 0.2s; }
        .btn-visit:hover { background: var(--primary-hover); }

        .promo-banner { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 24px; padding: 48px; margin-top: 80px; color: white; text-align: center; box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.4); }
        .promo-banner h2 { font-size: 2rem; font-weight: 800; margin-bottom: 16px; }
        .promo-banner p { font-size: 1.1rem; opacity: 0.9; margin-bottom: 32px; }
        .btn-cta { background: var(--accent); color: white; padding: 16px 40px; border-radius: 12px; font-size: 1.1rem; font-weight: 700; text-decoration: none; display: inline-block; transition: transform 0.2s; }
        .btn-cta:hover { transform: scale(1.05); }

        .footer-links { margin-top: 60px; display: flex; justify-content: center; gap: 24px; }
        .footer-links a { text-decoration: none; color: var(--text-light); font-weight: 600; font-size: 0.9rem; transition: color 0.2s; }
        .footer-links a:hover { color: var(--primary); }

        @media (max-width: 640px) { .grid-showcase { grid-template-columns: 1fr; } .promo-banner { padding: 32px 20px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">🎉</div>
        <h1>Data Berhasil Terkirim!</h1>
        <p class="lead">Terima kasih atas partisipasi Anda dalam penelitian ini. Partisipasi Anda sangat berarti bagi kemajuan BUMDesa kita semua.</p>

        <h2 class="showcase-title">Pameran Produk SimpleAkunting</h2>
        <p style="color: var(--text-light); max-width: 600px; margin: 0 auto 40px;">Sambil menunggu hasil penelitian, silakan jelajahi berbagai versi aplikasi akuntansi kami yang telah membantu ribuan entitas.</p>

        <div class="grid-showcase">
            <!-- Versi 1 -->
            <div class="product-card">
                <span class="version-badge">Versi 1.0</span>
                <h3 class="product-name">SimpleAkunting Classic</h3>
                <p class="product-desc">Solusi akuntansi fundamental yang stabil dan mudah digunakan untuk pemula.</p>
                <div class="credential-box">
                    <div class="credential-item"><span>User:</span><span>admin</span></div>
                    <div class="credential-item"><span>Pass:</span><span>admin123</span></div>
                </div>
                <a href="https://simpleakunting.biz.id" target="_blank" class="btn-visit">Coba Sekarang</a>
            </div>

            <!-- Versi 4 -->
            <div class="product-card">
                <span class="version-badge">Versi 4.0</span>
                <h3 class="product-name">SimpleAkunting Enterprise</h3>
                <p class="product-desc">Fitur komprehensif untuk bisnis dengan volume transaksi tinggi dan multi-divisi.</p>
                <div class="credential-box">
                    <div class="credential-item"><span>Email:</span><span>demo@contoh.com</span></div>
                    <div class="credential-item"><span>Pass:</span><span>demo1234</span></div>
                </div>
                <a href="https://bisnis1.v4.simpleakunting.biz.id" target="_blank" class="btn-visit">Coba Sekarang</a>
            </div>

            <!-- Versi 5 -->
            <div class="product-card">
                <span class="version-badge">Versi 5.0 (Abyakta)</span>
                <h3 class="product-name">SimpleAkunting Modern</h3>
                <p class="product-desc">Antarmuka mutakhir dengan analitik mendalam dan kustomisasi maksimal.</p>
                <div class="credential-box">
                    <div class="credential-item"><span>User:</span><span>admin</span></div>
                    <div class="credential-item"><span>Pass:</span><span>admin123</span></div>
                </div>
                <a href="https://abyakta.simpleakunting.id" target="_blank" class="btn-visit">Coba Sekarang</a>
            </div>
        </div>

        <div class="promo-banner">
            <h2>Berminat Mendapat Hibah Aplikasi?</h2>
            <p>Kami memiliki program khusus pemberdayaan BUMDesa melalui dukungan teknologi akuntansi berstandar nasional.</p>
            <a href="https://v3.simpleakunting.biz.id/umpan_balik.html" target="_blank" class="btn-cta">Daftar Hibah & Reservasi</a>
        </div>

        <div class="footer-links">
            <a href="{{ route('kuesioner.index') }}">← Kembali ke Dashboard Anda</a>
            <a href="https://v3.simpleakunting.biz.id/umpan_balik.html" target="_blank">Berikan Umpan Balik</a>
        </div>
    </div>
</body>
</html>
