<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_quiz_model extends Ci_Model {
	
	public function get_user_quizes($users_id)
	{
		$this->db->select('quiz.*, users_quiz.is_debug');
		$this->db->where('users_id', $users_id);
		$this->db->where('quiz.active', 1);
		$this->db->where('users_quiz.active', 1);
		$this->db->join('quiz', 'quiz.id = users_quiz.quiz_id');
		
		$get = $this->db->get('users_quiz');
		
		return $get->result();
	}
	
	public function add($users_id, $ids)
	{
		$this->db->trans_start();
		
		$this->db->set('active', 0);
		$this->db->where('users_id', $users_id);
		$this->db->update('users_quiz');
		
		foreach ($ids as $id)
		{
			// Insert or update
			$this->db->query("INSERT INTO users_quiz (users_id, quiz_id, active) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE active = 1", array($users_id, $id));
		}
		
		$this->db->trans_complete();
	}
	public function set_debugs($users_id, $is_debugs = array())
	{
		$this->db->trans_start();
		
		$this->db->set('is_debug', 0);
		$this->db->where('users_id', $users_id);
		$this->db->update('users_quiz');
		
		// jika terdapat id quiz maka is debug di set 1
		foreach ($is_debugs as $id)
		{
			// Insert or update
			$this->db->query("INSERT INTO users_quiz (users_id, quiz_id, is_debug) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE is_debug = 1", array($users_id, $id));
		}
		
		$this->db->trans_complete();
	}
	
	public function done($users_id, $code, $seconds_used = 0)
	{   
		$dbsave = $this->load->database('save', TRUE);
		
		$dbsave->set('time_end', date('Y-m-d H:i:s'));
		$dbsave->set('seconds_used', $seconds_used);
		$dbsave->where('users_id', $users_id);
		$dbsave->where('quiz_code', $code);
		
		return $dbsave->update('users_quiz_log');
	}
	
	public function validate_user_code_and_library($users_id, $code, $library_code)
	{
		// Check dulu berdasarkan code quiz dan library code
		$this->db->select('code');
		$this->db->where('users_id', $users_id);
		$this->db->where('code', $code);
		$this->db->where('library_code', $library_code);
		$this->db->where('quiz.active', 1);
		$this->db->where('users_quiz.active', 1);
		$this->db->join('quiz', 'quiz.id = users_quiz.quiz_id');
		$this->db->limit(1);
		
		$get = $this->db->get('users_quiz');
		
		if ($get->num_rows() == 1)
			return true;
		else
		{
			$this->db->select('group_quiz_items.quiz_code as code');
			$this->db->where('users_quiz.users_id', $users_id);
			$this->db->where('group_quiz_items.quiz_code', $code);
			$this->db->where('quiz_item.library_code', $library_code);
			$this->db->where('quiz.active', 1);
			$this->db->where('users_quiz.active', 1);
			$this->db->join('quiz', 'quiz.id = users_quiz.quiz_id and quiz.group_quiz_code is not null');
			$this->db->join('group_quiz_items', 'group_quiz_items.group_quiz_code = quiz.group_quiz_code');
			$this->db->join('quiz as quiz_item', 'quiz_item.code = group_quiz_items.quiz_code');
			$this->db->limit(1);
			
			$get = $this->db->get('users_quiz');
			
			if ($get->num_rows() == 1)
				return true;
		}
		
		return false;
	}
	
	public function valid_user_quiz_code($users_id, $code, &$quiz_info = array(), &$arr_library_code = array())
	{
		$arr_library_code = array();
		
		$this->db->select('allow_restart, code, label, description, library_code, sub_library_code, group_quiz_code');
		$this->db->where('users_id', $users_id);
		$this->db->where('code', $code);
		$this->db->where('quiz.active', 1);
		$this->db->where('users_quiz.active', 1);
		$this->db->join('quiz', 'quiz.id = users_quiz.quiz_id');
		$this->db->limit(1);
		
		$get = $this->db->get('users_quiz');
		
		if ($row = $get->first_row())
		{
			$quiz_info = array(
				'label' => $row->label,
				'description' => $row->description,
			);
			
			// Kalau library_code null berarti harus ada group_quiz_code, jika tidak ada maka return false
			$library_code = $row->library_code;
			$group_quiz_code = $row->group_quiz_code;
			
			if (gettype($library_code) == 'NULL' && gettype($row->group_quiz_code) == 'NULL')
			{
				return false;
			}
			
			if ($library_code)
			{
				$arr_library_code[$row->code] = array(
					'library' => $library_code,
					'sub_library' => $row->sub_library_code,
					'label' => $row->label,
					'allow_restart' => $row->allow_restart,
				);
					
				return true;
			}
			
			if ($group_quiz_code)
			{
				// Cari items
				$this->db->select('allow_restart, code, library_code, sub_library_code, label, quiz.group_quiz_code');
				$this->db->where('quiz.active', 1);
				$this->db->where('group_quiz_items.group_quiz_code', $group_quiz_code);
				$this->db->join('quiz', 'quiz.code = group_quiz_items.quiz_code');
				
				$this->db->order_by('group_quiz_items.ordering ASC');
				
				$get = $this->db->get('group_quiz_items');
				
				foreach ($get->result() as $item)
				{
					if($item->library_code){
						$arr_library_code[$item->code] = array(
							'library' => $item->library_code,
							'sub_library' => $item->sub_library_code,
							'label' => $item->label,
							'allow_restart' => $item->allow_restart,
						);
					} else if($item->group_quiz_code){
						// Cari items
						$this->db->select('allow_restart, code, library_code, sub_library_code, label, quiz.group_quiz_code');
						$this->db->where('quiz.active', 1);
						$this->db->where('group_quiz_items.group_quiz_code', $item->group_quiz_code);
						$this->db->join('quiz', 'quiz.code = group_quiz_items.quiz_code');
						
						$this->db->order_by('group_quiz_items.ordering ASC');
						
						$group_quiz_items = $this->db->get('group_quiz_items');
						foreach ($group_quiz_items->result() as $item){
							// var_dump($item);
							$arr_library_code[$item->code] = array(
								'library' => $item->library_code,
								'sub_library' => $item->sub_library_code,
								'label' => $item->label,
								'allow_restart' => $item->allow_restart,
							);
						}

					}else{
						$arr_library_code[$item->code] = array(
							'library' => $item->library_code,
							'sub_library' => $item->sub_library_code,
							'label' => $item->label,
							'allow_restart' => $item->allow_restart,
						);
					}
				}
				
				return true;
			}
		}
			
		return false;
	}
    
    public function save_session_id($session_id)
    {
        $dbsave = $this->load->database('save', TRUE);
        
        $dbsave->set('active_session_id', $session_id);
        $dbsave->where('id', $this->session->userdata('id'));
        
        if ($dbsave->update('users'))
        {
            $this->session->set_userdata('current_session_id', $session_id);
        }
    }
	
	public function valid_quiz_code($code, &$quiz_info = array(), &$arr_library_code = array())
	{
		$arr_library_code = array();
		
		$this->db->select('allow_restart, code, label, description, library_code, group_quiz_code');
		$this->db->where('code', $code);
		$this->db->limit(1);
		
		$get = $this->db->get('quiz');
		
		if ($row = $get->first_row())
		{
			$quiz_info = array(
				'label' => $row->label,
				'description' => $row->description,
			);
			
			// Kalau library_code null berarti harus ada group_quiz_code, jika tidak ada maka return false
			$library_code = $row->library_code;
			$group_quiz_code = $row->group_quiz_code;
			
			if (gettype($library_code) == 'NULL' && gettype($row->group_quiz_code) == 'NULL')
			{
				return false;
			}
			
			if ($library_code)
			{
				$arr_library_code[$row->code] = array(
					'library' => $library_code,
					'label' => $row->label,
					'allow_restart' => $row->allow_restart,
				);
					
				return true;
			}
			
			if ($group_quiz_code)
			{
				// Cari items
				$this->db->select('allow_restart, code, library_code, label');
				$this->db->where('quiz.active', 1);
				$this->db->where('group_quiz_items.group_quiz_code', $group_quiz_code);
				$this->db->join('quiz', 'quiz.code = group_quiz_items.quiz_code');
				
				$this->db->order_by('group_quiz_items.ordering ASC');
				
				$get = $this->db->get('group_quiz_items');
				
				foreach ($get->result() as $item)
				{
					$arr_library_code[$item->code] = array(
						'library' => $item->library_code,
						'label' => $item->label,
						'allow_restart' => $item->allow_restart,
					);
				}
				
				return true;
			}
		}
			
		return false;
	}
	public function validate_is_debug($users_id, $code){
		$sql = "SELECT a.is_debug 
				FROM users_quiz a
				LEFT JOIN quiz b ON (b.id = a.quiz_id)
				WHERE a.users_id = ? and b.code = ?";
		$query = $this->db->query($sql, array(
			$users_id,
			$code
		));
		$row = $query->first_row();
		return $row->is_debug == 1;
	}
}
