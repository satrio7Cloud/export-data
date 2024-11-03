<!-- resources/views/report/attendance_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kehadiran PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Kehadiran</h2>
    <p>Bulan: {{ $bulan }} - Tahun: {{ $tahun }}</p>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceReport as $index => $attendance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $attendance['nama_karyawan'] ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $attendance['tanggal'] ?? '-' }}</td>
                    <td>{{ $attendance['jam_masuk'] ?? '-' }}</td>
                    <td>{{ $attendance['jam_pulang'] ?? '-' }}</td>
                    <td>{{ $attendance['status'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
