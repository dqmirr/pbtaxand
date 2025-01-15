<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_library1 extends CI_Migration {

	public function up()
	{
		$data = array(
			array('code' => 'gti'),
		);
		
		// Seed
		$this->db->insert_batch('library', $data);
	}
	
	public function down()
	{
		$data = array(
			'gti_pci',
		);
		$this->db->where_in('code', $data);
		$this->db->delete('library');
	}

}
