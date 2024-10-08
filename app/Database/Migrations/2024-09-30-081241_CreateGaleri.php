<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleri extends Migration
{
    public function up()
    {
        // Table: galeri
        $this->forge->addField([
            'id_galeri'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'id_user'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'url'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'tipe'         => ['type' => 'ENUM', 'constraint' => ['image', 'video', 'document']],
            'uploaded_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'uploaded_at'  => ['type' => 'DATETIME']
        ]);
        $this->forge->addPrimaryKey('id_galeri');
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->addForeignKey('uploaded_by', 'userS', 'id');
        $this->forge->createTable('galeri');
    }

    public function down()
    {
        $this->forge->dropTable('galeri');
    }
}
