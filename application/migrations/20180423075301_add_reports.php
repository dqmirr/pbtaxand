<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_reports extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'created' => array(
				'type' => 'DATETIME',
			),
			'updated' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE,
			),
			'query' => array(
				'type' => 'TEXT',
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('reports', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('reports');
	}
	
}
