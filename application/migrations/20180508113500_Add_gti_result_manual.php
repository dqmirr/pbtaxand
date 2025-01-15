<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_gti_result_manual extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			),
			'fullname' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE,
			),
			'formasi_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'lc_num' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			're_num' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'ld_num' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'nd_num' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'so_num' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'gtq_num' => array(
				'type' => 'DECIMAL',
				'constraint' => '10,2',
			),
			'gtq' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'lc' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			're' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'ld' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'nd' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'so' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'target' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'kategori' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
			),
			'rank' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'lc_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
			're_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
			'ld_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
			'nd_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
			'so_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
			'gtq_text' => array(
				'type' => 'VARCHAR',
				'constraint' => '256',
			),
		));

		$attributes = array('ENGINE' => 'NDBCLUSTER');
		$this->dbforge->add_field('FOREIGN KEY (username) REFERENCES users(username)');
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('gti_result_manual', FALSE, $attributes);
	}

	public function down()
	{
		$this->dbforge->drop_table('gti_result_manual');
	}
	
}
