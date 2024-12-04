<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDesaTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_desa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'auto_increment' => true,
            ],
            'nama_desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_kecamatan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addKey('id_desa', true); // Primary key
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id_kecamatan', 'CASCADE', 'CASCADE'); // Foreign key
        $this->forge->createTable('desa');
        
    }

    public function down()
    {
        $this->forge->dropTable('desa');
    }
}
