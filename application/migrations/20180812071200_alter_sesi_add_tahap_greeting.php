<?php

class Migration_Alter_sesi_add_tahap_greeting extends CI_Migration {

	public function up()
	{
		$fields = array(
			'part' => array(
				'type' => 'varchar',
				'constraint' => 200,
				'null' => TRUE,
			),
			'greeting' => array(
				'type' => 'text',
				'null' => TRUE,
			),
		);
		
		$this->dbforge->add_column('sesi', $fields);
		
		// alter table `sesi` add `part` varchar(200) DEFAULT NULL, add `greeting` text;
	}

	public function down()
	{
		$this->dbforge->drop_column('sesi', 'greeting');
		$this->dbforge->drop_column('sesi', 'part');
	}
}
