<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\I18n\Time;

class GaleriImage extends BaseController
{

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

        // Validasi judul: wajib, unik kecuali untuk data yang sedang diedit
        if (!$this->validate([
            'judul' => 'required', // Validasi judul harus unik kecuali yang sedang diedit
            'image' => 'is_image[image]|max_size[image,10240]', // Gambar bersifat opsional
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil nilai judul dan gambar
        $judul = $this->request->getPost('judul');
        $newImage = $this->request->getFile('image');
        $pathImage = 'assets/uploads/images/galeri/';
        $pathToSave = $galeri['url']; // Set default path dengan gambar lama jika tidak ada gambar baru

        // Jika ada gambar baru yang diupload
        if ($newImage && $newImage->isValid() && !$newImage->hasMoved()) {
            // Hapus gambar lama jika ada
            if (file_exists($galeri['url'])) {
                unlink($galeri['url']);
            }

            // Simpan gambar baru
            $name = $newImage->getRandomName();
            if ($newImage->move($pathImage, $name)) {
                $pathToSave = $pathImage . $name; // Update path dengan gambar baru
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload gambar.');
            }
        }

        // Cek apakah judul sudah ada
        $judul = $this->request->getPost('judul');
        if (!$this->isJudulUnique($judul, $id)) {
            return redirect()->back()->withInput()->with('error', 'Judul galeri sudah ada. Mohon gunakan judul yang berbeda.');
        }

        // Data yang akan diperbarui
        $data = [
            'judul' => $judul,
            'url' => $pathToSave, // Menyimpan URL gambar baru atau lama
            'updated_at' => Time::now(),
        ];

        // Update data galeri
        if ($galeriModel->update($id, $data)) {
            return redirect()->to('/superadmin/galeri')->with('success', 'Galeri berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    // Fungsi untuk mengecek apakah judul sudah ada
    private function isJudulUnique($judul, $excludeId = null)
    {
        $galeriModel = new GaleriModel();

        // Cek apakah ada galeri dengan judul yang sama, kecuali ID yang diberikan
        $query = $galeriModel->where('judul', $judul);
        if ($excludeId) {
            $query = $query->where('id_galeri !=', $excludeId); // Mengecualikan ID saat update
        }

        $result = $query->first(); // Mengambil satu data, jika ada yang sama maka return false

        return empty($result); // Jika tidak ada data dengan judul yang sama, return true
    }
}
