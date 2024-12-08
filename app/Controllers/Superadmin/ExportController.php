<?php
namespace App\Controllers\Superadmin;

use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\BentukModel;
use App\Models\TahapanModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

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
    }public function exportToCSV()
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
            'status' => $status, // Tambahkan filter status
        ];
    
        // Ambil data berdasarkan filter
        $data = $model->getAllData($filters);

    
        // Nama file CSV
        $filename = "export_data_" . date('Ymd_His') . ".csv";
    
        // Header CSV
        $header = [
            'Judul', 'Deskripsi', 'Kategori', 'Bentuk', 'Tahapan', 'Tanggal Pengajuan', 'Status', 'Kecamatan', 'Desa', 'OPD', 'Pesan', 'URL File', 'Tahun'
        ];
    
        // Buat file CSV
        $file = fopen('php://output', 'w');
    
        // Set header HTTP untuk unduhan file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    
        // Tulis header ke file CSV
        fputcsv($file, $header);
    
        // Tulis data ke file CSV
        foreach ($data as $row) {
            fputcsv($file, [
                $row['judul'],
                $row['deskripsi'],
                $row['nama_jenis'], // Ubah ke kolom deskriptif
                $row['nama_bentuk'], // Ubah ke kolom deskriptif
                $row['nama_tahapan'], // Ubah ke kolom deskriptif
                $row['tanggal_pengajuan'],
                $row['status'],
                $row['nama_kecamatan'], // Ubah ke kolom deskriptif
                $row['nama_desa'], // Ubah ke kolom deskriptif
                $row['nama_opd'], // Tetap id_opd jika ini memang ID
                $row['pesan'],
                $row['url_file'],
                $row['tahun'],
            ]);
        }
        
    
        fclose($file);
        exit;
    }
    
    
}
