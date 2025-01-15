<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_quiz_log_model extends Ci_Model {

	public function hanya_yang_belum_selesai($users_id, &$arr_library_code)
	{
		$arr_quiz_code = array();

		foreach ($arr_library_code as $quiz_code => $library_code)
		{
			$arr_quiz_code[] = $quiz_code;
		}
		
		if(count($arr_quiz_code) > 0){
			$this->realtime_seconds_used($users_id, $arr_quiz_code);
			
			$this->db->select('quiz_code, epoch_start, time_start, time_end, index, (case when seconds > seconds_used then (seconds - seconds_used) else 0 end) as check_id, seconds as total_seconds');
			$this->db->where('users_id', $users_id);
			$this->db->where_in('quiz_code', $arr_quiz_code);
			
			$get = $this->db->get('users_quiz_log');
			
			foreach ($get->result() as $row)
			{

				if ($row->time_end != '')
					unset($arr_library_code[$row->quiz_code]);
				else
				{
					$arr_library_code[$row->quiz_code]['index'] = intval($row->index);
					$arr_library_code[$row->quiz_code]['time_start'] = $row->time_start;
					$arr_library_code[$row->quiz_code]['epoch_start'] = $row->epoch_start;
					$arr_library_code[$row->quiz_code]['check_id'] = $row->check_id;
					$arr_library_code[$row->quiz_code]['total_seconds'] = $row->total_seconds;
					$arr_library_code[$row->quiz_code]['validation'] = md5($row->time_start);
				}
			}
		}
	}

	public function update_seconds_used($index, $seconds_used, $users_id, $quiz_code){
		$this->db->set('last_update', date('Y-m-d H:i:s'));
		$this->db->set('seconds_used', $seconds_used);
		$this->db->where('quiz_code', $quiz_code);
		$this->db->where('users_id', $users_id);
		
		if ($index !== null)
		{
			$this->db->set('index', $index);
		}
		$this->db->update('users_quiz_log');
	}
	
	public function tandai_sudah_selesai($users_id, &$arr_quiz)
	{
		$params = array();
		$single_selesai = array();
		$quiz_group_lookup = array();
		$group_items_count = array();
		$group_selesai = array();
		
		foreach ($arr_quiz as $quiz)
		{
			if ($quiz->group_quiz_code != '' && $quiz->library_code!='multiplechoice')
			{
				$get = $this->db->query('SELECT quiz_code FROM group_quiz_items WHERE group_quiz_code = ?', array($quiz->group_quiz_code));
				
				$group_items_count[$quiz->group_quiz_code] = 0;
				
				foreach ($get->result() as $row)
				{
					$params[] = $row->quiz_code;
					$quiz_group_lookup[$row->quiz_code] = $quiz->group_quiz_code;
					$group_items_count[$quiz->group_quiz_code] += 1;
				}
			}
			else
			{
				$params[] = $quiz->code;
			}
		}
		
		if (count($params) > 0)
		{
			$this->db->select('quiz_code');
			$this->db->where_in('quiz_code', $params);
			$this->db->where('users_id', $users_id);
			$this->db->where('time_end is not ', 'null', false);
			$get = $this->db->get('users_quiz_log');
			
			foreach ($get->result() as $row)
			{
				if (isset($quiz_group_lookup[$row->quiz_code]))
					$group_items_count[$quiz_group_lookup[$row->quiz_code]] -= 1;
				
				$single_selesai[] = $row->quiz_code;
			}
			
			// Tandai di sini
			foreach ($arr_quiz as $quiz)
			{
				if (isset($group_items_count[$quiz->group_quiz_code]) && $group_items_count[$quiz->group_quiz_code] == 0)
				{
					$quiz->done = 1;
				}
				
				// dipisah tidak menggunakan elseif karena bisa jadi ga sengaja diset quiznya di luar group
				if (in_array($quiz->code, $single_selesai))
				{
					$quiz->done = 1;
				}
			}
		}
	}

	public function get_status_quiz($users_id, $quiz_code){
		define("STATUS_QUIZ",["Belum Dikerjakan", "Proses", "Selesai"]);
		$status_id = 0;

		$this->db->select('uql.time_start, uql.time_end');
		$this->db->where('uql.users_id', $users_id);
		$this->db->where('uql.quiz_code', $quiz_code);
		$query = $this->db->get("users_quiz_log uql")->first_row('array');
		if($query){
			$status_id = 1;
			if($query["time_end"]){
				$status_id = 2;
			}
		}

		return array(
			'id' => $status_id,
			'label' => STATUS_QUIZ[$status_id]
		);
	}

	public function get_questions($quiz_code, $users_id){
		$this->db->select('a.rows, b.id, b.rows as rows_paket_soal');
		$this->db->where('a.quiz_code', $quiz_code);
		$this->db->where('a.users_id', $users_id);
		$this->db->join('quiz_paket_soal b', 'b.id = a.quiz_paket_soal_id', 'left');
		$get = $this->db->get('users_quiz_log a')->result_array();
		return json_decode($get[0]['rows']);
	}

	public function find_current_users_quiz_log($users_id, $quiz_code){
		$this->db->select('*');
		$this->db->where('quiz_code', $quiz_code);
		$this->db->where('users_id', $users_id);
		$get = $this->db->get('users_quiz_log');
		return $get->row();
	}

	public function find_one_by_user_id($user_id){
		$this->db->select('a.users_id, a.quiz_code, a.time_start, a.time_end, a.last_update');
		$this->db->where('a.users_id', $user_id);
		$get = $this->db->get('users_quiz_log a')->row_array();
		return $get;
	}

	public function remove_by($users_id, $quiz_code){
		$this->db->where('users_id', $users_id);
		$this->db->where('quiz_code', $quiz_code);
		$this->db->delete('users_quiz_log');
	}

	public function check_finished_quiz($user_id, $code){
		$current_quiz = $this->find_current_users_quiz_log($user_id, $code);
		
		if(!$current_quiz){
			return false;
		}
		$now = date('Y-m-d H:i:s');
		$time_now = strtotime($now);
		$time_start = strtotime($current_quiz["time_start"]);
		$total_seconds_to_finished = intval($current_quiz["seconds"]);
		$current_seconds = abs($time_now - $time_start);
		$index = intval($current_quiz["index"]);
		$seconds_used = intval($current_quiz["seconds_used"]);
		
		if($time_end != ''){
			return true;
		}
		
		if($current_seconds >= $total_seconds_to_finished){
			$this->update_seconds_used($index, $total_seconds_to_finished, $user_id, $code);
			return true;
		}

        return false;
	}

	public function realtime_seconds_used($users_id, $arr_quiz_code){

		// var_dump($arr_quiz_code);
		$this->db->select('quiz_code, time_start, time_end, index, seconds, seconds_used');
		$this->db->where('users_id', $users_id);
		$this->db->where_in('quiz_code', $arr_quiz_code);
		
		$get = $this->db->get('users_quiz_log');
		foreach($get->result() as $row){
			$now = date('Y-m-d H:i:s');

			$date_1 = "2024-05-15 21:45:00";
			$date_2 = "2024-05-15 21:00:00";

			// $now_dt = new DateTime($now);
			// $start_dt = new DateTime($row->time_start);
			// $diff = $now_dt->diff($start_dt);
			$time_now = strtotime($now);
			$time_start = strtotime($row->time_start);
			$total_seconds_to_finished = intval($row->seconds);
			$seconds_used = $time_now - $time_start;
			if($seconds_used >= $total_seconds_to_finished){
				$seconds_used = $total_seconds_to_finished;
			}

			$this->update_seconds_used($row->index, $seconds_used, $users_id, $row->quiz_code);
		}
	}

}
