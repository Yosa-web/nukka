<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BeritaModel;
use App\Models\GaleriModel;
use App\Models\OptionWebModel;

class LandingController extends BaseController
{
    public function index()
    {
        $beritaModel = new BeritaModel();
        $galeriModel = new GaleriModel();
    
        $data = [
            'title' => 'Beranda',
            'beritas' => $beritaModel->getPublishedNews(), // Menggunakan $beritaModel tanpa $this
            'galeri' => $galeriModel->findAll(),           // Menggunakan $galeriModel tanpa $this
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
        return view('landing_page/database_inovasi/database_inovasi');
    }

    public function petaInovasi()
    {
        return view('landing_page/peta_inovasi/peta_inovasi');
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