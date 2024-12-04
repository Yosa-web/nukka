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
    public function index($id)
    {
        // Inisialisasi model
        $desaModel = new DesaModel();
        $kecamatanModel = new KecamatanModel();
    
        // Mengambil data kecamatan berdasarkan ID
        $data['kecamatan'] = $kecamatanModel->find($id);
        if (!$data['kecamatan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kecamatan tidak ditemukan');
        }
    
        // Mengambil data desa berdasarkan ID kecamatan
        $data['desa'] = $desaModel
            ->select('desa.id_desa, desa.nama_desa, desa.id_kecamatan, kecamatan.nama_kecamatan')
            ->join('kecamatan', 'kecamatan.id_kecamatan = desa.id_kecamatan')
            ->where('desa.id_kecamatan', $id)
            ->findAll();
    
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
    
        // Cek apakah nama desa yang dimasukkan sudah ada di database untuk kecamatan yang sama
        $existingDesa = $desaModel
            ->where('nama_desa', $data['nama_desa'])
            ->where('id_kecamatan', $data['id_kecamatan'])
            ->first();
    
        if ($existingDesa) {
            // Jika nama desa sudah ada, kembalikan error
            return redirect()->back()->withInput()->with('errors', 'Nama desa sudah ada di kecamatan ini, harap gunakan nama lain.');
        }
    
        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;
    
        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi
    
        // Simpan data desa ke dalam database
        if ($desaModel->save($data)) {
            // Mendapatkan ID desa yang baru saja ditambahkan
            $newDesaId = $desaModel->insertID();
    
            // Data untuk log aktivitas
            $logData = [
                'id_user'           => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'              => 'create', // Tindakan yang dilakukan
                'jenis_data'        => 'desa', // Jenis data yang terlibat
                'keterangan'        => "SuperAdmin dengan ID {$superAdminId} membuat desa dengan nama '{$data['nama_desa']}' di kecamatan dengan ID {$data['id_kecamatan']}.",
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
    
            // Jika berhasil, kembali ke halaman daftar desa dengan pesan sukses
            return redirect()->to("/superadmin/desa/{$data['id_kecamatan']}")->with('success', 'Data desa berhasil ditambahkan.');
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

    // Ambil data desa berdasarkan ID
    $desa = $desaModel->find($id);
    if (!$desa) {
        return redirect()->back()->with('error', 'Desa tidak ditemukan.');
    }

    // Ambil data yang diinput dari form (nama desa)
    $data = [
        'nama_desa' => $this->request->getPost('nama_desa'),
        'id_kecamatan' => $this->request->getPost('id_kecamatan') // ID kecamatan tetap dikirim meskipun tidak bisa diedit
    ];

    // Validasi jika nama desa sudah ada
    $existingDesa = $desaModel->where('nama_desa', $data['nama_desa'])->where('id_desa !=', $id)->first();
    if ($existingDesa) {
        return redirect()->back()->withInput()->with('errors', 'Nama desa sudah ada, harap gunakan nama lain.');
    }

    // Lakukan update data desa
    if ($desaModel->update($id, $data)) {
        return redirect()->back()->with('success', 'Data desa berhasil diperbarui.');
    } else {
        return redirect()->back()->withInput()->with('errors', 'Gagal memperbarui data desa.');
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
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $desaModel->errors());
        }
    }
}
