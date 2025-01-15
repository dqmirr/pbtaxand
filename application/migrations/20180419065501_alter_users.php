<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_users extends CI_Migration {

	public function up()
	{
		$fields = array(
			'formasi_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
			),
			'sesi_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
			),
			'first_login' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'agree_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,
			),
			'agree_time' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		);
		
		$this->dbforge->add_column('users', $fields);
		$this->dbforge->add_field('FOREIGN KEY `fk_formasi_formasi_code` (formasi_code) REFERENCES formasi(code)');
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'formasi_code');
		$this->dbforge->drop_column('users', 'sesi_code');
		$this->dbforge->drop_column('users', 'first_login');
		$this->dbforge->drop_column('users', 'agree_code');
		$this->dbforge->drop_column('users', 'agree_time');
	}
}
