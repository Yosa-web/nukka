<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKecamatanTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kecamatan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // Tambahkan unsigned agar konsisten
                'auto_increment' => true,
            ],
            'nama_kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_kecamatan', true); // Primary key
        $this->forge->createTable('kecamatan');
        
    }

    public function down()
    {
        $this->forge->dropTable('kecamatan');
    }
}
