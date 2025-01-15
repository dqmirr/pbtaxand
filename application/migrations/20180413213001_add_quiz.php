<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_quiz extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE,
			),
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,
			),
			'library_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'active' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (library_code) REFERENCES library(code)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('quiz', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('quiz');
	}
	
}
