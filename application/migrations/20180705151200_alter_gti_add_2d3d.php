<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_gti_add_2d3d extends CI_Migration {

	public function up()
	{
		$fields = array(
			'display' => array(
				'type' => 'varchar',
				'constraint' => 20,
				'null' => TRUE,
				'default' => NULL,
			),
		);
		
		$this->dbforge->add_column('gti_questions', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('gti_questions', 'display');
	}
}
