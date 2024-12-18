<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\Tahapan;
use App\Models\TahapanModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class KelolaTahapan extends BaseController
{

    public function index()
    {
        // Inisialisasi model
        $model = new TahapanModel();

        // Mengambil semua data dari tabel tahapan
        $data['tahapan'] = $model->findAll();

        // Melempar data ke view
        return view('/super_admin/tahapan/tahapan_list', $data);
    }

    public function store()
    {
        $tahapanModel = new \App\Models\TahapanModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Data yang diinput dari form
        $data = [
            'nama_tahapan' => $this->request->getPost('nama_tahapan')
        ];

        // Cek apakah nama jenis yang dimasukkan sudah ada di database
        $existingTahap = $tahapanModel->where('nama_tahapan', $data['nama_tahapan'])->first();
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
        if ($tahapanModel->save($data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newJenisInovasiId = $tahapanModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'create', // Tindakan yang dilakukan
                'jenis_data'       => 'tahapan', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin with ID {$superAdminId} create tahapan Inovasi with name " . $data['nama_tahapan'],
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
            return redirect()->to('/tahapan')->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $tahapanModel->errors());
        }
    }



    public function edit($id)
    {
        $model = new TahapanModel();
        $tahap = $model->find($id); // Ambil data berdasarkan ID

        return view('super_admin/tahapan/tahapan_list', ['tahap' => $tahap]);
    }


    // Update data jenis inovasi di database
    public function update($id)
    {
        $tahapanModel = new \App\Models\TahapanModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Ambil data jenis inovasi berdasarkan ID
        $tahapan = $tahapanModel->find($id);

        // Jika tidak ditemukan, redirect atau tangani error
        if (!$tahapan) {
            return redirect()->to('/tahapan')->with('error', 'tahapan inovasi tidak ditemukan.');
        }

        // Data yang diinput dari form
        $data = [
            'nama_tahapan' => $this->request->getPost('nama_tahapan')
        ];

        // Cek apakah nama jenis yang akan diupdate sudah ada di database
        $existingtahapan = $tahapanModel->where('nama_tahapan', $data['nama_tahapan'])
            ->where('id_tahapan !=', $id) // Pastikan tidak mengecek ID yang sedang diupdate
            ->first();

        if ($existingtahapan) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama tahapan sudah ada, harap gunakan nama lain.');
        }

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($tahapanModel->update($id, $data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newTahapaniId = $tahapanModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'update', // Tindakan yang dilakukan
                'jenis_data'       => 'tahapan', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data tahapan Inovasi dengan nama " . $data['nama_tahapan'],
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
            return redirect()->to('/tahapan')->with('success', 'Data berhasil diubah.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $tahapanModel->errors());
        }
    }



    // Hapus jenis inovasi dari databases
    public function delete($id)
    {
        $tahapanModel = new \App\Models\TahapanModel();
        $logModel = new \App\Models\LogAktivitasModel();

        $jenisInovasi = $tahapanModel->find($id);  // Temukan data sebelum dihapus
        $tahapanModel->delete($id);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Pengecekan apakah data jenis inovasi digunakan di tabel lain
        $relatedTables = [
            'inovasi', // Ganti dengan nama tabel terkait
        ];
    
        foreach ($relatedTables as $table) {
            if (db_connect()->table($table)->where('tahapan', $id)->countAllResults() > 0) {
                return redirect()->back()->with('errors', 'Data tidak dapat dihapus karena digunakan di tabel lain.');
            }
        }

        // Menghapus data jenis inovasi berdasarkan ID
        if ($tahapanModel->delete($id)) {

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'tahapan', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus Tahapan ",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/tahapan')->with('success', 'Data berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $tahapanModel->errors());
        }
    }
}
