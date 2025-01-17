<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_gti extends Class_Exam {
	
	protected $ci;
	protected $img_dir;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->img_dir = 'assets/images/';
	}
	
	public function restart($users_id, $code)
	{
		return $this->ci->db->delete('multiplechoice_jawaban', array('users_id'=>$users_id, 'jenis_soal'=>$code ));
	}
	
	protected function generate_question($code, $is_tutorial = 0)
	{
		$max_soal = null;
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
		
		switch ($sub_library_code)
		{
			case 'gti_pci':
			case 'gti_pci_r':
				$max_soal = 60;
				$opsi_jawaban = [0,1,2,3,4];
			break;
			
			case 'gti_penalaran':
				$max_soal = 50;
				$opsi_jawaban = [0,1,2];
			break;
			
			case 'gti_penalaran_2':
				$max_soal = 50;
				$opsi_jawaban = [0,1,2,3,4];
			break;
			
			case 'gti_jh':
			case 'gti_jh_r':
				$max_soal = 72;
				$opsi_jawaban = [0,1];
			break;
			
			case 'gti_kka':
			case 'gti_kka_r':
				$max_soal = 60;
				$opsi_jawaban = [0,1,2];
			break;
			
			case 'gti_orientasi':
			case 'gti_orientasi_2':
				$max_soal = 60;
				$opsi_jawaban = [0,1,2,3];
			break;
			
			case 'gti_2d':
			case 'gti_3d':
			case 'gti_kotak':
				$opsi_jawaban = [];
			break;
		}
		
		// Questions	
		$this->ci->db->where('is_tutorial', $is_tutorial);
		$this->ci->db->where('quiz_code', $code);
		
		$get = $this->ci->db->get('gti_questions');
		
		$rows = array();

		foreach ($get->result() as $index => $row)
		{
			$arr_soal = array();
			
			switch ($sub_library_code)
			{
				case 'gti_pci':
				case 'gti_pci_r':
					$atas = substr($row->soal, 0, 4);
					$bawah = substr($row->soal, -4);
					
					for ($i=0; $i<strlen($atas); $i++)
					{
						$arr_soal[] = array($atas[$i], $bawah[$i]);
					}
					
					$opsi = $opsi_jawaban;
				break;
				
				case 'gti_penalaran':
					$pecah = explode(';', $row->soal);
					$arr_soal = explode(',', $pecah[0]);
					$opsi = explode(',', $pecah[1]);
				break;
				
				case 'gti_penalaran_2':
					$pecah = explode(';', $row->soal);
					$arr_soal = array($pecah[0]); // Untuk pelanaran 2, soal semuanya menjadi 1 baris.
					$opsi = explode(',', $pecah[1]);
				break;
				
				case 'gti_jh':
				case 'gti_jh_r':
					$arr_soal[0] = $row->soal[0];
					$arr_soal[1] = $row->soal[1];
					$arr_soal[2] = $row->soal[2];
				
					$opsi = [$arr_soal[0], $arr_soal[2]];
				break;
				
				case 'gti_kka':
				case 'gti_kka_r':
					$arr_soal = explode(',', $row->soal);
					$opsi = array('A','B','C');
				break;
				
				case 'gti_orientasi':
					$pecah = explode('|', $row->soal);
					
					foreach ($pecah as $p)
					{
						$items = explode(',', $p);
						$arr_soal[] = $items;
					}
					
					$opsi = $opsi_jawaban;
				break;
				
				case 'gti_orientasi_2':
					$chunk = explode(';', $row->soal);
					$arr_soal['prefix'] = $chunk[0];
					$arr_soal['img'] = array();
					
					$pecah = explode('|', $chunk[1]);
					
					foreach ($pecah as $p)
					{
						$items = explode(',', $p);
						$arr_soal['img'][] = $items;
					}
					
					$opsi = $opsi_jawaban;
				break;
				
				case 'gti_2d':
				case 'gti_3d':
					$pecah = explode('|', $row->soal);
					$arr_soal = $pecah[0];
					$jawaban = explode(',', $pecah[1]);
					
					$opsi = $jawaban;
				break;
				
				case 'gti_kotak':
					$pecah = explode('|', $row->soal);
					$arr_soal = $row->nomor.'/'.$pecah[0];
					$kotak_jawaban = explode(',', $pecah[1]);
					$max_kotak_jawaban_per_row = 4;
					$pengali_kotak_per_row = 0;
					$jawaban = array();
					
					if (count($kotak_jawaban) > 4)
					{
						foreach ($kotak_jawaban as $kotak_index => $kotak_value)
						{
							if (($kotak_index + 1) <= (($pengali_kotak_per_row + 1) * $max_kotak_jawaban_per_row))
							{
								$jawaban[$pengali_kotak_per_row][$kotak_index + 1] = $row->nomor.'/'.$kotak_value;
							}
							
							if (($kotak_index + 1) == (($pengali_kotak_per_row + 1) * $max_kotak_jawaban_per_row))
							{
								$pengali_kotak_per_row++;
							}
						}
					}
					
					$opsi = $jawaban;
				break;
			}
			
			$data = array(
				'id' => $row->id,
				'index' => $index,
				'opsi' => $opsi,
				'soal' => $arr_soal,
			);
			
			if ($row->is_tutorial == 1)
				$data['jawaban'] = $row->jawaban;
			
			$rows[$index] = $data;
			$arr_index[] = $index;
		}
		
		$random_rows = $rows;
		
		shuffle($arr_index);
		$random_rows = array();
        
        $n = 0;
		
		foreach ($arr_index as $key => $index)
		{
			$rows[$index]['index'] = $key;
			$random_rows[$key] = $rows[$index];
            
            $n++;
            
            if ($max_soal !== null && $n == $max_soal) break;
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
        $this->exam_generate_questions($quiz_code, 'gti_questions');
    }
	
	public function save_answers($users_id, $code, $arr_jawaban, $seconds_used = 0, $index = null)
	{   
		/* untuk pbtaxand sementara abaikan ini
		 * 
		// Sebelum simpan, pastikan time_end belum terisi, kalau sudah terisi maka jangan dilanjutkan.
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
			
            $sql = "INSERT INTO gti_jawaban
				(`users_id`, `gti_questions_id`, `jawaban`, `quiz_code`,`created`)
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


        // this is modified for test
        public function get_questions_queue_test($code, $is_tutorial = 0, $users_id)
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

                switch ($sub_library_code)
                {
                        case 'gti_pci':
                        case 'gti_pci_r':
                                $opsi_jawaban = [0,1,2,3,4];
                        break;

                        case 'gti_penalaran':
                                $opsi_jawaban = [0,1,2];
                        break;

                        case 'gti_penalaran_2':
                                $opsi_jawaban = [0,1,2,3,4];
                        break;

                        case 'gti_jh':
                        case 'gti_jh_r':
                                $opsi_jawaban = [0,1];
                        break;

                        case 'gti_kka':
                        case 'gti_kka_r':
                                $opsi_jawaban = [0,1,2];
                        break;

                        case 'gti_orientasi':
                        case 'gti_orientasi_2':
                                $opsi_jawaban = [0,1,2,3];
                        break;

                        case 'gti_2d':
                        case 'gti_3d':
                        case 'gti_kotak':
                                $opsi_jawaban = [];
                        break;
                }

                // Questions
                $this->ci->db->where('is_tutorial', $is_tutorial);
                $this->ci->db->where('quiz_code', $code);

                $get = $this->ci->db->get('gti_questions');

                $rows = array();

                foreach ($get->result() as $index => $row)
                {
                $rows = array();

                foreach ($get->result() as $index => $row)
                {
                        $arr_soal = array();

                        switch ($sub_library_code)
                        {
                                case 'gti_pci':
                                case 'gti_pci_r':
                                        $atas = substr($row->soal, 0, 4);
                                        $bawah = substr($row->soal, -4);

                                        for ($i=0; $i<strlen($atas); $i++)
                                        {
                                                $arr_soal[] = array($atas[$i], $bawah[$i]);
                                        }

                                        $opsi = $opsi_jawaban;
                                break;

                                case 'gti_penalaran':
                                        $pecah = explode(';', $row->soal);
                                        $arr_soal = explode(',', $pecah[0]);
                                        $opsi = explode(',', $pecah[1]);
                                break;

                                case 'gti_penalaran_2':
                                        $pecah = explode(';', $row->soal);
                                        $arr_soal = array($pecah[0]); // Untuk pelanaran 2, soal semuanya menjadi 1 baris.
                                        $opsi = explode(',', $pecah[1]);
                                break;


                                case 'gti_jh':
                                case 'gti_jh_r':
                                        $arr_soal[0] = $row->soal[0];
                                        $arr_soal[1] = $row->soal[1];
                                        $arr_soal[2] = $row->soal[2];

                                        $opsi = [$arr_soal[0], $arr_soal[2]];
                                break;

                                case 'gti_kka':
                                case 'gti_kka_r':
                                        $arr_soal = explode(',', $row->soal);
                                        $opsi = array('A','B','C');
                                                                        break;

                                case 'gti_orientasi':
                                        $pecah = explode('|', $row->soal);

                                        foreach ($pecah as $p)
                                        {
                                                $items = explode(',', $p);
                                                $arr_soal[] = $items;
                                        }

                                        $opsi = $opsi_jawaban;
                                break;

                                case 'gti_orientasi_2':
                                        $chunk = explode(';', $row->soal);
                                        $arr_soal['prefix'] = $chunk[0];
                                        $arr_soal['img'] = array();

                                        $pecah = explode('|', $chunk[1]);

                                        foreach ($pecah as $p)
                                        {
                                                $items = explode(',', $p);
                                                $arr_soal['img'][] = $items;
                                        }


                                        $opsi = $opsi_jawaban;
                                break;

                                case 'gti_2d':
                                case 'gti_3d':
                                        $pecah = explode('|', $row->soal);
                                        $arr_soal = $pecah[0];
                                        $jawaban = explode(',', $pecah[1]);

                                        $opsi = $jawaban;
                                break;

                                case 'gti_kotak':

                                        $pecah = explode('|', $row->soal);
                                        $arr_soal = $row->nomor.'/'.$pecah[0];
                                        $kotak_jawaban = explode(',', $pecah[1]);
                                        $max_kotak_jawaban_per_row = 4;
                                        $pengali_kotak_per_row = 0;
                                        $jawaban = array();

                                        if (count($kotak_jawaban) > 4)
                                        {
                                                foreach ($kotak_jawaban as $kotak_index => $kotak_value)
                                                {
                                                        if (($kotak_index + 1) <= (($pengali_kotak_per_row + 1) * $max_kotak_jawaban_per_row))
                                                        {
                                                                $jawaban[$pengali_kotak_per_row][$kotak_index + 1] = $row->nomor.'/'.$kotak_value;
                                                        }

                                                        if (($kotak_index + 1) == (($pengali_kotak_per_row + 1) * $max_kotak_jawaban_per_row))
                                                        {
                                                                $pengali_kotak_per_row++;
                                                        }

                                                }
                                        }

                                        $opsi = $jawaban;
                                break;
                        }

                        $data = array(
                                'id' => $row->id,
                                'index' => $index,
                                'opsi' => $opsi,
                                'soal' => $arr_soal,
                        );

                        if ($row->is_tutorial == 1)
                                $data['jawaban'] = $row->jawaban;

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

                $result['opsi_jawaban'] = $opsi_jawaban;
                $result['sub_library'] = $sub_library_code;
                $result['rows'] = $random_rows;


                $get->free_result();
                $dbsave = $this->ci->load->database('save', TRUE);
                if ($is_tutorial != 1)
                {
                        // Semua data di $result kecuali seconds (karena akan direplace saat dipanggil kembali)
                        $save = array();
                        $save['opsi_jawaban'] = $result['opsi_jawaban'];
                        $save['sub_library'] = $result['sub_library'];
                        $save['rows'] = $result['rows'];

                        // Simpan soal
                        $query = '
                        INSERT INTO queue_test_users_quiz_log (`rows`, seconds, time_start, quiz_code, users_id) VALUES (?,?,?,?,?)
                        ON DUPLICATE KEY UPDATE `rows` = ?, seconds = ?, time_start = ?';

                        $rows = json_encode($save);
                        $time_start = date('Y-m-d H:i:s');


                        $dbsave->query(
                                $query,
                                array(
                                        $rows,
                                        $seconds,
                                        $time_start,
                                        $code,
                                        $users_id,
                                        $rows,
                                        $seconds,
                                        $time_start,
                                )
                        );
                }

                $this->ci->db->close();
                $dbsave->close();
                return $result;
        	}
	}
}
