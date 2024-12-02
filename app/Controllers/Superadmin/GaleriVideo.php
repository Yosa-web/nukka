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

        // // Path untuk menyimpan file gambar
        // $pathImage = 'assets/uploads/images/galeri/';
        // $file = $this->request->getFile('image');
        // $url = $this->request->getPost('url');
        // $urlToSave = null;

        if (!$this->validate([
            'judul' => 'required',
            'url'   => 'required|valid_url',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil data dari request POST
        $judul = $this->request->getPost('judul');
        $url = $this->request->getPost('url');


        // // Jika tipe adalah "video", gunakan URL yang diinput
        // if ($this->request->getPost('tipe') === 'video') {
        //     if (!$this->validate([
        //         'judul' => 'required',
        //         'tipe' => 'required|in_list[image,video]',
        //         'url' => 'required|valid_url',
        //     ])) {
        //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        //     }

        //     $urlToSave = $url;
        // }

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
}


//         $galeriModel = new GaleriModel();

// if (!$this->validate([
//     'judul' => 'required',
//     'url'   => 'required|valid_url', // Validasi URL video
// ])) {
//     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
// }

//         // Simpan data ke database
//         $data = [
//             'judul'        => $this->request->getPost('judul'),
//             'id_user'      => auth()->user()->id,
//             'url'          => $this->request->getPost('url'),
//             'tipe'         => 'video',
//             'uploaded_by'  => auth()->user()->id,
//             'uploaded_at'  => date('Y-m-d H:i:s'),
//         ];

//         $galeriModel->save($data);

//         return redirect()->to('/superadmin/galeri')->with('success', 'Video URL berhasil disimpan.');
//     }
// }
