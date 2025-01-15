<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_ist_questions extends CI_Migration {

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
				'constraint' => 200
			),
			'nomor' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 20
			),
			'quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'ist_group_code' => array(
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
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->add_field('FOREIGN KEY (ist_group_code) REFERENCES ist_group(code)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('ist_questions', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('ist_questions');
	}
	
}
