<?php

namespace App\Controllers\UserUmum;

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
    public function edit()
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
        return view('user_umum/profile/edit_profile', [
            'user' => $user,
        ]);
    }

    public function update(): RedirectResponse
    {
        $users = $this->getUserProvider();

        // Dapatkan user berdasarkan sesi login
        $userId = auth()->user()->id;
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
        }

        $newNIK = $this->request->getPost('NIK');
        if ($newNIK && $newNIK !== $user->NIK) {
            $rules['NIK']['rules'][] = 'is_unique[users.NIP,id,' . $userId . ']';
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

        // Logout jika email atau password berubah
        if ($emailChanged || $passwordChanged) {
            auth()->logout();
            session()->destroy();

            // Redirect ke halaman login
            return redirect()->to('/login?message=' . urlencode('Email atau password telah diperbarui. Silakan login kembali.'));
        }

        // Redirect dengan pesan sukses
        return redirect()->to('/userumum/inovasi/filter')
            ->with('message', 'Profil berhasil diperbarui.');
    }
}
