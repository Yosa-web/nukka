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

    public function create(){
        return view('super_admin/berita/create_berita');
    }

 public function store() {
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

    $superAdminId = auth()->user()->id;
    $user = auth()->user()->id;

    $data = [
        'judul'        => $this->request->getVar('judul'),
        'isi'          => $this->request->getVar('isi'),
        'gambar'       => $fotoUrl,
        'tanggal_post' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
        'posted_by'    => $user,
        // 'id_user'      => $user,
        'status'       => $this->request->getVar('status'),
    ];

    $db = \Config\Database::connect();
    $db->transStart();
    
    if ($this->beritaModel->save($data)) {
        $newBeritaId = $this->beritaModel->insertID();

        $logData = [
            'id_user'          => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'             => 'create',
            'jenis_data'       => 'Berita',
            'keterangan'       => "SuperAdmin with ID {$superAdminId} create Berita with ID {$newBeritaId}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        $db->transComplete();
        
        if ($db->transStatus() === false) {
            log_message('debug', 'Transaction failed.');
            return redirect()->back()->with('errors', 'Gagal menyimpan data Berita dan mencatat log aktivitas.');
        }

        return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil ditambahkan dan log tercatat.');
    } else {
        log_message('debug', 'Data save failed: ' . json_encode($this->beritaModel->errors()));
        return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
    }
}

public function edit($id){
    $berita = $this->beritaModel->getBerita($id);
        $data = [
            'title' => 'List berita',
            'berita' => $berita,
        ];
        return view('super_admin/berita/edit_berita', $data);
}

public function update($id)
{
    // Validasi input
    if (!$this->validate($this->beritaModel->getValidationRules(), $this->beritaModel->getValidationMessages())) {
        log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Path untuk menyimpan file gambar
    $path = 'assets/uploads/images/berita/';
    $foto = $this->request->getFile('gambar');
    $fotoUrl = null;

    // Ambil data berita lama
    $beritaLama = $this->beritaModel->find($id);

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

    $data = [
        'judul'        => $this->request->getVar('judul'),
        'isi'          => $this->request->getVar('isi'),
        'gambar'       => $fotoUrl,  // Menyimpan gambar baru atau lama
        'tanggal_post' => $tanggalPost,
        'posted_by'    => $user,
        'status'       => $this->request->getVar('status'),
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
            'keterangan'        => "SuperAdmin with ID {$superAdminId} updated Berita with ID {$id}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        $db->transComplete();

        // Cek status transaksi
        if ($db->transStatus() === false) {
            log_message('debug', 'Transaction failed.');
            return redirect()->back()->with('errors', 'Gagal menyimpan data Berita dan mencatat log aktivitas.');
        }

        return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil diupdate dan log tercatat.');
    } else {
        log_message('debug', 'Data update failed: ' . json_encode($this->beritaModel->errors()));
        return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
    }
}


public function delete($id){
    $superAdminId = auth()->user()->id;

    if ($this->beritaModel->delete($id)) {

        // Data log aktivitas untuk pencatatan
        $logData = [
            'id_user'          => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(), // Format tanggal
            'aksi'             => 'delete', // Tindakan yang dilakukan
            'jenis_data'       => 'Berita', // Jenis data yang terlibat
            'keterangan'       => "SuperAdmin with ID {$superAdminId} deleted Berita with ID {$id}",
        ];

        // Simpan log aktivitas
        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Redirect ke halaman list OPD dengan pesan sukses
        return redirect()->to('/superadmin/berita/list-berita')->with('success', 'Data Berita berhasil dihapus!');
    } else {
        // Jika penghapusan gagal, tampilkan pesan error dari model
        return redirect()->back()->withInput()->with('errors', $this->beritaModel->errors());
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

public function show($id)
{
    $beritaModel = new BeritaModel();
    $publishedBerita = $beritaModel->getPublishedNews($id); // Ambil berita berdasarkan ID

    // Pastikan berita ditemukan
    if (!empty($publishedBerita)) {
        $data = [
            'title' => 'Detail Berita',
            'berita' => $publishedBerita[0], // Ambil item pertama karena getPublishedNews mengembalikan array
        ];

        return view('landing_page/berita/detail', $data);
    } else {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita tidak ditemukan');
    }
}



}
