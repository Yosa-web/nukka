<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JenisInovasiModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\I18n\Time;

class KelolaJenisInovasi extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $model = new JenisInovasiModel();

        // Mengambil semua data dari tabel jenis_inovasi
        $data['jenis_inovasi'] = $model->findAll();

        // Melempar data ke view
        return view('/super_admin/jenis_inovasi/jenis_inovasi_list', $data);
    }

    public function store()
    {
        $jenisInovasiModel = new \App\Models\JenisInovasiModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Data yang diinput dari form
        $data = [
            'nama_jenis' => $this->request->getPost('nama_jenis')
        ];

        // Cek apakah nama jenis yang dimasukkan sudah ada di database
        $existingJenis = $jenisInovasiModel->where('nama_jenis', $data['nama_jenis'])->first();
        if ($existingJenis) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama jenis sudah ada, harap gunakan nama lain.');
        }

        // // Insert data jenis inovasi
        // $jenisInovasiModel->insert($data);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($jenisInovasiModel->save($data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newJenisInovasiId = $jenisInovasiModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'create', // Tindakan yang dilakukan
                'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin with ID {$superAdminId} create Jenis Inovasi with name " . $data['nama_jenis'],
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal menyimpan data Jenis Inovasi.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/jenis_inovasi')->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $jenisInovasiModel->errors());
        }
    }



    public function edit($id)
    {
        $model = new JenisInovasiModel();
        $jenis = $model->find($id); // Ambil data berdasarkan ID

        return view('super_admin/jenis_inovasi/jenis_inovasi_list', ['jenis' => $jenis]);
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

        // Cek apakah nama jenis yang akan diupdate sudah ada di database
        $existingJenis = $jenisInovasiModel->where('nama_jenis', $data['nama_jenis'])
            ->where('id_jenis_inovasi !=', $id) // Pastikan tidak mengecek ID yang sedang diupdate
            ->first();

        if ($existingJenis) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama jenis sudah ada, harap gunakan nama lain.');
        }

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($jenisInovasiModel->update($id, $data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newJenisInovasiId = $jenisInovasiModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'update', // Tindakan yang dilakukan
                'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data Jenis Inovasi dengan nama " . $data['nama_jenis'],
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal mengedit data Jenis Inovasi.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/jenis_inovasi')->with('success', 'Data berhasil diubah.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $jenisInovasiModel->errors());
        }
    }



    // Hapus jenis inovasi dari databases
    public function delete($id)
    {
        $jenisInovasiModel = new \App\Models\JenisInovasiModel();
        $logModel = new \App\Models\LogAktivitasModel();

        $jenisInovasi = $jenisInovasiModel->find($id);  // Temukan data sebelum dihapus
        $jenisInovasiModel->delete($id);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menghapus data jenis inovasi berdasarkan ID
        if ($jenisInovasiModel->delete($id)) {

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data Jenis Inovasi ",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/jenis_inovasi')->with('success', 'Data berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $jenisInovasiModel->errors());
        }
    }
}
