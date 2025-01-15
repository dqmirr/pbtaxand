<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_users3 extends CI_Migration {

	public function up()
	{
		$fields = array(
			'last_update' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		);
		
		$this->dbforge->add_column('users', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users', 'last_update');
	}
}
