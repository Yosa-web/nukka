<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use App\Controllers\Superadmin\GaleriImage;
use App\Controllers\Superadmin\GaleriVideo;

class KelolaGaleri extends BaseController
{
    public function index()
    {
        $galeriModel = new GaleriModel();
        $data['galeri'] = $galeriModel->findAll();  // Mengambil semua data galeri

        return view('super_admin/galeri/index', $data);
    }

    public function create()
    {
        return view('super_admin/galeri/create');
    }


    public function store()
    {
        $tipe = $this->request->getPost('tipe');

        // Kondisi berdasarkan tipe, arahkan ke controller yang sesuai
        if ($tipe === 'image') {
            $imageController = new GaleriImage();
            return $imageController->storeImage();
        } elseif ($tipe === 'video') {
            $videoController = new GaleriVideo();
            return $videoController->storeVideo();
        }

        return redirect()->back()->with('error', 'Tipe galeri tidak valid.');
    }


    public function edit($id)
    {
        $galeriModel = new GaleriModel();
        $data['galeri'] = $galeriModel->find($id);

        if (!$data['galeri']) {
            return redirect()->to('/superadmin/galeri')->with('error', 'Data galeri tidak ditemukan.');
        }

        // Tampilkan halaman edit berdasarkan tipe (image/video)
        if ($data['galeri']['tipe'] === 'image') {
            return view('super_admin/galeri/edit_image', $data);
        } elseif ($data['galeri']['tipe'] === 'video') {
            return view('super_admin/galeri/edit_video', $data);
        }

        return redirect()->to('/superadmin/galeri');
    }


    public function delete($id)
    {
        $galeriModel = new \App\Models\GaleriModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Ambil data galeri untuk log aktivitas
        $galeri = $galeriModel->find($id);
        $galeriModel->delete($id);

        // Mendapatkan ID pengguna (SuperAdmin) yang sedang login
        $superAdminId = auth()->user()->id;

        // Menghapus data jenis inovasi berdasarkan ID
        if ($galeriModel->delete($id)) {

            // Data untuk log aktivitas
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
                'aksi'             => 'hapus data', // Tindakan yang dilakukan
                'jenis_data'       => 'galeri', // Jenis data yang terlibat
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data galeri ",
            ];

            // Simpan log aktivitas ke dalam database
            $logModel->save($logData);

            // Jika berhasil, kembali ke halaman dashboard dengan pesan sukses
            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil dihapus.');
        } else {
            // Jika penyimpanan data gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }
}
