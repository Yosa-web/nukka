<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            'id_opd',
            'no_telepon',
            'name',
            'NIK',
            'NIP',
            

        ];
    }

    public function getUsersWithOpd()
    {
        return $this->select('users.*, opd.nama_opd')
                    ->join('opd', 'opd.id_opd = users.id_opd', 'left')
                    ->findAll();
    }

    public function getGroups($userId)
    {
        // Mengambil grup berdasarkan user_id dari tabel auth_groups_users
        return $this->db->table('auth_groups_users')
                        ->select('group') // Hanya memilih kolom group
                        ->where('user_id', $userId) // Filter berdasarkan user_id
                        ->get()
                        ->getResultArray(); // Mengembalikan hasil sebagai array
    }
}    
