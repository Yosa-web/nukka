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

        // Ambil semua pengguna yang aktif dengan filter id_opd tidak kosong dan group admin-opd
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

        // Ambil semua pengguna yang aktif dengan filter id_opd tidak kosong
        $users = $userModel->where('id_opd !=', null)->findAll();
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
        $opdNames = []; // Menyimpan nama OPD jika diperlukan

        $penggunaUmum = [];

        // Ambil semua pengguna yang aktif dengan filter id_opd kosong
        $users = $userModel->where('id_opd', null)->findAll();

        foreach ($users as $user) {
            // Ambil grup pengguna
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group');

            // Filter untuk group sekertaris-opd, kepala-opd, atau operator
            if (array_intersect(['user',], $groupNames)) {
                // Mendapatkan nama OPD berdasarkan id_opd, jika ada
                $namaOpd = $opdNames[$user->id_opd] ?? 'Tidak Diketahui'; // Sesuaikan dengan cara kamu mendapatkan nama OPD

                // Menambahkan data pengguna umum ke dalam array
                $penggunaUmum[] = [
                    'id' => $user->id,
                    'no_telepon' => $user->no_telepon,
                    'name' => $user->name,
                    'NIP' => $user->NIP,
                    'NIK' => $user->NIK,
                    'email' => $user->email,
                    'active' => $user->active,
                    'group' => implode(', ', $groupNames),
                    'nama_opd' => $namaOpd // Menambahkan nama OPD jika ada
                ];
            }
        }

        return view('super_admin/user/umum/umum_list', ['penggunaUmum' => $penggunaUmum]);
    }



    public function createAdmin()
    {
        // Inisialisasi model OPD
        $opdModel = new OpdModel();

        // Mendapatkan instance database
        $db = \Config\Database::connect();

        // Mendapatkan daftar id_opd yang sudah digunakan oleh user dalam grup 'admin-opd'
        $usedOpdIds = $db->table('auth_groups_users')
            ->join('users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group', 'admin-opd')
            ->select('users.id_opd')
            ->distinct()
            ->get()
            ->getResultArray();

        // Ekstrak id_opd yang digunakan ke dalam array
        $usedOpdIdsArray = array_column($usedOpdIds, 'id_opd');

        // Ambil OPD yang belum digunakan (tidak ada dalam daftar id_opd yang sudah digunakan)
        $opd = $opdModel->getAvailableOpd($usedOpdIdsArray); // Menggunakan fungsi getAvailableOpd

        // Kirim data OPD ke view
        return $this->view('super_admin/user/admin_opd/create_admin', ['opd' => $opd]);
    }



    public function createPegawai()
    {
        // Ambil data dari tabel opd
        $opdModel = new OpdModel();
        $opdData = $opdModel->findAll();

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

        // Debug: Periksa data yang dikirim ke view
        var_dump($opdWithHead);

        return $this->view('super_admin/user/pegawai/create_pegawai', [
            'opd' => $opdData,
            'opdWithHead' => $opdWithHead,
            'id_opd' => old('id_opd')
        ]);
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
            'aksi'             => 'tambah data',
            'jenis_data'       => 'User',
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} membuat User baru dengan ID {$user->id} dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Tentukan arah redirect berdasarkan group yang diinputkan
        if ($group === 'admin-opd') {
            return redirect()->to('/superadmin/user/list/admin')
                ->with('message', 'Data user berhasil ditambahkan!');
        } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
            return redirect()->to('/superadmin/user/list/pegawai')
                ->with('message', 'Data user berhasil ditambahkan!');
        }

        // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
        return redirect()->to('/superadmin/user/list/admin')
            ->with('message', 'Data user berhasil ditambahkan!');
    }




    public function editAdmin(string $id)
    {

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

        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($decryptedId);

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


    public function editPegawai(string $id)
    {
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

        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($decryptedId);

        if (!$user) {
            return redirect()->to('/superadmin/user/pegawai/pegawai_list')
                ->with('error', 'User tidak ditemukan.');
        }

        // Ambil grup user saat ini menggunakan GroupModel
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getGroupsForUser($user->id);

        // Ambil nama grup dalam bentuk array, lalu tetapkan ke grup pertama atau 'user' jika tidak ada
        $groupNames = array_column($userGroups, 'group');
        $currentGroup = !empty($groupNames) ? $groupNames[0] : 'user';

        // Ambil data OPD
        $opdModel = new OpdModel();
        $opd = $opdModel->findAll();

        // Ambil data kepala-opd
        $db = \Config\Database::connect();
        $builder = $db->table('auth_groups_users');
        $builder->select('auth_groups_users.user_id, auth_groups_users.group, users.id_opd');
        $builder->join('users', 'users.id = auth_groups_users.user_id');
        $builder->where('auth_groups_users.group', 'kepala-opd');
        $query = $builder->get();
        $usersWithHead = $query->getResult();

        // Ambil semua id_opd yang sudah memiliki kepala-opd
        $opdWithHead = [];
        foreach ($usersWithHead as $head) {
            $opdWithHead[] = $head->id_opd;
        }

        // Jika user yang sedang diedit adalah kepala OPD, tambahkan id_opd-nya ke dalam daftar
        if ($currentGroup === 'kepala-opd' && !in_array($user->id_opd, $opdWithHead)) {
            $opdWithHead[] = $user->id_opd;
        }


        // Kirim data user, grup, OPD, dan status ke view
        return view('super_admin/user/pegawai/edit_pegawai', [
            'user' => $user,
            'currentGroup' => $currentGroup, // Kirim grup saat ini ke view
            'opd' => $opd, // Kirim data OPD ke view
            'opdWithHead' => $opdWithHead, // Kirim daftar OPD yang sudah memiliki kepala
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

        // Tambahkan validasi untuk field `active`
        $rules['active'] = [
            'rules' => 'required|in_list[0,1]',
            'label' => 'Status'
        ];

        // Lakukan validasi
        if (!$this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data user
        $allowedPostFields = array_keys($rules);
        $user->fill($this->request->getPost($allowedPostFields));

        // Set field `active` sesuai input
        $user->active = $this->request->getPost('active');

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
            'keterangan'       => "SuperAdmin dengan ID {$superAdminId} mengupdate User dengan ID {$user->id}, status aktif {$user->active}, dan grup {$group}",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Tentukan arah redirect berdasarkan group yang diinputkan
        if ($group === 'admin-opd') {
            return redirect()->to('/superadmin/user/list/admin')
                ->with('message', 'Data user berhasil diperbarui.');
        } elseif (in_array($group, ['sekertaris-opd', 'kepala-opd', 'operator'])) {
            return redirect()->to('/superadmin/user/list/pegawai')
                ->with('message', 'Data user berhasil diperbarui.');
        }

        // Jika group tidak sesuai dengan kondisi yang ada, tetap redirect ke daftar pengguna admin
        return redirect()->to('/superadmin/user/list/admin')
            ->with('message', 'Data user berhasil diperbarui.');
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
            ->with('message', 'Data user berhasil ditambahkan!');
    }


    public function editUserUmum(string $id)
    {
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

        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan ID
        $user = $users->findById($decryptedId);

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

        // Tambahkan aturan untuk active agar menjadi opsional
        $rules['active'] = [
            'rules' => 'permit_empty|in_list[0,1]',
            'label' => 'Status Aktivasi'
        ];

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


    public function delete()
    {
        // Ambil ID dari request POST
        $id = $this->request->getPost('id');
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

            return redirect()->back()->with('message', 'User berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }




    public function nonActiveList()
    {
        $userModel = new UserModel();
        $opdModel = new OpdModel();
        $groupModel = new GroupModel(); // Model untuk menangani grup pengguna

        // Ambil semua pengguna yang belum aktif dan memiliki grup 'admin-opd'
        $users = $userModel
            ->select('users.*, auth_groups_users.group')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->where('active', 0)
            ->where('auth_groups_users.group', 'admin-opd')
            ->findAll();

        foreach ($users as $user) {
            // Ambil data OPD dan email dari tabel masing-masing
            $user->nama_opd = $opdModel->find($user->id_opd)->nama_opd ?? 'Tidak Diketahui';
            $user->email = $user->getEmail(); // Metode getEmail() sesuai entitas email
        }

        return view('super_admin/user/aktivasi', ['users' => $users]);
    }

    public function countNonActiveAdmins()
    {
        $userModel = new UserModel();

        // Hitung jumlah pengguna dengan kondisi yang sesuai
        $count = $userModel
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->where('active', 0)
            ->where('auth_groups_users.group', 'admin-opd')
            ->countAllResults();

        // Kembalikan response dalam format JSON
        return $this->response->setJSON(['count' => $count]);
    }



    public function activate()
    {
        $userModel = new UserModel();

        // Dapatkan ID dari input POST
        $id = $this->request->getPost('id');
        $user = $userModel->find($id);

        if (!$user || $user->active == 1) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau sudah aktif.');
        }

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

        $email = \Config\Services::email();
        $email->setTo($user->email);
        $email->setSubject('Pemberitahuan Aktivasi Akun - Balitbang Pesawaran');

        $message = "
            <p>Yth. {$user->name},</p>
            <p>Dengan hormat,</p>
            <p>Sehubungan dengan pendaftaran Anda sebagai pengguna di sistem kami, kami ingin memberitahukan bahwa akun Anda telah berhasil diaktifkan. Anda sekarang dapat masuk ke sistem menggunakan akun Anda.</p>
            <p>Hormat kami,</p>
            <p>Balitbang Pesawaran</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html');

        if ($email->send()) {
            return redirect()->back()->with('message', 'Akun berhasil diaktifkan dan email notifikasi telah dikirim.');
        } else {
            return redirect()->back()->with('error', 'Akun berhasil diaktifkan namun email gagal dikirim.');
        }
    }


    public function reject()
    {
        $userModel = new UserModel();

        $id = $this->request->getPost('id');
        $user = $userModel->find($id);

        if (!$user || $user->active == 1) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau sudah aktif.');
        }

        $email = \Config\Services::email();
        $email->setTo($user->email);
        $email->setSubject('Penolakan Aktivasi Akun - Balitbang Pesawaran');

        $message = "
            <p>Yth. {$user->name},</p>
            <p>Kami mohon maaf, pendaftaran Anda tidak dapat kami terima. Silakan mencoba mendaftar kembali dengan data yang sesuai.</p>
            <p>Hormat kami,</p>
            <p>Balitbang Pesawaran</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html');

        if ($email->send()) {
            $userModel->delete($id, true);

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
