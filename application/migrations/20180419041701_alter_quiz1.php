<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_quiz1 extends CI_Migration {

	public function up()
	{
		$fields = array(
			'seconds' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => 180
			),
			'allow_restart' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => 0
			),
		);
		
		$this->dbforge->add_column('quiz', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('quiz', 'seconds');
		$this->dbforge->drop_column('quiz', 'allow_restart');
	}
}
