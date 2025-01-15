<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_email_job extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'unique' => TRUE
			),
			'interval' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
			'order' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field('UNIQUE `interval_order` (`interval`, `order`)');
		$this->dbforge->create_table('email_job', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('email_job');
	}
	
}
