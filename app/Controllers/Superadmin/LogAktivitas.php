<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LogAktivitasModel;
class LogAktivitas extends BaseController
{

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel(); // Inisialisasi model pengguna
    }
    public function index()
    {
        $data = [
            'title' => 'List Log Aktivitas',
            'log' => $this->logModel->findAll(),
        ];
        return view('super_admin/log/list_log_aktivitas', $data);    
    }
}