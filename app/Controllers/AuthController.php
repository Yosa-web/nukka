<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends BaseController
{
    public function handleLogin()
    {
        // Cek apakah pengguna sudah login
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'Anda belum login.');
        }

        // Cek grup pengguna menggunakan inGroup()
        if (auth()->user()->inGroup('superadmin')) {
            return redirect()->to('/dashboard');
        } elseif (auth()->user()->inGroup('admin-opd')) {
            return redirect()->to('/adminopd/pegawai/list');
        } elseif (auth()->user()->inGroup('sekertaris-opd')) {
            return redirect()->to('/sekertaris/inovasi');
        } elseif (auth()->user()->inGroup('kepala-opd')) {
            return redirect()->to('/kepala/inovasi');
        } elseif (auth()->user()->inGroup('operator')) {
            return redirect()->to('/operator/inovasi/filter');
        } elseif (auth()->user()->inGroup('user')) {
            return redirect()->to('/userumum/inovasi/filter');
        } else {
            // Redirect default jika grup tidak dikenali
            return redirect()->to('/home')->with('error', 'Grup pengguna tidak dikenali.');
        }
    }
}
