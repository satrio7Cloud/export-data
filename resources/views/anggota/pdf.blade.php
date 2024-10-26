<!DOCTYPE html>
<html>
<head>
    <title>Detail Anggota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #007BFF; /* Warna biru */
        }

        p {
            font-size: 14px;
            line-height: 1.6;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #007BFF; /* Warna biru */
            color: white;
        }

        .container {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Anggota</h1>
        <table class="table">
            <tr>
                <th>Nama</th>
                <td>{{ $anggota->nama_lengkap }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $anggota->alamat }}</td>
            </tr>
            <tr>
                <th>Kota</th>
                <td>{{ $anggota->kota }}</td>
            </tr>
            <tr>
                <th>No Telp</th>
                <td>{{ $anggota->notelp }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>
