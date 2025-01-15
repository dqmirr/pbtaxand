<?php

class Class_Exam {
    
    public function __construct()
	{
		$this->ci =& get_instance();
	}
    
    public function exam_generate_questions($quiz_code, $table_name)
    {
        // Check apakah punya tutorial
        switch ($table_name)
        {
			case 'disc_question':
            case 'multiplechoice_question':
            case 'essay_questions':
                // ... do nothing
            break;
            
            default:
                $this->ci->db->select('id');
                $this->ci->db->where('quiz_code', $quiz_code);
                $this->ci->db->where('is_tutorial', 1);
                $this->ci->db->limit(1);
                $get = $this->ci->db->get($table_name);
                
                if ($row = $get->first_row())
                {
                    // Check apakah sudah ada di table quiz_paket_soal, karena tutorial cukup 1 saja
                    $this->ci->db->select('id');
                    $this->ci->db->where('quiz_code', $quiz_code);
                    $this->ci->db->where('is_tutorial', 1);
                    $this->ci->db->limit(1);
                    $get = $this->ci->db->get('quiz_paket_soal');
                    
                    if (! $row = $get->first_row())
                    {
                        // method dari library yang bersangkutan
                        $this->generate_question($quiz_code, 1);
                    }
                }
        }
        
        // method dari library yang bersangkutan
        $this->generate_question($quiz_code);
    }
    
    public function get_questions($code, $is_tutorial = 0, $library = null, $epoch_now = null)
	{
        $result = array('rows'=>[]);
        
        if ($is_tutorial === true || $is_tutorial > 0)
        {
            $this->ci->db->where('quiz_code', $code);
            $this->ci->db->where('is_tutorial', 1);
            $get = $this->ci->db->get('quiz_paket_soal');
            
            if ($row = $get->first_row('array'))
            {
                // Set Result
                $result = json_decode($row['rows'], true);
            }
            
            // get sub_library
            $this->ci->db->select('sub_library_code as sub_library, code');
            $this->ci->db->where('code', $code);
            $this->ci->db->limit(1);
            $get = $this->ci->db->get('quiz');
            
            if ($row = $get->first_row('array'))
            {
                $result = array_merge($result, $row);
            }
        }
        else
        {
            $this->ci->db->select('rows, id');
            $this->ci->db->where('quiz_code', $code);
            $this->ci->db->where('is_tutorial', 0);
            $this->ci->db->where('deleted', 0);
            $get_paket_soal = $this->ci->db->get('quiz_paket_soal');
            
            $total_row = $get_paket_soal->num_rows('array');
            
            if ($total_row > 0)
            {
                // Get seconds from quiz table
                $this->ci->db->select('seconds');
                $this->ci->db->where('code', $code);
                $get = $this->ci->db->get('quiz');
                
                if ($quiz = $get->first_row())
                {
                    $seconds = $quiz->seconds;
                    
                    $data = $get_paket_soal->result('array');
                    $index = rand(0, $total_row - 1);
                    
                    $selected = $data[$index];
                    $quiz_paket_soal_id = $selected['id'];
                    $row = json_decode($data[$index]['rows'], true);
                    
                    // Set Result
                    $result = $row;
                    $result['seconds'] = $seconds;
                    
                    // get settings
                    $this->ci->db->select('value');
                    $this->ci->db->where('name', $code.'_seconds_extra');
                    $get_settings = $this->ci->db->get('settings');
                    
                    if ($row_settings = $get_settings->first_row())
                    {
                        $result['seconds_extra'] = $row_settings->value;
                    }
                    
                    // Simpan ke users_quiz_log
                    $dbsave = $this->ci->load->database('save', TRUE);
                    
                    $query = '
                    INSERT INTO users_quiz_log (`rows`, `quiz_paket_soal_id`, seconds, time_start, quiz_code, users_id, epoch_start) VALUES (?,?,?,?,?,?,?)
                    ON DUPLICATE KEY UPDATE `rows` = ?, seconds = ?';

					if($epoch_now){
						$epoch_seconds = intval($epoch_now)/1000;
						$time_start = date('Y-m-d H:i:s', $epoch_seconds);
					}else{
						$time_start = date('Y-m-d H:i:s');
					}
                    
					$result['epoch_start'] = $epoch_now;
					$result['time_start'] = $time_start;
					$result['total_seconds'] = $seconds;
                    $result['validation'] = md5($time_start);
                    
                    if ($library == 'pauli')
                    {
                        $dbsave->trans_start();
                    }

					$dbsave->query(
							$query,
							array(
									json_encode($row),
									$quiz_paket_soal_id,
									$seconds,
									$time_start,
									$code,
									$this->ci->session->userdata('id'),
									$epoch_now,
									json_encode($row),
									$seconds,
							)
					);
                    
                    if ($library == 'pauli')
                    {
                        // Hapus semua data jawaban dan statitik
                        $dbsave->where('users_id', $this->ci->session->userdata('id'));
                        $dbsave->where('quiz_code', $code);
                        $dbsave->delete('pauli_jawaban_log');
                        
                        $dbsave->where('users_id', $this->ci->session->userdata('id'));
                        $dbsave->where('quiz_code', $code);
                        $dbsave->delete('pauli_jawaban_statistik');
                        
                        $dbsave->trans_complete();
                    }
                }
            }
        }
        
        return $result;
    }
}
