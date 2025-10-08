<!DOCTYPE html>
<html>
<head>
    <title>{{ $judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .info-admin {
            margin-bottom: 20px;
            padding: 10px;
            background: #fff;
            border-left: 5px solid #007bff;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>{{ $judul }}</h1>

    <div class="info-admin">
        <p><strong>Admin:</strong> {{ $admin }}</p>
        <p><strong>Waktu Login:</strong> {{ $waktu_login }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nomor Permohonan</th>
                <th>Pemohon</th>
                <th>Jenis Surat</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permohonan as $p)
                <tr>
                    <td>{{ $p['permohonan_id'] }}</td>
                    <td>{{ $p['nomor_permohonan'] }}</td>
                    <td>{{ $p['pemohon_warga_id'] }}</td>
                    <td>{{ $p['jenis_id'] }}</td>
                    <td>{{ $p['tanggal_pengajuan'] }}</td>
                    <td>{{ $p['status'] }}</td>
                    <td>{{ $p['catatan'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
