<?php

namespace App\Controllers\Superadmin;

use App\Models\LogAktivitasModel;
use App\Controllers\BaseController;
use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\BentukModel;
use App\Models\TahapanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KunjunganModel;

class Dashboard extends BaseController
{

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel(); // Inisialisasi model pengguna
    }

    public function index()
    {
        // Memuat model yang diperlukan
        $kategoriModel = new JenisInovasiModel();
        $bentukModel = new BentukModel();
        $tahapanModel = new TahapanModel();
        $inovasiModel = new InovasiModel();  // Model untuk tabel inovasi (atau yang memiliki kategori)
        $kunjunganModel = new KunjunganModel();  // Model untuk tabel kunjungan

        // Mengambil semua jenis inovasi
        $jenisInovasi = $kategoriModel->findAll();

        // Mengambil jumlah inovasi berdasarkan id_jenis_inovasi
        $kategoriCounts = [];
        foreach ($jenisInovasi as $jenis) {
            $count = $inovasiModel->where('kategori', $jenis['id_jenis_inovasi'])->countAllResults();
            $kategoriCounts[] = [
                'nama_jenis' => $jenis['nama_jenis'],
                'count' => $count,
            ];
        }

        // Mengambil data kunjungan per bulan
        $kunjunganData = $kunjunganModel->select("DATE_FORMAT(tanggal_kunjungan, '%m-%Y') as bulan_tahun, COUNT(*) as jumlah_kunjungan")
            ->groupBy("bulan_tahun")
            ->orderBy("bulan_tahun", "ASC")
            ->findAll();

        // Menyiapkan data untuk chart
        $kunjunganCounts = [
            'labels' => array_column($kunjunganData, 'bulan_tahun'),
            'data' => array_column($kunjunganData, 'jumlah_kunjungan'),
        ];


        // Mengirimkan data ke view
        $data = [
            'title' => 'Dashboard Inovasi',
            'log' => $this->logModel->getLogWithUser(),
            'kategoriOptions' => $kategoriModel->findAll(),  // Opsi kategori yang digunakan di form
            'bentukOptions' => $bentukModel->findAll(),
            'tahapanOptions' => $tahapanModel->findAll(),
            'kategoriCountsJson' => json_encode($kategoriCounts),  // Data untuk chart kategori
            'kunjunganCountsJson' => json_encode($kunjunganCounts),  // Mengirimkan data kunjungan dalam format JSON
        ];

        return view('super_admin/dashboard', $data);
    }
}
