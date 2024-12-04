<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DesaModel;
use App\Models\KecamatanModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\I18n\Time;

class DesaController extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $desaModel = new DesaModel();
        $kecamatanModel = new KecamatanModel();
    
        // Mengambil data desa dengan join ke tabel kecamatan
        $data['desa'] = $desaModel
        ->select('desa.id_desa, desa.nama_desa, desa.id_kecamatan, kecamatan.nama_kecamatan')
        ->join('kecamatan', 'kecamatan.id_kecamatan = desa.id_kecamatan')
        ->findAll();
    
    
        // Mengambil data kecamatan
        $data['kecamatan'] = $kecamatanModel->findAll();
    
        // Melempar data ke view
        return view('/super_admin/desa/desa_list', $data);
    }
    
    

    public function store()
    {
        $desaModel = new DesaModel();
        $logModel = new LogAktivitasModel();

        // Data yang diinput dari form
        $data = [
            'nama_desa' => $this->request->getPost('nama_desa'),
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
        ];

        // Cek apakah nama jenis yang dimasukkan sudah ada di database
        $existingDesa = $desaModel->where('nama_desa', $data['nama_desa'])->first();
        if ($existingDesa) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama desa sudah ada, harap gunakan nama lain.');
        }

        // // Insert data jenis inovasi
        // $jenisInovasiModel->insert($data);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($desaModel->save($data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newdesaId = $desaModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'create', // Tindakan yang dilakukan
                'jenis_data'       => 'desa', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} membuat desa dengan nama " . $data['nama_desa'],
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal menyimpan data desa.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/superadmin/desa')->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $desaModel->errors());
        }
    }

    public function edit($id)
    {
        $model = new DesaModel();
    
        // Ambil data desa beserta nama kecamatan melalui join
        $desa = $model
            ->select('desa.*, kecamatan.nama_kecamatan') // Pilih kolom yang dibutuhkan
            ->join('kecamatan', 'kecamatan.id_kecamatan = desa.id_kecamatan') // Join tabel kecamatan
            ->where('desa.id_desa', $id) // Filter berdasarkan ID desa
            ->first(); // Ambil satu data
    
        if (!$desa) {
            // Jika data tidak ditemukan, tampilkan error atau redirect
            return redirect()->to('/superadmin/desa')->with('error', 'Data tidak ditemukan.');
        }
    
        // Kirim data ke view
        return view('super_admin/desa/edit_desa', ['desa' => $desa]);
    }
    

    public function update($id)
    {
        $desaModel = new DesaModel();
        $logModel = new LogAktivitasModel();

        // Ambil data jenis inovasi berdasarkan ID
        $desa = $desaModel->find($id);

        // Jika tidak ditemukan, redirect atau tangani error
        if (!$desa) {
            return redirect()->to('/superadmin/desa')->with('error', 'desa tidak ditemukan.');
        }

        // Data yang diinput dari form
        $data = [
            'nama_desa' => $this->request->getPost('nama_desa'),
            'id_kecamatan' => $this->request->getPost('id_kecamatan')
        ];

        // Cek apakah nama jenis yang akan diupdate sudah ada di database
        $existingDesa = $desaModel->where('nama_desa', $data['nama_desa'])
            ->where('id_desa !=', $id) // Pastikan tidak mengecek ID yang sedang diupdate
            ->first();

        if ($existingDesa) {
            // Jika nama jenis sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama desa sudah ada, harap gunakan nama lain.');
        }

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data jenis inovasi ke dalam database
        if ($desaModel->update($id, $data)) {  // Corrected here
            // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
            $newdesaId = $desaModel->insertID();  // Corrected here

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'update', // Tindakan yang dilakukan
                'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data desa dengan nama " . $data['nama_desa'],
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
            return redirect()->to('/superadmin/desa')->with('success', 'Data berhasil diubah.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $desaModel->errors());
        }
    }

    public function delete($id)
    {
        $desaModel = new DesaModel();
        $logModel = new LogAktivitasModel();

        $desa = $desaModel->find($id);  // Temukan data sebelum dihapus
        $desaModel->delete($id);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menghapus data jenis inovasi berdasarkan ID
        if ($desaModel->delete($id)) {

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data Desa ",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/superadmin/desa')->with('success', 'Data berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $desaModel->errors());
        }
    }
}
