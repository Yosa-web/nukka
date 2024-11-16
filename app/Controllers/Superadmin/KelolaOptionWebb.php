<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use App\Models\OptionWebModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class KelolaOptionWeb extends BaseController
{
    protected $optionWebModel;

    public function __construct()
    {
        $this->optionWebModel = new OptionWebModel();
    }

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

        $pathImage = 'assets/uploads/images/optionweb/';
        $file = $this->request->getFile('image');
        $text = $this->request->getPost('text');
        $warna = $this->request->getPost('warna'); // Ambil input warna jika ada
        $tipe = $this->request->getPost('tipe') ?? $optionWebModel->find($id)['seting_type'];
        $fileNameToSave = null;

        // Jika tipe adalah 'warna', ambil data warna dari input
        if ($tipe === 'warna' || $tipe === 'kode warna') {
            $warna = $this->request->getPost('warna'); // Ambil nilai warna
            if (!$this->validate(['warna' => 'required'])) { // Validasi warna
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $fileNameToSave = $warna;

            // Jika tipe adalah 'text', ambil data teks dari input
        } elseif ($tipe === 'text') {
            $text = $this->request->getPost('text'); // Ambil nilai teks
            if (!$this->validate(['text' => 'required'])) { // Validasi teks
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $fileNameToSave = $text;

            // Jika tipe adalah 'image', ambil data gambar dari input file
        } elseif ($tipe === 'image') {
            $file = $this->request->getFile('image'); // Ambil file gambar
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $uniqueName = $file->getRandomName(); // Buat nama acak untuk file
                if ($file->move($pathImage, $uniqueName)) {
                    $fileNameToSave = $uniqueName;
                } else {
                    return redirect()->back()->with('error', 'Gagal memindahkan gambar.');
                } // Simpan nama file untuk update ke database
            } else {
                return redirect()->back()->withInput()->with('errors', ['image' => 'Gagal mengunggah gambar.']);
            }
        }

        // Jika tidak ada perubahan data, tetap gunakan nilai lama dari database
        if (!$fileNameToSave) {
            $existingOption = $this->optionWebModel->find($id);
            $fileNameToSave = $existingOption['value'];
        }

        // Siapkan data untuk update ke database
        $data = [
            'value' => $fileNameToSave
        ];

        if ($optionWebModel->update($id, $data)) {
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'update',
                'jenis_data'       => 'option_web',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui option dengan ID {$id}",
            ];
            $logModel->save($logData);

            return redirect()->to('/superadmin/optionweb')->with('success', 'Data option berhasil diperbarui.');
        } else {
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