<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_essay_jawaban extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'auto_increment' => TRUE,
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				),
			'quiz_code' => array(
				'type' => 'varchar',
				'constraint' => 100,
			),
			'essay_questions_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'jawaban' => array(
				'type' => 'text',
				),
			'created' => array(
				'type' => 'DATETIME',
				'null' => TRUE
				),
			'updated' => array(
				'type' => 'DATETIME',
				'null' => TRUE
				),
			)
		);
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_code_essay_q` (quiz_code) REFERENCES quiz (code) ON UPDATE CASCADE');
		$this->dbforge->add_field('FOREIGN KEY `fk_essay_qid_essay_j` (essay_questions_id, quiz_code) REFERENCES essay_questions (id, quiz_code) ON UPDATE CASCADE');
		$this->dbforge->add_field('FOREIGN KEY `fk_users_id_essay_j` (users_id) REFERENCES users (id) ON UPDATE CASCADE');
		$this->dbforge->add_field('UNIQUE KEY (`essay_questions_id`, `users_id`)');
		$this->dbforge->create_table('essay_jawaban');
	}
	
	public function down()
	{
		$this->dbforge->drop_table('essay_jawaban');
	}
	
}
