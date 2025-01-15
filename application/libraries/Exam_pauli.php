<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'libraries/Class_Exam.php');

class Exam_pauli extends Class_Exam {
	
	protected $ci;
	protected $img_dir;
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->img_dir = 'assets/images/';
		$this->jawaban_benar = 9;
	}
	
	public function restart($users_id, $code)
	{
		return false;
		//return $this->ci->db->delete('personal_jawaban', array('users_id'=>$users_id, 'quiz_code'=>$code ));
	}
	
	public function generate_questions($code, $is_tutorial = 0)
	{
		$result = array();
		$arr_index = array();
		$opsi_jawaban = [];

		// Ambil seconds dari table quiz
		$this->ci->db->select('seconds');
		$this->ci->db->where('code', $code);
		$get = $this->ci->db->get('quiz');
		$row = $get->first_row();
		
		// Setingan default
		$pauli_is_demo = 0;
		$pauli_col_num = 20;
		$pauli_row_num = 75;
		$pauli_max_penjumlahan = 3;

		$pauli_seconds = $row->seconds;
		$pauli_part_seconds = 60 * 3; // 3 menit
		
		// Ambil config dari table settings

		// ini harus ada di table settings jika tidak ingin default:
		// 1. pauli_part_seconds
		// 2. pauli_col_num
		// 3. pauli_row_num
		// 4. pauli_max_penjumlahan
		
		$this->ci->db->select('name, value');
		$this->ci->db->or_where('name', $code.'_part_seconds');
		$this->ci->db->or_where('name', $code.'_col_num');
		$this->ci->db->or_where('name', $code.'_row_num');
		$this->ci->db->or_where('name', $code.'_max_penjumlahan');
		$this->ci->db->or_where('name', $code.'_is_demo');
		$get = $this->ci->db->get('settings');
		
		// override variable
		foreach ($get->result() as $row)
		{
			if (preg_match('/^'.$code.'_(.*)/', $row->name, $match))
			{
				$var = 'pauli_'.$match[1];
				${$var} = $row->value;
			}
		}
		
		$total_part = ceil($pauli_seconds / $pauli_part_seconds);

		$part = array();
		$totals = array();
		
		// sementara semua part totalnya 9
		$pauli_max_number = $this->jawaban_benar;
		
		// Kalau $is_tutorial = 2, hapus data di quiz_log agar bisa mendapat soal yang baru
		if ($is_tutorial == 2)
		{
			$this->ci->db->where('users_id', $this->ci->session->userdata('id'));
			$this->ci->db->where('quiz_code', $code);
			$this->ci->db->delete('users_quiz_log');
			
			$is_tutorial = 0;
		}

		for ($p=0; $p<$total_part; $p++)
		{
			$rows = array();
			$total = 0;
			$penjumlahan = 1;
			
			//$this->ci->session->set_userdata($code.'_part_'.$p, $pauli_max_number);
			
			for ($n=0; $n<$pauli_row_num; $n++)
			{
				for ($i=0; $i<$pauli_col_num; $i++)
				{
					if ($total > 0 && $total < $pauli_max_number)
					{
						$angka = rand(1, $pauli_max_number);
						$sisa = $pauli_max_number - $total - $angka;
						
						# 9 - 1 - 2 = 6
						if ($sisa > 0)
						{
							if ($penjumlahan == $pauli_max_penjumlahan)
							{
								$angka = $pauli_max_number - $total;
								$total = 0;
								$penjumlahan = 1;
							}
							else
							{
								$total += $angka;
								$penjumlahan++;
							}
						}
						else if ($sisa < 0)
						{
							$angka = $pauli_max_number - $total;
							$total = 0;
							$penjumlahan = 1;
						}
						else
						{
							$total = 0;
							$penjumlahan = 1;
							$rows[$n][$i] = $angka;
							continue;
						}
						
						$rows[$n][$i] = $angka;
					}
					else
					{
						if ($total == $pauli_max_number)
							$total = 0;
						
						$angka = rand(1, $pauli_max_number);
						$rows[$n][$i] = $angka;
						
						$total += $angka;
						$penjumlahan++;
					}
				}
			}
			
			$part[] = json_encode($rows);
		}
		
		$result['code'] = $code;
		$result['seconds'] = $pauli_seconds;
		//$result['max_col'] = $pauli_col_num;
		//$result['timer'] = $pauli_part_seconds;
		$result['rows'] = array(
			'version' => 2,
			'part' => $part,
			'max_col' => $pauli_col_num,
			'timer' => $pauli_part_seconds,
			'no_recalculate_seconds' => true, // khusus pauli harus sama secondsnya
		);

        $dbsave = $this->ci->load->database('save', TRUE);
        
        // Semua data di $result kecuali seconds (karena akan direplace saat dipanggil kembali)
        $save = array();
        $save['rows'] = $result['rows'];
        $rows = json_encode($save);

        // Simpan Paket Soal
        $dbsave->set('rows', $rows);
        $dbsave->set('quiz_code', $code);
        $dbsave->set('is_tutorial', $is_tutorial);
        $dbsave->insert('quiz_paket_soal');
		
		return $dbsave->insert_id();
	}
    
    public function get_questions($code, $is_tutorial = 0, $library = null)
    {
        return parent::get_questions($code, $is_tutorial, 'pauli');
    }
	
	public function save_answers($users_id, $code, $arr_jawaban, $seconds_used = 0)
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
		
		$dbsave = $this->ci->load->database('save', TRUE);
		
		$time = date('Y-m-d H:i:s');
		
		$arr_part = array();
		
		if (! is_array($arr_jawaban))
			return true;
		
		// kumpulkan part
		foreach($arr_jawaban as $part => $rows)
        {
			// Convert jawaban jika berupa string
			if (! is_array($rows))
			{
				$new_rows = array();
				$orders = explode(';', $rows);
				
				foreach ($orders as $order => $values)
				{
					$row = explode(',', $values);
					$new_rows[$order] = $row;
				}
				
				$rows = $new_rows;
				$arr_jawaban[$part] = $new_rows;
			}
			
			if (count($rows) > 0)
				$arr_part[] = (int) $part;
		}
		
		if (count($arr_part) == 0)
			return true;

		$stat_part = array();
		
		foreach($arr_jawaban as $part => $rows)
		{
			$stat_part[$part] = array(
				'total' => 0,
				'benar' => 0,
				'salah' => 0,
			);
			
			// Hitung benar/salah di aplikasi
			foreach ($rows as $order => $row)
			{
				if (array_sum($row) == 0)
				{
					$stat_part[$part]['total'] += 0;
					$stat_part[$part]['benar'] += 0;
					$stat_part[$part]['salah'] += 0;
				}	
				else if (array_sum($row) == 9)
				{
					$stat_part[$part]['total'] += 1;
					$stat_part[$part]['benar'] += 1;
				}
				else
				{
					$stat_part[$part]['total'] += 1;
					$stat_part[$part]['salah'] += 1;
				}
			}
		}
		
		// Simpan
		foreach ($stat_part as $part => $row)
		{
			$sql = '
			INSERT INTO pauli_jawaban_log (`created`, `users_id`, `quiz_code`,`part`,`jawaban`)
			VALUES (?,?,?,?,?)
			ON DUPLICATE KEY UPDATE jawaban = ?
			';
			
			$jawaban = json_encode($arr_jawaban[$part]);
			$dbsave->query($sql, array($time, $users_id, $code, $part, $jawaban, $jawaban));
			
			$sql = '
			INSERT INTO pauli_jawaban_statistik (`created`, `users_id`, `quiz_code`, `part`,`total`,`benar`,`salah`)
			VALUES (?,?,?,?,?,?,?)
			ON DUPLICATE KEY UPDATE total = ?, benar = ?, salah = ?
			';
			
			$dbsave->query($sql, array($time, $users_id, $code, $part, $row['total'], $row['benar'], $row['salah'], $row['total'], $row['benar'], $row['salah']));
		}
        
        // Update users_quiz
        $dbsave->set('last_update', date('Y-m-d H:i:s'));
        $dbsave->set('seconds_used', $seconds_used);
        $dbsave->where('quiz_code', $code);
        $dbsave->where('users_id', $users_id);
        return $dbsave->update('users_quiz_log');
        
        //$this->ci->db->trans_complete();

		//return $this->ci->db->trans_status();
	}
}
