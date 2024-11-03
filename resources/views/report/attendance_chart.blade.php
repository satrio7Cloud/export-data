@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Laporan Kehadiran - {{ date('F Y') }}</h1>

        <!-- Tombol Unduh PDF dan Excel -->
        <div class="mb-3">
            <a href="{{ route('attendance.report.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-danger">Unduh PDF</a>
            <a href="{{ route('attendance.report.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}" class="btn btn-success">Unduh Excel</a>
        </div>

        <!-- Tabel untuk Laporan Kehadiran -->
        <table class="table table-bordered">
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
                @foreach ($attendanceReport as $attendance)
                    <tr class="{{ $attendance['status'] === 'Tidak Hadir' ? 'bg-light-red' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $attendance['nama_karyawan'] ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $attendance['tanggal'] ?? '-' }}</td>
                        <td>{{ $attendance['jam_masuk'] ?? '-' }}</td>
                        <td>{{ $attendance['jam_pulang'] ?? '-' }}</td>
                        <td>{{ $attendance['status'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-center">
            {{ $attendanceData->links() }}
        </div> --}}

        <!-- Bagian Grafik -->
        <div>
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>

    <!-- CSS for faded red background -->
    <style>
        .bg-light-red {
            background-color: rgba(255, 99, 132, 0.2); /* Light red color */
        }
    </style>

    <!-- Sertakan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Siapkan data untuk grafik
        const attendanceData = @json($attendanceReport);

        if (attendanceData.length === 0) {
            console.log('Tidak ada data untuk ditampilkan');
        } else {
            const presentCounts = attendanceData.filter(item => item.status === 'Hadir').length;
            const lateCounts = attendanceData.filter(item => item.status === 'Terlambat').length; // Hitung jumlah terlambat
            const izinCounts = attendanceData.filter(item => item.status && item.status.includes('Izin')).length;
            const absentCounts = attendanceData.filter(item => item.status === 'Tidak Hadir').length; // Hitung jumlah tidak hadir

            const data = {
                labels: ['Hadir', 'Terlambat', 'Izin', 'Tidak Hadir'], // Tambahkan label 'Terlambat'
                datasets: [{
                    label: 'Jumlah Karyawan Berdasarkan Status Kehadiran',
                    data: [presentCounts, lateCounts, izinCounts, absentCounts], // Tambahkan jumlah terlambat ke data
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 159, 64, 0.2)', // Warna untuk 'Terlambat'
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)' 
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)', // Border untuk 'Terlambat'
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)' 
                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                }
            };

            const attendanceChart = new Chart(
                document.getElementById('attendanceChart'),
                config
            );
        }
    </script>
@endsection
