<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class OptionWeb extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_setting'      => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'key'           => ['type' => 'VARCHAR', 'constraint' => 20],
            'seting_type'       => ['type' => 'varchar', 'Constraint' => 50],
            'value'        => ['type' => 'longtext'],
            'modified_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey('id_setting');
        $this->forge->addForeignKey('modified_by', 'users', 'id');
        $this->forge->createTable('option_web');
    }

    public function down()
    {
        $this->forge->dropTable('option_web');
    }
}
