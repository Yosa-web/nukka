<?php

namespace App\Controllers\UserUmum;

use App\Controllers\BaseController;
use App\Controllers\Superadmin\LogAktivitas;
use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\OpdModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class KelolaDataInovasi extends BaseController
{
    protected $inovasiModel;
    protected $opdModel;
    protected $userModel;
    protected $LogAktivitasModel;
    protected $JenisInovasiModel;
    protected $litbang;

    public function __construct()
    {
        $this->inovasiModel = new InovasiModel();
        $this->opdModel = new OpdModel();
        $this->userModel = new UserModel();
        $this->JenisInovasiModel = new JenisInovasiModel();
        $this->LogAktivitasModel = new LogAktivitas();
        $this->litbang = \Config\Database::connect();
    }

    public function filterByStatuses()
    {
        // Mengambil user yang sedang login
        $user = auth()->user();
        $userId = $user->id;

        // Mendapatkan data inovasi dengan status selain tertunda dan tertolak
        // Dan hanya menampilkan data berdasarkan id_user yang sedang login
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->where('inovasi.id_user', $userId) // Filter berdasarkan id_user
            // ->whereNotIn('status', ['tertunda', 'tertolak']) // Hanya status selain tertunda dan tertolak
            ->findAll();

        return view('user_umum/inovasi/filter_by_statuses', $data);
    }

    public function create()
    {
        $data['opd'] = $this->opdModel->findAll();
        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();
        return view('user_umum/inovasi/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'judul' => 'required|max_length[100]',
            'deskripsi' => 'required',
            'kategori' => 'required',
            // 'status' => 'required',
            'kecamatan' => 'required',
            'id_opd' => 'required',
            'url_file' => 'uploaded[url_file]|max_size[url_file,2048]|ext_in[url_file,pdf]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori = $this->request->getPost('kategori');
        $status = $this->request->getPost('status') ?? 'draf';
        $kecamatan = $this->request->getPost('kecamatan');
        $id_opd = $this->request->getPost('id_opd');
        // $tanggalPengajuan = date('Y-m-d H:i:s');
        $tanggalPengajuan = Time::now('Asia/Jakarta', 'en')->toDateTimeString();
        $user = auth()->user()->id;

        $file = $this->request->getFile('url_file');
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/', $fileName);
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file.');
        }

        if ($file->getClientExtension() !== 'pdf') {
            return redirect()->back()->withInput()->with('error', 'File harus berformat PDF.');
        }

        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'kategori' => $kategori,
            'status' => 'tertunda',
            'kecamatan' => $kecamatan,
            'tanggal_pengajuan' => $tanggalPengajuan,
            'id_user' => $user,
            'id_opd' => $id_opd,
            'url_file' => isset($fileName) ? 'uploads/' . $fileName : null,
        ];

        $this->inovasiModel->save($data);


        return redirect()->to('/userumum/inovasi/filter')->with('success', 'Inovasi berhasil ditambahkan.');
    }
    public function edit($id_inovasi)
    {
        // Mengambil user yang sedang login
        $user = auth()->user();
        $userId = $user->id;

        // Mengambil data inovasi
        $data['inovasi'] = $this->inovasiModel
            ->where('id_inovasi', $id_inovasi)
            ->where('id_user', $userId) // Filter berdasarkan id_user
            ->first();

        // Jika data inovasi tidak ditemukan atau id_user tidak cocok
        if (!$data['inovasi']) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit inovasi ini.');
        }

        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();
        $data['opd'] = $this->opdModel->findAll();

        return view('user_umum/inovasi/edit', $data);
    }


    public function update($id_inovasi)
    {
        // Mengambil user yang sedang login
        $user = auth()->user();
        $userId = $user->id;

        // Mengambil data inovasi
        $inovasi = $this->inovasiModel
            ->where('id_inovasi', $id_inovasi)
            ->where('id_user', $userId) // Filter berdasarkan id_user
            ->first();

        // Jika data inovasi tidak ditemukan atau id_user tidak cocok
        if (!$inovasi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memperbarui inovasi ini.');
        }

        // Memproses data update
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kategori'  => $this->request->getPost('kategori'),
            'id_opd'    => $this->request->getPost('id_opd'),
            'kecamatan' => $this->request->getPost('kecamatan'),
            'status'    => 'tertunda',  // Force status to "tertunda"
        ];

        // Cek apakah ada file baru yang diunggah
        $file = $this->request->getFile('url_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama jika ada
            $oldFile = $inovasi['url_file'];
            if (!empty($oldFile) && file_exists(FCPATH . $oldFile)) {
                unlink(FCPATH . $oldFile);
            }

            // Pastikan file baru adalah PDF
            if ($file->getClientExtension() !== 'pdf') {
                return redirect()->back()->withInput()->with('error', 'File harus berformat PDF.');
            }

            // Simpan file baru
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['url_file'] = 'uploads/' . $newName;
        }

        // Update data di database
        $this->inovasiModel->update($id_inovasi, $data);

        return redirect()->to('/userumum/inovasi/filter')->with('success', 'Inovasi berhasil diperbarui.');
    }


    public function show($id_inovasi)
    {
        // Mengambil user yang sedang login
        $user = auth()->user();
        $userId = $user->id;

        // Mendapatkan data inovasi berdasarkan id dan filter berdasarkan id_user
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->where('inovasi.id_inovasi', $id_inovasi)
            ->where('inovasi.id_user', $userId) // Filter berdasarkan id_user
            ->first();

        // Jika data inovasi tidak ditemukan atau id_user tidak cocok
        if (!$data['inovasi']) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke inovasi ini.');
        }

        return view('user/umum/inovasi/show', $data);
    }
}
