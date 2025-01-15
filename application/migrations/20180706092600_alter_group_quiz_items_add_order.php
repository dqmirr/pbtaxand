<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_group_quiz_items_add_order extends CI_Migration {

	public function up()
	{
		$fields = array(
			'ordering' => array(
				'type' => 'int',
				'constraint' => 11,
				'null' => TRUE,
			),
		);
		
		$this->dbforge->add_column('group_quiz_items', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('group_quiz_items', 'ordering');
	}
}
