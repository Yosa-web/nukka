<?php

namespace App\Controllers\Superadmin;

use CodeIgniter\Shield\Controllers\RegisterController as BaseRegisterController;
use App\Models\OpdModel;
use App\Models\UserModel;
use App\Models\LogAktivitasModel;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\HTTP\RedirectResponse;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GroupModel;
use CodeIgniter\I18n\Time;

class KelolaProfile extends BaseRegisterController
{
    public function editProfile()
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan sesi login
        $userId = auth()->user()->id;
        $user = $users->findById($userId);

        if (!$user) {
            return redirect()->to('/dashboard')
                ->with('error', 'User tidak ditemukan.');
        }

        // Kirim data user ke view
        return view('super_admin/user/profile', [
            'user' => $user,
        ]);
    }

    public function updateUser(): RedirectResponse
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan sesi login
        $userId = auth()->id(); // Menggunakan Shield untuk mendapatkan ID pengguna
        $user = $users->findById($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Ambil rules dari validation config (misalnya editUser)
        $rules = config('Validation')->editUser;

        // Modifikasi aturan agar semua field menjadi opsional
        foreach ($rules as $field => &$rule) {
            $rule['rules'] = array_merge(['permit_empty'], $rule['rules']);
        }

        // Menambahkan aturan unik untuk email, no_telepon, dan NIP jika diubah
        $newEmail = $this->request->getPost('email');
        $emailChanged = $newEmail && $newEmail !== $user->email;
        if ($emailChanged) {
            $rules['email']['rules'][] = 'is_unique[auth_identities.secret,id,' . $userId . ']';
            $rules['email']['errors']['is_unique'] = 'Email sudah digunakan oleh pengguna lain.';
        }

        $newPassword = $this->request->getPost('password');
        $passwordChanged = $newPassword && !password_verify($newPassword, $user->password_hash);

        $newNoTelepon = $this->request->getPost('no_telepon');
        if ($newNoTelepon && $newNoTelepon !== $user->no_telepon) {
            $rules['no_telepon']['rules'][] = 'is_unique[users.no_telepon,id,' . $userId . ']';
            $rules['no_telepon']['errors']['is_unique'] = 'Nomor telepon sudah digunakan oleh pengguna lain.';
        }

        $newNIP = $this->request->getPost('NIP');
        if ($newNIP && $newNIP !== $user->NIP) {
            $rules['NIP']['rules'][] = 'is_unique[users.NIP,id,' . $userId . ']';
            $rules['NIP']['errors']['is_unique'] = 'NIP sudah digunakan oleh pengguna lain.';
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

        // Catat log aktivitas
        $logData = [
            'id_user'          => $userId,
            'tanggal_aktivitas' => Time::now('Asia/Jakarta', 'en')->toDateTimeString(),
            'aksi'             => 'update',
            'jenis_data'       => 'User',
            'keterangan'       => "User dengan ID {$userId} memperbarui profilnya",
        ];

        $logModel = new LogAktivitasModel();
        $logModel->save($logData);

        // Logout setelah perubahan apapun terjadi
        auth()->logout();

        // Redirect ke halaman login dengan pesan
        return redirect()->to('/login')->with('message', 'Profil Anda telah diperbarui. Silakan login kembali.');
    }
}
