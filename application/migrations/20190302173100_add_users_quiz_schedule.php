<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users_quiz_schedule extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'auto_increment' => TRUE,
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
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
			'date' => array(
				'type' => 'DATE',
			),
			'time_from' => array(
				'type' => 'TIME',
			),
			'time_to' => array(
				'type' => 'TIME',
			),
			'active' => array(
				'type' => 'TINYINT',
				'default' => 1,
				'constraint' => 1,
			),
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field('FOREIGN KEY `fk_users_id_schedule` (users_id) REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE');
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_id_schedule` (quiz_id) REFERENCES quiz (id) ON UPDATE CASCADE ON DELETE CASCADE');
		$this->dbforge->add_field('UNIQUE KEY (`users_id`, `quiz_id`, `date`)');
		$this->dbforge->create_table('users_quiz_schedule');
	}

	public function down()
	{
		$this->dbforge->drop_table('users_quiz_schedule');
	}
}
