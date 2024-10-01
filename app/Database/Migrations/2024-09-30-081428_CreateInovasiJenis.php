<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInovasiJenis extends Migration
{
    public function up()
    {
        // Table: inovasi_jenis
        $this->forge->addField([
            'id_inovasi'      => ['type' => 'INT', 'constraint' => 11],
            'id_jenis_inovasi' => ['type' => 'INT', 'constraint' => 11]
        ]);
        $this->forge->addPrimaryKey(['id_inovasi', 'id_jenis_inovasi']);
        $this->forge->addForeignKey('id_inovasi', 'inovasi', 'id_inovasi');
        $this->forge->addForeignKey('id_jenis_inovasi', 'jenis_inovasi', 'id_jenis_inovasi');
        $this->forge->createTable('inovasi_jenis');
    }

    public function down()
    {
        $this->forge->dropTable('inovasi_jenis');
    }
}
