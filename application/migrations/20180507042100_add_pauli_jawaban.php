<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_pauli_jawaban extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'created' => array(
				'type' => 'DATETIME',
				'null' => TRUE
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
			'part' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'order' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'arr_jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
			),
			'jawaban_benar' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'jawaban' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'benar' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
			),
		));

		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (users_id) REFERENCES users(id)');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->add_field('UNIQUE KEY (`users_id`, `quiz_code`, `part`, `order`)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('pauli_jawaban', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('pauli_jawaban');
	}
	
}
