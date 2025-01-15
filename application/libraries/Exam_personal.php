<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_personal extends Class_Exam {
	
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
		
		switch ($sub_library_code)
		{
			case 'hexaco':
				$opsi_jawaban = array(0=>'Sangat Setuju', 1=>'Setuju', 2=>'Netral', 3=>'Tidak Setuju', 4=>'Sangat Tidak Setuju');
			break;
			
			case 'cti':
				$opsi_jawaban = array(0=>'Pasti Benar', 1=>'Hampir/Banyak Benarnya', 2=>'Ragu-ragu', 3=>'Hampir/Banyak Salahnya', 4=>'Pasti Salah');
			break;
			
			case 'd3ad':
				$opsi_jawaban = ['A', 'B'];
			break;
            
            case 'psikosomatis':
                $opsi_jawaban = array(
                    1 => array(1 => 'Ya', 0 => 'Tidak'),
                    2 => array(
                            1 => 'Jika Anda Tidak Pernah Berfikir dan Merasakannya',
                            2 => 'Jika Anda Jarang berfikir dan Merasakannya',
                            3 => 'Jika Anda terkadang berfikir dan merasakannya',
                            4 => 'Jika Anda Sering berfikir dan Merasakannya',
                            5 => 'Jika Anda Selalu Berfikir dan Merasakannya',
                        ),
                    3 => array(1 => 'Ya', 0 => 'Tidak'),
                );
            break;
		}
		
		// Questions	
		$this->ci->db->where('is_tutorial', $is_tutorial);
		switch($code){
			case 'hexaco':
				$this->ci->db->where('quiz_code', 'P1v2');
				break;
			default:
				$this->ci->db->where('quiz_code', $code);
				break;
		}
		
		$get = $this->ci->db->get('personal_questions');
		$quiz_result = $get->result();
		
		$rows = array();
		
		// Karena d3ad beda sendiri modelnya, maka dia diurai dulu
		if ($sub_library_code == 'd3ad')
		{
			$group_quiz_result = array();
			
			foreach ($quiz_result as $index => $row)
			{
				$group_index = ($row->nomor - 1);
				
				if (! isset($group_quiz_result[$group_index]->nomor))
				{
					$group_quiz_result[$group_index] = (object) array(
						'id' => $row->id,
						'nomor' => $row->nomor,
						'soal' => array(), 
						'reversed_score' => $row->reversed_score,
						);
				}
				
				$group_quiz_result[$group_index]->soal[] = array('id' => $row->id, 'text' => $row->soal);
			}
			
			// Ganti $quiz_result menjadi $group_quiz_result
			$quiz_result = $group_quiz_result;
		}
        
        if ($sub_library_code == 'psikosomatis')
        {
            $group_quiz_result = array();
            $arr_group_index = array();
            
            foreach ($quiz_result as $index => $row)
			{
                $group_index = $row->reversed_score;
                $group_quiz_result[$group_index]['soal'][$row->id] = $row->soal;
                $arr_group_index[$group_index][] = $row->id;
            }
            
            foreach ($group_quiz_result as $group_index => $val)
            {
                // randomize soal
                shuffle($arr_group_index[$group_index]);
                $new_soal = array();
                
                foreach ($arr_group_index[$group_index] as $soal_id)
                {
                    $new_soal[$soal_id] = $group_quiz_result[$group_index]['soal'][$soal_id];
                }
                
                $group_quiz_result[$group_index]['soal'] = $new_soal;
            }
        }
		
		foreach ($quiz_result as $index => $row)
		{
			$arr_soal = array();
			
			switch ($sub_library_code)
			{
				case 'hexaco':
					$arr_soal[] =$row->soal;
					
					$opsi = [5,4,3,2,1];
					
					if ($row->reversed_score == 1)
					{
						$opsi = [1,2,3,4,5];
					}
					
				break;
				
				case 'cti':
					$arr_soal[] =$row->soal;
					
					$opsi = [5,4,3,2,1];
					
					if ($row->reversed_score == 1)
					{
						$opsi = [1,2,3,4,5];
					}
				break;
				
				case 'd3ad':
					// khusus untuk ini arr_soal tidak perlu append
					$arr_soal =$row->soal;
					$opsi = null;
				break;
                
                case 'psikosomatis':
                    continue;
                break;
			}

			$data = array(
				'id' => $row->id,
				'index' => $index,
				'opsi' => $opsi,
				'soal' => $arr_soal,
			);
			
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
        
        if ($sub_library_code == 'psikosomatis')
        {
            $random_rows = $group_quiz_result;
        }
		
		$result['opsi_jawaban'] = $opsi_jawaban;
		$result['sub_library'] = $sub_library_code;
		$result['rows'] = $random_rows;
		
		$dbsave = $this->ci->load->database('save', TRUE);
        
        // Semua data di $result kecuali seconds (karena akan direplace saat dipanggil kembali)
        $save = array();
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
        $this->exam_generate_questions($quiz_code, 'personal_questions');
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
			
            $sql = "INSERT INTO personal_jawaban
				(`users_id`, `personal_questions_id`, `jawaban`, `quiz_code`,`created`)
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
