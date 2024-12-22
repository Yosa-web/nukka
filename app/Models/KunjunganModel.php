<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['tanggal_kunjungan', 'ip_address', 'user_agent'];
    protected $useTimestamps = false;  // Menggunakan tanggal_kunjungan sebagai timestamp

    // Fungsi untuk menambah kunjungan
    public function tambahKunjungan($ip_address = null, $user_agent = null)
    {
        $data = [
            'tanggal_kunjungan' => date('Y-m-d H:i:s'),  // Menggunakan waktu saat ini
            'ip_address' => $ip_address ?: $_SERVER['REMOTE_ADDR'],
            'user_agent' => $user_agent ?: $_SERVER['HTTP_USER_AGENT'],
        ];

        return $this->insert($data);
    }

    // Fungsi untuk mengambil jumlah kunjungan per jam
    public function getKunjunganPerJam()
    {
        return $this->select('HOUR(tanggal_kunjungan) as jam, COUNT(*) as jumlah_kunjungan')
            ->groupBy('HOUR(tanggal_kunjungan)')
            ->orderBy('jam', 'ASC')
            ->findAll();
    }
}
