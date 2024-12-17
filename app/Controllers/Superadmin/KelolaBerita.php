<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BeritaModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\I18n\Time;

class KelolaBerita extends BaseController
{
    public $beritaModel;
    public $logModel;
    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->logModel = new LogAktivitasModel();
    }
    public function index()
    {
        $data = [
            'title' => 'List Berita',
            'berita' => $this->beritaModel->getBerita(),
        ];
        return view('super_admin/berita/list_berita', $data);
    }

    public function create()
    {
        return view('super_admin/berita/create_berita');
    }



    public function store()
    {
        // Debugging: Lihat data yang diterima
        log_message('debug', print_r($this->request->getPost(), true));

        // Validasi input
        if (!$this->validate($this->beritaModel->getValidationRules(), $this->beritaModel->getValidationMessages())) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Path untuk menyimpan file gambar
        $path = 'assets/uploads/images/berita/';
        $foto = $this->request->getFile('gambar');
        $fotoUrl = null;

        if ($foto->isValid() && !$foto->hasMoved()) {
            $name = $foto->getRandomName();
            if ($foto->move($path, $name)) {
                log_message('debug', 'Image moved successfully: ' . $name);
                $fotoUrl = $path . $name;
            } else {
                log_message('debug', 'Image move failed: ' . $foto->getErrorString());
            }
        }

        // Menyiapkan data
        $user = auth()->user()->id;
        $data = [
            'judul'        => $this->request->getVar('judul'),
            'isi'          => $this->request->getVar('isi'),
            'gambar'       => $fotoUrl,
            'tanggal_post' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'posted_by'    => $user,
            'status'       => $this->request->getVar('status'),
            'slug'         => url_title($this->request->getVar('judul'), '-', true),  // Menambahkan slug berdasarkan judul
        ];

        // Memulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // Simpan data berita baru
        if ($this->beritaModel->save($data)) {
            $newBeritaId = $this->beritaModel->insertID();

            // Simpan log aktivitas
            $logData = [
                'id_user'          => $user,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'tambah data',
                'jenis_data'       => 'Berita',
                'keterangan'       => "SuperAdmin dengan ID {$user} menambahkan data Berita dengan ID {$newBeritaId}",
            ];

            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            $db->transComplete();

            // Mengecek status transaksi
            if ($db->transStatus() === false) {
                log_message('debug', 'Transaction failed.');
                return redirect()->back()->with('errors', 'Gagal menyimpan data Berita dan mencatat log aktivitas.');
            }

            return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil ditambahkan.');
        } else {
            log_message('debug', 'Data save failed: ' . json_encode($this->beritaModel->errors()));
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }
    }


    public function edit($slug)
    {
        $berita = $this->beritaModel->getBerita($slug);
        $data = [
            'title' => 'List berita',
            'berita' => $berita,
        ];
        return view('super_admin/berita/edit_berita', $data);
    }

    public function update($id)
    {
        // Ambil data berita lama
        $beritaLama = $this->beritaModel->find($id);

        // Ambil judul yang dikirimkan pada form
        $judulBaru = $this->request->getVar('judul');

        // Validasi input dengan pengecekan judul yang berubah
        $validationRules = $this->beritaModel->getValidationRules();
        if ($judulBaru !== $beritaLama['judul']) {
            $validationRules['judul'] = 'required|max_length[200]|is_unique[berita.judul,id_berita,' . $id . ']';
        } else {
            $validationRules['judul'] = 'required|max_length[200]';
        }

        // Validasi input
        if (!$this->validate($validationRules, $this->beritaModel->getValidationMessages())) {
            log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Path untuk menyimpan file gambar
        $path = 'assets/uploads/images/berita/';
        $foto = $this->request->getFile('gambar');
        $fotoUrl = null;

        // Jika ada file baru yang diunggah dan valid
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $name = $foto->getRandomName();
            if ($foto->move($path, $name)) {
                log_message('debug', 'Image moved successfully: ' . $name);
                $fotoUrl = $path . $name;
            } else {
                log_message('debug', 'Image move failed: ' . $foto->getErrorString());
            }
        } else {
            // Gunakan URL gambar lama jika tidak ada unggahan baru
            $fotoUrl = $beritaLama['gambar'];
        }

        // Mengambil tanggal post sebelumnya jika tidak ada input baru
        $tanggalPost = $this->request->getVar('tanggal_post') ?: $beritaLama['tanggal_post'];

        $superAdminId = auth()->user()->id;
        $user = auth()->user()->id;

        // Menambahkan slug berdasarkan judul
        $data = [
            'judul'        => $judulBaru,
            'isi'          => $this->request->getVar('isi'),
            'gambar'       => $fotoUrl,  // Menyimpan gambar baru atau lama
            'tanggal_post' => $tanggalPost,
            'posted_by'    => $user,
            'status'       => $this->request->getVar('status'),
            'slug'         => url_title($judulBaru, '-', true), // Menambahkan slug baru
        ];

        // Inisialisasi database dan transaksi
        $db = \Config\Database::connect();
        $db->transStart();

        // Update data berita
        if ($this->beritaModel->update($id, $data)) {
            // Catat log aktivitas
            $logData = [
                'id_user'           => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'              => 'update',
                'jenis_data'        => 'Berita',
                'keterangan'        => "SuperAdmin dengan ID {$superAdminId} updated Berita dengan ID {$id}",
            ];

            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            $db->transComplete();

            // Cek status transaksi
            if ($db->transStatus() === false) {
                log_message('debug', 'Transaction failed.');
                return redirect()->back()->with('errors', 'Gagal menyimpan data Berita dan mencatat log aktivitas.');
            }

            return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil diperbarui.');
        } else {
            log_message('debug', 'Data update failed: ' . json_encode($this->beritaModel->errors()));
            return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
        }
    }




    public function delete()
    {
        // Ambil ID berita dari data POST
        $id = $this->request->getPost('id_berita');

        if ($id && $this->beritaModel->delete($id)) {
            // Ambil ID super admin dari session
            $superAdminId = auth()->user()->id;

            // Data log aktivitas untuk pencatatan
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'hapus data',
                'jenis_data'       => 'Berita',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus data Berita with ID {$id}",
            ];

            // Simpan log aktivitas
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);

            return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil dihapus!');
        } else {
            // Jika penghapusan gagal, tampilkan pesan error
            return redirect()->back()->withInput()->with('errors', 'Gagal menghapus berita.');
        }
    }


    public function publishedNews()
    {
        $beritaModel = new BeritaModel();
        $publishedBerita = $beritaModel->getPublishedNews();

        if (!empty($publishedBerita)) {
            return view('landing_page/berita/berita_published', [
                'beritas' => $publishedBerita,
            ]);
        } else {
            return view('landing_page/berita/berita_published', ['beritas' => []]);
        }
    }

    public function detail($slug)
    {
        // Model Berita
        $beritaModel = new BeritaModel();
        $publishedBerita = $beritaModel->getBerita($slug); // Ambil berita berdasarkan slug

        // Pastikan berita ditemukan
        if ($publishedBerita) {
            $data = [
                'title' => 'Detail Berita',
                'berita' => $publishedBerita, // Hanya satu berita karena menggunakan first()
            ];

            return view('landing_page/berita/detail', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    }

    public function show($slug)
    {
        $beritaModel = new BeritaModel();
        $publishedBerita = $beritaModel->getPublishedNews($slug); // Ambil berita berdasarkan slug
        // $publishedRandBerita = $beritaModel->getRandPublishedNews($slug);
        // Pastikan berita ditemukan
        if (!empty($publishedBerita)) {
            $data = [
                'title' => 'Detail Berita',
                'berita' => $publishedBerita[0], // Ambil item pertama karena getPublishedNews mengembalikan array
                'randberita' => $publishedBerita,
            ];

            return view('landing_page/berita/detail', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    }
}
