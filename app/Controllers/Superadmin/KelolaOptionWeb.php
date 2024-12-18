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
        $options = $model->findAll();

        // Proses data untuk membersihkan tag HTML, namun izinkan beberapa tag HTML
        foreach ($options as &$option) {
            // Izinkan tag HTML seperti <b>, <i>, <u>, <strong>, <em>, <p>, <h1>, <h2>, dll
            $allowed_tags = '<b><i><u><strong><em><p><h1><h2><h3><h4><h5><h6><ul><ol><li><br>';
            $option['clean_text'] = strip_tags($option['value'], $allowed_tags); // Membersihkan tag HTML kecuali yang diizinkan
        }

        // Kirim data ke view
        $data['options'] = $options;

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
        $warna = $this->request->getPost('warna');
        $option = $optionWebModel->find($id); // Ambil data berdasarkan ID
        $tipe = $this->request->getPost('tipe') ?? $option['seting_type'];
        $key = $option['key']; // Ambil key untuk menentukan nama file
        $fileNameToSave = null;

        // Jika tipe adalah 'warna'
        if ($tipe === 'warna' || $tipe === 'kode warna') {
            if (!$this->validate(['warna' => 'required'])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $fileNameToSave = $warna;

            // Jika tipe adalah 'text'
        } elseif ($tipe === 'text') {
            if (!$this->validate(['text' => 'required'])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $fileNameToSave = $text;

            // Jika tipe adalah 'image'
        } elseif ($tipe === 'image') {
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Tentukan nama file sesuai key: logo, banner1, banner2, atau banner3
                if (stripos($key, 'Banner 1') !== false) {
                    $fileNameToSave = 'banner1.' . $file->getExtension();
                } elseif (stripos($key, 'Banner 2') !== false) {
                    $fileNameToSave = 'banner2.' . $file->getExtension();
                } elseif (stripos($key, 'Banner 3') !== false) {
                    $fileNameToSave = 'banner3.' . $file->getExtension();
                } elseif (stripos($key, 'Logo') !== false) {
                    $fileNameToSave = 'logo.' . $file->getExtension();
                } else {
                    $fileNameToSave = $file->getRandomName(); // Default jika tidak terdeteksi
                }

                // Hapus file lama jika ada
                $existingFile = $pathImage . $option['value'];
                if (file_exists($existingFile)) {
                    unlink($existingFile);
                }

                // Simpan file baru
                if (!$file->move($pathImage, $fileNameToSave)) {
                    return redirect()->back()->with('error', 'Gagal menyimpan file baru.');
                }
            } else {
                return redirect()->back()->withInput()->with('errors', ['image' => 'Gagal mengunggah gambar.']);
            }
        }

        // Jika tidak ada perubahan data
        if (!$fileNameToSave) {
            $fileNameToSave = $option['value'];
        }

        // Update data
        $data = ['value' => $fileNameToSave];
        if ($optionWebModel->update($id, $data)) {
            // Simpan log aktivitas
            $superAdminId = auth()->user()->id;
            $logModel->save([
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'update',
                'jenis_data'       => 'option_web',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} memperbarui {$key} dengan ID {$id}",
            ]);

            return redirect()->to('/superadmin/optionweb')->with('success', "{$key} berhasil diperbarui.");
        } else {
            return redirect()->back()->withInput()->with('errors', $optionWebModel->errors());
        }
    }
}
