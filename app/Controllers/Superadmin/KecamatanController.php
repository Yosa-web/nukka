<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KecamatanModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\I18n\Time;

class KecamatanController extends BaseController
{
        public function index()
        {
            // Inisialisasi model
            $model = new KecamatanModel();
    
            // Mengambil semua data dari tabel jenis_inovasi
            $data['kecamatan'] = $model->findAll();
    
            // Melempar data ke view
            return view('/super_admin/kecamatan/kecamatan_list', $data);
        }

        public function store()
        {
            $kecamatanModel = new KecamatanModel();
            $logModel = new LogAktivitasModel();
    
            // Data yang diinput dari form
            $data = [
                'nama_kecamatan' => $this->request->getPost('nama_kecamatan')
            ];
    
            // Cek apakah nama jenis yang dimasukkan sudah ada di database
            $existingKecamatan = $kecamatanModel->where('nama_kecamatan', $data['nama_kecamatan'])->first();
            if ($existingKecamatan) {
                // Jika nama jenis sudah ada, kembalikan error
                return redirect()->back()->withInput()->with('errors', 'Nama kecamatan sudah ada, harap gunakan nama lain.');
            }
    
            // // Insert data jenis inovasi
            // $jenisInovasiModel->insert($data);
    
            // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
            $superAdminId = auth()->user()->id;
    
            // Menggunakan transaksi untuk memastikan integritas data
            $db = \Config\Database::connect();
            $db->transStart(); // Memulai transaksi
    
            // Simpan data jenis inovasi ke dalam database
            if ($kecamatanModel->save($data)) {  // Corrected here
                // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
                $newKecamatanId = $kecamatanModel->insertID();  // Corrected here
    
                // Data untuk log aktivitas
                $logData = [
                    'id_user'          => $superAdminId,
                    'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                    'aksi'             => 'create', // Tindakan yang dilakukan
                    'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                    'keterangan'       => "SuperAdmin dengan ID {$superAdminId} membuat kecamatan dengan nama " . $data['nama_kecamatan'],
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
                return redirect()->to('/superadmin/kecamatan')->with('success', 'Data berhasil ditambahkan.');
            } else {
                // Jika penyimpanan data gagal, kembali ke form dengan pesan error
                return redirect()->back()->withInput()->with('errors', $kecamatanModel->errors());
            }
        }

        public function edit($id)
        {
            $model = new kecamatanModel();
            $kecamatan = $model->find($id); // Ambil data berdasarkan ID
    
            return view('super_admin/kecamatan/kecamatan_list', ['jenis' => $kecamatan]);
        }

        public function update($id)
        {
            $kecamatanModel = new KecamatanModel();
            $logModel = new LogAktivitasModel();
    
            // Ambil data jenis inovasi berdasarkan ID
            $kecamatan = $kecamatanModel->find($id);
    
            // Jika tidak ditemukan, redirect atau tangani error
            if (!$kecamatan) {
                return redirect()->to('/superadmin/kecamatan')->with('error', 'Jenis inovasi tidak ditemukan.');
            }
    
            // Data yang diinput dari form
            $data = [
                'nama_kecamatan' => $this->request->getPost('nama_kecamatan')
            ];
    
            // Cek apakah nama jenis yang akan diupdate sudah ada di database
            $existingKecamatan = $kecamatanModel->where('nama_kecamatan', $data['nama_kecamatan'])
                ->where('id_kecamatan !=', $id) // Pastikan tidak mengecek ID yang sedang diupdate
                ->first();
    
            if ($existingKecamatan) {
                // Jika nama jenis sudah ada, kembalikan error
                return redirect()->back()->withInput()->with('errors', 'Nama jenis sudah ada, harap gunakan nama lain.');
            }
    
            // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
            $superAdminId = auth()->user()->id;
    
            // Menggunakan transaksi untuk memastikan integritas data
            $db = \Config\Database::connect();
            $db->transStart(); // Memulai transaksi
    
            // Simpan data jenis inovasi ke dalam database
            if ($kecamatanModel->update($id, $data)) {  // Corrected here
                // Mendapatkan ID jenis inovasi yang baru saja ditambahkan
                $newKecamatanId = $kecamatanModel->insertID();  // Corrected here
    
                // Data untuk log aktivitas
                $logData = [
                    'id_user'          => $superAdminId,
                    'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                    'aksi'             => 'update', // Tindakan yang dilakukan
                    'jenis_data'       => 'jenis inovasi', // Jenis data yang terlibat
                    'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data Jenis Inovasi dengan nama " . $data['nama_kecamatan'],
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
                return redirect()->to('/superadmin/kecamatan')->with('success', 'Data berhasil diubah.');
            } else {
                // Jika penyimpanan data gagal, kembali ke form dengan pesan error
                return redirect()->back()->withInput()->with('errors', $kecamatanModel->errors());
            }
        }

        public function delete($id)
        {
            $kecamatanModel = new \App\Models\KecamatanModel();
            $desaModel = new \App\Models\DesaModel();
            $logModel = new \App\Models\LogAktivitasModel();
        
            // Cek apakah id_kecamatan ada di tabel desa
            $desa = $desaModel->where('id_kecamatan', $id)->first();
            if ($desa) {
                // Jika ada desa yang terkait, jangan hapus dan beri pesan error
                return redirect()->back()->with('errors', 'Data Kecamatan tidak dapat dihapus karena ada desa yang terkait.');
            }
        
            // Temukan data kecamatan sebelum dihapus
            $kecamatan = $kecamatanModel->find($id);
            
            if (!$kecamatan) {
                // Jika kecamatan tidak ditemukan, beri pesan error
                return redirect()->back()->with('error', 'Kecamatan tidak ditemukan.');
            }
        
            // Hapus data kecamatan
            if ($kecamatanModel->delete($id)) {
                // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
                $superAdminId = auth()->user()->id;
        
                // Data untuk log aktivitas
                $logData = [
                    'id_user'          => $superAdminId,
                    'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                    'aksi'             => 'hapus data',
                    'jenis_data'       => 'kecamatan',
                    'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data Kecamatan dengan ID {$id}",
                ];
        
                // Simpan log aktivitas ke dalam database
                $logModel->save($logData);
        
                // Jika berhasil, kembali ke halaman daftar kecamatan dengan pesan sukses
                return redirect()->to('/superadmin/kecamatan')->with('success', 'Data Kecamatan berhasil dihapus.');
            } else {
                // Jika penyimpanan data gagal, kembali ke form dengan pesan error
                return redirect()->back()->withInput()->with('error', 'Gagal menghapus data Kecamatan.');
            }
        }

        

}
