<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisInovasi extends Migration
{
    public function up()
    {
        // Table: jenis_inovasi
        $this->forge->addField([
            'id_jenis_inovasi'  => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nama_jenis'       => ['type' => 'VARCHAR', 'constraint' => 50]
        ]);
        $this->forge->addPrimaryKey('id_jenis_inovasi');
        $this->forge->createTable('jenis_inovasi');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_inovasi');
    }
}
