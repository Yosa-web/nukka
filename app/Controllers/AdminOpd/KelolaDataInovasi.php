<?php

namespace App\Controllers\AdminOpd;

use App\Controllers\BaseController;
use App\Models\InovasiModel;
use App\Models\OpdModel;
use App\Models\UserModel;
use App\Models\JenisInovasiModel;
use App\Models\BentukModel;
use App\Models\TahapanModel;
use App\Models\KecamatanModel;
use App\Models\DesaModel;
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
    protected $kecamatanModel;
    protected $desaModel;
    protected $bentukModel;
    protected $tahapanModel;
    protected $litbang;

    public function __construct()
    {
        $this->inovasiModel = new InovasiModel();
        $this->opdModel = new OpdModel();
        $this->userModel = new UserModel();
        $this->JenisInovasiModel = new JenisInovasiModel();
        $this->bentukModel = new BentukModel();
        $this->tahapanModel = new TahapanModel();
        $this->kecamatanModel = new KecamatanModel();
        $this->desaModel = new DesaModel();
        $this->LogAktivitasModel = new LogAktivitasModel();
        $this->litbang = \Config\Database::connect();
    }

    public function filterByStatuses()
    {
        $user = auth()->user(); // Ambil data pengguna yang sedang login
        $id_user = $user->id; // Ambil ID pengguna

        // Query untuk mengambil data inovasi hanya yang dibuat oleh pengguna yang sedang login
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, 
                     jenis_inovasi.nama_jenis, 
                     bentuk.nama_bentuk, 
                     tahapan.nama_tahapan, 
                     kecamatan.nama_kecamatan, 
                     desa.nama_desa, 
                     opd.nama_opd,
                     users.name as diajukan_oleh') // Menambahkan nama pengguna yang mengajukan
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left') // Join dengan tabel OPD
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users
            ->where('inovasi.id_user', $id_user) // Filter hanya inovasi yang dibuat oleh pengguna yang sedang login
            ->orderBy('FIELD(inovasi.status, "tertunda", "draf", "revisi", "terbit", "arsip", "tertolak")') // Urutkan berdasarkan status
            ->findAll();

        return view('admin_opd/inovasi/filter_by_statuses', $data);
    }

    public function create()
    {
        $data['opd'] = $this->opdModel->findAll(); // Ambil semua data OPD untuk dropdown
        $data['bentuk'] = $this->bentukModel->findAll(); // Ambil semua data bentuk untuk dropdown
        $data['tahapan'] = $this->tahapanModel->findAll(); // Ambil semua data tahapan untuk dropdown
        $data['kecamatan'] = $this->kecamatanModel->findAll(); // Ambil semua data kecamatan untuk dropdown
        $data['desa'] = $this->desaModel->findAll(); // Ambil semua data desa untuk dropdown
        $data['jenis_inovasi'] = $this->litbang->table('jenis_inovasi')->get()->getResultArray();

        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, 
                 jenis_inovasi.nama_jenis, 
                 bentuk.nama_bentuk, 
                 tahapan.nama_tahapan, 
                 kecamatan.nama_kecamatan, 
                 desa.nama_desa, 
                 opd.nama_opd,
                 users.username as diajukan_oleh') // Menambahkan nama-nama terkait
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users untuk mendapatkan username
            ->findAll();

        // Memasukkan created_at secara manual
        $data['created_at'] = date('Y-m-d H:i:s');
        return view('admin_opd/inovasi/create', $data);
    }

    public function store()
    {
        // Ambil kecamatan dan desa berdasarkan ID
        $kecamatan = $this->kecamatanModel->find($this->request->getPost('kecamatan'));
        if (!$kecamatan) {
            return redirect()->back()->withInput()->with('error', 'Kecamatan tidak ditemukan.');
        }

        $desa = $this->desaModel->find($this->request->getPost('desa'));
        if (!$desa) {
            return redirect()->back()->withInput()->with('error', 'Desa tidak ditemukan.');
        }

        // Validasi form input
        if (!$this->validate([
            'judul' => 'required|max_length[100]',
            'deskripsi' => 'required',
            'tahun' => 'required',
            'kategori' => 'required',
            'bentuk' => 'required',
            'tahapan' => 'required',
            'url_file' => 'uploaded[url_file]|max_size[url_file,2048]|ext_in[url_file,pdf]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $tahun = $this->request->getPost('tahun');
        $kategori = $this->request->getPost('kategori');
        $bentuk = $this->request->getPost('bentuk');
        $tahapan = $this->request->getPost('tahapan');
        $status = $this->request->getPost('status') ?? 'draf';
        $kecamatan = $this->request->getPost('kecamatan');
        $desa = $this->request->getPost('desa');
        $tanggalPengajuan = Time::now('Asia/Jakarta', 'en')->toDateTimeString();
        $user = auth()->user();  // Ambil user yang sedang login

        // Ambil id_opd dari user yang sedang login
        $id_opd = $user->id_opd;  // Asumsikan kolom id_opd ada di tabel users dan terhubung dengan user yang sedang login

        // Cek apakah id_opd tersedia untuk user
        if (empty($id_opd)) {
            return redirect()->back()->withInput()->with('error', 'User tidak memiliki OPD yang terdaftar.');
        }

        // Ambil file yang diupload
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

        // Siapkan data yang akan disimpan
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'tahun' => $tahun,
            'kategori' => $kategori,
            'bentuk' => $bentuk,
            'tahapan' => $tahapan,
            'status' => 'tertunda',
            'kecamatan' => $kecamatan,
            'desa' => $desa,
            'tanggal_pengajuan' => $tanggalPengajuan,
            'id_user' => $user->id,
            'id_opd' => $id_opd,  // Gunakan id_opd dari user yang sedang login
            'url_file' => isset($fileName) ? 'uploads/' . $fileName : null,
        ];

        // Simpan data inovasi
        $this->inovasiModel->save($data);

        // Ambil ID inovasi yang baru disimpan
        $newInovasiId = $this->inovasiModel->insertID();

        // Log aktivitas
        $logData = [
            'id_user' => $user->id,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'tambah data',
            'jenis_data' => 'Inovasi',
            'keterangan' => "admin dengan ID {$user->id} menambahkan data Inovasi dengan ID {$newInovasiId}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/admin/inovasi/filter')->with('success', 'Inovasi berhasil ditambahkan.');
    }


    public function edit($id_inovasi)
    {
        // Ambil data inovasi berdasarkan ID
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, 
                jenis_inovasi.nama_jenis, 
                bentuk.nama_bentuk, 
                tahapan.nama_tahapan, 
                kecamatan.nama_kecamatan, 
                desa.nama_desa,
                opd.nama_opd,
               users.username as diajukan_oleh,
            inovasi.tahun')
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users untuk mendapatkan username
            ->find($id_inovasi); // Ambil data berdasarkan ID

        // Pastikan jika data inovasi tidak ditemukan
        if (!$data['inovasi']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Inovasi tidak ditemukan');
        }

        // Ambil semua data terkait untuk dropdown
        $data['opd'] = $this->opdModel->findAll(); // Ambil semua data OPD
        $data['bentuk'] = $this->bentukModel->findAll(); // Ambil semua data bentuk
        $data['tahapan'] = $this->tahapanModel->findAll(); // Ambil semua data tahapan
        $data['kecamatan'] = $this->kecamatanModel->findAll(); // Ambil semua data kecamatan
        $data['desa'] = $this->desaModel->findAll(); // Ambil semua data desa
        $data['jenis_inovasi'] = $this->litbang->table('jenis_inovasi')->get()->getResultArray(); // Ambil data jenis inovasi

        // Debug untuk memastikan data tahapan ada dan valid
        // var_dump($data['tahapan']); // Uncomment jika ingin debug

        return view('admin_opd/inovasi/edit', $data);
    }

    public function update($id_inovasi)
    {
        // Ambil data inovasi berdasarkan ID
        $inovasi = $this->inovasiModel->find($id_inovasi);
        if (!$inovasi) {
            return redirect()->to('/admin/inovasi/filter')->with('error', 'Inovasi tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        $pesanBaru = $this->request->getPost('pesan');

        // Validasi: Pesan wajib diisi jika status adalah tertolak, revisi, atau arsip
        if (in_array($status, ['tertolak', 'revisi', 'arsip']) && empty($pesanBaru)) {
            return redirect()->back()->withInput()->with('error', 'Pesan wajib diisi untuk status ini.');
        }

        // Validasi inputan
        $validationRules = [
            'judul' => 'required|max_length[100]',
            'deskripsi' => 'required',
            'tahun' => 'required',
            'kategori' => 'required',
            'bentuk' => 'required',
            'tahapan' => 'required',
            'id_opd' => 'permit_empty',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil nilai id_opd dari input
        $id_opd = $this->request->getPost('id_opd') ?: $inovasi['id_opd']; // Gunakan nilai sebelumnya jika tidak ada input

        // Persiapkan data untuk diupdate
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tahun' => $this->request->getPost('tahun'),
            'kategori'  => $this->request->getPost('kategori'),
            'bentuk'    => $this->request->getPost('bentuk'),
            'tahapan'   => $this->request->getPost('tahapan'),
            'status'    => $status,
            'id_opd'    => $id_opd, // Simpan nilai null atau nilai sebelumnya
            'kecamatan' => $this->request->getPost('kecamatan'),
            'desa'      => $this->request->getPost('desa'),
        ];

        // Gabungkan pesan lama dan baru jika status adalah revisi
        if ($status === 'revisi' && !empty($pesanBaru)) {
            $pesanLama = $inovasi['pesan'] ?? '';
            $data['pesan'] = !empty($pesanLama) ? $pesanLama . "\n" . $pesanBaru : $pesanBaru;
        } else {
            $data['pesan'] = $inovasi['pesan'] ?? null;
        }

        // Jika status adalah 'terbit', tambahkan metadata
        if ($status === 'terbit') {
            $data['updated_at'] = Time::now('Asia/Jakarta', 'id')->toDateTimeString();
            $user = auth()->user();
            $data['published_by'] = $user->id;
        }

        // Cek apakah ada file baru yang diunggah
        $file = $this->request->getFile('url_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $oldFile = $inovasi['url_file'];
            if (!empty($oldFile) && file_exists(FCPATH . $oldFile)) {
                unlink(FCPATH . $oldFile);
            }

            if ($file->getClientExtension() !== 'pdf') {
                return redirect()->back()->withInput()->with('error', 'File harus berformat PDF.');
            }

            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['url_file'] = 'uploads/' . $newName;
        } else {
            $data['url_file'] = $inovasi['url_file'];
        }

        // **Menetapkan status menjadi "tertunda" sebelum update**
        $data['status'] = 'tertunda'; // Pastikan status menjadi 'tertunda' sebelum disimpan


        // Update data
        $this->inovasiModel->update($id_inovasi, $data);

        // Log aktivitas
        $user = auth()->user()->id;
        $logData = [
            'id_user' => $user,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'update',
            'jenis_data' => 'Inovasi',
            'keterangan' => "admin dengan ID {$user} memperbarui Inovasi dengan ID {$id_inovasi}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/admin/inovasi/filter')->with('success', 'Inovasi berhasil diperbarui.');
    }

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
            'keterangan' => "kepala dengan ID {$user} menghapus Inovasi dengan ID {$id_inovasi}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/admin/inovasi/filter')->with('success', 'Proposal berhasil dihapus.');
    }

    public function show($id_inovasi)
    {
        $data['inovasi'] = $this->inovasiModel
            ->select('inovasi.*, 
                 jenis_inovasi.nama_jenis, 
                 bentuk.nama_bentuk, 
                 tahapan.nama_tahapan, 
                 kecamatan.nama_kecamatan, 
                 desa.nama_desa, 
                 users.username as diajukan_oleh') // Menambahkan nama-nama terkait
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users untuk mendapatkan username
            ->where('inovasi.id_inovasi', $id_inovasi)
            ->first();
        return view('admin/inovasi/show', $data);
    }


    public function getDesa()
    {
        // Ambil id_kecamatan dari parameter GET
        $id_kecamatan = $this->request->getGet('id_kecamatan');

        if ($id_kecamatan) {
            // Query untuk mengambil desa berdasarkan id_kecamatan
            $desaModel = new DesaModel();
            $desa = $desaModel->where('id_kecamatan', $id_kecamatan)->findAll();

            // Mengembalikan response dalam format JSON
            return $this->response->setJSON($desa);
        } else {
            return $this->response->setJSON([]);
        }
    }
}
