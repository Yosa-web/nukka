<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KunjunganModel;

class KunjunganController extends BaseController
{
    public function getKunjunganData()
    {
        $kunjunganModel = new KunjunganModel();

        // Mengambil jumlah kunjungan per bulan (format bulan-tahun)
        $kunjunganData = $kunjunganModel->select("DATE_FORMAT(tanggal_kunjungan, '%m-%Y') as bulan_tahun, COUNT(*) as jumlah_kunjungan")
            ->groupBy("bulan_tahun")  // Kelompokkan berdasarkan bulan-tahun
            ->orderBy("bulan_tahun", "ASC")  // Urutkan berdasarkan bulan-tahun
            ->findAll();

        // Menyiapkan data untuk chart
        $data = [
            'labels' => array_column($kunjunganData, 'bulan_tahun'),  // Label berupa bulan-tahun
            'data' => array_column($kunjunganData, 'jumlah_kunjungan'),  // Data jumlah kunjungan
        ];

        // Mengirimkan data dalam format JSON
        return $this->response->setJSON($data);
    }
}
