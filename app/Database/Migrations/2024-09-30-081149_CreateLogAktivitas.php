<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogAktivitas extends Migration
{
    public function up()
    {
        // Table: log_aktivitas
        $this->forge->addField([
            'id_log'            => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'id_user'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_aktivitas' => ['type' => 'DATETIME'],
            'aksi'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'jenis_data'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'keterangan'        => ['type' => 'VARCHAR', 'constraint' => 50]
        ]);
        $this->forge->addPrimaryKey('id_log');
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->createTable('log_aktivitas');
    }

    public function down()
    {
        $this->forge->dropTable('log_aktivitas');
    }
}
