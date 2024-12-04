<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bentuk extends Migration
{
    public function up()
    {
        // Table: bentuk
        $this->forge->addField([
            'id_bentuk'  => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'nama_bentuk'       => ['type' => 'VARCHAR', 'constraint' => 50]
        ]);
        $this->forge->addPrimaryKey('id_bentuk');
        $this->forge->createTable('bentuk');
    }

    public function down()
    {
        $this->forge->dropTable('bentuk');
    }
}
