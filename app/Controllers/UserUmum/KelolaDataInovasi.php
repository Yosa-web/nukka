<?php

namespace App\Controllers\UserUmum;

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
        // Mengambil data Kepala OPD yang sedang login
        $user = auth()->user();
        $id_opd = $user->id_opd; // Mengambil id_opd Kepala OPD yang sedang login
        $id_user = $user->id; // Ambil id_user yang sedang login

        // Query untuk mengambil data inovasi
        $query = $this->inovasiModel
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
            ->join('users', 'inovasi.id_user = users.id', 'left'); // Join dengan tabel users untuk mendapatkan nama

        // Menyaring berdasarkan OPD yang sedang login atau id_user jika tidak memiliki OPD
        if ($id_opd) {
            $query->where('inovasi.id_opd', $id_opd);
        } else {
            $query->where('inovasi.id_user', $id_user); // Menampilkan data berdasarkan id_user jika tidak ada OPD
        }

        // Hapus penyaringan status yang bukan 'tertunda' dan 'tertolak' agar semua status ditampilkan
        // Jadi bagian ini dihapus atau dimodifikasi
        // $query->whereNotIn('inovasi.status', ['tertunda', 'tertolak']);

        // Mengatur urutan berdasarkan status inovasi (termasuk 'tertunda')
        $query->orderBy('FIELD(inovasi.status, "tertunda", "draf", "revisi", "terbit", "arsip", "tertolak")');

        // Ambil hasil data inovasi
        $data['inovasi'] = $query->findAll();

        return view('user_umum/inovasi/filter_by_statuses', $data);
    }

    public function create()
    {
        // $data['opd'] = $this->opdModel->findAll(); // Ambil semua data OPD untuk dropdown
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
                 
                 users.username as diajukan_oleh') // Menambahkan nama-nama terkait
            // ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left') // Join dengan tabel bentuk
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left') // Join dengan tabel tahapan
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left') // Join dengan tabel kecamatan
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left') // Join dengan tabel desa
            ->join('users', 'inovasi.id_user = users.id', 'left') // Join dengan tabel users untuk mendapatkan username
            ->findAll();

        // Memasukkan created_at secara manual
        $data['created_at'] = date('Y-m-d H:i:s');
        return view('user_umum/inovasi/create', $data);
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

        // Cek apakah user memiliki OPD
        $id_opd = $user->id_opd;

        // Jika tidak memiliki OPD, atur ID OPD ke NULL atau biarkan kosong, atau gunakan nilai default lain
        if (empty($id_opd)) {
            $id_opd = '-'; // Set ID OPD ke null jika tidak ada
            // Bisa juga mengarahkan ke halaman tertentu jika diperlukan
            // return redirect()->back()->withInput()->with('error', 'User tidak memiliki OPD yang terdaftar.');
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
            // 'id_opd' => $id_opd,  // Gunakan id_opd dari user yang sedang login, atau null jika tidak ada
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
            'keterangan' => "User dengan ID {$user->id} menambahkan data Inovasi dengan ID {$newInovasiId}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/userumum/inovasi/filter')->with('success', 'Inovasi berhasil ditambahkan.');
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
                  users.username as diajukan_oleh') // Menambahkan nama-nama terkait
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

        return view('user_umum/inovasi/edit', $data);
    }


    public function update($id_inovasi)
    {
        // Ambil data inovasi berdasarkan ID
        $inovasi = $this->inovasiModel->find($id_inovasi);
        if (!$inovasi) {
            return redirect()->to('/superadmin/inovasi/filter')->with('error', 'Inovasi tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        $pesanBaru = $this->request->getPost('pesan'); // Pesan baru yang akan diupdate

        // Validasi: Pesan wajib diisi jika status adalah tertolak, revisi, atau arsip
        if (in_array($status, ['tertolak', 'revisi', 'arsip']) && empty($pesanBaru)) {
            return redirect()->back()->withInput()->with('error', 'Pesan wajib diisi untuk status ini.');
        }

        // Validasi inputan untuk kolom lainnya
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

        // Persiapkan data untuk diupdate
        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tahun' => $this->request->getPost('tahun'),
            'kategori'  => $this->request->getPost('kategori'),
            'bentuk'    => $this->request->getPost('bentuk'),
            'tahapan'   => $this->request->getPost('tahapan'),
            'status'    => $status, // Status yang dipilih oleh pengguna
            'id_opd'    => $this->request->getPost('id_opd') ?: null, // Set null jika kosong
            'kecamatan' => $this->request->getPost('kecamatan'),
            'desa'      => $this->request->getPost('desa'),
        ];

        // Jika status adalah revisi, gabungkan pesan lama dan pesan baru
        // Gabungkan pesan lama dan pesan baru jika ada
        if ($status === 'revisi' && !empty($pesanBaru)) {
            // Jika pesan lama ada, gabungkan dengan pesan baru
            $pesanLama = $inovasi['pesan'] ?? '';
            if (!empty($pesanLama)) {
                $pesanGabungan = $pesanLama . "\n" . $pesanBaru; // Gabungkan pesan lama dengan pesan baru, dengan newline (\n) sebagai pemisah
            } else {
                $pesanGabungan = $pesanBaru;  // Jika pesan lama kosong, hanya simpan pesan baru
            }
            $data['pesan'] = $pesanGabungan;
        } else {
            // Jika status bukan revisi atau tidak ada pesan baru, biarkan pesan lama
            $data['pesan'] = $inovasi['pesan'] ?? null;
        }

        // Jika status adalah 'terbit', set published_at dan published_by
        if ($status === 'terbit') {
            $data['updated_at'] = Time::now('Asia/Jakarta', 'id')->toDateTimeString();  // Waktu saat update
            $user = auth()->user();
            $data['published_by'] = $user->id; // Menyimpan ID user yang sedang login, bukan nama
        }

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
        } else {
            // Jika file tidak diubah, gunakan file lama
            $data['url_file'] = $inovasi['url_file'];
        }

        // **Menetapkan status menjadi "tertunda" sebelum update**
        $data['status'] = 'tertunda'; // Pastikan status menjadi 'tertunda' sebelum disimpan


        // Update data di database
        $this->inovasiModel->update($id_inovasi, $data);

        // Log aktivitas
        $user = auth()->user()->id;
        $logData = [
            'id_user' => $user,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi' => 'update',
            'jenis_data' => 'Inovasi',
            'keterangan' => "user dengan ID {$user} memperbarui Inovasi dengan ID {$id_inovasi}",
        ];
        $this->LogAktivitasModel->save($logData);

        return redirect()->to('/userumum/inovasi/filter')->with('success', 'Inovasi berhasil diperbarui.');
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

        return redirect()->to('/userumum/inovasi/filter')->with('success', 'Proposal berhasil dihapus.');
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
        return view('user/umum/inovasi/show', $data);
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
