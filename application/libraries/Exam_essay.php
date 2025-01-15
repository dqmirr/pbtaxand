<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_essay extends Class_Exam {
	
	protected $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
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
		
		$sub_library_code = $row->sub_library_code;
		$seconds = $row->seconds;
		
		// Questions	
		$this->ci->db->select('id, question');
		$this->ci->db->where('quiz_code', $code);
		
		$get = $this->ci->db->get('essay_questions');
		$quiz_result = array();
		
		foreach ($get->result() as $index => $row)
		{
			$row->index = $index;
			$quiz_result[] = $row;
		}
		
		$result['seconds'] = $seconds;
		$result['opsi_jawaban'] = $opsi_jawaban;
		$result['sub_library'] = $sub_library_code;
		$result['rows'] = $quiz_result;
		
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
        $this->exam_generate_questions($quiz_code, 'essay_questions');
    }
	
	public function save_answers($users_id, $code, $arr_jawaban, $seconds_used = 0, $index = null)
	{  		
		$dbsave = $this->ci->load->database('save', TRUE);
		
        foreach($arr_jawaban as $id_soal => $jawaban)
        {			
			$time = date('Y-m-d H:i:s');
			
            $sql = "INSERT INTO essay_jawaban
				(`users_id`, `essay_questions_id`, `jawaban`, `quiz_code`,`created`)
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
	}
}
