<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_multiplechoice_story extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'code' => array(
				'type' => 'varchar',
				'constraint' => '20'
			),
			'story' => array(
				'type' => 'text',
				'null' => TRUE,
			)
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('code', TRUE);
		$this->dbforge->create_table('multiplechoice_story', FALSE, $attributes);
	}
	
	public function down()
	{
		$this->dbforge->drop_table('multiplechoice_story');
	}

}
