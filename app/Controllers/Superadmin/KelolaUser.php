<?php

namespace App\Controllers\Superadmin;

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

class KelolaUser extends BaseRegisterController
{
    public function __construct()
    {
        $this->userModel = new UserModel(); // Inisialisasi model pengguna
    }

    public function indexAdmin()
    {
        $userModel = new UserModel();
        $groupModel = new GroupModel();
        $opdModel = new OpdModel();

        // Ambil semua OPD dan buat array mapping ID ke nama OPD
        $allOpds = $opdModel->findAll();
        $opdNames = [];
        foreach ($allOpds as $opd) {
            $opdNames[$opd->id_opd] = $opd->nama_opd;
        }

        $penggunaOPD = [];

        // Ambil semua pengguna yang aktif dengan filter `id_opd` tidak kosong dan group `admin-opd`
        $users = $userModel->where('active', 1)->where('id_opd !=', null)->findAll();
        foreach ($users as $user) {
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group');

            if (in_array('admin-opd', $groupNames)) {
                $namaOpd = $opdNames[$user->id_opd] ?? 'Tidak Diketahui';

                $penggunaOPD[] = [
                    'id' => $user->id,
                    'id_opd' => $namaOpd,
                    'no_telepon' => $user->no_telepon,
                    'name' => $user->name,
                    'NIP' => $user->NIP,
                    'email' => $user->email,
                    'active' => $user->active,
                    'group' => 'admin-opd'
                ];
            }
        }

        return view('super_admin/user/admin_opd/admin_list', ['penggunaOPD' => $penggunaOPD]);
    }


    public function indexPegawai()
    {
        $userModel = new UserModel();
        $groupModel = new GroupModel();
        $opdModel = new OpdModel();

        // Ambil semua OPD dan buat array mapping ID ke nama OPD
        $allOpds = $opdModel->findAll();
        $opdNames = [];
        foreach ($allOpds as $opd) {
            $opdNames[$opd->id_opd] = $opd->nama_opd;
        }

        $pegawaiOPD = [];

        // Ambil semua pengguna yang aktif dengan filter `id_opd` tidak kosong
        $users = $userModel->where('active', 1)->where('id_opd !=', null)->findAll();
        foreach ($users as $user) {
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group');

            // Filter untuk group sekertaris-opd, kepala-opd, atau operator
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

        return view('super_admin/user/pegawai/pegawai_list', ['pegawaiOPD' => $pegawaiOPD]);
    }


    public function indexUmum()
    {
        $userModel = new UserModel();
        $groupModel = new GroupModel();

        $penggunaUmum = [];

        // Ambil semua pengguna yang aktif dengan filter `id_opd` kosong
        $users = $userModel->where('active', 1)->where('id_opd', null)->findAll();
        foreach ($users as $user) {
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group');

            $penggunaUmum[] = [
                'id' => $user->id,
                'no_telepon' => $user->no_telepon,
                'name' => $user->name,
                'NIP' => $user->NIP,
                'NIK' => $user->NIK,
                'email' => $user->email,
                'active' => $user->active,
                'group' => implode(', ', $groupNames)
            ];
        }

        return view('super_admin/user/umum/umum_list', ['penggunaUmum' => $penggunaUmum]);
    }


    public function createAdmin()
    {
        // Ambil data dari tabel opd
        $opdModel = new OpdModel(); // Inisialisasi model opd
        $test['opd'] = $opdModel->findAll(); // Ambil semua data opd

        // Kirim data ke view
        return $this->view('super_admin/user/admin_opd/create_admin', $test);
    }

    public function createPegawai()
    {
        // Ambil data dari tabel opd
        $opdModel = new OpdModel(); // Inisialisasi model opd
        $test['opd'] = $opdModel->findAll(); // Ambil semua data opd

        // Kirim data ke view
        return $this->view('super_admin/user/pegawai/create_pegawai', $test);
    }

    public function createUmum()
    {
        // Kirim data ke view
        return $this->view('super_admin/user/umum/create_umum');
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
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} membuat User baru dengan ID {$user->id} dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Tentukan arah redirect berdasarkan group yang diinputkan
        if ($group === 'admin-opd') {
            return redirect()->to('/superadmin/user/list/admin')
                ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
        } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
            return redirect()->to('/superadmin/user/list/pegawai')
                ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
        }

        // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
        return redirect()->to('/superadmin/user/list/admin')
            ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
    }




    public function editAdmin(int $id)
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($id);

        if (!$user) {
            return redirect()->to('/superadmin/user/admin_opd/admin_list')
                ->with('error', 'User tidak ditemukan.');
        }

        // Ambil grup user saat ini menggunakan GroupModel
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getGroupsForUser($user->id);

        // Ambil nama grup, atau jika tidak ada, tetapkan ke 'user' sebagai default
        $currentGroup = !empty($userGroups) ? $userGroups[0]['group'] : 'user';

        // Ambil data OPD
        $opdModel = new OpdModel();
        $opd = $opdModel->findAll();

        // Kirim data user, grup, dan OPD ke view
        return view('super_admin/user/admin_opd/edit_admin', [
            'user' => $user,
            'currentGroup' => $currentGroup, // Kirim grup saat ini ke view
            'opd' => $opd, // Kirim data OPD ke view
        ]);
    }


    public function editPegawai(int $id)
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($id);

        if (!$user) {
            return redirect()->to('/superadmin/user/pegawai/pegawai_list')
                ->with('error', 'User tidak ditemukan.');
        }

        // Ambil grup user saat ini menggunakan GroupModel
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getGroupsForUser($user->id);

        // Ambil nama grup, atau jika tidak ada, tetapkan ke 'user' sebagai default
        $currentGroup = !empty($userGroups) ? $userGroups[0]['group'] : 'user';

        // Ambil data OPD
        $opdModel = new OpdModel();
        $opd = $opdModel->findAll();

        // Kirim data user, grup, dan OPD ke view
        return view('super_admin/user/pegawai/edit_pegawai', [
            'user' => $user,
            'currentGroup' => $currentGroup, // Kirim grup saat ini ke view
            'opd' => $opd, // Kirim data OPD ke view
        ]);
    }



    public function update(int $id): RedirectResponse
    {
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
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} mengupdate User baru dengan ID {$user->id} dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Tentukan arah redirect berdasarkan group yang diinputkan
        if ($group === 'admin-opd') {
            return redirect()->to('/superadmin/user/list/admin')
                ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
        } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
            return redirect()->to('/superadmin/user/list/pegawai')
                ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
        }

        // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
        return redirect()->to('/superadmin/user/list/admin')
            ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
    }



    //Pengguna UMUM
    public function createUserUmum()
    {

        // Kirim data ke view
        return $this->view('super_admin/user/create_user');
    }

    public function storeUserUmum(): RedirectResponse
    {
        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = config('Validation')->createUserUmum;

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Ambil grup dari input form
        $group = $this->request->getPost('group');

        $groupModel = new GroupModel();
        $groupModel->addUserToGroup($user->id, $group); // Menambahkan user ke grup dari form input

        Events::trigger('register', $user);

        // Nonaktifkan otomatisasi OTP/aktivasi akun
        // Set akun sebagai non-aktif (superadmin yang akan mengaktifkan)
        $user->active = true;
        $users->save($user);


        // Catat log aktivitas
        $superAdminId = auth()->user()->id;
        $logData = [
            'id_user'          => $superAdminId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'             => 'create',
            'jenis_data'       => 'User',
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} membuat User baru dengan ID {$user->id} dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);
        // Jangan panggil startLogin dan completeLogin untuk menghindari login langsung

        // Success - Informasikan bahwa akun akan diaktivasi oleh superadmin
        return redirect()->to('/superadmin/user/list/umum')
            ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
    }


    public function editUserUmum(int $id)
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($id);

        if (!$user) {
            return redirect()->to('/superadmin/user/list')
                ->with('error', 'User tidak ditemukan.');
        }

        // Ambil grup user saat ini menggunakan GroupModel
        $groupModel = new GroupModel();
        $userGroup = $groupModel->getGroupsForUser($user->id);


        // Kirim data user, grup, dan OPD ke view
        return view('super_admin/user/umum/edit_umum', [
            'user' => $user,
        ]);
    }





    public function updateUserUmum(int $id): RedirectResponse
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Ambil rules dari validation config (misalnya editUser)
        $rules = config('Validation')->editUserUmum;

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

        $newNIP = $this->request->getPost('NIK');
        if ($newNIP && $newNIP !== $user->NIP) {
            $rules['NIK']['rules'][] = 'is_unique[users.NIK,id,' . $id . ']';
        }

        // Lakukan validasi
        if (!$this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data user
        $allowedPostFields = array_keys($rules);
        $user->fill($this->request->getPost($allowedPostFields));

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
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} mengupdate User baru dengan ID {$user->id} dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);


        // Redirect dengan pesan sukses
        return redirect()->to('/superadmin/user/list/umum')
            ->with('message', 'Data user berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();

        // Cek apakah user ada
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Hapus user secara permanen
        if ($userModel->delete($id, true)) {
            // Catat log aktivitas
            $superAdminId = auth()->user()->id;
            $logData = [
                'id_user'          => $superAdminId,
                'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
                'aksi'             => 'delete',
                'jenis_data'       => 'User',
                'keterangan'       => "SuperAdmin dengan ID {$superAdminId} menghapus User dengan ID {$user->id}",
            ];

            $logModel = new LogAktivitasModel();
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
            $user->email = $user->getEmail(); // Metode `getEmail()` sesuai entitas email
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
