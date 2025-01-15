<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_sub_library extends CI_Migration {

	public function up()
	{
		$data = array(
			array('library_code'=>'gti', 'code' => 'gti_pci'),
			array('library_code'=>'gti', 'code' => 'gti_penalaran'),
			array('library_code'=>'gti', 'code' => 'gti_jh'),
			array('library_code'=>'gti', 'code' => 'gti_kka'),
			array('library_code'=>'gti', 'code' => 'gti_orientasi'),
		);
		
		// Seed
		$this->db->insert_batch('sub_library', $data);
	}
	
	public function down()
	{
		$data = array(
			'gti_pci',
			'gti_penalaran',
			'gti_jh',
			'gti_kka',
			'gti_orientasi',
		);
		$this->db->where_in('code', $data);
		$this->db->delete('sub_library');
	}

}
