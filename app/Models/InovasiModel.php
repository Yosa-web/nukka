<?php

namespace App\Models;

use CodeIgniter\Model;

class InovasiModel extends Model
{
    protected $table            = 'inovasi';
    protected $primaryKey       = 'id_inovasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'deskripsi',
        'kategori',
        'tanggal_pengajuan',
        'status',
        'kecamatan',
        'id_user',
        'id_opd',
        'pesan',
        'published_at',
        'url_file'
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

    public function getJumlahInovasiPerKecamatan()
    {
        return $this->select('kecamatan, COUNT(*) as jumlahInovasi')
                    ->groupBy('kecamatan')
                    ->findAll();
    }
}
