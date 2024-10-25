<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class GroupModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,

            // 'first_name',
        ];
    }

    public function addUserToGroup($userId, $group)
    {
        // Siapkan data untuk dimasukkan ke dalam tabel auth_groups_users
        $data = [
            'user_id' => $userId,
            'group'   => $group, // Group dalam bentuk varchar
        ];
    
        // Masukkan data ke tabel auth_groups_users
        return $this->db->table('auth_groups_users')->insert($data);
    }

    public function getGroupsForUser(int $userId)
    {
        return $this->db->table('auth_groups_users') // Pastikan tabel ini benar
                    ->where('user_id', $userId)
                    ->get()
                    ->getResultArray();
    }

    public function removeUserFromAllGroups($userId)
    {
        return $this->db->table('auth_groups_users')->where('user_id', $userId)->delete();
    }
}
