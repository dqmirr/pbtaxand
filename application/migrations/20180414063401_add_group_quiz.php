<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_group_quiz extends CI_Migration {

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
				'unique' => TRUE,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('group_quiz', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('group_quiz');
	}
	
}
