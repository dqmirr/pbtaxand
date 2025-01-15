<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_gti_questions_5_juli extends CI_Migration {

	public function up()
	{
		$fields = array(
			'jawaban' => array(
				'type' => 'varchar',
				'constraint' => 10,
			),
		);
		
		$this->dbforge->modify_column('gti_questions', $fields);
	}

	public function down()
	{
		$fields = array(
			'jawaban' => array(
				'type' => 'varchar',
				'constraint' => 2,
			),
		);
		
		$this->dbforge->modify_column('gti_questions', $fields);
	}
}
