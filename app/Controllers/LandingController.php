<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\OptionWebModel;
use App\Models\InovasiModel;

class LandingController extends BaseController
{
    protected $inovasiModel;

    public function __construct()
    {
        $this->inovasiModel = new InovasiModel();
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

        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis, opd.nama_opd')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left')  // Menggabungkan data OPD
            ->whereNotIn('status', ['tertunda', 'tertolak', 'draf'])
            ->findAll();
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

    public function semuaFoto()
    {

        $galeriModel = new GaleriModel();

        $data = [
            'galeri' => $galeriModel->findAll(),
        ];

        return view('landing_page/galeri/galeri_foto', $data);
    }

    public function semuaVideo()
    {

        $galeriModel = new GaleriModel();

        $data = [
            'galeri' => $galeriModel->findAll(),
        ];

        return view('landing_page/galeri/galeri_video', $data);
    }
}
