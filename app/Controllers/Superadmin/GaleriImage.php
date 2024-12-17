<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\I18n\Time;

class GaleriImage extends BaseController
{
    // Fungsi untuk memastikan judul unik
    private function isJudulUnique($judul, $id = null)
    {
        $galeriModel = new GaleriModel();
        $builder = $galeriModel->builder();

        // Jika $id diberikan, kita mengecualikan galeri yang sedang diperbarui
        if ($id) {
            $builder->where('id_galeri !=', $id);
        }

        $builder->where('judul', $judul);
        $existing = $builder->countAllResults();

        return $existing === 0; // Jika tidak ada judul yang sama, return true
    }

    public function storeImage()
    {
        $galeriModel = new \App\Models\GaleriModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Path untuk menyimpan file gambar
        $pathImage = 'assets/uploads/images/galeri/';
        $file = $this->request->getFile('image'); // Mendapatkan file dari request

        // Validasi form
        if (!$this->validate([
            'judul' => 'required',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,10240]', // max 10MB
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Pengecekan apakah judul sudah ada
        $judul = $this->request->getPost('judul');
        if (!$this->isJudulUnique($judul)) {
            return redirect()->back()->withInput()->with('error', 'Judul galeri sudah ada. Mohon gunakan judul yang berbeda.');
        }

        // Jika file gambar ada dan valid
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName(); // Dapatkan nama acak untuk file
            if ($file->move($pathImage, $name)) {
                // File berhasil dipindahkan, hanya menyimpan path relatif tanpa base_url
                $pathToSave = $pathImage . $name;
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload gambar atau gambar tidak valid.');
        }

        // Data yang akan disimpan
        $data = [
            'judul'        => $judul,
            'id_user'      => auth()->user()->id,
            'url'          => $pathToSave,  // Simpan path relatif saja
            'tipe'         => 'image',
            'uploaded_by'  => auth()->user()->id,
            'uploaded_at'  => date('Y-m-d H:i:s'),
        ];

        // Menyimpan data ke database
        if ($galeriModel->save($data)) {
            // Logging aktivitas tambah
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'tambah data',
                'jenis_data'       => 'galeri',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menambahkan data galeri dengan nama " . $data['judul'],
            ];
            $logModel->save($logData);

            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    public function updateImage($id)
    {
        $galeriModel = new GaleriModel();

        // Ambil data galeri berdasarkan ID
        $galeri = $galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/superadmin/galeri')->with('error', 'Galeri tidak ditemukan.');
        }

        // Validasi input
        if (!$this->validate([
            'judul' => 'required',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,10240]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Pengecekan apakah judul sudah ada
        $judul = $this->request->getPost('judul');
        if (!$this->isJudulUnique($judul, $id)) {
            return redirect()->back()->withInput()->with('error', 'Judul galeri sudah ada. Mohon gunakan judul yang berbeda.');
        }

        $newImage = $this->request->getFile('image');
        $pathImage = 'assets/uploads/images/galeri/';
        $pathToSave = '';

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
            // Jika tidak ada gambar baru, gunakan gambar lama
            $pathToSave = $galeri['url'];
        }

        // Data yang akan diperbarui
        $data = [
            'judul' => $judul,
            'url' => $pathToSave,
            'updated_at' => Time::now(),
        ];

        // Update data galeri
        if ($galeriModel->update($id, $data)) {
            return redirect()->to('/superadmin/galeri')->with('success', 'Gambar berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }
}
