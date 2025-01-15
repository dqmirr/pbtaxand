<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_personal_questions extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'soal' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'nomor' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'trait' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
			),
			'reversed_score' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0,
				'null' => FALSE
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'is_tutorial' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => 0,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('personal_questions', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('personal_questions');
	}
	
}
