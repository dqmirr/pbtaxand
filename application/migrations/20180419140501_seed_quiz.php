<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_quiz extends CI_Migration {

	public function up()
	{
		$data = array(
			array(
				'code' => 'gti_pci', 
				'library_code' => 'gti',
				'label' => 'Subtest 1',
				'sub_library_code' => 'gti_pci',
				'description' => '',
			),
			array(
				'code' => 'gti_penalaran', 
				'library_code' => 'gti',
				'label' => 'Subtest 2',
				'sub_library_code' => 'gti_penalaran',
				'description' => '',
			),
			array(
				'code' => 'gti_jh', 
				'library_code' => 'gti',
				'label' => 'Subtest 3',
				'sub_library_code' => 'gti_jh',
				'description' => '',
			),
			array(
				'code' => 'gti_kka', 
				'library_code' => 'gti',
				'label' => 'Subtest 4',
				'sub_library_code' => 'gti_kka',
				'description' => '',
			),
			array(
				'code' => 'gti_orientasi', 
				'library_code' => 'gti',
				'label' => 'Subtest 5',
				'sub_library_code' => 'gti_orientasi',
				'description' => '',
			),
		);
		
		// Seed
		$this->db->insert_batch('quiz', $data);
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
		$this->db->delete('quiz');
	}
}
