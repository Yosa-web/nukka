<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\JenisInovasiModel;
use App\Models\OptionWebModel;

/**
 * Class BaseController
 */
abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $jenis_inovasi; // Deklarasikan properti untuk jenis inovasi
    protected $nama;          // Properti untuk nama website

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load model JenisInovasiModel untuk mendapatkan semua jenis inovasi
        $jenisInovasiModel = new JenisInovasiModel();
        $this->jenis_inovasi = $jenisInovasiModel->findAll();

        // Load model OptionWebModel untuk mendapatkan key Nama
        $optionWebModel = new OptionWebModel();
        $nama = $optionWebModel->where('key', 'Nama')->first();
        $this->nama = $nama['value'] ?? 'Rumah Inovasi'; // Default jika Nama tidak ada
    }

    public function renderView($view, $data = [])
    {
        // Tambahkan data jenis_inovasi dan nama website ke setiap view
        $data['jenis_inovasi'] = $this->jenis_inovasi;
        $data['namaWebsite'] = $this->nama;

        return view($view, $data);
    }

    /**
     * Redirect user based on their group
     *
     * @return void
     */
}
