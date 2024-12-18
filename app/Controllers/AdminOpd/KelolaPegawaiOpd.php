<?php

namespace App\Controllers\AdminOpd;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Controllers\RegisterController as BaseRegisterController;
use App\Models\OpdModel;
use App\Models\UserModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use App\Models\GroupModel;
use CodeIgniter\I18n\Time;

class KelolaPegawaiOpd extends BaseRegisterController
{
    public function __construct()
    {
        $this->userModel = new UserModel(); // Inisialisasi model pengguna
    }

    public function index()
    {
        $userModel = new UserModel();
        $groupModel = new GroupModel();
        $opdModel = new OpdModel();
        
        // Ambil OPD admin-opd yang sedang login
        $adminOpdId = auth()->user()->id_opd;
    
        // Ambil nama OPD berdasarkan ID
        $opdNames = [];
        $allOpds = $opdModel->findAll();
        foreach ($allOpds as $opd) {
            $opdNames[$opd->id_opd] = $opd->nama_opd;
        }
    
        $pegawaiOPD = [];
    
        // Ambil pengguna yang aktif dengan id_opd sesuai admin-opd yang login
        $users = $userModel->where('active', 1)->where('id_opd', $adminOpdId)->findAll();
        foreach ($users as $user) {
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group');
    
            // Filter untuk role tertentu di OPD tersebut
            if (array_intersect(['sekertaris-opd', 'kepala-opd', 'operator'], $groupNames)) {
                $namaOpd = $opdNames[$user->id_opd] ?? 'Tidak Diketahui';
    
                $pegawaiOPD[] = [
                    'id' => $user->id,
                    'id_opd' => $namaOpd,
                    'no_telepon' => $user->no_telepon,
                    'name' => $user->name,
                    'NIP' => $user->NIP,
                    'email' => $user->email,
                    'active' => $user->active,
                    'group' => implode(', ', $groupNames)
                ];
            }
        }
    
        return view('admin_opd/kelola_pegawai/pegawai_list', ['pegawaiOPD' => $pegawaiOPD]);
    }
    
    public function create()
    {
        // Ambil `id_opd` langsung dari pengguna yang sedang login
        $adminOpdId = auth()->user()->id_opd;
    
        // Ambil data kepala-opd
        $db = \Config\Database::connect();
        $builder = $db->table('auth_groups_users');
        $builder->select('auth_groups_users.user_id, auth_groups_users.group, users.id_opd');
        $builder->join('users', 'users.id = auth_groups_users.user_id');
        $builder->where('auth_groups_users.group', 'kepala-opd');
        $query = $builder->get();
        $usersWithHead = $query->getResult();
    
        // Ambil semua opd_id yang sudah memiliki kepala-opd
        $opdWithHead = [];
        foreach ($usersWithHead as $user) {
            $opdWithHead[] = $user->id_opd;
        }
    
        // Ambil data OPD admin yang sedang login
        $opdModel = new OpdModel();
        $opd = $opdModel->where('id_opd', $adminOpdId)->first();
    
        return view('admin_opd/kelola_pegawai/create_pegawai', [
            'opd' => $opd,
            'opdWithHead' => $opdWithHead,
        ]);
    }
    
    
    
    public function store(): RedirectResponse
{
    $users = $this->getUserProvider();

    // Validasi terlebih dahulu
    $rules = config('Validation')->createUser;

    if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Simpan user
    $allowedPostFields = array_keys($rules);
    $user = $this->getUserEntity();
    $user->fill($this->request->getPost($allowedPostFields));

    // Menentukan id_opd untuk user yang sedang login (admin-opd)
    $user->id_opd = auth()->user()->id_opd; // Set 'id_opd' ke ID OPD milik admin yang sedang login

    // Penanganan untuk pendaftaran menggunakan email saja
    if ($user->username === null) {
        $user->username = null;
    }

    try {
        $users->save($user);
    } catch (ValidationException $e) {
        return redirect()->back()->withInput()->with('errors', $users->errors());
    }

    // Dapatkan objek user lengkap dengan ID
    $user = $users->findById($users->getInsertID());

    // Ambil grup dari input form
    $group = $this->request->getPost('group');

    $groupModel = new GroupModel();
    $groupModel->addUserToGroup($user->id, $group);

    Events::trigger('register', $user);

    // Nonaktifkan otomatisasi OTP/aktivasi akun
    $user->active = true;
    $users->save($user);

    // Catat log aktivitas
    $superAdminId = auth()->user()->id;
    $logData = [
        'id_user'          => $superAdminId,
        'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
        'aksi'             => 'create',
        'jenis_data'       => 'User',
        'keterangan'       => "Admin-OPD dengan ID {$superAdminId} membuat User baru dengan ID {$user->id} dan grup {$group}",
    ];

    $logModel = new LogAktivitasModel();
    $logModel->save($logData);

    // Tentukan arah redirect berdasarkan group yang diinputkan
    if ($group === 'admin-opd') {
        return redirect()->to('/adminopd/pegawai/list')
            ->with('message', 'Anda Berhasil membuat Akun.');
    } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
        return redirect()->to('/adminopd/pegawai/list')
            ->with('message', 'Anda Berhasil membuat Akun.');
    }

    // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
    return redirect()->to('/adminopd/pegawai/list')
        ->with('message', 'Anda Berhasil membuat Akun.');
}


    public function edit(string $id) // Ubah tipe parameter menjadi string
    {
                // Ambil `id_opd` langsung dari pengguna yang sedang login
                $adminOpdId = auth()->user()->id_opd;
    
                // Ambil data kepala-opd
                $db = \Config\Database::connect();
                $builder = $db->table('auth_groups_users');
                $builder->select('auth_groups_users.user_id, auth_groups_users.group, users.id_opd');
                $builder->join('users', 'users.id = auth_groups_users.user_id');
                $builder->where('auth_groups_users.group', 'kepala-opd');
                $query = $builder->get();
                $usersWithHead = $query->getResult();
            
                // Ambil semua opd_id yang sudah memiliki kepala-opd
                $opdWithHead = [];
                foreach ($usersWithHead as $user) {
                    $opdWithHead[] = $user->id_opd;
                }
        // Ambil encrypter dari service untuk dekripsi
        $encrypter = \Config\Services::encrypter();
    
        // Dekripsi ID
        try {
            // Dekripsi ID terenkripsi (menggunakan hex2bin untuk mengkonversi dari hex)
            $decryptedId = $encrypter->decrypt(hex2bin($id));
    
            // Pastikan ID yang terdekripsi adalah integer
            $decryptedId = (int) $decryptedId;
        } catch (\Exception $e) {
            // Tangani jika dekripsi gagal
            return redirect()->back()->with('error', 'ID tidak valid.');
        }
    
        // Ambil data user berdasarkan ID yang terdekripsi
        $users = $this->getUserProvider();
        $user = $users->findById($decryptedId);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
    
        // Ambil ID OPD admin yang sedang login
        $adminOpdId = auth()->user()->id_opd;
        $opdModel = new OpdModel();
        $opd = $opdModel->find($adminOpdId);
    
        // Cek apakah user memiliki izin untuk mengedit data
        if (!auth()->user()->inGroup('admin-opd') || $user->id_opd !== $adminOpdId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
        }
    
        // Mengambil grup pengguna menggunakan Shield
        $groupModel = model('GroupModel'); // Pastikan GroupModel dari Shield digunakan
        $userGroups = $groupModel->getGroupsForUser($user->id);
    
        // Ambil nama grup dalam bentuk array, seperti yang dilakukan di controller index
        $groupNames = array_column($userGroups, 'group');
    
        // Set nama grup default jika ada
        $user->group = !empty($groupNames) ? $groupNames[0] : null;
                    
        // Kirim data ke view
        return view('admin_opd/kelola_pegawai/edit_pegawai', [
            'user' => $user,
            'opd' => $opd,
            'opdWithHead' => $opdWithHead,
        ]);
    }
    
    

     
    
    public function update(): RedirectResponse
    {
        $id = $this->request->getPost('id');
        $users = $this->getUserProvider();
    
        // Dapatkan user berdasarkan ID
        $user = $users->findById($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
    
        // Ambil rules dari validation config (misalnya editUser)
        $rules = config('Validation')->editUser;
    
        // Modifikasi aturan agar semua field menjadi opsional
        foreach ($rules as $field => &$rule) {
            $rule['rules'] = array_merge(['permit_empty'], $rule['rules']);
        }
    
        // Menambahkan aturan unik untuk email hanya jika email diubah
        $newEmail = $this->request->getPost('email');
        if ($newEmail && $newEmail !== $user->email) {
            $rules['email']['rules'][] = 'is_unique[auth_identities.secret,id,' . $id . ']';
        }
    
        // Menambahkan aturan unik untuk no_telepon dan NIP hanya jika diubah
        $newNoTelepon = $this->request->getPost('no_telepon');
        if ($newNoTelepon && $newNoTelepon !== $user->no_telepon) {
            $rules['no_telepon']['rules'][] = 'is_unique[users.no_telepon,id,' . $id . ']';
        }
    
        $newNIP = $this->request->getPost('NIP');
        if ($newNIP && $newNIP !== $user->NIP) {
            $rules['NIP']['rules'][] = 'is_unique[users.NIP,id,' . $id . ']';
        }
    
        // Lakukan validasi
        if (!$this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Update data user
        $allowedPostFields = array_keys($rules);
        $user->fill($this->request->getPost($allowedPostFields));
    
        // Jika admin tidak dapat mengedit OPD, pastikan id_opd tidak diubah
        $adminOpdId = auth()->user()->id_opd;
        if ($this->request->getPost('id_opd') != $adminOpdId) {
            $user->id_opd = $adminOpdId; // Mengatur id_opd tetap sesuai dengan admin yang sedang login
        }
    
        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }
    
        // Jika grup diubah
        $group = $this->request->getPost('group');
        if ($group) {
            $groupModel = new GroupModel();
    
            // Hapus semua grup yang terkait dengan user saat ini
            $groupModel->removeUserFromAllGroups($user->id);
    
            // Tambahkan user ke grup baru dari form
            $groupModel->addUserToGroup($user->id, $group);
        }
    
        // Catat log aktivitas
        $superAdminId = auth()->user()->id;
        $logData = [
            'id_user'          => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'             => 'update',
            'jenis_data'       => 'User',
            'keterangan'       => "Admin OPD dengan ID {$superAdminId} mengupdate User baru dengan ID {$user->id} dan grup {$group}",
        ];
    
        $logModel = new LogAktivitasModel();
        $logModel->save($logData);
    
        // Tentukan arah redirect berdasarkan group yang diinputkan
        if ($group === 'admin-opd') {
            return redirect()->to('/adminopd/pegawai/list')
                ->with('message', 'Pembuatan akun berhasil.');
        } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
            return redirect()->to('/adminopd/pegawai/list')
                ->with('message', 'Data berhasil diubah.');
        }
    
        // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
        return redirect()->to('/adminopd/pegawai/list')
            ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
    }
    


    public function delete()
    {
        // Ambil ID dari request POST
        $id = $this->request->getPost('id');
    
        // Pastikan ID ada dan valid
        if (!$id) {
            return redirect()->back()->with('error', 'ID user tidak ditemukan.');
        }
    
        // Ambil data user yang akan dihapus
        $userModel = new UserModel();
        $user = $userModel->find($id);
    
        // Jika user tidak ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
    
        // Ambil data user yang sedang login
        $currentUser = auth()->user();
    
        // Cek apakah user yang sedang login berada dalam grup admin-opd dan id_opd-nya sama
        $adminOpdId = $currentUser->id_opd;  // Ambil id_opd dari user yang sedang login
    
        if (!auth()->user()->inGroup('admin-opd') || $user->id_opd !== $adminOpdId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus user ini.');
        }
    
        // Hapus user secara permanen
        if ($userModel->delete($id, true)) {
            // Catat log aktivitas
            $logModel = new LogAktivitasModel();
            $logData = [
                'id_user'          => $currentUser->id,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'delete',
                'jenis_data'       => 'User',
                'keterangan'       => "Admin-OPD dengan ID {$currentUser->id} menghapus User dengan ID {$user->id}",
            ];
    
            $logModel->save($logData);
    
            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
    
    
    




    public function nonActiveList()
    {
        $userModel = new UserModel();
        $opdModel = new OpdModel();

        // Ambil semua pengguna yang belum aktif
        $users = $userModel->where('active', 0)->findAll();

        foreach ($users as $user) {
            // Ambil data OPD dan email dari tabel masing-masing
            $user->nama_opd = $opdModel->find($user->id_opd)->nama_opd ?? 'Tidak Diketahui';
            $user->email = $user->getEmail(); // Metode getEmail() sesuai entitas email
        }



        return view('super_admin/user/aktivasi', ['users' => $users]);
    }


    public function activate($id)
    {
        $userModel = new UserModel();

        // Dapatkan data user berdasarkan ID
        $user = $userModel->find($id);

        // Periksa apakah user ada dan belum aktif
        if (!$user || $user->active == 1) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau sudah aktif.');
        }
        // Update status active menjadi 1
        $user->active = 1;
        $userModel->save($user);

        $superAdminId = auth()->user()->id;
        $logData = [
            'id_user'          => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'             => 'aktivasi',
            'jenis_data'       => 'User',
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} mengaktifkan User baru dengan ID {$user->id}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);
        // Kirim email notifikasi aktivasi
        $email = \Config\Services::email();
        $email->setTo($user->email);
        $email->setSubject('Pemberitahuan Aktivasi Akun - Balitbang Pesawaran');

        // Pesan email formal
        $message = "
            <p>Yth. {$user->name},</p>
            
            <p>Dengan hormat,</p>
            
            <p>Sehubungan dengan pendaftaran Anda sebagai pengguna di sistem kami, kami ingin memberitahukan bahwa akun Anda telah berhasil diaktifkan. Anda sekarang dapat masuk ke sistem menggunakan akun Anda.</p>
            
            <p>Apabila Anda memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
            
            <p>Terima kasih atas perhatian dan kerjasama Anda.</p>

            <p>Hormat kami,</p>
            <p>Balitbang Pesawaran<br>
            [Alamat Instansi]<br>
            [Nomor Telepon Instansi]<br>
            [Email Instansi]</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html'); // Mengatur jenis email ke HTML
        if ($email->send()) {
            return redirect()->back()->with('message', 'Akun berhasil diaktifkan dan email notifikasi telah dikirim.');
        } else {
            return redirect()->back()->with('error', 'Akun berhasil diaktifkan namun email gagal dikirim.');
        }
    }

    public function reject($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        
        // Periksa apakah user ada dan belum aktif
        if (!$user || $user->active == 1) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau sudah aktif.');
        }
        
        // Kirim email notifikasi penolakan
        $email = \Config\Services::email();
        $email->setTo($user->email);
        $email->setSubject('Penolakan Aktivasi Akun - Balitbang Pesawaran');
        
        $message = "
            <p>Yth. {$user->name},</p>
            
            <p>Kami mohon maaf, pendaftaran Anda tidak dapat kami terima. Silakan mencoba mendaftar kembali dengan data yang sesuai.</p>
            
            <p>Terima kasih atas perhatian Anda.</p>
            
            <p>Hormat kami,</p>
            <p>Balitbang Pesawaran</p>
        ";
        
        $email->setMessage($message);
        $email->setMailType('html');
        
        if ($email->send()) {
            // Jika email berhasil dikirim, hapus akun secara permanen
            $userModel->delete($id, true); // Parameter true untuk penghapusan permanen
            
            // Log aktivitas penolakan
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'penolakan',
                'jenis_data'       => 'User',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menolak aktivasi User dengan ID {$user->id}",
            ];
            
            $logModel = new LogAktivitasModel();
            $logModel->save($logData);
            
            return redirect()->back()->with('message', 'Akun berhasil ditolak, dihapus secara permanen, dan email notifikasi penolakan telah dikirim.');
        } else {
            return redirect()->back()->with('error', 'Email penolakan gagal dikirim. Akun tidak dihapus.');
        }
    }
}