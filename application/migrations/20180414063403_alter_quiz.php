<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_quiz extends CI_Migration {

	public function up()
	{
		$alter_fields = array(
			'library_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				),
		);
		
		$this->dbforge->modify_column('quiz', $alter_fields);
		
		$add_fields = array(
			'group_quiz_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE,
				'after' => 'library_code',
			),
		);
		
		$this->dbforge->add_field('FOREIGN KEY `fk_quiz_group_quiz_code` (group_quiz_code) REFERENCES group_quiz(code)');
		$this->dbforge->add_field('UNIQUE KEY (group_quiz_code)');
		$this->dbforge->add_column('quiz', $add_fields);
	}

	public function down()
	{
		$this->db->query('ALTER TABLE quiz DROP FOREIGN KEY fk_quiz_group_quiz_code');
		$this->dbforge->drop_column('quiz', 'group_quiz_code');
	}
	
}
