<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_multiplechoice_25_mei extends CI_Migration {

	public function up()
	{
		$fields = array(
			'post_question' => array(
				'type' => 'text',
				'null' => TRUE,
				'default' => NULL,
			),
			'multiplechoice_story_code' => array(
				'type' => 'varchar',
				'constraint' => '20',
				'null' => TRUE,
				'default' => NULL,
			),
			'group_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'default' => NULL,
			),
		);
		
		$this->dbforge->add_column('multiplechoice_question', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('multiplechoice_question', 'group_name');
		$this->dbforge->drop_column('multiplechoice_question', 'multiplechoice_story_code');
		$this->dbforge->drop_column('multiplechoice_question', 'post_question');
	}
}
