<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Blast - Kuesioner BUMDesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #25d366;
            --primary-hover: #128c7e;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --text: #1e293b;
            --text-light: #64748b;
            --border: #e2e8f0;
            --wa-color: #25d366;
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
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: #1e293b;
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

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-wa {
            background: var(--wa-color);
            color: white;
        }

        .btn-wa:hover {
            background: var(--primary-hover);
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .template-section {
            padding: 24px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
            font-size: 0.9rem;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: inherit;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 100px;
        }

        .hint {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-top: 4px;
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

        .search-box {
            padding: 16px 24px;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .search-box input {
            width: 100%;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }

            nav {
                padding: 16px 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
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
            <a href="{{ route('admin.whatsapp') }}" style="color: var(--primary); font-weight: 700;">WhatsApp</a>
            <span>{{ auth()->user()->name }}</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <div>
                <h1>WhatsApp Blast Dashboard</h1>
                <p style="color: var(--text-light); margin-top: 4px;">Kirim pesan personalisasi ke responden kuesioner.
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn"
                style="background: white; border: 1px solid var(--border); color: var(--text);">
                ← Kembali ke Dashboard
            </a>
        </div>

        <div class="card">
            <div class="template-section">
                <div class="form-group">
                    <label for="template">Template Pesan</label>
                    <textarea id="messageTemplate"
                        placeholder="Tulis pesan Anda di sini...">Halo Bapak/Ibu [Nama], perkenalkan kami dari tim riset BUMDesa. Terima kasih telah mengisi kuesioner kami. Kami ingin mengonfirmasikan jika menghendaki mendapatkan hibah source aplikasi akuntansi SimpleAkunting, silakan mempelajari panduannya di https://simpleakunting.my.id/panduanhibahSA.html...terimakasih</textarea>
                    <div class="hint">Gunakan <strong>[Nama]</strong> untuk menyebut nama responden secara otomatis.
                    </div>
                </div>
            </div>

            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari nama, desa, atau nomor WA..."
                    onkeyup="filterTable()">
            </div>

            <div class="table-container">
                <table id="respondentTable">
                    <thead>
                        <tr>
                            <th>Nama Responden</th>
                            <th>Nomor WA</th>
                            <th>BUMDesa</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kuesioners as $k)
                            <tr>
                                <td class="name-cell" data-name="{{ $k->nama_responden }}">{{ $k->nama_responden }}</td>
                                <td class="wa-cell">{{ $k->nomor_wa }}</td>
                                <td>{{ $k->nama_bumdesa }}</td>
                                <td>{{ $k->jabatan }}</td>
                                <td>
                                    <button onclick="sendWA('{{ $k->nomor_wa }}', '{{ $k->nama_responden }}')"
                                        class="btn btn-wa">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 2L11 13"></path>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                        Kirim WA
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty">Belum ada data responden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function sendWA(phone, name) {
            let template = document.getElementById('messageTemplate').value;
            let message = template.replace('[Nama]', name);

            // Format phone number: remove non-digits, ensure starts with country code
            let formattedPhone = phone.replace(/\D/g, '');
            if (formattedPhone.startsWith('0')) {
                formattedPhone = '62' + formattedPhone.substring(1);
            } else if (!formattedPhone.startsWith('62')) {
                formattedPhone = '62' + formattedPhone;
            }

            let url = `https://wa.me/${formattedPhone}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }

        function filterTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('respondentTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let show = false;
                let tds = tr[i].getElementsByTagName('td');
                for (let j = 0; j < tds.length - 1; j++) {
                    if (tds[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        show = true;
                        break;
                    }
                }
                tr[i].style.display = show ? "" : "none";
            }
        }
    </script>
</body>

</html>