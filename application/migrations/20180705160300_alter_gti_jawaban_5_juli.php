<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_gti_jawaban_5_juli extends CI_Migration {

	public function up()
	{
		$fields = array(
			'jawaban' => array(
				'type' => 'varchar',
				'constraint' => 10,
			),
		);
		
		$this->dbforge->modify_column('gti_jawaban', $fields);
	}

	public function down()
	{
		$fields = array(
			'jawaban' => array(
				'type' => 'varchar',
				'constraint' => 2,
			),
		);
		
		$this->dbforge->modify_column('gti_jawaban', $fields);
	}
}
