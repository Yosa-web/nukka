<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\BentukModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class KelolaBentuk extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $model = new BentukModel();

        // Mengambil semua data dari tabel tahapan
        $data['bentuk'] = $model->findAll();

        // Melempar data ke view
        return view('/super_admin/bentuk/bentuk_list', $data);
    }

    public function store()
    {
        $bentukModel = new \App\Models\BentukModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Data yang diinput dari form
        $data = [
            'nama_bentuk' => $this->request->getPost('nama_bentuk')
        ];

        // Cek apakah nama jenis yang dimasukkan sudah ada di database
        $existingTahap = $bentukModel->where('nama_bentuk', $data['nama_bentuk'])->first();
        if ($existingTahap) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama tahapan sudah ada, harap gunakan nama lain.');
        }

        // // Insert data jenis inovasi
        // $jenisInovasiModel->insert($data);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($bentukModel->save($data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newBentukId = $bentukModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'create', // Tindakan yang dilakukan
                'jenis_data'       => 'bentuk', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin with ID {$superAdminId} create bentuk Inovasi with name " . $data['nama_bentuk'],
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal menyimpan data bentuk Inovasi.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/bentuk')->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $bentukModel->errors());
        }
    }



    public function edit($id)
    {
        $model = new BentukModel();
        $bentuk = $model->find($id); // Ambil data berdasarkan ID

        return view('super_admin/bentuk/bentuk_list', ['bentuk' => $bentuk]);
    }


    // Update data jenis inovasi di database
    public function update($id)
    {
        $bentukModel = new \App\Models\BentukModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Ambil data jenis inovasi berdasarkan ID
        $bentuk = $bentukModel->find($id);

        // Jika tidak ditemukan, redirect atau tangani error
        if (!$bentuk) {
            return redirect()->to('/tahapan')->with('error', 'tahapan inovasi tidak ditemukan.');
        }

        // Data yang diinput dari form
        $data = [
            'nama_bentuk' => $this->request->getPost('nama_bentuk')
        ];

        // Cek apakah nama jenis yang akan diupdate sudah ada di database
        $existingbentuk = $bentukModel->where('nama_bentuk', $data['nama_bentuk'])
            ->where('id_bentuk !=', $id) // Pastikan tidak mengecek ID yang sedang diupdate
            ->first();

        if ($existingbentuk) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama bentuk sudah ada, harap gunakan nama lain.');
        }

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($bentukModel->update($id, $data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newTahapaniId = $bentukModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'update', // Tindakan yang dilakukan
                'jenis_data'       => 'bentuk', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data bentuk Inovasi dengan nama " . $data['nama_bentuk'],
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal mengedit data tahapan Inovasi.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/bentuk')->with('success', 'Data berhasil diubah.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $bentukModel->errors());
        }
    }

    // Hapus jenis inovasi dari databases
    public function delete($id)
    {
        $bentukModel = new \App\Models\BentukModel();
        $logModel = new \App\Models\LogAktivitasModel();

        $bentuk = $bentukModel->find($id);  // Temukan data sebelum dihapus
        $bentukModel->delete($id);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menghapus data jenis inovasi berdasarkan ID
        if ($bentukModel->delete($id)) {

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'bentuk', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus Bentuk Inovasi ",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/bentuk')->with('success', 'Data berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $bentukModel->errors());
        }
    }
}
