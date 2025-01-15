<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_quiz2 extends CI_Migration {

	public function up()
	{
		$fields = array(
			'sub_library_code' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
			),
		);
		
		$this->dbforge->add_column('quiz', $fields);
		$this->dbforge->add_field('FOREIGN KEY (sub_library_code) REFERENCES sub_library (code)');
	}
	
	public function down()
	{
		$this->dbforge->drop_column('quiz', 'sub_library_code');
	}
}
