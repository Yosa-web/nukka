<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKunjunganTable extends Migration
{
    public function up()
    {
        // Membuat tabel kunjungan
        $this->forge->addField([
            'id_kunjungan' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'tanggal_kunjungan' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => true, // opsional
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true, // opsional
            ],
        ]);

        // Menambahkan primary key
        $this->forge->addPrimaryKey('id_kunjungan');
        $this->forge->createTable('kunjungan');
    }

    public function down()
    {
        // Menghapus tabel kunjungan jika rollback
        $this->forge->dropTable('kunjungan');
    }
}
