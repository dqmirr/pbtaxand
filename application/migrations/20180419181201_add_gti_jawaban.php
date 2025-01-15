<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gti_jawaban extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'gti_questions_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 2
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY `fk_users_id_users_gti_j` (users_id) REFERENCES users (id)');
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_code_quiz_gti_j` (quiz_code) REFERENCES quiz (code)');
		$this->dbforge->add_field('UNIQUE KEY (`users_id`, `quiz_code`, `gti_questions_id`)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('gti_jawaban', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('gti_jawaban');
	}
	
}
