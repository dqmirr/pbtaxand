<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_gti_jawaban_add_time extends CI_Migration {

	public function up()
	{
		$fields = array(
			'created' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'updated' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
		);
		
		$this->dbforge->add_column('gti_jawaban', $fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('gti_jawaban', 'created');
		$this->dbforge->drop_column('gti_jawaban', 'updated');
	}
}
