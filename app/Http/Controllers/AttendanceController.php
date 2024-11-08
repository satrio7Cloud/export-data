<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\Libur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan bulan dan tahun dari request atau menggunakan bulan dan tahun sekarang
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        // Ambil data kehadiran berdasarkan bulan dan tahun
        $attendanceData = Absensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Ambil data izin berdasarkan bulan dan tahun
        $izinData = Izin::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Ambil semua karyawan
        $allKaryawan = Karyawan::all();

        // Gabungkan data untuk laporan
        $attendanceReport = $this->generateAttendanceReport($attendanceData, $izinData, $allKaryawan);

        return view('report.attendance_chart', compact('attendanceReport', 'bulan', 'tahun'));
    }

    private function generateAttendanceReport($attendanceData, $izinData, $allKaryawan)
    {
        $report = [];
        $attendedKaryawanIds = $attendanceData->pluck('id_karyawan')->toArray();
        $izinKaryawanIds = $izinData->pluck('id_karyawan')->toArray();

        // Get all holidays within the month
        $holidays = Libur::whereMonth('tanggal', Carbon::now()->month)
            ->pluck('tanggal')
            ->toArray();

        // Proses data kehadiran
        foreach ($attendanceData as $attendance) {
            $status = 'Hadir'; // Default status

            // Ambil jam masuk dari shift yang terkait
            $shift = $attendance->shift;
            $cutoffTime = $shift ? $shift->jam_masuk : '07:00:00';

            // Cek apakah karyawan terlambat
            if ($attendance->jam_masuk > $cutoffTime) {
                $status = 'Terlambat';
            }

            $report[] = [
                'id_karyawan' => $attendance->id_karyawan,
                'nama_karyawan' => $attendance->karyawan->nama ?? 'Tidak Diketahui',
                'tanggal' => $attendance->tanggal,
                'jam_masuk' => $attendance->jam_masuk,
                'jam_pulang' => $attendance->jam_pulang,
                'status' => $status
            ];
        }

        // Proses data izin
        foreach ($izinData as $izin) {
            $report[] = [
                'id_karyawan' => $izin->id_karyawan,
                'nama_karyawan' => $izin->karyawan ? $izin->karyawan->nama : 'Tidak Diketahui',
                'tanggal' => $izin->tanggal,
                'jam_masuk' => null,
                'jam_pulang' => null,
                'status' => 'Izin: ' . $izin->alasan
            ];
        }

        return $report;
    }
    
    // Metode untuk menghasilkan laporan PDF
    public function generatePdf(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $attendanceData = Absensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $izinData = Izin::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $allKaryawan = Karyawan::all();
        $attendanceReport = $this->generateAttendanceReport($attendanceData, $izinData, $allKaryawan);

        $pdf = PDF::loadView('report.attendance_pdf', compact('attendanceReport', 'bulan', 'tahun'));
        return $pdf->download('laporan_absensi_' . $bulan . '_' . $tahun . '.pdf');
    }

    // Metode untuk menghasilkan laporan Excel
    public function generateExcel(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $attendanceData = Absensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $izinData = Izin::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $allKaryawan = Karyawan::all();

        $attendanceReport = $this->generateAttendanceReport($attendanceData, $izinData, $allKaryawan);

        // Buat Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'ID Karyawan');
        $sheet->setCellValue('B1', 'Nama Karyawan');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Jam Masuk');
        $sheet->setCellValue('E1', 'Jam Pulang');
        $sheet->setCellValue('F1', 'Status');

        // Isi data
        $row = 2;
        foreach ($attendanceReport as $item) {
            $sheet->setCellValue('A' . $row, $item['id_karyawan']);
            $sheet->setCellValue('B' . $row, $item['nama_karyawan']);
            $sheet->setCellValue('C' . $row, $item['tanggal']);
            $sheet->setCellValue('D' . $row, $item['jam_masuk']);
            $sheet->setCellValue('E' . $row, $item['jam_pulang']);
            $sheet->setCellValue('F' . $row, $item['status']);
            $row++;
        }

        // Buat file Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'laporan_absensi_' . $bulan . '_' . $tahun . '.xlsx';
        $writer->save($fileName);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
