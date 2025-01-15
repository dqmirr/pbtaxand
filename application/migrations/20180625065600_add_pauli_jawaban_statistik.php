<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_pauli_jawaban_statistik extends CI_Migration {

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
			'total' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'benar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'salah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_max_total' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_max_benar' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_max_salah' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_min_total' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_min_benar' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'is_min_salah' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'default' => 0,
			),
			'tren' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
			),
			'gap' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => 0,
			),
		));

		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (users_id) REFERENCES users(id)');
		$this->dbforge->add_field('FOREIGN KEY (quiz_code) REFERENCES quiz(code)');
		$this->dbforge->add_field('UNIQUE KEY (`users_id`, `quiz_code`, `part`)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('pauli_jawaban_statistik', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('pauli_jawaban_statistik');
	}
	
}
