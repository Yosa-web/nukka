<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\OptionWebModel;
use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;

class LandingController extends BaseController
{
    protected $inovasiModel;
    protected $JenisInovasiModel;


    public function __construct()
    {
        $this->inovasiModel = new InovasiModel();
        $this->JenisInovasiModel = new JenisInovasiModel();
    }

    public function index()
    {
        $beritaModel = new BeritaModel();
        $galeriModel = new GaleriModel();
        $optionWebModel = new OptionWebModel();

        $banner = $optionWebModel->where('key', 'Banner')->first();

        $data = [
            'title' => 'Beranda',
            'beritas' => $beritaModel->getPublishedNews(), // Menggunakan $beritaModel tanpa $this
            'galeri' => $galeriModel->findAll(),           // Menggunakan $galeriModel tanpa $this
            'banner' => $banner,
        ];

        return view('landing_page/beranda/beranda', $data);
    }

    public function tentang()
    {
        $optionWebModel = new OptionWebModel();

        // Mendapatkan data dari tabel option_web dengan key 'Deskripsi'
        $deskripsi = $optionWebModel->where('key', 'Deskripsi')->first(); // Mengambil satu record
        $beritaModel = new BeritaModel();

        $data = [
            'title' => 'Tentang',
            'option' => $deskripsi, // Mengirimkan data tunggal ke view
            'beritas' => $beritaModel->getPublishedNewsNew(), // Menggunakan $beritaModel tanpa $this
        ];

        return view('landing_page/tentang/tentang', $data);
    }


    public function visi()
    {
        return view('landing_page/visi_misi/visi_misi');
    }

    public function databaseInovasi()
    {
        // Mengambil koneksi database
        $litbang = \Config\Database::connect();

        // Mengambil data dengan status terbit untuk tampil di index.php
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, 
            jenis_inovasi.nama_jenis, 
            bentuk.nama_bentuk, 
            tahapan.nama_tahapan, 
            kecamatan.nama_kecamatan, 
            desa.nama_desa, 
            opd.nama_opd,
            users.name as diajukan_oleh') // Menambahkan nama pengguna yang mengajukan
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users untuk mendapatkan name
            ->where('inovasi.status', 'terbit')  // Menampilkan hanya status 'terbit'
            ->orderBy('FIELD(inovasi.status, "terbit", "tertunda", "draf", "revisi", "arsip", "tertolak")') // Mengatur urutan
            ->findAll();

        // Mengambil data jenis_inovasi untuk kategori filter
        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();

        return view('landing_page/database_inovasi/database_inovasi', $data);
    }


    public function petaInovasi()
    {
        // Mengambil data jumlah inovasi per kecamatan
        $inovasiModel = new InovasiModel();
        $data['inovasi'] = $inovasiModel->getJumlahInovasiPerKecamatan();

        return view('landing_page/peta_inovasi/peta_inovasi', $data);
    }

    public function jumlahInovasi()
    {
        $model = new InovasiModel();
        $data = $model->getJumlahInovasiPerKecamatan();

        return $this->response->setJSON($data);
    }

    public function regulasi()
    {
        $optionWebModel = new OptionWebModel();

        // Mendapatkan data dari tabel option_web dengan key 'Deskripsi'
        $deskripsi = $optionWebModel->where('key', 'Regulasi')->first(); // Mengambil satu record

        $data = [
            'title' => 'Tentang',
            'option' => $deskripsi, // Mengirimkan data tunggal ke view
        ];
        return view('landing_page/regulasi/regulasi', $data);
    }

    //berita
    public function semuaBerita()
    {
        $optionWebModel = new OptionWebModel();

        // Mendapatkan data dari tabel option_web dengan key 'Deskripsi'
        $deskripsi = $optionWebModel->where('key', 'Deskripsi')->first(); // Mengambil satu record
        $beritaModel = new BeritaModel();

        $data = [
            'title' => 'Tentang',
            'option' => $deskripsi, // Mengirimkan data tunggal ke view
            'new_berita' => $beritaModel->getPublishedNewsNewOne(), // Menggunakan $beritaModel tanpa $this
            'new_beritas' => $beritaModel->getPublishedNewsNew(), // Menggunakan $beritaModel tanpa $this
            'beritas' => $beritaModel->getPublishedNews(),
        ];

        return view('landing_page/berita/berita_lainnya', $data);
    }
}
