<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_admins extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
			),
			'fullname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 254,
				'unique' => TRUE,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('admins', FALSE, $attributes);
		
		$this->db->insert('admins', array(
			'username' => 'admin',
			'password' => sha1('admin'),
			'fullname' => 'Administrator',
			'email' => 'admin@localhost',
		));
	}

	public function down()
	{
		$this->dbforge->drop_table('admins');
	}
	
}
