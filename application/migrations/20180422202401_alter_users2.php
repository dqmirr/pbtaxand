<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_users2 extends CI_Migration {

	public function up()
	{
		$fields = array(
			'email_sent' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 0,
			),
			'last_login' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'last_logout' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		);
		
		$this->dbforge->add_column('users', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'email_sent');
		$this->dbforge->drop_column('users', 'last_login');
		$this->dbforge->drop_column('users', 'last_logout');
	}
}
