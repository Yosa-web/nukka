<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\Controller;
use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LogAktivitasModel;
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

        if (!$this->validate([
            'judul' => 'required',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,10240]', // max 10MB
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Jika file gambar ada dan valid
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName(); // Dapatkan nama acak untuk file
            if ($file->move($pathImage, $name)) {
                // File berhasil dipindahkan
                $urlToSave = base_url($pathImage . $name); // URL yang akan disimpan ke database
            } else {
                // Gagal memindahkan file
                return redirect()->back()->with('error', 'Gagal mengupload gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal mengupload gambar atau gambar tidak valid.');
        }

        // Data yang akan disimpan
        $data = [
            'judul'        => $this->request->getPost('judul'),
            'id_user'      => auth()->user()->id,
            'url'          => $urlToSave,
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
                'aksi'             => 'create',
                'jenis_data'       => 'galeri',
                'keterangan'       => "SuperAdmin with ID {$superAdminId} created galeri with name " . $data['judul'],
            ];
            $logModel->save($logData);

            // Berhasil, kembali ke halaman galeri dengan pesan sukses
            return redirect()->to('/superadmin/galeri')->with('success', 'Data galeri berhasil ditambahkan.');
        } else {
            // Gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $galeriModel->errors());
        }
    }
}



//         $galeriModel = new GaleriModel();
//         $pathImage = 'assets/uploads/images/galeri/';
//         $file = $this->request->getFile('image');

//         if (!$this->validate([
//             'judul' => 'required',
//             'image' => 'uploaded[image]|is_image[image]|max_size[image,10240]', // max 10MB
//         ])) {
//             return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
//         }

//         // Proses upload file
//         if ($file && $file->isValid()) {
//             $name = $file->getRandomName();
//             if ($file->move($pathImage, $name)) {
//                 $urlToSave = base_url($pathImage . $name); // URL yang akan disimpan ke database

//                 // Simpan data ke database
//                 $data = [
//                     'judul'        => $this->request->getPost('judul'),
//                     'id_user'      => auth()->user()->id,
//                     'url'          => $urlToSave,
//                     'tipe'         => 'image',
//                     'uploaded_by'  => auth()->user()->id,
//                     'uploaded_at'  => date('Y-m-d H:i:s'),
//                 ];

//                 $galeriModel->save($data);

//                 return redirect()->to('/superadmin/galeri')->with('success', 'Gambar berhasil diupload.');
//             }
//         }

//         return redirect()->back()->with('error', 'Gagal mengupload gambar.');
//     }
// }
