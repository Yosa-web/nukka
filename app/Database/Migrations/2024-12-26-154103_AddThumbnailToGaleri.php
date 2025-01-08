<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddThumbnailToGaleri extends Migration
{
    public function up()
    {
        // Menambahkan kolom thumbnail_url ke tabel galeri
        $this->forge->addColumn('galeri', [
            'thumbnail_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true]
        ]);
    }

    public function down()
    {
        // Menghapus kolom thumbnail_url dari tabel galeri
        $this->forge->dropColumn('galeri', 'thumbnail_url');
    }
}
