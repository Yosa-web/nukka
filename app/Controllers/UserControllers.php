<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserControllers extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $userModel = new UserModel();

        // Mengambil semua data dari tabel users
        $data['jenis_inovasi'] = $userModel->findAll();

        // Melempar data ke view
        return view('users_list', $data);
    }

    public function create()
    {
        // Memuat view untuk form input
        return view('create_user');
    }

    public function store()
    {
        // Inisialisasi model
        $userModel = new UserModel();

        // Mengambil data dari request
        $data = [
            'id' => $this->request->getPost('id'),
            'nama' => $this->request->getPost('nama')
        ];

        // Menyimpan data ke database
        $userModel->insert($data);

        // Redirect setelah menyimpan data
        return redirect()->to('/users');
    }
}
