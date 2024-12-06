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
            'kategori'        => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'bentuk'        => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'tahapan'        => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'tanggal_pengajuan' => ['type' => 'DATETIME'],
            'status'          => ['type' => 'ENUM', 'constraint' => ['terbit', 'draf', 'arsip', 'revisi', 'tertunda', 'tertolak']],
            'kecamatan'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'desa'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'id_user'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_opd'          => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'unsigned' => true],
            'pesan'       => ['type' => 'LONGTEXT', 'null' => true],
            'tahun'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'published_by'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'published_at'    => ['type' => 'DATETIME', 'null' => true],
            'url_file'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id_inovasi');
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->addForeignKey('id_opd', 'opd', 'id_opd');
        $this->forge->createTable('inovasi');
    }

    public function down()
    {
        $this->forge->dropTable('inovasi');
    }
}
