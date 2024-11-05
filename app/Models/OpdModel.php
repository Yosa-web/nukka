<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Opd;

class OpdModel extends Model
{
    protected $table            = 'opd';
    protected $primaryKey       = 'id_opd';
    protected $useAutoIncrement = true;
    protected $returnType = Opd::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_opd', 'alamat', 'telepon', 'email'];

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
    protected $validationRules      = [
        'nama_opd' => 'required|min_length[3]|max_length[100]',
        'alamat'   => 'required|min_length[10]|max_length[255]',
        'telepon'  => 'required|numeric|min_length[10]|max_length[15]',
        'email'    => 'required|valid_email|max_length[100]',
    ];
    protected $validationMessages   = [
        'nama_opd' => [
        'required'   => 'Nama OPD wajib diisi.',
        'min_length' => 'Nama OPD harus memiliki minimal 3 karakter.',
        'max_length' => 'Nama OPD tidak boleh lebih dari 100 karakter.',
    ],
        'alamat' => [
            'required'   => 'Alamat wajib diisi.',
            'min_length' => 'Alamat harus memiliki minimal 10 karakter.',
            'max_length' => 'Alamat tidak boleh lebih dari 255 karakter.',
        ],
        'telepon' => [
            'required'   => 'Nomor telepon wajib diisi.',
            'numeric'    => 'Nomor telepon harus berupa angka.',
            'min_length' => 'Nomor telepon harus memiliki minimal 10 angka.',
            'max_length' => 'Nomor telepon tidak boleh lebih dari 15 angka.',
        ],
        'email' => [
            'required'   => 'Email wajib diisi.',
            'valid_email' => 'Masukkan format email yang valid.',
            'max_length' => 'Email tidak boleh lebih dari 100 karakter.',
        ],
    ];
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

    public function getOpd($id = null)
    {
        if ($id != null) {
            return $this->select('opd.*')->find($id);
        }
        return $this->select('opd.*')->findAll();
    }

    public function getAvailableOpd($usedOpdIds)
    {
        if (!empty($usedOpdIds)) {
            return $this->whereNotIn('id_opd', $usedOpdIds)->findAll();
        }
        // Jika array kosong, kembalikan semua OPD
        return $this->findAll();
    }
    
}
