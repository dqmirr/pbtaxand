<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gti_questions extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'nomor' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'soal' => array(
				'type' => 'VARCHAR',
				'constraint' => 256,
				'null' => TRUE,
			),
			'jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 2
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
			),
			'is_tutorial' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => 0,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_code_gt_q` (quiz_code) REFERENCES quiz (code)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('gti_questions', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('gti_questions');
	}
	
}
