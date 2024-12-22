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
    protected $namaWebsite; // Tambahkan properti untuk nama website

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->logModel = new LogAktivitasModel();
        $this->namaWebsite = $nama['value'] ?? 'Balitbang'; // Fallback jika Nama tidak tersedia

    }
    public function index()
    {
        $data = [
            'title' => 'List Berita',
            'berita' => $this->beritaModel->getBerita(),
            'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view
        ];
        return view('super_admin/berita/list_berita', $data);
    }

    public function create()
    {
        return view('super_admin/berita/create_berita');
    }

    public function store()
    {
        // Validasi input, cek judul unik, dan tidak boleh hanya spasi
        $judul = trim($this->request->getVar('judul'));

        if (empty($judul)) {
            return redirect()->back()->withInput()->with('errors', 'Judul tidak boleh kosong.');
        }

        if ($this->beritaModel->where('judul', $judul)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', 'Judul berita harus unik.');
        }

        // Path untuk menyimpan file gambar
        $path = 'assets/uploads/images/berita/';
        $foto = $this->request->getFile('gambar');
        $fotoUrl = null;

        if ($foto->isValid() && !$foto->hasMoved()) {
            $name = $foto->getRandomName();
            $foto->move($path, $name);
            $fotoUrl = $path . $name;
        }

        $data = [
            'judul'        => $judul,
            'isi'          => $this->request->getVar('isi'),
            'gambar'       => $fotoUrl,
            'tanggal_post' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'posted_by'    => auth()->user()->id,
            'status'       => $this->request->getVar('status'),
            'slug'         => url_title($judul, '-', true),
            'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view

        ];

        if ($this->beritaModel->save($data)) {
            $logData = [
                'id_user'          => auth()->user()->id,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'tambah data',
                'jenis_data'       => 'Berita',
                'keterangan'       => "SuperAdmin menambahkan berita berjudul {$judul}.",
            ];
            $this->logModel->save($logData);

            return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Berita berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('errors', 'Gagal menyimpan berita.');
    }

    public function edit($slug)
    {
        $berita = $this->beritaModel->getBerita($slug);
        $data = [
            'title' => 'List berita',
            'berita' => $berita,
            'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view

        ];
        return view('super_admin/berita/edit_berita', $data);
    }

    public function update($id)
    {
        // Validasi input, cek judul unik, dan tidak boleh hanya spasi
        $judul = trim($this->request->getVar('judul'));
        $beritaLama = $this->beritaModel->find($id);

        if (empty($judul)) {
            return redirect()->back()->withInput()->with('errors', 'Judul tidak boleh kosong.');
        }

        if ($judul !== $beritaLama['judul'] && $this->beritaModel->where('judul', $judul)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('errors', 'Judul berita harus unik.');
        }

        // Path untuk menyimpan file gambar
        $path = 'assets/uploads/images/berita/';
        $foto = $this->request->getFile('gambar');
        $fotoUrl = $beritaLama['gambar'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $name = $foto->getRandomName();
            $foto->move($path, $name);
            $fotoUrl = $path . $name;
        }

        $data = [
            'judul'        => $judul,
            'isi'          => $this->request->getVar('isi'),
            'gambar'       => $fotoUrl,
            'tanggal_post' => $this->request->getVar('tanggal_post') ?: $beritaLama['tanggal_post'],
            'posted_by'    => auth()->user()->id,
            'status'       => $this->request->getVar('status'),
            'slug'         => url_title($judul, '-', true),
            'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view

        ];

        if ($this->beritaModel->update($id, $data)) {
            $logData = [
                'id_user'          => auth()->user()->id,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'update',
                'jenis_data'       => 'Berita',
                'keterangan'       => "SuperAdmin mengubah berita dengan ID {$id}.",
            ];
            $this->logModel->save($logData);

            return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Berita berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('errors', 'Gagal memperbarui berita.');
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
                'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view
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
                'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view
            ];

            return view('super_admin/berita/detail_berita', $data);
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
                'namaWebsite' => $this->namaWebsite, // Kirim nama website ke view
            ];

            return view('landing_page/berita/detail', $data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
        }
    }

    public function checkTitle()
    {
        if ($this->request->isAJAX()) {
            $judul = $this->request->getPost('judul');

            // Cek apakah judul sudah digunakan
            $exists = $this->beritaModel
                ->where('judul', $judul)
                ->countAllResults() > 0;

            return $this->response->setJSON(['exists' => $exists]);
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
}
