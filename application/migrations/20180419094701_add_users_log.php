<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users_log extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'users_id' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'null' => FALSE,
			),
			'time' => array(
				'type' => 'DATETIME',
			),
			'action' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY `fk_users_users_id` (users_id) REFERENCES users(id)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_log', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('users_log');
	}
	
}
