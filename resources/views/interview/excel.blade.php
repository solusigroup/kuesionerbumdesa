<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ekspor Transkrip Wawancara</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th colspan="8" style="font-size: 14px; font-weight: bold; text-align: center; height: 30px;">
                    LAMPIRAN METODOLOGI: TRANSKRIP WAWANCARA MENDALAM (IN-DEPTH INTERVIEW)
                </th>
            </tr>
            <tr>
                <th style="background-color: #d3d3d3; font-weight: bold;">No</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">Nama BUMDesa</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">Nama Narasumber</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">Jabatan</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">X1: Kapasitas Manajerial</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">X2: Tekanan Budaya Lokal</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">X3: Kelemahan Tata Kelola</th>
                <th style="background-color: #d3d3d3; font-weight: bold;">Y: Kualitas Pelaporan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $index => $log)
            <tr>
                <td valign="top" align="center">{{ $index + 1 }}</td>
                <td valign="top">{{ $log->nama_bumdesa }}</td>
                <td valign="top">{{ $log->nama_narasumber }}</td>
                <td valign="top">{{ $log->jabatan }}</td>
                <td valign="top">{!! nl2br(e($log->transkrip_kapasitas_x1)) !!}</td>
                <td valign="top">{!! nl2br(e($log->transkrip_budaya_x2)) !!}</td>
                <td valign="top">{!! nl2br(e($log->transkrip_tata_kelola_x3)) !!}</td>
                <td valign="top">{!! nl2br(e($log->transkrip_pelaporan_y)) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
