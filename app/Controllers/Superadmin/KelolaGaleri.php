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
        $model = new GaleriModel();
        $data['galeri'] = $model->findAll();

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
        $model = new GaleriModel();
        $data['galeri'] = $model->find($id);

        return view('/super_admin/galeri/edit', $data);
    }

    public function update($id)
    {
        $galeriModel = new \App\Models\GaleriModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Path untuk menyimpan file gambar
        $pathImage = 'assets/uploads/images/galeri/';
        $file = $this->request->getFile('image');
        $url = $this->request->getPost('url');
        $urlToSave = null;

        // Validasi input berdasarkan tipe yang dipilih
        if ($this->request->getPost('tipe') === 'image') {
            if (!$this->validate([
                'judul' => 'required',
                'tipe' => 'required|in_list[image,video]',
                'image' => 'is_image[image]|max_size[image,10240]', // max 10MB
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Jika ada file gambar, proses uploadnya
            if ($file && $file->isValid()) {
                if (!$file->hasMoved()) {
                    $name = $file->getRandomName();
                    if ($file->move($pathImage, $name)) {
                        log_message('debug', 'File image moved successfully: ' . $name);
                        $urlToSave = base_url($pathImage . $name); // URL yang akan disimpan ke database
                    } else {
                        log_message('debug', 'Image move failed: ' . $file->getErrorString());
                        return redirect()->back()->with('error', 'Gagal memindahkan gambar.');
                    }
                }
            }
        }

        // Jika tipe adalah "video", gunakan URL yang diinput
        if ($this->request->getPost('tipe') === 'video') {
            if (!$this->validate([
                'judul' => 'required',
                'tipe' => 'required|in_list[image,video]',
                'url' => 'required|valid_url',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $urlToSave = $url;
        }

        // Jika file tidak ada dan URL tidak ada, gunakan data yang sudah ada di database
        if (!$urlToSave) {
            $existingGaleri = $galeriModel->find($id);
            $urlToSave = $existingGaleri['url'];
        }

        // Data yang akan diperbarui
        $data = [
            'judul'        => $this->request->getPost('judul'),
            'id_user'      => auth()->user()->id,
            'url'          => $urlToSave,
            'tipe'         => $this->request->getPost('tipe'),
            'uploaded_by'  => auth()->user()->id,
            'uploaded_at'  => date('Y-m-d H:i:s'),
        ];

        // Memperbarui data di database
        if ($galeriModel->update($id, $data)) {
            // Logging aktivitas edit
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'update',
                'jenis_data'       => 'galeri',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui data galeri dengan nama " . $data['judul'],
            ];
            $logModel->save($logData);

            // Berhasil, kembali ke halaman galeri dengan pesan sukses
            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil diperbarui.');
        } else {
            // Gagal, kembali ke form dengan pesan error
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
