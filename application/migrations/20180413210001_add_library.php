<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_library extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('code', TRUE);
		$this->dbforge->create_table('library', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('library');
	}
	
}
