<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends Ci_Model {

	function __construct(){
		$this->load->model('Table_users');
	}
	public function get_user_quiz_by_user($users_id){
		$sql = "SELECT * FROM users_quiz uq WHERE uq.active = 1 AND uq.users_id = ?";
		return $this->db->query($sql, array($users_id))->result('array');
	}

	public function get_user_report($sesi_code)
	{
		$result = array();
		$sql_user_quiz = "SELECT uq.quiz_id FROM users_quiz uq WHERE uq.active = 1 AND uq.users_id = ?";
		$sql_quiz = "SELECT q.id, q.code, q.label FROM quiz q WHERE q.id = ?";
		$users = $this->Table_users->get_by_sesi($sesi_code)["data"];
		foreach($users as $user){
			$user_quizs = $this->db->query($sql_user_quiz, array($user['id']))->result('array');
			$result[$user['id']] = $user;
			foreach($user_quizs as $user_quiz){
				$quizs = $this->db->query($sql_quiz,array($user_quiz["quiz_id"]))->result('array');
				foreach($quizs as $quiz){
					$result[$user['id']]['quiz'][$quiz['id']] = $quiz;
				}
			}
		}
		return $result;
	}	
	
	public function get_quiz_report($sesi_code)
	{
		$sql = "SELECT DISTINCT uq.quiz_id, q.code, q.label FROM users_quiz uq
						LEFT JOIN quiz q ON (q.id = uq.quiz_id)
						LEFT JOIN users u ON (u.id = uq.users_id)
						WHERE uq.active = 1 AND u.sesi_code = ? GROUP BY uq.quiz_id
				";
		return $this->db->query($sql, array($sesi_code))->result('');
	}

}
?>
