<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use App\Models\OptionWebModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class KelolaOptionWeb extends BaseController
{
    public function index()
    {
        $model = new OptionWebModel();

        // Mengambil semua data dari tabel option_web
        $data['options'] = $model->findAll();

        // Load view dan kirim data options
        return view('super_admin/option_web/index', $data);
    }

    public function edit($id)
    {
        $model = new OptionWebModel();

        // Mengambil data berdasarkan ID
        $data['options'] = $model->find($id);

        $data['option_web'] = $model->find($id);

        return view('super_admin/option_web/edit', $data);
    }
    public function update($id)
    {
        $optionWebModel = new \App\Models\OptionWebModel();
        $logModel = new \App\Models\LogAktivitasModel();

        // Path untuk menyimpan file gambar
        $pathImage = 'assets/uploads/images/optionweb/';
        $file = $this->request->getFile('image');
        $text = $this->request->getPost('text');
        $fileNameToSave = null;

        // Validasi input berdasarkan tipe yang dipilih
        if ($this->request->getPost('tipe') === 'image') {
            if (!$this->validate([
                'tipe' => 'required|in_list[image,text]',
                'image' => 'is_image[image]|max_size[image,10240]', // max 10MB
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Jika ada file gambar, proses uploadnya
            if ($file && $file->isValid()) {
                if (!$file->hasMoved()) {
                    $uniqueName = $file->getRandomName(); // Dapatkan nama unik file
                    if ($file->move($pathImage, $uniqueName)) {
                        $fileNameToSave = $uniqueName; // Simpan hanya nama file
                    } else {
                        return redirect()->back()->with('error', 'Gagal memindahkan gambar.');
                    }
                }
            }
        }

        // Jika tipe adalah "text", gunakan teks yang diinput
        if ($this->request->getPost('tipe') === 'text') {
            if (!$this->validate([
                'tipe' => 'required|in_list[image,text]',
                'text' => 'required',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $fileNameToSave = $text; // Simpan teks ke value
        }

        // Jika file tidak ada dan URL tidak ada, gunakan data yang sudah ada di database
        if (!$fileNameToSave) {
            $existingOptionweb = $optionWebModel->find($id);
            $fileNameToSave = $existingOptionweb['value'];
        }

        // Data yang akan diperbarui
        $data = [
            'value' => $fileNameToSave // Simpan hanya kode unik (nama file atau teks)
        ];

        // Memperbarui data di database
        if ($optionWebModel->update($id, $data)) {
            // Logging aktivitas edit
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'update',
                'jenis_data'       => 'option_web',
                'keterangan'       => "SuperAdmin with ID {$superAdminId} updated option with ID {$id}",
            ];
            $logModel->save($logData);

            // Berhasil, kembali ke halaman option web dengan pesan sukses
            return redirect()->to('/superadmin/optionweb')->with('success', 'Data option berhasil diperbarui.');
        } else {
            // Gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('errors', $optionWebModel->errors());
        }
    }

    // // KelolaOptionWeb.php
    // public function showImage($id)
    // {
    //     $model = new OptionWebModel();
    //     $option = $model->find($id); // Mencari opsi berdasarkan ID

    //     // Pastikan opsi ditemukan dan bertipe image
    //     if ($option && $option['seting_type'] === 'image') {
    //         return view('super_admin/option_web/show_image', ['image_url' => $option['value']]);
    //     } else {
    //         return redirect()->back()->with('error', 'Gambar tidak ditemukan atau tipe salah.');
    //     }
    // }

    // public function publishedOptions()
    // {
    //     $optionWebModel = new OptionWebModel();
    //     $publishedOptions = $optionWebModel->findAll(); // Ambil semua opsi yang ada

    //     if (!empty($publishedOptions)) {
    //         return view('landing_page/option_web/option_published', [
    //             'options' => $publishedOptions,
    //         ]);
    //     } else {
    //         return view('landing_page/option_web/option_published', ['options' => []]);
    //     }
    // }

    // public function show($id)
    // {
    //     $optionWebModel = new OptionWebModel();
    //     $option = $optionWebModel->find($id); // Ambil opsi berdasarkan ID

    //     // Pastikan opsi ditemukan
    //     if (!empty($option)) {
    //         $data = [
    //             'title' => 'Detail Opsi Web',
    //             'option' => $option, // Ambil item detail opsi
    //         ];

    //         return view('landing_page/option_web/option_detail', $data);
    //     } else {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Opsi tidak ditemukan');
    //     }
    // }
}
