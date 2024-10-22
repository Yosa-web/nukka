<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionWebModel extends Model
{
    protected $table            = 'option_web';
    protected $primaryKey       = 'id_setting';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    =
    [
        'key',
        'seting_type',
        'value',
        'modified_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // public function getOptionWeb($id = null)
    // {
    //     $this->select('option_web.*, users.username AS uploaded_by_username');
    //     $this->join('users', 'users.id = option_web.uploaded_by'); // Join antara tabel option_web dan users

    //     if ($id !== null) {
    //         return $this->find($id); // Ambil data option web berdasarkan ID
    //     }

    //     return $this->findAll(); // Ambil semua data option web
    // }

    // // Method untuk mendapatkan option web yang dipublikasikan
    // public function getPublishedOptions($id = null)
    // {
    //     $query = $this->db->table('option_web')
    //         ->select('option_web.*, users.username AS uploaded_by_username')
    //         ->join('users', 'users.id = option_web.uploaded_by', 'left')
    //         ->where('option_web.status', 'published'); // Kondisi untuk mengambil yang statusnya published

    //     // Jika $id diberikan, tambahkan filter berdasarkan id
    //     if ($id !== null) {
    //         $query->where('option_web.id', $id);
    //     }

    //     $result = $query->get()->getResultArray();

    //     // Debug: cetak hasilnya untuk pengecekan
    //     log_message('debug', 'Published Options: ' . print_r($result, true));

    //     return $result;
    // }
}
