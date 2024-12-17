<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LogAktivitasModel;
use CodeIgniter\I18n\Time;

class GaleriVideo extends BaseController
{
    public function storeVideo()
    {
        $galeriModel = new \App\Models\GaleriModel();
        $logModel = new \App\Models\LogAktivitasModel();

        if (!$this->validate([
            'judul' => 'required',
            'url'   => 'required|valid_url',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil data dari request POST
        $judul = $this->request->getPost('judul');
        $url = $this->request->getPost('url');

        // Cek apakah judul video sudah ada
        if (!$this->isJudulUnique($judul)) {
            return redirect()->back()->withInput()->with('error', 'Judul video sudah ada. Mohon gunakan judul yang berbeda.');
        }

        // Data yang akan disimpan
        $data = [
            'judul'        => $this->request->getPost('judul'),
            'id_user'      => auth()->user()->id,
            'url'          => $this->request->getPost('url'),
            'tipe'         => 'video',
            'uploaded_by'  => auth()->user()->id,
            'uploaded_at'  => date('Y-m-d H:i:s'),
        ];

        // Menyimpan data baru ke database
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

            // Berhasil, kembali ke halaman galeri dengan pesan sukses
            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil ditambahkan.');
        } else {
            // Gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    public function updateVideo($id)
    {
        $galeriModel = new GaleriModel();

        // Ambil data galeri berdasarkan ID
        $galeri = $galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/superadmin/galeri')->with('error', 'Galeri tidak ditemukan.');
        }

        // Validasi input untuk URL video
        if (!$this->validate([
            'judul' => 'required',
            'url' => 'valid_url|required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = $this->request->getPost('judul');
        $urlVideo = $this->request->getPost('url');

        // Cek apakah judul video sudah ada (kecuali judul video yang sedang diedit)
        if (!$this->isJudulUnique($judul, $id)) {
            return redirect()->back()->withInput()->with('error', 'Judul video sudah ada. Mohon gunakan judul yang berbeda.');
        }

        // Data yang akan diperbarui
        $data = [
            'judul' => $this->request->getPost('judul'),
            'url' => $urlVideo,
            'updated_at' => Time::now(),
        ];

        // Update data galeri
        if ($galeriModel->update($id, $data)) {
            return redirect()->to('/superadmin/galeri')->with('success', 'Video berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }

    // Fungsi untuk mengecek apakah judul video unik
    private function isJudulUnique($judul, $excludeId = null)
    {
        $galeriModel = new GaleriModel();
        // Query untuk mengecek judul yang sama, kecuali id yang diberikan
        $query = $galeriModel->where('judul', $judul);
        if ($excludeId) {
            $query = $query->where('id_galeri !=', $excludeId); // Mengecualikan ID saat update
        }
        $result = $query->first(); // Mengambil satu data, jika ada yang sama maka return true

        return empty($result); // Jika tidak ada data dengan judul yang sama, return true
    }
}
