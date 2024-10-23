<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('super_admin/dashboard');
    }

    public function opd(): string
    {
        return view('opd');
    }
}
