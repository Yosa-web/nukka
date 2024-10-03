<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisInovasiModel;
use CodeIgniter\HTTP\ResponseInterface;

class SuperAdminController extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $model = new JenisInovasiModel();

        // Mengambil semua data dari tabel jenis_inovasi
        $data['jenis_inovasi'] = $model->findAll();

        // Melempar data ke view
        return view('jenis_inovasi_list', $data);
    }

    public function create()
    {
        // Memuat view untuk form input
        return view('create_jenis_inovasi');
    }

    public function store()
    {
        $jenisInovasiModel = new \App\Models\JenisInovasiModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Data yang diinput dari form
        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis')
        ];

        // Insert data jenis inovasi
        $jenisInovasiModel->insert($data);

        // Ambil pengguna yang sedang login
        $user = auth()->user();  // Atau gunakan session()->get('id_user')

        if (!empty($user->id)) {
            // Log aktivitas jika id_user tidak null
            $logModel->logActivity(
                $user->id,  // Ambil ID pengguna yang sedang login
                'Create',   // Aksi
                'Jenis Inovasi',  // Jenis data
                'Menambahkan jenis inovasi baru: ' . $data['nama_jenis']  // Keterangan
            );
        } else {
            // Jika id_user null, tambahkan log atau tangani error
            log_message('error', 'ID User tidak ditemukan saat mencoba menyimpan log aktivitas.');
        }

        // Redirect setelah data disimpan
        return redirect()->to('/jenis_inovasi');
    }


    // Tampilkan form untuk mengedit jenis inovasi
    public function edit($id)
    {
        $model = new JenisInovasiModel();
        $data['jenis_inovasi'] = $model->find($id);

        return view('edit_jenis_inovasi', $data);
    }

    // Update data jenis inovasi di database
    public function update($id)
    {
        $jenisInovasiModel = new \App\Models\JenisInovasiModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Ambil data jenis inovasi berdasarkan ID
        $jenisInovasi = $jenisInovasiModel->find($id);

        // Jika tidak ditemukan, redirect atau tangani error
        if (!$jenisInovasi) {
            return redirect()->to('/jenis_inovasi')->with('error', 'Jenis inovasi tidak ditemukan.');
        }

        // Data yang diinput dari form
        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis')
        ];

        // Update data jenis inovasi
        $jenisInovasiModel->update($id, $data);

        // Ambil pengguna yang sedang login
        $user = auth()->user();  // Ambil objek pengguna yang sedang login

        if (!empty($user->id)) {
            // Log aktivitas jika id_user tersedia
            $logModel->logActivity(
                $user->id,  // Ambil ID pengguna yang sedang login
                'Update',   // Aksi
                'Jenis Inovasi',  // Jenis data
                'Mengupdate jenis inovasi dengan ID: ' . $id . ', nama baru: ' . $data['nama_jenis']  // Keterangan
            );
        } else {
            // Tangani jika ID user tidak ditemukan
            log_message('error', 'ID User tidak ditemukan saat mencoba menyimpan log aktivitas.');
        }

        // Redirect setelah data diupdate
        return redirect()->to('/jenis_inovasi')->with('success', 'Jenis inovasi berhasil diupdate.');
    }



    // Hapus jenis inovasi dari databases
    public function delete($id)
    {
        $jenisInovasiModel = new \App\Models\JenisInovasiModel();
        $logModel = new \App\Models\LogAktivitasModel();

        $jenisInovasi = $jenisInovasiModel->find($id);  // Temukan data sebelum dihapus
        $jenisInovasiModel->delete($id);

        // Ambil pengguna yang sedang login
        $user = auth()->user();  // Ambil objek pengguna yang sedang login

        if (!empty($user->id)) {
            // Log aktivitas jika id_user tersedia
            $logModel->logActivity(
                $user->id,  // Ambil ID pengguna yang sedang login
                'Delete',   // Aksi
                'Jenis Inovasi',  // Jenis data
                'Menghapus jenis inovasi dengan ID: ' . $id . ', nama: ' . $jenisInovasi['nama_jenis']  // Keterangan
            );
        } else {
            // Tangani jika ID user tidak ditemukan
            log_message('error', 'ID User tidak ditemukan saat mencoba menyimpan log aktivitas.');
        }

        return redirect()->to('/jenis_inovasi');
    }
}
