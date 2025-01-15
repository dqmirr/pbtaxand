<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users_quiz extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'quiz_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'active' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('PRIMARY KEY (users_id, quiz_id)');
		$this->dbforge->add_field('FOREIGN KEY (users_id) REFERENCES users(id)');
		$this->dbforge->add_field('FOREIGN KEY (quiz_id) REFERENCES quiz(id)');
		$this->dbforge->create_table('users_quiz', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('users_quiz');
	}
	
}
