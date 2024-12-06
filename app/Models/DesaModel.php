<?php

namespace App\Models;

use CodeIgniter\Model;

class DesaModel extends Model
{
    protected $table            = 'desa';
    protected $primaryKey       = 'id_desa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_desa', 'id_kecamatan', 'created_at', 'updated_at', 'deleted_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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

    public function insertDesa($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');  // Menambahkan created_at sebelum insert
        return $this->insert($data); // Insert data ke tabel
    }

    // Fungsi untuk mengambil desa berdasarkan kecamatan
    public function getDesaByKecamatan($id_kecamatan)
    {
        return $this->where('id_kecamatan', $id_kecamatan)->findAll();  // Pastikan kolom kecamatan_id benar
    }
}
