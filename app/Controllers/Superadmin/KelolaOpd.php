<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OpdModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Encryption\Encryption;

class KelolaOpd extends BaseController
{
    public $opdModel;
    public $logModel;
    public function __construct()
    {
        $this->opdModel = new OpdModel();
        $this->logModel = new LogAktivitasModel();
    }


    //fungsi untuk menampilkan list data opd yang ada di database
    public function index()
    {
        // Ambil data OPD
        $opds = $this->opdModel->findAll();

        // Ambil encrypter dari service
        $encrypter = \Config\Services::encrypter();

        // Enkripsi ID OPD untuk setiap OPD
        foreach ($opds as $opd) {
            $opd->encrypted_id = bin2hex($encrypter->encrypt(strval($opd->id_opd)));
        }

        // Kirim data OPD ke view
        return view('super_admin/opd/list_opd', ['opds' => $opds]);
    }

    //fungsi untuk menampilkan form create opd
    public function createOpd()
    {

        return view('super_admin/opd/opd');
    }

    // Fungsi untuk menyimpan data OPD ke database
    public function storeOpd()
    {
        // Validasi input form
        if (!$this->validate([
            'nama_opd' => [
                'rules' => 'required|min_length[3]|max_length[100]|is_unique[opd.nama_opd]',
                'errors' => [
                    'required' => 'Nama OPD wajib diisi.',
                    'min_length' => 'Nama OPD minimal 3 karakter.',
                    'max_length' => 'Nama OPD maksimal 100 karakter.',
                    'is_unique' => 'Nama OPD ini sudah terdaftar.',
                ]
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]|max_length[255]',
                'errors' => [
                    'required' => 'Alamat wajib diisi.',
                    'min_length' => 'Alamat minimal 10 karakter.',
                    'max_length' => 'Alamat maksimal 255 karakter.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal 100 karakter.',
                ]
            ],
            'telepon' => [
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi.',
                    'numeric' => 'Nomor telepon hanya boleh berisi angka.',
                    'min_length' => 'Nomor telepon minimal 10 angka.',
                    'max_length' => 'Nomor telepon maksimal 15 angka.',
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Data OPD yang akan disimpan
        $data = [
            'nama_opd' => esc($this->request->getVar('nama_opd')),
            'alamat'   => esc($this->request->getVar('alamat')),
            'email'    => esc($this->request->getVar('email')),
            'telepon'  => esc($this->request->getVar('telepon')),
        ];

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menggunakan transaksi untuk memastikan integritas data
        $db = \Config\Database::connect();
        $db->transStart(); // Memulai transaksi

        // Simpan data OPD ke dalam database
        if ($this->opdModel->save($data)) {
            // Mendapatkan ID OPD yang baru saja ditambahkan
            $newOpdId = $this->opdModel->insertID();



            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'tambah data', // Tindakan yang dilakukan
                'jenis_data'       => 'OPD', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menambahkan data OPD dengan ID {$newOpdId}",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal menyimpan data OPD!');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/superadmin/opd')->with('success', 'Data OPD berhasil ditambahkan.');
        } else {
            // Jika penyimpanan data OPD gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->opdModel->errors());
        }
    }

    public function editOpd($encrypted_id)
    {
        // Ambil encrypter dari service
        $encrypter = \Config\Services::encrypter();

        // Dekripsi ID OPD
        $id_opd = $encrypter->decrypt(hex2bin($encrypted_id));

        // Cari data OPD berdasarkan ID
        $opd = $this->opdModel->find($id_opd);

        // Pastikan OPD ditemukan
        if (!$opd) {
            return redirect()->to('/superadmin/opd')->with('error', 'OPD tidak ditemukan.');
        }

        // Kirim data OPD ke view edit
        $data = [
            'title' => 'Edit OPD',
            'opd'   => $opd,
        ];

        return view('super_admin/opd/edit_opd', $data);
    }







    public function updateOpd()
    {
        $opdModel = new OpdModel();
        $id = $this->request->getPost('id_opd');
        $namaOpd = esc($this->request->getPost('nama_opd'));

        // Cek apakah nama_opd sudah digunakan oleh record lain
        $existingOpd = $opdModel->where('nama_opd', $namaOpd)->where('id_opd !=', $id)->first();

        if ($existingOpd) {
            // Jika nama_opd sudah digunakan, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', ['nama_opd' => 'Nama OPD harus unik.']);
        }

        // Data yang akan diupdate
        $data = [
            'nama_opd' => $namaOpd,
            'alamat'   => esc($this->request->getPost('alamat')),
            'email'    => esc($this->request->getPost('email')),
            'telepon'  => esc($this->request->getPost('telepon')),
        ];

        // Lakukan update data
        if (!$opdModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $opdModel->errors());
        }

        // Ambil ID pengguna (super admin) untuk log aktivitas
        $superAdminId = auth()->user()->id;

        // Simpan log aktivitas
        $logData = [
            'id_user'           => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'              => 'update',
            'jenis_data'        => 'OPD',
            'keterangan'        => "SuperAdmin dengan ID {$superAdminId} memperbarui data OPD dengan ID {$id}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        return redirect()->to('/superadmin/opd')->with('success', 'Data berhasil diperbarui.');
    }



    public function checkDelete($idOpd)
    {
        $inovasiModel = new \App\Models\InovasiModel();
        $usersModel = new \App\Models\UserModel();

        $inovasiCount = $inovasiModel->where('id_opd', $idOpd)->countAllResults();
        $usersCount = $usersModel->where('id_opd', $idOpd)->countAllResults();

        if ($inovasiCount > 0 || $usersCount > 0) {
            return $this->response->setJSON(['canDelete' => false]);
        }
        return $this->response->setJSON(['canDelete' => true]);
    }





    public function deleteOpd()
    {

        // Ambil ID berita dari data POST
        $id = $this->request->getPost('id_opd');

        // Menghapus data OPD berdasarkan ID
        if ($this->opdModel->delete($id)) {
            $superAdminId = auth()->user()->id;


            // Data log aktivitas untuk pencatatan
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'OPD', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data OPD dengan ID {$id}",
            ];

            // Simpan log aktivitas
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            // Redirect ke halaman list OPD dengan pesan sukses
            return redirect()->to('/superadmin/opd')->with('success', 'Data OPD berhasil dihapus.');
        } else {
            // Jika penghapusan gagal, tampilkan pesan error dari model
            return redirect()->back()->withInput()->with('errors', $this->opdModel->errors());
        }
    }
}
