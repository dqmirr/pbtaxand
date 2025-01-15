<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_users_add_active extends CI_Migration {

	public function up()
	{
		$fields = array(
			'active' => array(
				'type' => 'INT',
				'constraint' => 1,
				'default' => 1,
			),
		);
		
		$this->dbforge->add_column('users', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'active');
	}
}
