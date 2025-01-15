<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_ist extends Class_Exam {
	
	protected $ci;
	protected $img_dir;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->img_dir = 'assets/images/';
	}
	
	public function restart($users_id, $code)
	{
		return false;
		//return $this->ci->db->delete('personal_jawaban', array('users_id'=>$users_id, 'quiz_code'=>$code ));
	}
	
	protected function generate_question($code, $is_tutorial = 0)
	{
		$result = array();
		$arr_index = array();
		$opsi_jawaban = [];
		$seconds = 0;
		
		$this->ci->db->select('seconds, sub_library_code, id');
		$this->ci->db->where('code', $code);
		$get = $this->ci->db->get('quiz');
		$row = $get->first_row();
		
		$quiz_id = $row->id;
		
		if ($is_tutorial != 1)
		{
			$is_tutorial = 0;
			
			// Timer
			$seconds = $row->seconds;
			$result['seconds'] = $seconds;
		}
		
		$sub_library_code = $row->sub_library_code;
		
		// get settings
		$this->ci->db->select('value');
		$this->ci->db->where('name', $code.'_seconds_extra');
		$get_settings = $this->ci->db->get('settings');
		
		if ($row_settings = $get_settings->first_row())
		{
			$result['seconds_extra'] = $row_settings->value;
		}
		
		$opsi_jawaban = [];
		$arr_group = [];
		
		// Questions	
		$this->ci->db->where('is_tutorial', $is_tutorial);
		$this->ci->db->where('quiz_code', $code);
		
		$get = $this->ci->db->get('ist_questions');
		$quiz_result = $get->result();
		
		$rows = array();
		
		foreach ($quiz_result as $index => $row)
		{	
			switch ($sub_library_code)
			{
				case 'zr':
					$data = array(
						'id' => $row->id,
						'index' => $index,
						'soal' => explode(',', $row->soal),
						'jawaban_user' => '?',
					);
				break;
				
				default: 
					$data = array(
						'id' => $row->id,
						'index' => $index,
						'group' => $row->ist_group_code,
						'soal' => $row->soal,
					);
					
					$arr_group[] = $row->ist_group_code;
			}
			
			$rows[$index] = $data;
			$arr_index[] = $index;
		}
		
		$random_rows = $rows;
		
		shuffle($arr_index);
		$random_rows = array();
		
		foreach ($arr_index as $key => $index)
		{
			$rows[$index]['index'] = $key;
			$random_rows[$key] = $rows[$index];
		}
		
		// Kalau ada group
		if (count($arr_group) > 0)
		{
			$groups = array();
			
			$this->ci->db->select('code, soal');
			$this->ci->db->where_in('code', $arr_group);
			$get = $this->ci->db->get('ist_group');
			
			foreach ($get->result() as $row)
			{
				$arr_group_opsi = array();
				$group_opsi = explode(',', $row->soal);
				
				foreach ($group_opsi as $gopsi)
				{
					$gopsi_part = explode('=', $gopsi);
					$arr_group_opsi[$gopsi_part[0]] = $gopsi_part[1];
				}
				
				$groups[$row->code] = $arr_group_opsi;
			}
			
			$result['group_code'] = $groups;
		}
		
		$result['opsi_jawaban'] = $opsi_jawaban;
		$result['sub_library'] = $sub_library_code;
		$result['rows'] = $random_rows;
		
        $dbsave = $this->ci->load->database('save', TRUE);
        
        // Semua data di $result kecuali seconds (karena akan direplace saat dipanggil kembali)
        $save = array();
        
        if (isset($result['group_code']))
        {
            $save['group_code'] = $result['group_code'];
        }
        
        $save['opsi_jawaban'] = $result['opsi_jawaban'];
        $save['sub_library'] = $result['sub_library'];
        $save['rows'] = $result['rows'];
			
		$rows = json_encode($save);
        
        // Simpan Paket Soal
        $dbsave->set('rows', $rows);
        $dbsave->set('quiz_code', $code);
        $dbsave->set('is_tutorial', $is_tutorial);
        $dbsave->insert('quiz_paket_soal');
		
		return $dbsave->insert_id();
	}
    
    public function generate_questions($quiz_code)
    {
        $this->exam_generate_questions($quiz_code, 'ist_questions');
    }
	
	public function save_answers($users_id, $code, $arr_jawaban, $seconds_used = 0, $index = null)
	{   
		// Sebelum simpan, pastikan time_end belum terisi, kalau sudah terisi maka jangan dilanjutkan.
		/*
		$this->ci->db->select('time_end');
		$this->ci->db->where('quiz_code', $code);
		$this->ci->db->where('users_id', $users_id);
		$this->ci->db->where('time_end !=', null);
		
		$get = $this->ci->db->get('users_quiz_log');
		
		if ($get->num_rows() > 0)
			return true;
		*/
		
		//$this->ci->db->trans_start();
		
		$dbsave = $this->ci->load->database('save', TRUE);
		
        foreach($arr_jawaban as $id_soal => $jawaban)
        {			
			$time = date('Y-m-d H:i:s');
			
            $sql = "INSERT INTO ist_jawaban
				(`users_id`, `ist_questions_id`, `jawaban`, `quiz_code`,`created`)
				VALUES
				(?, ?, ?, ?, ?)
				ON DUPLICATE KEY UPDATE jawaban = ?, updated = ?
			";
			
			$dbsave->query($sql, array($users_id, $id_soal, $jawaban, $code, $time, $jawaban, $time));
        }
        
        // Update users_quiz
        $dbsave->set('last_update', date('Y-m-d H:i:s'));
        $dbsave->set('seconds_used', $seconds_used);
        $dbsave->where('quiz_code', $code);
        $dbsave->where('users_id', $users_id);
        
        if ($index !== null)
        {
            $dbsave->set('index', $index);
        }
        
        return $dbsave->update('users_quiz_log');
        
        //$this->ci->db->trans_complete();

		//return $this->ci->db->trans_status();
	}
}
