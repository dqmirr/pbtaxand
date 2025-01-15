<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_formasi extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'unique' => TRUE,
			),
			'label' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'sesi_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
		));
		
		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY `fk_sesi_sesi_code` (sesi_code) REFERENCES sesi(code)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('formasi', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('formasi');
	}
	
}
