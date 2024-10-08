<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInovasi extends Migration
{
    public function up()
    {
        // Table: inovasi
        $this->forge->addField([
            'id_inovasi'      => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'judul'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'       => ['type' => 'LONGTEXT'],
            'kategori'        => ['type' => 'ENUM', 'constraint' => ['kategori1', 'kategori2', 'kategori3']],
            'tanggal_pengajuan' => ['type' => 'DATETIME'],
            'status'          => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected']],
            'id_user'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_opd'          => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'unsigned' => true],
            'published_by'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'published_at'    => ['type' => 'DATETIME'],
            'url_file'        => ['type' => 'VARCHAR', 'constraint' => 255]
        ]);
        $this->forge->addPrimaryKey('id_inovasi');
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->addForeignKey('id_opd', 'opd', 'id_opd');
        $this->forge->addForeignKey('published_by', 'users', 'id');
        $this->forge->createTable('inovasi');
    }

    public function down()
    {
        $this->forge->dropTable('inovasi');
    }
}
