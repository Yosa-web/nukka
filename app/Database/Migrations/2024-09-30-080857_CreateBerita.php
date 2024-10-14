<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerita extends Migration
{
    public function up()
    {
        // Table: berita
        $this->forge->addField([
            'id_berita'       => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 50],
            'isi'             => ['type' => 'LONGTEXT'],
            'gambar'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal_post'    => ['type' => 'DATETIME'],
            'posted_by'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['draft', 'published', 'archive'], 'default' => 'draft']
        ]);
        $this->forge->addPrimaryKey('id_berita');
        $this->forge->addForeignKey('posted_by', 'users', 'id');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
