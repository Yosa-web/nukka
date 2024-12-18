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

    public function update($id)
    {
        $galeriModel = new GaleriModel();
        $logModel = new LogAktivitasModel();

        // Ambil data galeri berdasarkan ID
        $galeri = $galeriModel->find($id);

        if (!$galeri) {
            return redirect()->to('/superadmin/galeri')->with('error', 'Galeri tidak ditemukan.');
        }

        // Validasi input
        if (!$this->validate([
            'judul' => 'required',
            'tipe' => 'required|in_list[image,video]',
            'image' => 'is_image[image]|max_size[image,10240]', // max 10MB
            'url' => 'valid_url', // Validasi URL untuk video
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tipe = $this->request->getPost('tipe');
        $pathToSave = '';

        // Jika tipe 'image'
        if ($tipe == 'image') {
            $newImage = $this->request->getFile('image');
            $pathImage = 'assets/uploads/images/galeri/';

            // Jika ada gambar baru
            if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
                // Hapus gambar lama jika ada
                if (file_exists($galeri['url'])) {
                    unlink($galeri['url']);
                }

                // Simpan gambar baru
                $name = $newImage->getRandomName();
                if ($newImage->move($pathImage, $name)) {
                    $pathToSave = $pathImage . $name;
                } else {
                    return redirect()->back()->with('error', 'Gagal mengupload gambar.');
                }
            } else {
                // Tidak ada gambar baru, gunakan gambar lama
                $pathToSave = $galeri['url'];
            }
        }

        // Jika tipe 'video'
        elseif ($tipe == 'video') {
            $urlVideo = $this->request->getPost('url');
            $pathToSave = $urlVideo; // Menyimpan URL video jika tidak ada file baru
        }

        // Data yang akan diperbarui
        $data = [
            'judul' => $this->request->getPost('judul'),
            'url' => $pathToSave,
            'tipe' => $tipe,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Update data galeri
        if ($galeriModel->update($id, $data)) {
            // Logging aktivitas update
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user' => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi' => 'update data',
                'jenis_data' => 'galeri',
                'keterangan' => "SuperAdmin dengan ID {$superAdminId} memperbarui data galeri dengan judul " . $data['judul'],
            ];
            $logModel->save($logData);

            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
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