<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users_quiz_log extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100
			),
			'rows' => array(
				'type' => 'TEXT',
			),
			'seconds' => array(
				'type' => 'INT',
				'constraint' => 11,
				'default' => 0,
			),
			'time_start' => array(
				'type' => 'DATETIME',
			),
			'time_end' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'last_update' => array(
				'type' => 'DATETIME',
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (users_id) REFERENCES users (id)');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz (code)');
		$this->dbforge->add_key(array('users_id', 'quiz_code'), TRUE);
		$this->dbforge->create_table('users_quiz_log', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('users_quiz_log');
	}
	
}
