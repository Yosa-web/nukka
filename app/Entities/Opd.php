<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Opd extends Entity
{
    protected $datamap = [];

    protected $attributes = [
        'id_opd' => null,
        'nama_opd' => null,
        'alamat' => null,
        'telepon' => null,
        'email' => null,
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
