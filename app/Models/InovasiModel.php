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
    protected $allowedFields = ['judul', 'deskripsi', 'tahun', 'kategori', 'status', 'kecamatan', 'desa', 'tahapan', 'bentuk', 'tanggal_pengajuan', 'id_user', 'id_opd', 'pesan', 'url_file'];


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

    public function getJumlahInovasiPerKecamatan()
    {
        return $this->select('kecamatan, COUNT(*) as jumlahInovasi')
            ->groupBy('kecamatan')
            ->findAll();
    }

    public function getAllData($filters = [])
    {
        $builder = $this->db->table($this->table)
            ->select('inovasi.*, jenis_inovasi.nama_jenis, bentuk.nama_bentuk, tahapan.nama_tahapan, kecamatan.nama_kecamatan, desa.nama_desa, opd.nama_opd')
            ->join('jenis_inovasi', 'inovasi.kategori = jenis_inovasi.id_jenis_inovasi', 'left')
            ->join('bentuk', 'inovasi.bentuk = bentuk.id_bentuk', 'left')
            ->join('tahapan', 'inovasi.tahapan = tahapan.id_tahapan', 'left')
            ->join('kecamatan', 'inovasi.kecamatan = kecamatan.id_kecamatan', 'left')
            ->join('desa', 'inovasi.desa = desa.id_desa', 'left')
            ->join('opd', 'inovasi.id_opd = opd.id_opd', 'left');

        // Filter data berdasarkan input
        if (!empty($filters['jenis_inovasi'])) {
            $builder->where('jenis_inovasi.id_jenis_inovasi', $filters['jenis_inovasi']);
        }
        if (!empty($filters['tahun'])) {
            $builder->where('inovasi.tahun', $filters['tahun']);
        }
        if (!empty($filters['bentuk'])) {
            $builder->where('bentuk.id_bentuk', $filters['bentuk']);
        }
        if (!empty($filters['tahapan'])) {
            $builder->where('tahapan.id_tahapan', $filters['tahapan']);
        }
        if (!empty($filters['status'])) {
            $builder->where('inovasi.status', $filters['status']); // Tambahkan filter status
        }

        return $builder->get()->getResultArray();
    }

    public function getJumlahInovasiPerKecamatanDanDesa()
    {
        return $this->select('kecamatan, desa, COUNT(*) as jumlahInovasi')
            ->where('status', 'terbit')  // Hanya status terbit
            ->groupBy('kecamatan, desa')  // Mengelompokkan berdasarkan kecamatan dan desa
            ->findAll();
    }
}
