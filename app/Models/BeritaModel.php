<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id_berita';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'isi', 'gambar', 'tanggal_post', 'posted_by', 'status', 'slug'];

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
        'judul' => 'required|max_length[200]',
        'isi' => 'required',
        // 'gambar' => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
        // 'tanggal_post' => 'required',
        // 'posted_by' => 'required|integer',
        'status' => 'in_list[draft,published,archive]'
    ];
    protected $validationMessages   = [
        'judul' => [
            'required'   => 'Judul berita wajib diisi.',
            'max_length' => 'Judul berita tidak boleh lebih dari 200 karakter.'
        ],
        'isi' => [
            'required' => 'Isi berita wajib diisi.',
        ],
        // 'gambar' => [
        //     'uploaded' => 'Gambar wajib diunggah.',
        //     'mime_in'  => 'Format gambar harus berupa jpg, jpeg, atau png.',
        //     'max_size' => 'Ukuran gambar tidak boleh lebih dari 2MB.'
        // ],
        // 'tanggal_post' => [
        //     'required'   => 'Tanggal posting wajib diisi.',
        // ],
        // 'posted_by' => [
        //     'required' => 'ID pengguna yang memposting wajib diisi.',
        //     'integer'  => 'ID pengguna harus berupa angka.'
        // ],
        'status' => [
            'in_list' => 'Status yang dipilih tidak valid. Pilih antara draft, published, atau archive.',
        ]

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

    public function saveBerita($data)
    {
        // Menambahkan slug berdasarkan judul berita
        $data['slug'] = url_title($data['judul'], '-', true);

        // Menyimpan data ke dalam database
        return $this->insert($data);
    }
    public function getBerita($slug = null)
    {
        $this->select('berita.*, users.name AS uploaded_by_username');
        $this->join('users', 'users.id = berita.posted_by'); // Join antara tabel berita dan users
    
        // Jika $slug diberikan, cari berita berdasarkan slug
        if ($slug != null) {
            return $this->where('berita.slug', $slug)->first(); // Cari berita berdasarkan slug
        }
    
        return $this->findAll();
    }
    

    public function getPublishedNews($slug = null)
    {
        $query = $this->db->table('berita')
                          ->select('berita.*, users.username AS uploaded_by_username')
                          ->join('users', 'users.id = berita.posted_by', 'left')
                          ->where('berita.status', 'published');
    
        // Jika $slug diberikan, tambahkan kondisi filter berdasarkan slug
        if ($slug !== null) {
            $query->where('berita.slug', $slug); // Cari berita berdasarkan slug
        }
    
        $result = $query->get()->getResultArray();
        
        // Debug: cetak hasilnya untuk pengecekan
        log_message('debug', 'Published News by Slug: ' . print_r($result, true));
        
        return $result;
    }
    


}
