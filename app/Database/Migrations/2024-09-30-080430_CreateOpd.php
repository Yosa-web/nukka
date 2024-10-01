<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOpd extends Migration
{
    public function up()
    {
        // Table: opd
        $this->forge->addField([
            'id_opd'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_opd'  => ['type' => 'VARCHAR', 'constraint' => 50],
            'alamat'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'telepon'   => ['type' => 'VARCHAR', 'constraint' => 12],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 50]
        ]);
        $this->forge->addPrimaryKey('id_opd');
        $this->forge->createTable('opd');
    }

    public function down()
    {

        $this->forge->dropTable('opd');
    }
}
