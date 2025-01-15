<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Table_quiz_paket extends Ci_Model 
{
	private $db_table;

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->db_table = $this->db->protect_identifiers('quiz_paket_soal', TRUE);
		$this->load->library('help');
	}

	function get_count_by_quiz_code($quiz_code){

		$status = 'ok';
		
		if(!$quiz_code){
			$status = 'failed';
			$message = 'quiz_code is required';
		}

		if($status == 'ok'){
			$count = $this->db->where('quiz_code', $quiz_code)->count_all_results($this->db_table);
			$data = array(
				'count' => $count
			);
			$message = 'Data retrieve successfully';
		}

		return array(
			'status' => $status,
			'data' => $data,
			'message' => $message
		);
	}
}
