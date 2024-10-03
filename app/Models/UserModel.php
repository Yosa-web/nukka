<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'jenis_inovasi';  // Nama tabel di database
    protected $primaryKey = 'id_jenis_inovasi';  // Primary key tabel
    protected $allowedFields = ['id_jenis_inovasi', 'nama_jenis'];  // Field yang boleh di-insert dan update

    // Opsi lain seperti menggunakan timestamps jika diperlukan
    protected $useTimestamps = true;
}
