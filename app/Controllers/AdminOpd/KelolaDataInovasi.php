<?php

namespace App\Controllers\AdminOpd;

use App\Controllers\BaseController;
use App\Models\InovasiModel;
use App\Models\JenisInovasiModel;
use App\Models\LogAktivitasModel;
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
        $this->LogAktivitasModel = new LogAktivitasModel();
        $this->litbang = \Config\Database::connect();
    }


    public function filterByStatuses()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil `id_opd` langsung dari properti user atau melalui array
        $opdUser = $user->id_opd ?? null; // Coba akses langsung sebagai properti

        // Jika akses langsung gagal, gunakan `toArray()`
        if ($opdUser === null) {
            $userData = $user->toArray();
            $opdUser = $userData['id_opd'] ?? null;
        }

        // Jika `id_opd` masih null, ambil secara manual dari database
        if ($opdUser === null) {
            $userId = $user->id;
            $userRecord = $this->userModel->find($userId);
            $opdUser = $userRecord['id_opd'] ?? null;
        }

        // Filter data inovasi berdasarkan OPD user yang login
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->where('inovasi.id_opd', $opdUser) // Filter berdasarkan OPD user
            ->whereNotIn('status', ['tertunda', 'tertolak']) // Hanya status selain tertunda dan tertolak
            ->findAll();

        return view('super_admin/opd/admin/inovasi/filter_by_statuses', $data);
    }


    public function create()
    {
        $data['opd'] = $this->opdModel->findAll();
        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();
        return view('super_admin/opd/admin/inovasi/create', $data);
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


        return redirect()->to('/admin/inovasi/filter')->with('success', 'Inovasi berhasil ditambahkan.');
    }


    public function edit($id_inovasi)
    {
        $data['inovasi'] = $this->inovasiModel->find($id_inovasi);
        $data['jenis_inovasi'] = $this->JenisInovasiModel->findAll();
        $data['opd'] = $this->opdModel->findAll();
        return view('super_admin/opd/admin/inovasi/edit', $data);
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

        return redirect()->to('/admin/inovasi/filter')->with('success', 'Inovasi berhasil diperbarui.');
    }

    public function show($id_inovasi)
    {
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, jenis_inovasi.nama_jenis')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->where('inovasi.id_inovasi', $id_inovasi)
            ->first();
        return view('admin/inovasi/show', $data);
    }
}
