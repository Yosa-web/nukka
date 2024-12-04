<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tahapan extends Migration
{
    public function up()
    {
        // Table: tahapan
        $this->forge->addField([
            'id_tahapan'  => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nama_tahapan'       => ['type' => 'VARCHAR', 'constraint' => 50]
        ]);
        $this->forge->addPrimaryKey('id_tahapan');
        $this->forge->createTable('tahapan');
    }

    public function down()
    {
        $this->forge->dropTable('tahapan');
    }
}
