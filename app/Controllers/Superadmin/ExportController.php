<?php

namespace App\Controllers\Superadmin;

use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\BentukModel;
use App\Models\TahapanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use Dompdf\Dompdf;
use Dompdf\Options;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportController extends BaseController
{
    public function showExportForm()
    {
        $kategoriModel = new JenisInovasiModel();
        $bentukModel = new BentukModel();
        $tahapanModel = new TahapanModel();

        $data = [
            'kategoriOptions' => $kategoriModel->findAll(),
            'bentukOptions' => $bentukModel->findAll(),
            'tahapanOptions' => $tahapanModel->findAll(),
        ];

        return view('super_admin/export/export_view', $data);
    }

    public function exportToCSV()
    {
        $model = new InovasiModel();
    
        // Ambil filter dari input
        $kategori = $this->request->getGet('kategori');
        $tahun = $this->request->getGet('tahun');
        $bentuk = $this->request->getGet('bentuk');
        $tahapan = $this->request->getGet('tahapan');
        $status = $this->request->getGet('status');
    
        // Jika status "semua", set menjadi null atau abaikan filter status
        if ($status == 'semua' || empty($status)) {
            $status = null; // Abaikan filter status
        }
    
        // Definisikan filter
        $filters = [
            'jenis_inovasi' => $kategori,
            'tahun' => $tahun,
            'bentuk' => $bentuk,
            'tahapan' => $tahapan,
            'status' => $status,
        ];
    
        // Ambil data berdasarkan filter
        $data = $model->getAllData($filters);
    
        // Nama file CSV
        $filename = "export_data_" . date('Ymd_His') . ".csv";
    
        // Header CSV (Kolom tabel)
        $header = [
            'Judul',
            'Deskripsi',
            'Kategori',
            'Bentuk',
            'Tahapan',
            'Tanggal Pengajuan',
            'Status',
            'Kecamatan',
            'Desa',
            'OPD',
            'Pesan',
            'URL File',
            'Tahun'
        ];
    
        // Menyiapkan output ke browser
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    
        // Membuka file untuk output (streaming ke browser)
        $file = fopen('php://output', 'w');
    
        // Menulis BOM untuk UTF-8 agar mendukung karakter khusus
        fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
    
        // Tulis header
        fputcsv($file, $header);
    
        // Tulis data
        foreach ($data as $row) {
            fputcsv($file, [
                $row['judul'],
                $row['deskripsi'],
                $row['nama_jenis'],
                $row['nama_bentuk'],
                $row['nama_tahapan'],
                date('Y-m-d', strtotime($row['tanggal_pengajuan'])),
                $row['status'],
                $row['nama_kecamatan'],
                $row['nama_desa'],
                $row['nama_opd'],
                $row['pesan'],
                $row['url_file'],
                $row['tahun'],
            ]);
        }
    
        // Menutup file
        fclose($file);
        exit;
    }
    

    public function exportToPDF()
    {
        $model = new InovasiModel();

        // Ambil filter dari input
        $kategori = $this->request->getGet('kategori');
        $tahun = $this->request->getGet('tahun');
        $bentuk = $this->request->getGet('bentuk');
        $tahapan = $this->request->getGet('tahapan');
        $status = $this->request->getGet('status');

        // Definisikan filter
        $filters = [
            'jenis_inovasi' => $kategori,
            'tahun' => $tahun,
            'bentuk' => $bentuk,
            'tahapan' => $tahapan,
            'status' => $status,
        ];

        // Ambil data berdasarkan filter
        $data = $model->getAllData($filters);

        // Cek jika data kosong
        if (empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
        }

        // HTML untuk tabel PDF
        $html = '
    <h2 style="text-align: center;">Export Data Inovasi</h2>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Bentuk</th>
                <th>Tahapan</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>OPD</th>
                <th>Pesan</th>
                <th>URL File</th>
                <th>Tahun</th>
            </tr>
        </thead>
        <tbody>';

        // Tambahkan data ke tabel
        foreach ($data as $row) {
            $html .= '
            <tr>
                <td>' . htmlspecialchars($row['judul']) . '</td>
                <td>' . htmlspecialchars($row['deskripsi']) . '</td>
                <td>' . htmlspecialchars($row['nama_jenis']) . '</td>
                <td>' . htmlspecialchars($row['nama_bentuk']) . '</td>
                <td>' . htmlspecialchars($row['nama_tahapan']) . '</td>
                <td>' . date('Y-m-d', strtotime($row['tanggal_pengajuan'])) . '</td>
                <td>' . htmlspecialchars($row['status']) . '</td>
                <td>' . htmlspecialchars($row['nama_kecamatan']) . '</td>
                <td>' . htmlspecialchars($row['nama_desa']) . '</td>
                <td>' . htmlspecialchars($row['nama_opd']) . '</td>
                <td>' . htmlspecialchars($row['pesan']) . '</td>
                <td>' . htmlspecialchars($row['url_file']) . '</td>
                <td>' . htmlspecialchars($row['tahun']) . '</td>
            </tr>';
        }

        $html .= '
        </tbody>
    </table>';

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Jika menggunakan URL gambar
        $dompdf = new Dompdf($options);

        // Muat konten HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set ukuran dan orientasi kertas (A4, landscape/portrait)
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Kirim PDF ke browser
        $dompdf->stream('Export_Data_Inovasi_' . date('Ymd_His') . '.pdf', ["Attachment" => true]);
        exit;
    }

    public function exportToExcel()
    {
        $model = new InovasiModel();

        // Ambil filter dari input
        $kategori = $this->request->getGet('kategori');
        $tahun = $this->request->getGet('tahun');
        $bentuk = $this->request->getGet('bentuk');
        $tahapan = $this->request->getGet('tahapan');
        $status = $this->request->getGet('status');

        // Definisikan filter
        $filters = [
            'jenis_inovasi' => $kategori,
            'tahun' => $tahun,
            'bentuk' => $bentuk,
            'tahapan' => $tahapan,
            'status' => $status,
        ];

        // Ambil data berdasarkan filter
        $data = $model->getAllData($filters);

        // Cek jika data kosong
        if (empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diekspor.');
        }

        // Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom Excel
        $header = [
            'Judul',
            'Deskripsi',
            'Kategori',
            'Bentuk',
            'Tahapan',
            'Tanggal Pengajuan',
            'Status',
            'Kecamatan',
            'Desa',
            'OPD',
            'Pesan',
            'URL File',
            'Tahun',
        ];

        // Tulis header ke baris pertama
        $sheet->fromArray($header, null, 'A1');

        // Tulis data mulai dari baris kedua
        $rowNumber = 2;
        foreach ($data as $row) {
            $sheet->fromArray([
                $row['judul'],
                $row['deskripsi'],
                $row['nama_jenis'],
                $row['nama_bentuk'],
                $row['nama_tahapan'],
                date('Y-m-d', strtotime($row['tanggal_pengajuan'])),
                $row['status'],
                $row['nama_kecamatan'],
                $row['nama_desa'],
                $row['nama_opd'],
                $row['pesan'],
                $row['url_file'],
                $row['tahun'],
            ], null, 'A' . $rowNumber);
            $rowNumber++;
        }

        // Nama file Excel
        $filename = 'Export_Data_Inovasi_' . date('Ymd_His') . '.xlsx';

        // Menyiapkan respons HTTP untuk mengunduh file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Tulis file Excel ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
