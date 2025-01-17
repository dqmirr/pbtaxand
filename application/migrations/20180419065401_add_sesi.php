<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_sesi extends CI_Migration {

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
				'constraint' => 50,
				'unique' => TRUE,
			),
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'time_from' => array(
				'type' => 'DATETIME',
			),
			'time_to' => array(
				'type' => 'DATETIME',
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('sesi', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('sesi');
	}
	
}
