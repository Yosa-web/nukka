<?php

namespace App\Listeners;

use CodeIgniter\Shield\Authentication\Events\Login;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Entities\User;
use App\Models\UserModel;  // Pastikan untuk mengimpor model UserModel

class RedirectAfterLoginListener
{
    public function __construct()
    {
        // Mendaftarkan event listener untuk after login
        Events::on('afterLogin', [$this, 'onLogin']);
    }

    public function onLogin(User $user)
    {
        // Ambil ID pengguna yang login
        $userId = auth()->user()->id;
        
        // Ambil grup pengguna dari UserModel
        $userModel = new UserModel();
        $groups = $userModel->getGroups($userId);  // Mendapatkan grup berdasarkan user_id
        
        // Ambil nama grup pertama, asumsikan satu pengguna hanya memiliki satu grup
        $group = isset($groups[0]) ? $groups[0]->name : null;

        // Redirect berdasarkan grup
        switch ($group) {
            case 'superadmin':
                return redirect()->to('/dashboard');
            case 'admin-opd':
                return redirect()->to('/adminopd/pegawai/list');
            case 'sekretaris-opd':
                return redirect()->to('/sekertaris/inovasi');
            case 'kepala-opd':
                return redirect()->to('/kepala/inovasi');
            case 'operator':
                return redirect()->to('/operator/inovasi');
            case 'user':
                return redirect()->to('/userumum/inovasi');
            default:
                return redirect()->to('/beranda');  // Default jika grup tidak dikenali
        }
    }
}
