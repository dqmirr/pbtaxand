<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_group_quiz_items extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'group_quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key(array('group_quiz_code', 'quiz_code'), TRUE);
		$this->dbforge->add_field('FOREIGN KEY (group_quiz_code) REFERENCES group_quiz(code)');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->create_table('group_quiz_items', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('group_quiz_items');
	}
	
}
