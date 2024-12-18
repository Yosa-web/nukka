<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Halaman Beranda
     *
     * @return string
     */
    public function index(): string
    {
        // Data tambahan khusus untuk view
        $data = [
            'title' => 'Beranda' // Judul halaman
        ];

        // Menggunakan renderView agar data global dari BaseController tersedia
        return $this->renderView('welcome_message', $data);
    }

    /**
     * Halaman OPD
     *
     * @return string
     */
    public function opd(): string
    {
        // Data tambahan khusus untuk view
        $data = [
            'title' => 'OPD' // Judul halaman
        ];

        // Menggunakan renderView agar data global dari BaseController tersedia
        return $this->renderView('opd', $data);
    }
}
