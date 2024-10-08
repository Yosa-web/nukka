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


// <?php

// namespace App\Database\Migrations;

// use CodeIgniter\Database\Migration;

// class CreatePegawai extends Migration
// {
//     public function up()
//     {
//         // Table: pegawai
//         $this->forge->addField([
//             'id_pegawai' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
//             'nama'       => ['type' => 'VARCHAR', 'constraint' => 50],
//             'nip'        => ['type' => 'VARCHAR', 'constraint' => 18],
//             'jabatan'    => ['type' => 'VARCHAR', 'constraint' => 50],
//             'id_opd'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true]
//         ]);
//         $this->forge->addPrimaryKey('id_pegawai');
//         $this->forge->addForeignKey('id_opd', 'opd', 'id_opd');
//         $this->forge->createTable('pegawai');
//     }

//     public function down()
//     {
//         $this->forge->dropTable('pegawai');
//     }
// }
