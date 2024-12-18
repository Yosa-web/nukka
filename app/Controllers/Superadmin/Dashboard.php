<?php

namespace App\Controllers\Superadmin;
use App\Models\LogAktivitasModel;
use App\Controllers\BaseController;
use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\BentukModel;
use App\Models\TahapanModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel(); // Inisialisasi model pengguna
    }

    public function index()
    {
        $kategoriModel = new JenisInovasiModel();
        $bentukModel = new BentukModel();
        $tahapanModel = new TahapanModel();
    
        $data = [
            'title' => 'List Log Aktivitas',
            'log' => $this->logModel->getLogWithUser(),
            'kategoriOptions' => $kategoriModel->findAll(),
            'bentukOptions' => $bentukModel->findAll(),
            'tahapanOptions' => $tahapanModel->findAll(),
        ];
    
        return view('super_admin/dashboard', $data);    
    }

}
