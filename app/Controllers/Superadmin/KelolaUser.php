<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Controllers\RegisterController as BaseRegisterController;
use App\Models\OpdModel;
use App\Models\UserModel;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use App\Models\GroupModel;

class KelolaUser extends BaseRegisterController
{
    public function __construct()
    {
        $this->userModel = new UserModel(); // Inisialisasi model pengguna
    }

    public function index()
    {
        $userModel = new UserModel();
        $groupModel = new GroupModel();
    
        // Ambil semua user dari database
        $users = $userModel->findAll();
    
        // Buat array untuk Pengguna OPD dan Pengguna Umum
        $penggunaOPD = [];
        $penggunaUmum = [];
    
        // Ambil grup user dan pisahkan berdasarkan ada atau tidaknya id_opd
        foreach ($users as $user) {        
    
            $groups = $groupModel->getGroupsForUser($user->id);
            $groupNames = array_column($groups, 'group'); // Ambil nama grup
    
            // Buat array data user untuk keperluan view
            $userData = [
                'id' => $user->id,
                'id_opd' => $user->id_opd,
                'no_telepon' => $user->no_telepon,
                'name' => $user->name,
                'NIP' => $user->NIP,
                'NIK' => $user->NIK,
                'email' => $user->email,
                'group' => implode(', ', $groupNames) // Mengonversi array grup ke string
            ];
    
            if (!empty($user->id_opd)) {
                $penggunaOPD[] = $userData;  // Masukkan ke Pengguna OPD jika id_opd ada
            } else {
                $penggunaUmum[] = $userData;  // Masukkan ke Pengguna Umum jika id_opd tidak ada
            }
        }
    
        // Passing data user ke view
        return view('super_admin/user/list_user', [
            'penggunaOPD' => $penggunaOPD,
            'penggunaUmum' => $penggunaUmum,
        ]);
    }
    

    public function create()
    {
        // Ambil data dari tabel opd
        $opdModel = new OpdModel(); // Inisialisasi model opd
        $test['opd'] = $opdModel->findAll(); // Ambil semua data opd

        // Kirim data ke view
        return $this->view('super_admin/user/create_opd', $test);
    }

    public function store(): RedirectResponse
    {
        $users = $this->getUserProvider();
    
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = config('Validation')->createUser;
    
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
    
        // Jangan panggil startLogin dan completeLogin untuk menghindari login langsung
    
        // Success - Informasikan bahwa akun akan diaktivasi oleh superadmin
        return redirect()->to('/superadmin/user/list')
            ->with('message', 'Pendaftaran berhasil! Akun Anda akan diaktivasi oleh superadmin.');
    }
    

    public function edit(int $id)
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
        
        // Jika user tidak ada grup, tetapkan grup default
        // $userGroupName = $userGroup ? $userGroup['group'] : 'user';
        
        // Ambil data OPD
        $opdModel = new OpdModel(); // Pastikan Anda memiliki model ini
        $opd = $opdModel->findAll(); // Ambil semua data OPD
        
        // Kirim data user, grup, dan OPD ke view
        return view('super_admin/user/edit_opd', [
            'user' => $user,
            // 'userGroup' => $userGroupName,
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
    
        // Redirect dengan pesan sukses
        return redirect()->to('/superadmin/user/list')
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
    
        // Jangan panggil startLogin dan completeLogin untuk menghindari login langsung
    
        // Success - Informasikan bahwa akun akan diaktivasi oleh superadmin
        return redirect()->to('/superadmin/user/list')
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
        return view('super_admin/user/edit_user', [
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
    
        // Redirect dengan pesan sukses
        return redirect()->to('/superadmin/user/list')
            ->with('message', 'Data user berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        $userModel = new UserModel();

        // Check if the user exists
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->to('/superadmin/user/list')->with('error', 'User not found.');
        }

        // Delete the user
        if ($userModel->delete($id)) {
            return redirect()->to('/superadmin/user/list')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->to('/superadmin/user/list')->with('error', 'Failed to delete user.');
        }
    }

        
}
