<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\OpdModel;
use CodeIgniter\I18n\Time;

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
        $data = [
            'title' => 'List OPD',
            'opd' => $this->opdModel->getOpd(),
        ];
        return view('super_admin/opd/list_opd', $data);
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
            'nama_opd' => 'required|min_length[3]|max_length[100]',
            'alamat'   => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[100]',
            'telepon'  => 'required|numeric|min_length[10]|max_length[15]'
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
                'aksi'             => 'create', // Tindakan yang dilakukan
                'jenis_data'       => 'OPD', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin with ID {$superAdminId} create OPD with ID {$newOpdId}",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            // Selesaikan transaksi
            $db->transComplete();

            // Cek apakah transaksi berhasil
            if ($db->transStatus() === false) {
                // Jika gagal, rollback dan kembali ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal menyimpan data OPD dan mencatat log aktivitas.');
            }

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/superadmin/opd')->with('success', 'Data OPD berhasil ditambahkan dan log tercatat.');
        } else {
            // Jika penyimpanan data OPD gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->opdModel->errors());
        }
    }

    public function editOpd($id)
    {
        $opd = $this->opdModel->getOpd($id);
        $data = [
            'title' => 'List OPD',
            'opd' => $opd,
        ];
        return view('super_admin/opd/edit_opd', $data);
    }

    public function updateOpd($id)
    {

        if (!$this->validate([
            'nama_opd' => 'required|min_length[3]|max_length[100]',
            'alamat'   => 'required|min_length[10]|max_length[255]',
            'email'    => 'required|valid_email|max_length[100]',
            'telepon'  => 'required|numeric|min_length[10]|max_length[15]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $opdModel = new OpdModel();
        $data = [
            'nama_opd' => esc($this->request->getVar('nama_opd')),
            'alamat'   => esc($this->request->getVar('alamat')),
            'email'    => esc($this->request->getVar('email')),
            'telepon'  => esc($this->request->getVar('telepon')),
        ];

        $superAdminId = auth()->user()->id;
        // Proses update data
        if ($opdModel->update($id, $data)) {

            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'update', // Tindakan yang dilakukan
                'jenis_data'      => 'OPD', // Jenis data yang terlibat
                'keterangan'      => "SuperAdmin with ID {$superAdminId} update OPD with ID {$id}",
            ];

            $logModel = new LogAktivitasModel();
            $logModel->save($logData);
            // Jika update berhasil, redirect ke halaman list_opd
            return redirect()->to('/superadmin/opd')->with('success', 'Data berhasil diperbarui!');
        } else {
            // Jika update gagal, tampilkan pesan error dari model
            return redirect()->back()->withInput()->with('errors', $this->opdModel->errors());
        }
    }

    public function deleteOpd($id)
    {
        // Mendapatkan ID superadmin yang sedang login (dari session)
        $superAdminId = auth()->user()->id;

        // Menghapus data OPD berdasarkan ID
        if ($this->opdModel->delete($id)) {

            // Data log aktivitas untuk pencatatan
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'delete', // Tindakan yang dilakukan
                'jenis_data'       => 'OPD', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin with ID {$superAdminId} deleted OPD with ID {$id}",
            ];

            // Simpan log aktivitas
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            // Redirect ke halaman list OPD dengan pesan sukses
            return redirect()->to('/superadmin/opd')->with('success', 'Data OPD berhasil dihapus!');
        } else {
            // Jika penghapusan gagal, tampilkan pesan error dari model
            return redirect()->back()->withInput()->with('errors', $this->opdModel->errors());
        }
    }
}
