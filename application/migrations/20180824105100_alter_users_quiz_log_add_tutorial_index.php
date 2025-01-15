<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_alter_users_quiz_log_add_tutorial_index extends CI_Migration {

	public function up()
	{
		$add_fields = array(
			'index' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => 0,
			),
			'seconds_used' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'constraint' => 11,
				'default' => 0,
			),
		);
		
		// ALTER TABLE `users_quiz_log` ADD `index` INT (11) NULL DEFAULT 0, ADD `seconds_used` INT(11) UNSIGNED NOT NULL DEFAULT 0;
		
		$this->dbforge->add_column('users_quiz_log', $add_fields);
	}
	
	public function down()
	{
		$this->dbforge->drop_column('users_quiz_log', 'index');
		$this->dbforge->drop_column('users_quiz_log', 'seconds_used');
	}
}
