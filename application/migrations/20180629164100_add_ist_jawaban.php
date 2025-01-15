<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ist_jawaban extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'ist_questions_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 20
			),
			'created' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'updated' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->add_field('FOREIGN KEY (users_id) REFERENCES users(id)');
		$this->dbforge->add_field('FOREIGN KEY (ist_questions_id) REFERENCES ist_questions(id)');
		$this->dbforge->add_field('UNIQUE KEY (`users_id`, `ist_questions_id`)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ist_jawaban', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('ist_jawaban');
	}
	
}
