<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Drop_column_users_quiz extends CI_Migration {

	public function up()
	{
		$this->dbforge->drop_column('users_quiz', 'questions');
		$this->dbforge->drop_column('users_quiz', 'seconds');
		$this->dbforge->drop_column('users_quiz', 'time_start');
		$this->dbforge->drop_column('users_quiz', 'last_update');
		$this->dbforge->drop_column('users_quiz', 'time_end');
	}
	
	public function down()
	{
		$fields = array(
			'questions' => array(
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
			'last_update' => array(
				'type' => 'DATETIME',
			),
			'time_end' => array(
				'type' => 'DATETIME',
			),
		);
		
		$this->dbforge->add_column('users_quiz', $fields);
	}
}
