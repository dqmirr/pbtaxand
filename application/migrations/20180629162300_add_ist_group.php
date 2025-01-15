<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ist_group extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE
			),
			'soal' => array(
				'type' => 'VARCHAR',
				'constraint' => 200
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ist_group', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('ist_group');
	}
	
}
