<?php

namespace App\Controllers\Superadmin;
use App\Models\LogAktivitasModel;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    public function __construct()
    {
        $this->logModel = new LogAktivitasModel(); // Inisialisasi model pengguna
    }

    public function index()
    {
        $data = [
            'title' => 'List Log Aktivitas',
            'log' => $this->logModel->getLogWithUser(),
        ];
        return view('super_admin/dashboard', $data);    
    } 

}
