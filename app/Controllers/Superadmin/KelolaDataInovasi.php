<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\InovasiModel;
use App\Models\OpdModel;
use App\Models\UserModel;
use App\Models\JenisInovasiModel;
use App\Models\LogAktivitasModel;
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
        $this->LogAktivitasModel = new LogAktivitasModel();
        $this->litbang = \Config\Database::connect();
    }



    public function index()
    {
        // Mengambil koneksi database
        $litbang = \Config\Database::connect();

        // Menggunakan inovasiModel untuk mendapatkan data dengan status tertunda atau tertolak
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->whereIn('status', ['tertunda', 'tertolak'])  // Hanya status tertunda dan tertolak
            ->orderBy('FIELD(status, "tertunda", "draf", "revisi", "terbit", "arsip", "tertolak")') // Mengatur urutan
            ->findAll();

        return view('super_admin/inovasi/index', $data);
    }

    public function filterByStatuses()
    {
        // Mengambil koneksi database
        $litbang = \Config\Database::connect();

        // Mendapatkan data dengan status selain tertunda dan tertolak
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->whereNotIn('status', ['tertunda', 'tertolak']) // Hanya status selain tertunda dan tertolak
            ->findAll();

        return view('super_admin/inovasi/filter_by_statuses', $data);
    }



    // Fungsi untuk menampilkan form tambah proposal
    public function create()
    {
        $data['opd'] = $this->opdModel->findAll(); // Ambil semua data OPD untuk dropdown
        $data['jenis_inovasi'] = $this->litbang->table('jenis_inovasi')->get()->getResultArray();

        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->findAll();

        return view('super_admin/inovasi/create', $data); // Tampilkan view form
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

        // if ($status === 'terbit') {
        //     $data['published_by'] = $user;
        //     $data['published_at'] = date('Y-m-d H:i:s');
        // }

        $this->inovasiModel->save($data);

        $newInovasiId = $this->inovasiModel->insertID();

        // Log aktivitas
        $logData = [
            'id_user' => $user,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'tambah data',
            'jenis_data' => 'Inovasi',
            'keterangan' => "SuperAdmin dengan ID {$user} menambahkan data Inovasi dengan ID {$newInovasiId}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/superadmin/inovasi/filter')->with('success', 'Proposal berhasil diajukan.');
    }


    public function edit($id_inovasi)
    {
        $data['inovasi'] = $this->inovasiModel->find($id_inovasi);
        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();
        $data['opd'] = $this->opdModel->findAll();
        return view('super_admin/inovasi/edit', $data);
    }

    public function update($id_inovasi)
    {
        $inovasi = $this->inovasiModel->find($id_inovasi); // Ambil data inovasi berdasarkan ID
        $status = $this->request->getPost('status');
        $pesanBaru = $this->request->getPost('pesan');

        // Validasi: Pesan wajib diisi jika status adalah tertolak, revisi, atau arsip
        if (in_array($status, ['tertolak', 'revisi', 'arsip']) && empty($pesanBaru)) {
            return redirect()->back()->withInput()->with('error', 'Pesan wajib diisi untuk status ini.');
        }

        // Jika status adalah revisi, gabungkan pesan lama dan baru
        if ($status === 'revisi' && !empty($pesanBaru)) {
            $pesanLama = $inovasi['pesan'] ?? '';
            $pesanGabungan = trim($pesanLama . ' --- ' . $pesanBaru);
            $data['pesan'] = $pesanGabungan;
        } else {
            $data['pesan'] = $pesanBaru ?: $inovasi['pesan']; // Jika pesan baru tidak ada, gunakan pesan lama
        }

        // Persiapkan data untuk diupdate
        $data = [
            'judul'      => $this->request->getPost('judul'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'kategori'   => $this->request->getPost('kategori'),
            'status'     => $status,
            'pesan'      => $data['pesan'],
            'id_opd'     => $this->request->getPost('id_opd'),
            'kecamatan'  => $this->request->getPost('kecamatan'), // Tambahkan kecamatan
        ];

        // Atur published_at dan published_by jika status adalah 'terbit'
        if ($status === 'terbit') {
            $data['published_at'] = Time::now('Asia/Jakarta', 'id')->toDateTimeString();
            $user = auth()->user();
            $data['published_by'] = $user->name;
        }

        // Cek apakah ada file baru yang diunggah
        $file = $this->request->getFile('url_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama jika ada
            $oldFile = $this->inovasiModel->find($id_inovasi)['url_file'];
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

        // $this->inovasiModel->update($id_inovasi, $data);
        // Log aktivitas
        $user = auth()->user()->id;
        $logData = [
            'id_user' => $user,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'update',
            'jenis_data' => 'Inovasi',
            'keterangan' => "SuperAdmin dengan ID {$user} memperbarui Inovasi dengan ID {$id_inovasi}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/superadmin/inovasi/filter')->with('success', 'Proposal berhasil diperbarui.');
    }

    //     return redirect()->to('/superadmin/inovasi')->with('success', 'Proposal berhasil diperbarui.');
    // }

    public function delete($id_inovasi)
    {
        $this->inovasiModel->delete($id_inovasi);
        // Log aktivitas
        $user = auth()->user()->id;
        $logData = [
            'id_user' => $user,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'delete',
            'jenis_data' => 'Inovasi',
            'keterangan' => "SuperAdmin dengan ID {$user} menghapus Inovasi dengan ID {$id_inovasi}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/superadmin/inovasi/filter')->with('success', 'Proposal berhasil dihapus.');
    }
    //     return redirect()->to('/superadmin/inovasi')->with('success', 'Proposal berhasil dihapus.');
    // }

    public function show($id_inovasi)
    {
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->where('inovasi.id_inovasi', $id_inovasi)
            ->first();
        return view('super_admin/inovasi/show', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $pesan = $this->request->getPost('pesan');
        $user = auth()->user()->id;

        $data = [
            'status' => $status,
            'pesan' => $pesan,
        ];

        // Jika statusnya "terbit", tambahkan informasi publikasi
        if ($status === 'terbit') {
            $data['published_by'] = $user()->username; // Mengambil username user yang login
            $data['published_at'] = Time::now('Asia/Jakarta', 'en')->toDateTimeString(); // Tanggal dan waktu saat ini
        }

        $this->inovasiModel->update($id, $data);
        return redirect()->to('/inovasi/detail/' . $id)->with('success', 'Status berhasil diperbarui.');
    }

    public function tolak()
    {
        $id_inovasi = $this->request->getPost('id_inovasi');
        $pesan = $this->request->getPost('pesan');

        // Pastikan ID inovasi dan pesan tidak kosong
        if ($id_inovasi && $pesan) {
            // Update data
            $this->inovasiModel->update($id_inovasi, [
                'status' => 'tertolak',
                'pesan' => $pesan
            ]);

            // Berikan pesan sukses dan kembali ke halaman index
            return redirect()->to('/superadmin/inovasi/')->with('success', 'Proposal berhasil ditolak dengan pesan.');
        }

        // Jika ada masalah, kembali dengan pesan error
        return redirect()->back()->withInput()->with('error', 'Pesan wajib diisi untuk menolak proposal.');
    }

    public function setujui()
    {
        $id_inovasi = $this->request->getPost('id_inovasi');

        // Validasi apakah ID inovasi ada
        if ($id_inovasi) {
            // Update status menjadi 'draf'
            $this->inovasiModel->update($id_inovasi, [
                'status' => 'draf'
            ]);

            // Kirim respon sukses
            // return $this->response->setJSON(['status' => 'success', 'message' => 'Proposal berhasil disetujui']);
            return redirect()->to('/superadmin/inovasi/')->with('success', 'Proposal berhasil disetujui.');
        }

        // Jika gagal
        // return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyetujui inovasi']);
        return redirect()->back()->withInput()->with('error', 'Gagal menyetujui proposal!');
    }
}
