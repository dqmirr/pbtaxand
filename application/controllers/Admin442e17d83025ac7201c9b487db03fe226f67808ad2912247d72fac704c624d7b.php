<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b extends Ci_Controller {

	public function __construct()
	{
		parent::__construct();

		$target = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['SERVER_ADDR'];

		if (! in_array($target, $this->config->item('admin_allow_host')))
			die('Method Not Allowed');
		
		$this->load->database();
		$this->load->library('grocery_CRUD');
		$this->load->library('parser');
		$this->admin_url = $this->uri->segment(1);
		
		if ($this->session->userdata('is_admin'))
		{
			$this->session->set_userdata('admin_controller', $this->admin_url);
		}
		
		$this->report_url = '';
		
		$this->db->select('value');
		$this->db->where('name', 'report_type');
		$get = $this->db->get('settings');
		
		if ($row = $get->first_row())
			$this->report_url = $row->value;
			
		$this->excel_dir = 'tmp/generated-653edbcb08e565a11593e0860d65c9bb/report/excel/';
		$this->excel_path = base_url($this->excel_dir);
	}
	
	private function _generate_output($title, $output = null, $header = '')
	{ 
		$template = array(
			'title' => $title,
			'body' => $header . $this->load->view('Admin/output_view', (array) $output, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);  
	}
	
	public function ajax_auth()
	{
		$json = array();
		
		try
		{
			$this->load->database();
			$this->load->model('admin_auth_model');

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->admin_auth_model->validate($username, $password, $output))
			{
				$this->session->set_userdata($output);
			}
			else
			{
				throw new Exception('Username atau Password Salah');
			}
			
			$json['redirect'] = site_url($this->admin_url);
			$json['success'] = true;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}
	
	public function ajax_change_password()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
				
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('current_password', 'Password Lama', 'required|callback_valid_old_password');
			$this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
			$this->form_validation->set_rules('new_password_repeat', 'Password Baru (Ulangi)', 'required|matches[new_password]');
			
			if ($this->form_validation->run() === false)
			{
				throw new Exception(validation_errors('- ',' '));
			}
			
			$this->db->set('password', sha1($this->input->post('new_password')));
			$this->db->where('password', sha1($this->input->post('current_password')));
			$this->db->where('username', $this->session->userdata('username'));
			
			if (! $this->db->update('admins'))
				throw new Exception('Gagal ganti password');
			
			$json['success'] =  TRUE;
			$json['msg'] = 'Password berhasil diganti';
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}
	
	public function ajax_delete_queue()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
				
			$id = $this->input->post('id');
			$sha1_codes = $this->input->post('sha1_codes');
			
			if (empty($id))
				throw new Exception('id tidak boleh kosong');
			
			if (empty($sha1_codes))
				throw new Exception('sha1_codes tidak boleh kosong');
				
			# Pastikan kombinasinya benar
			$this->db->select('sha1_codes');
			$this->db->where('id', $id);
			$this->db->where('sha1_codes', $sha1_codes);
			$get = $this->db->get('report_queue');
			
			if ($row = $get->first_row())
			{	
				$this->db->where('id', $id);
				$this->db->where('sha1_codes', $sha1_codes);
				$this->db->delete('report_queue');
				
				if (file_exists($this->excel_dir.$sha1_codes.'.xlsx'))
				{
					unlink($this->excel_dir.$sha1_codes.'.xlsx');
				}
			}
			else
				throw new Exception('Data yang akan dihapus tidak ditemukan');
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		
		echo json_encode($json);
	}
	
    public function ajax_generate_paket_soal()
    {
        $json = array();
        
        try
        {
            if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
                
            if ($_POST)
            {
                if (isset($_POST['code']))
                {
                    $code = $_POST['code'];
                    
                    // get library by given code
                    $this->db->select('library_code');
                    $this->db->where('code', $code);
                    $get = $this->db->get('quiz');
                    
                    if ($row = $get->first_row())
                    {
                        $library_name = 'Exam_'.$row->library_code;
                        
                        if (file_exists(APPPATH.'libraries/'.$library_name.'.php'))
                        {
                            $library = strtolower($library_name);
                            $this->load->library($library);
                            
                            // Check methods
                            $methods = get_class_methods($this->{$library});
                            
                            if (in_array('generate_questions', $methods))
                            {
                                // Generate Soal
                                $this->{$library}->generate_questions($code);
                                
                                // Get Total
                                $get = $this->db->query('
                                SELECT
                                    SUM(CASE WHEN is_tutorial = 1 THEN 1 ELSE 0 END) as total_tutorial,
                                    SUM(CASE WHEN is_tutorial = 0 THEN 1 ELSE 0 END) as total_quiz
                                FROM
                                    quiz_paket_soal
                                WHERE
                                    quiz_code = ?
                                    AND
                                    deleted = 0
                                GROUP BY
                                    quiz_code
                                ', array($code));
                                
                                if ($row = $get->first_row())
                                {
                                    $json['total_tutorial'] = $row->total_tutorial;
                                    $json['total_quiz'] = $row->total_quiz;
                                }
                                else
                                {
                                    $json['total_tutorial'] = 0;
                                    $json['total_quiz'] = 0;
                                }
                                
                                $json['code'] = $code;
                            }
                            else
                            {
                                throw new Exception ('Library '.$library_name.' tidak memiliki method generate_questions. Hubungi Administrator.');
                            }
                        }
                        else
                        {
                            throw new Exception ('Library '.$library_name.' tidak ditemukan. Hubungi Administrator.');
                        }
                    }
                }
            }
            else
            {
                throw new Exception('Tidak ada quiz code yang dikirim');
            }
        }
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
        
    }
    
	public function preview_soal(){
		$output = array(
			'link' => '/list-soal-pbtaxand?page=1&pagination=10&jenis_soal=english'
		);
		$template = array(
			'title' => $title,
			'body' => $header . $this->load->view('Admin/soal/preview', (array) $output, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);  
	}

	public function ajax_generate_report()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
				
			$field = $this->input->post('generate_by');
			$arr_code = $this->input->post('code');

			if (! in_array($field, array('sesi_code','formasi_code')))
				throw new Exception('Error: pilihan opsi harus berdasarkan sesi/formasi');

			if (empty($arr_code))
				throw new Exception('Error: code harus dipilih');
				
			$curl = curl_init();
			$params = array();
			
			foreach ($arr_code as $code)
			{
				$params['code'][] = $code;
			}
			
			$this->load->model('Setting_model', 'setting');
			$python_api_url = $this->setting->find_settings_by_name('python_api_url');

			$query_string = http_build_query($params);
			
			$url = 'http://localhost:8085/'.$field.'?'.$query_string;

			if($python_api_url){
				$url = $python_api_url[0]->value.'/'.$field.'?'.$query_string;
			}
			
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($curl);
			
			$res = json_decode($result);
			$json['result'] = $res;
			
			// Ambil data dari database berdasarkan sha1_codes yang ada di $res
			if (isset($res->sha1_codes))
			{
				$json['reload'] = true;
			}
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	public function ajax_get_beda_jadwal()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
			
			$query = '
				SELECT
					a.fullname,
					b.label as formasi,
					c.label as sesi_formasi,
					d.label as sesi_baru
				FROM
					users a
					JOIN formasi b ON (b.code = a.formasi_code)
					JOIN sesi c ON (c.code = b.sesi_code)
					LEFT JOIN sesi d ON (d.code = a.sesi_code)
				WHERE
					a.sesi_code IS NOT NULL
			';
			
			$get = $this->db->query($query);
			
			$json['rows'] = $get->result();
			$json['success'] =  TRUE;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		
		echo json_encode($json);
	}
	
	public function ajax_get_formasi()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
			
			$idle_seconds = 5 * 60;
			
			$query = '
				SELECT
					a.sesi,
					a.time_from,
					a.time_to,
					a.formasi,
					(CASE 
						WHEN NOW() BETWEEN a.time_from AND a.time_to THEN 1
						WHEN NOW() > a.time_to THEN 2 
						ELSE 0 END) as dimulai,
					count(a.id) as total,
					SUM(CASE 
						WHEN 
							a.last_login BETWEEN a.time_from AND a.time_to AND a.last_logout < a.last_login 
							AND TIME_TO_SEC(TIMEDIFF(NOW(),a.last_update)) <= ?
						THEN 1
						
						ELSE 0 
					END) as active,
					SUM(CASE 
						WHEN 
							a.last_login BETWEEN a.time_from AND a.time_to AND a.last_logout < a.last_login 
							AND TIME_TO_SEC(TIMEDIFF(NOW(),a.last_update)) > ?
						THEN 1
						
						ELSE 0 
					END) as idle,
					SUM(a.email_sent) as email_sent,
					SUM(CASE WHEN COALESCE(CHAR_LENGTH(a.first_login),0) = 0 THEN 0 ELSE 1 END) as first_login,
					SUM(CASE WHEN COALESCE(CHAR_LENGTH(a.agree_code),0) = 0 THEN 0 ELSE 1 END) as agree
				FROM
				(
				SELECT
					a.id,
					a.first_login,
					a.last_login,
					a.last_logout,
					a.last_update,
					a.email_sent,
					a.agree_code,
					b.label as formasi,
					s.label as sesi,
					s.time_from,
					s.time_to
				FROM
					users a
					JOIN formasi b ON (a.formasi_code = b.code)
					JOIN sesi s ON (b.sesi_code = s.code)
				WHERE
					a.sesi_code IS NULL

				UNION

				SELECT
					a.id,
					a.first_login,
					a.last_login,
					a.last_logout,
					a.last_update,
					a.email_sent,
					a.agree_code,
					b.label as formasi,
					s.label as sesi,
					s.time_from,
					s.time_to
				FROM
					users a
					JOIN formasi b ON (a.formasi_code = b.code)
					JOIN sesi s ON (a.sesi_code = s.code)
					JOIN sesi
				) a
				GROUP BY
					a.sesi,
					a.formasi,
					a.time_from,
					a.time_to
				ORDER BY
					cast(REPLACE(a.sesi,\'Sesi \',\'\') as UNSIGNED) ASC,
					a.formasi ASC
			';
			
			$get = $this->db->query($query, array($idle_seconds, $idle_seconds));
			
			$json['rows'] = $get->result();
			$json['success'] =  TRUE;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		
		echo json_encode($json);
	}
	
	public function ajax_get_tanpa_quiz()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
			
			$query = '
				select
				b.*
				from (
				SELECT
				a.id,
				a.fullname,
				sum(a.total) as total
				FROM (
				SELECT
				id,
				fullname,
				0 as total
				FROM
				users

				UNION

				SELECT
				a.id,
				a.fullname,
				SUM(case when b.active = 1 then 1 else 0 end) as total
				FROM
				users a
				JOIN users_quiz b ON (b.users_id = a.id)
				GROUP BY
				a.id,
				a.fullname
				) a
				GROUP BY a.id, a.fullname
				) b
				where b.total = 0
			';
			
			$get = $this->db->query($query);
			
			$json['rows'] = $get->result();
			$json['success'] =  TRUE;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		
		echo json_encode($json);
	}
	
	private function rgb($arr)
	{
		$hex = '#';
		
		foreach ($arr as $val)
		{
			//Convert the random number into a Hex value.
			$dechex = dechex($val);
			//Pad with a 0 if length is less than 2.
			if(strlen($dechex) < 2){
				$dechex = "0" . $dechex;
			}
			//Concatenate
			$hex .= $dechex;
		}
		
		return $hex;
	}
	
	public function ajax_get_code()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
				
			$field = $this->input->post('generate_by');
			
			if (! in_array($field, array('sesi_code','formasi_code')))
				throw new Exception('Error: pilihan opsi harus berdasarkan sesi/formasi');
			
			$this->db->select('code, label');
			$this->db->order_by('label ASC');
			
			if ($field == 'sesi_code')	
				$get = $this->db->get('sesi');
			else
				$get = $this->db->get('formasi');
				
			$json['data'] = $get->result();
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	public function ajax_get_queue_status()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
			
			$id = $this->input->post('id');
			$default_reload_in = 3;
			
			$this->db->select('status, step, num_step, json_step');
			$this->db->where('id', $id);
			$get = $this->db->get('report_queue');
			
			if ($row = $get->first_row())
			{
				$json['status'] = $row->status;
				$json['step'] = $row->step;
				$json['num_step'] = $row->num_step;
				$json['details'] = json_decode($row->json_step);
				
				if ($row->status != 'done') 
				{
					// Check ke setting apakah ada parameter report_generate_reload_in?
					$this->db->select('value');
					$this->db->where('name', 'report_generate_reload_in');
					$get = $this->db->get('settings');
					
					if ($setting = $get->first_row())
					{
						$default_reload_in = $setting->value;
					}
					
					$json['reload_in'] = $default_reload_in * 1000; // 3 detik
				}
			}
			else
			{
				$json['remove'] = true;
			}
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	public function ajax_get_report_queue()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
		
			$this->db->order_by('created DESC');
			$get = $this->db->get('report_queue');
			
			$json['ext'] = '.xlsx';
			$json['path'] = $this->excel_path;
			$json['data'] = $get->result();
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	public function ajax_get_statistik()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
			
			$labels = array();
			$colors = array();
			$swap_colors = array();
			
			// Login
			$sql = "
			select
				count(id) as total,
				sum(case when agree_code is null then 0 else 1 end) as login_sesuai_waktu,
				sum(case when first_login is not null and agree_code is null then 1 else 0 end) as login_tidak_sesuai_waktu,
				sum(case when first_login is null then 1 else 0 end) as tidak_pernah_login
			from 
				users
			where
				formasi_code is not null";
			$get = $this->db->query($sql);
			
			$rowl = $get->first_row();
			
			// Test
			$sql = "
			select
				total as test,
				count(users_id) as total
			from
			(
			SELECT
				users_id,
				count(distinct quiz_code) as total
			FROM
				gti_jawaban
			group BY
				users_id
			) a
			group BY
				total
			order by
				total asc
			";
			$get = $this->db->query($sql);
			$total_ikut_test = 0;
			$data_test = array();
			
			$penambah = 0;
			
			foreach ($get->result() as $n => $row)
			{
				if ($n == 0 && $row->test != '0')
				{
					$labels[] = 'Tidak Mengikuti Test';
					$data_test[] = 0;
					$colors[] = '#BFBFBF';
				}
				else if ($row->test == '0')
				{
					$labels[] = 'Tidak Mengikuti Test';
					$data_test[] = $row->total;
					$colors[] = '#BFBFBF';
					continue;
				}
				
				$labels[] = 'Menyelesaikan '.$row->test.' test';
				$data_test[] = $row->total;
				$colors[] = $this->rgb(array(30+$penambah,144+$penambah,255));
				$total_ikut_test += $row->total;
				
				$penambah += 20;
			}
			
			if (count($colors) > 0)
				$swap_colors = array($colors[0]);
			
			// Balik warna
			for ($i=count($colors) - 1; $i>0; $i--)
			{
				$swap_colors[] = $colors[$i];
			}
			
			$colors = $swap_colors;
			
			$labels[] = 'Tidak Pernah Login';
			$labels[] = 'Login Sesuai Waktu';
			$labels[] = 'Login Tidak Sesuai Waktu';
			
			$merge = array();
			
			foreach ($data_test as $row)
			{
				$merge[] = 0;
			}
			
			$json['stat']['total'] = $rowl->total;
			$json['stat']['labels'] = $labels;
			
			$tidak_ikut_test = $rowl->total - $total_ikut_test;
			$data_test[0] = $tidak_ikut_test;
			
			$json['stat']['data'] = array(
				0 => array_merge($data_test, array(0, 0, 0)),
				1 => array_merge($merge, array($rowl->tidak_pernah_login, $rowl->login_sesuai_waktu, $rowl->login_tidak_sesuai_waktu)),
			); 
			
			$json['stat']['colors'] = array_merge($colors, array(				
				// Login
				'#BFBFBF',
				'#00B900', 	
				'#89CF89',
				)
			);
			
			//==== Formasi
			$sql = "
			SELECT
				b.label,
				SUM(test) as test,
				SUM(total - test) as tidak_test
			FROM
			(
				SELECT
					b.code,
					COUNT(a.id) as total,
					0 as test
				FROM
					users a
					JOIN formasi b ON (a.formasi_code = b.code)
				GROUP BY
					b.code
				
				UNION
				
				SELECT
					b.formasi_code as code,
					0 as total,
					COUNT(DISTINCT b.id) as test
				FROM
					gti_jawaban a
					JOIN users b ON (a.users_id = b.id)
				GROUP BY
					b.formasi_code
			) a
			JOIN formasi b ON (b.code = a.code)
			GROUP BY
				a.code
			";
			$get = $this->db->query($sql);
			
			$arr_formasi_test = array();
			$arr_formasi_tidak_test = array();
			$arr_formasi_labels = array();
			
			foreach ($get->result() as $row)
			{
				$arr_formasi_labels[] = $row->label;
				$arr_formasi_test[] = $row->test;
				$arr_formasi_tidak_test[] = $row->tidak_test;
			}
			
			$json['formasi']['labels'] = $arr_formasi_labels;
			$json['formasi']['data'] = array(
				$arr_formasi_test, // test
				$arr_formasi_tidak_test, // tidak test
			);
			
			$json['success'] = true;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		
		echo json_encode($json);
	}
	
	public function ajax_logout()
	{
		$this->session->sess_destroy();
		
		$json = array('success'=>true, 'redirect'=>site_url($this->admin_url));
		
		echo json_encode($json);
	}
	
	private function get_total_quiz(&$group_quiz_code_lookup, $arr_group_quiz_code, $arr_quiz_code)
	{
		$arr_group_quiz_code_exploded = explode(',', $arr_group_quiz_code);
		$arr_quiz_code_exploded = explode(',', $arr_quiz_code);
		$arr_quiz_code_found = array();
		
		foreach ($arr_group_quiz_code_exploded as $group_quiz_code)
		{
			if (empty($group_quiz_code)) continue;
			
			if (! isset($group_quiz_code_lookup[$group_quiz_code]))
			{
				$get = $this->db->query('
				select quiz_code from group_quiz_items where group_quiz_code = ?;
				', array($group_quiz_code));
				
				foreach ($get->result() as $row)
				{
					$group_quiz_code_lookup[$group_quiz_code][] = $row->quiz_code;
				}
			}
			
			$arr_quiz_code_found = array_merge($arr_quiz_code_found, $group_quiz_code_lookup[$group_quiz_code]);
		}
		
		foreach ($arr_quiz_code_exploded as $quiz_code)
		{
			if (empty($quiz_code)) continue;

			$arr_quiz_code_found[] = $quiz_code;
		}
		
		return count(array_unique($arr_quiz_code_found));
	}
	
	public function ajax_get_statistik_baru()
	{
		$json = array();
		$group_quiz_code_lookup = array();
		$selesai = 0;
		
		try
		{
			$sesi_code = $this->input->post('sesi_code');
			$date = $this->input->post('date');
			
			$get = $this->db->query('
			select
				a.users_id,
				a.total as total_selesai,
				group_concat(case when c.group_quiz_code is not null then c.group_quiz_code else null end) as arr_group_quiz_code,
				group_concat(case when c.group_quiz_code is null then c.code else null end) as arr_quiz_code
			from 
			(
			select
					a.users_id,
					b.formasi_code,
					count(a.quiz_code) as total
			from
					users_quiz_log a,
					users b
			where
					a.users_id = b.id
					and
					b.sesi_code = ?
					and
					date(a.time_start) = ?
					and
					a.time_end is not null
			group by 
					a.users_id, b.formasi_code
			) a, users_quiz b, quiz c
			where
				a.users_id = b.users_id
				and
				b.quiz_id = c.id
				and
				b.active = 1
			group by
				a.users_id, a.total
			', array($sesi_code, $date));
			
			foreach ($get->result() as $row)
			{
				$total_quiz = $this->get_total_quiz($group_quiz_code_lookup, $row->arr_group_quiz_code, $row->arr_quiz_code);
				
				if ($row->total_selesai >= $total_quiz)
				{
					$selesai++;
				}
			}
			
			$json['selesai'] = $selesai;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	private function ajax_get_statistik_baru_old()
	{
		$json = array();
		
		try
		{
			if ($this->session->userdata('is_admin') <= 0)
				throw new Exception('Anda tidak berhak mengakses halaman ini.');
				
			// hardcoded quiz
			
			$sesi_code = $this->input->post('sesi_code');
			$date = $this->input->post('date');

// Quiz Single
$sql = "
create temporary table users_quiz_tmp (users_id INT(11) unsigned, INDEX (users_id, quiz_code), UNIQUE(users_id, quiz_code)) as
select
	b.code as quiz_code,
	a.users_id,
	b.label
from
	users_quiz a,
	quiz b
where
	a.quiz_id = b.id
	and
	a.active = 1
	and
	b.active = 1
";
$this->db->query($sql);

// Quiz Group
$sql = "
insert ignore into users_quiz_tmp (quiz_code, users_id, label)
select
	d.code as quiz_code,
	a.users_id,
	d.label
from
	users_quiz a,
	quiz b,
	group_quiz_items c,
	quiz d
where
	a.quiz_id = b.id
	and
	b.group_quiz_code = c.group_quiz_code
	and
	d.code = c.quiz_code
	and
	b.active = 1
	and
	a.active = 1
";
$this->db->query($sql);

$sql = "
create temporary table users_quiz_log_tmp as  
select 
	a.users_id, a.quiz_code, a.time_start, a.time_end, b.sesi_code 
from 
	users_quiz_log a,
	users b,
	sesi c
where
	a.users_id = b.id 
	and 
	b.sesi_code = ?
	and
	c.code = b.sesi_code
	and
	? between date(c.time_from) and date(c.time_to) 
";
$this->db->query($sql, array($sesi_code, $date));

// SELESAI
$sql = "
select
a.quiz_code,
label,
count(distinct a.users_id) as total,
SUM(CASE WHEN time_end IS NOT NULL THEN 1 ELSE 0 END) as selesai,
SUM(CASE WHEN time_end IS NULL THEN 1 ELSE 0 END) as masih_mengerjakan
from
users_quiz_log_tmp a, users_quiz_tmp b
where
a.quiz_code = b.quiz_code
and
a.users_id = b.users_id
GROUP BY
quiz_code,
label
ORDER BY label ASC
";

/*"
SELECT
quiz_code,
label,
count(distinct users_id) as total,
SUM(CASE WHEN time_end IS NOT NULL THEN 1 ELSE 0 END) as selesai,
SUM(CASE WHEN time_end IS NULL THEN 1 ELSE 0 END) as masih_mengerjakan
FROM
users u
join users_quiz_log a on (u.id = a.users_id and u.sesi_code = 'sabtu')
join quiz b on (a.quiz_code = b.code)
WHERE
quiz_code in ('1A','2A','3A','P1','P2','P3','english')
GROUP BY
quiz_code,
label
			";*/
			
			$get = $this->db->query($sql);
			$statistik = array();
			
			foreach ($get->result() as $row)
			{
				$statistik[$row->quiz_code] = $row;
			}
			
			/*
			// SEMUA
			$sql = "
			SELECT
			quiz_code,
			count(distinct users_id) as total
			FROM
			personal_jawaban
			WHERE
			quiz_code in ('P1','P2','P3')
			GROUP BY quiz_code

			UNION

			SELECT
			quiz_code,
			count(distinct users_id) as total
			FROM
			ist_jawaban
			WHERE
			quiz_code in ('1A','2A','3A')
			GROUP BY quiz_code

			UNION

			SELECT
			jenis_soal as quiz_code,
			count(distinct users_id) as total
			FROM
			multiplechoice_jawaban
			WHERE
			jenis_soal = 'english'
			GROUP BY jenis_soal

			ORDER BY quiz_code ASC;
			";
			
			$selesai = array();
			
			foreach ($get->result() as $row)
			{
				$selesai[$row->quiz_code] = $row->total;
			}
			
			$get = $this->db->query($sql);
			*/
			
			$json['stat'] = $statistik;
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
	}
	
	public function callback_insert($post_array)
	{
	  $post_array['created'] = date('Y-m-d H:i:s');
	  return $post_array;
	}

	public function callback_update($post_array)
	{
	  $post_array['updated'] = date('Y-m-d H:i:s');
	  return $post_array;
	}
	
	public function change_password()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$data = array('change_password_url' => site_url($this->admin_url.'/ajax_change_password'));	
			
		$template = array(
			'title' => 'Change Password',
			'body' => $this->load->view('Admin/change_password_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function custom_reports()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_table('reports');
		$crud->set_subject('Reports');
		$crud->columns('title', 'created', 'updated');
		$crud->add_fields('title','query','created');
		$crud->edit_fields('title','query','updated');
		$crud->unset_texteditor('query');
		
		$crud->required_fields('title');
		
		$crud->change_field_type('created','invisible');
		$crud->change_field_type('updated','invisible');
		
		$crud->callback_before_insert(array($this,'callback_insert'));
		$crud->callback_before_update(array($this,'callback_update'));
		 
		$crud->add_action('Report CSV', '', $this->admin_url.'/report/csv', 'text-dark oi oi-spreadsheet', '', '_blank');
		$crud->add_action('Report HTML', '', $this->admin_url.'/report/html', 'text-dark oi oi-file', '', '_blank');
		 
		$output = $crud->render();
		
		$this->_generate_output('Reports', $output);
	}
	
	public function email_job()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_table('email_job');
		$crud->set_subject('Email Job');
		$crud->columns('ip_address', 'interval', 'order');
		 
		$output = $crud->render();
		
		$this->_generate_output('Email Job', $output);
	}
	
	public function formasi()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('formasi');
		$crud->set_subject('Formasi');
		$crud->set_relation('sesi_code', 'sesi', '{label} ({time_from} - {time_to})');
		$crud->columns('code', 'label', 'sesi_code', 'posisi', 'tingkatan');
		$crud->display_as('sesi_code', 'Sesi');
		 
		$output = $crud->render();
		
		$this->_generate_output('Formasi', $output);
	}
	
	// Ini dieksekusi untuk membuat kode html
	public function generate_code_html($id = 0, $code = null)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$this->load->library('parser');
		$users_id = $this->session->userdata('id');
		
		$questions = array();
		$libraries = array();
		$library_views = array();
		
		if ($code === null && $id > 0)
		{
			$this->db->select('code');
			$this->db->where('id', $id);
			$get = $this->db->get('quiz');
			
			if (! $row = $get->first_row())
				return;
				
			$code = $row->code;
		}
		
		// Check dulu apakah quiz ini sudah selesai dilaksanakan?
		// Jika sudah maka buang dari $arr_library_code
		$this->load->model('users_quiz_model');
		$this->load->model('users_quiz_log_model');
		
		// Check exam code
		if (! $this->users_quiz_model->valid_quiz_code($code, $quiz_info, $arr_library_code))
		{
			return;
		}
		
		foreach ($arr_library_code as $quiz_code => $library_code)
		{
			$questions[] = array(
				'code' => $quiz_code, 
				'library' => $library_code['library'], 
				'label' => $library_code['label']
			);
			
			$libraries[] = $library_code['library'];
		}
		
		$libraries = array_unique($libraries);
		
		// Load view library untuk dipake bersama-sama
		foreach ($libraries as $library)
		{
			$library_views[] = $this->load->view('Exam/lib_'.$library.'_view', array(), true);
		}
		
		$data = array(
			'img_path' => base_url('assets/images/'),
			'main_quiz_code' => $code,
			'quiz_codes' => $questions, 
			'library_views' => $library_views,
			'back_to_main_menu_url' => site_url('exam'),
			'get_questions_url' => site_url('exam/ajax_get_questions'),
			'save_answers_url' => site_url('task/queue.php'),
		);
		
		$breadcrumb_data = array('items' => array($quiz_info['label']));
		
		$template = array(
			'title' => 'Home',
			'body' => $this->load->view('Exam/code_view', $data, true), 
			'breadcrumb' => $this->load->view('templates/breadcrumb', $breadcrumb_data, true),
		);
		
		$html = $this->parser->parse('templates/main', $template, TRUE);
		
		$fp = fopen("assets/exam/{$code}.html", 'w');
		fwrite($fp, $html);
		fclose($fp);
		
		echo '<script>window.close()</script>';
	}
    
    public function generate_paket_soal()
    {
        if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
        
		if (!property_exists($this, 'Generate_exam_mdl')){
			$this->load->model('Generate_exam_mdl');
		}

        $error = $this->session->flashdata('error');
        
        $this->db->select('`a`.`code`, `a`.`label`, sum(case when `b`.`is_tutorial` = 1 then 1 else 0 end) as jumlah_tutorial, sum(case when `b`.`is_tutorial` = 0 then 1 else 0 end) as jumlah_quiz', false);
        // $this->db->where('a.group_quiz_code', null);
        $this->db->join('quiz_paket_soal b', 'b.quiz_code = a.code and b.deleted = 0','left');
        $this->db->group_by('a.code, a.label');
        $get = $this->db->get('quiz a');
        $arr_quiz = $get->result();
        
		$list_jenis_soal = $this->Generate_exam_mdl->get_list_jenis_soal();

		$arr_jenis_soal = array();
		foreach($list_jenis_soal as $value){
			array_push($arr_jenis_soal, $value["jenis_soal"]);
        }

		foreach($arr_quiz as $index=>$quiz){
			if(in_array($quiz->code, $arr_jenis_soal)){
				$quiz->{'href'} = "/soal/generate_exam/detail/".$quiz->code;
			}
		}

        $data = array(
            'title' => 'Generate Paket Soal', 
            'arr_quiz' => $arr_quiz, 
            'error' => $error,
            'admin_url' => $this->admin_url
        );
        
        $template = array(
			'title' => $data['title'],
			'body' => $this->load->view('Admin/generate_paket_soal_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
    }
	
	public function index($date = '')
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
	
		$this->load->model('users_model');
		
		//$users = $this->users_model->list_all();
		
		$date = ($date == '') ? date('Y-m-d') : $date;
		
		$sql = "
		SELECT
		a.sesi_code,
		b.label,
		COUNT(a.id) as total
		FROM
		users a
		JOIN sesi b ON (a.sesi_code = b.code)
		WHERE
		date(b.time_from) <= ?
		AND
		date(b.time_to) >= ?
		AND
		a.formasi_code != 'test'
		GROUP BY a.sesi_code
		";
		
		$get = $this->db->query($sql, array($date, $date));

		$data = array(
			'url' => site_url($this->admin_url.'/'), 
			'data' => $get->result(), 
			'date' => $date,
		);
		
		$template = array(
			'title' => 'Admin',
			'body' => $this->load->view('Admin/dashboard_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function login()
	{
		$data['login_url'] = site_url($this->admin_url.'/ajax_auth');
		$data['btn_class'] = 'btn-danger';
		$data['survey_mode'] = 1; // selalu dianggap survey
		$this->load->view('Page/index_view', $data);
	}
	
	public function quiz()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('quiz');
		$crud->set_subject('Quiz');
		$crud->set_relation('library_code', 'library', 'code');
		$crud->set_relation('sub_library_code', 'sub_library', 'code');
		$crud->set_relation('group_quiz_code', 'group_quiz', 'code');
		$crud->columns('code', 'label', 'description', 'library_code', 'sub_library_code', 'group_quiz_code', 'active', 'seconds', 'allow_restart');
		$crud->order_by('quiz.code','asc');
		
		$crud->field_type('active', 'dropdown', array(1=>'Active', 0=>'Inactive'));
		$crud->field_type('allow_restart', 'dropdown', array('1'=>'Yes', '0'=>'No'));
		
		$crud->add_action('Generate', '', $this->admin_url.'/generate_code_html', 'text-dark oi oi-puzzle-piece', '', 'generate_code_html');
		 
		$output = $crud->render();
		
		$this->_generate_output('Quiz', $output);
	}
	
	public function quiz_group()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_table('group_quiz');
		$crud->set_subject('Group Quiz');
		$crud->columns('code');
		$crud->add_action('Set Quiz', '', $this->admin_url.'/quiz_group_items', 'text-dark oi oi-task', '', '_self');
		 
		$output = $crud->render();
		
		$this->_generate_output('Group Quiz', $output);
	}
	
	public function quiz_group_items($group_quiz_id=null)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		if ($group_quiz_id !== null)
		{
			// get code by group_quiz's id
			$this->db->select('code');
			$this->db->where('id', $group_quiz_id);
			$get = $this->db->get('group_quiz');
			
			if ($row = $get->first_row())
			{
				redirect($this->admin_url.'/quiz_group_items?by=group_quiz_code&search='.$row->code);
			}
		}
		
		$URL = $_SERVER['QUERY_STRING'] ? current_url().'?'.$_SERVER['QUERY_STRING'] : current_url();
		
		if (isset($_POST['action']))
		{
			$out = array();
			
			try
			{
				switch ($_POST['action'])
				{
					case 'add':
						// check dulu apakah ada duplikat
						$this->db->select('quiz_code');
						$this->db->where('group_quiz_code', $this->input->post('group_quiz_code'));
						$this->db->where('quiz_code', $this->input->post('quiz_code'));
						$get = $this->db->get('group_quiz_items');
						
						if ($row = $get->first_row())
						{
							throw new Exception('Tidak bisa tambah Group dan Quiz Code karena data ini sudah ada.');
						}
						
						$this->db->set('group_quiz_code', $this->input->post('group_quiz_code'));
						$this->db->set('quiz_code', $this->input->post('quiz_code'));
						$this->db->set('ordering', $this->input->post('order'));

						if (! $this->db->insert('group_quiz_items'))
						{
							throw new Exception('Unknown Error. Gagal Tambah Data');
						}
						
						$out['success'] = true;
						
					break;
					
					case 'update':
					
						// check dulu apakah ada duplikat
						$this->db->select('quiz_code');
						$this->db->where('group_quiz_code', $this->input->post('group_quiz_code'));
						$this->db->where('quiz_code', $this->input->post('new_quiz_code'));
						$get = $this->db->get('group_quiz_items');
						
						if ($row = $get->first_row())
						{
							if ($row->quiz_code != $this->input->post('quiz_code'))
							{
								throw new Exception('Tidak bisa ganti Quiz Code karena data ini sudah ada.');
							}
						}
						
						$this->db->set('quiz_code', $this->input->post('new_quiz_code'));
						$this->db->set('ordering', $this->input->post('order'));
						$this->db->where('quiz_code', $this->input->post('quiz_code'));
						$this->db->where('group_quiz_code', $this->input->post('group_quiz_code'));
						$result = $this->db->update('group_quiz_items');
						
						if ($result)
						{
							$out['group_quiz_code'] = $this->input->post('group_quiz_code');
							$out['quiz_code'] = $this->input->post('new_quiz_code');
							$out['order'] = $this->input->post('order');
							$out['success'] = true;
						}
						else
						{
							throw new Exception('Update Error!');
						}
					break;
					
					case 'delete':
						$this->db->where('quiz_code', $this->input->post('quiz_code'));
						$this->db->where('group_quiz_code', $this->input->post('group_quiz_code'));
						$result = $this->db->delete('group_quiz_items');
						
						if (! $result)
						{
							throw new Exception('Gagal Hapus Data');
						}
						
						$out['success'] = true;
					break;
					
					default: throw new Exception('Unknown Action');
				}
			}
			catch (Exception $e)
			{
				$out['error'] = true;
				$out['msg'] = $e->getMessage();
			}
			
			echo json_encode($out);
			return;
		}
		
		// Get Group
		$select_arr_group = array();
		
		$this->db->select('code');
		$this->db->order_by('code', 'asc');
		$get = $this->db->get('group_quiz');
		
		foreach ($get->result() as $row)
		{
			$select_arr_group[$row->code] = $row->code;
		}
		
		// Get Quiz
		// $this->db->select('code');
		// $this->db->where('library_code !=', null);
		// $this->db->where('group_quiz_code', null);
		// $this->db->order_by('code', 'asc');
		// $get = $this->db->get('quiz');
		// $arr_quiz = $get->result();

		// New Version
		$this->db->select('code');
		// $this->db->where('library_code !=', null);
		// $this->db->where('group_quiz_code', null);
		$this->db->order_by('code', 'asc');
		$get = $this->db->get('quiz');
		$arr_quiz = $get->result();
			
		$search_text = '';
		$search_by = '';
		$default_group_quiz_code = '';
		
		if (isset($_GET['by'], $_GET['search']))
		{
			switch ($_GET['by'])
			{
				case 'group_quiz_code':
				case 'quiz_code':
					
					$search_by = $_GET['by'];
					$search_text = trim($_GET['search']);
					
					if (! empty($search_text))
					{
						if ($_GET['by'] == 'group_quiz_code')
						{
							$default_group_quiz_code = $_GET['search'];
						}
						
						$this->db->like($_GET['by'], $_GET['search']);
					}
					
				break;
			}
		}
		
		$this->db->order_by('group_quiz_code asc, ordering asc');
		$get = $this->db->get('group_quiz_items');
		
		$data = array(
			'arr_group_quiz' => $get->result(),
			'arr_quiz' => $arr_quiz,
			'search_text' => $search_text,
			'search_by' => $search_by,
			'dropdown_add_group' => form_dropdown('add_group', $select_arr_group, $default_group_quiz_code, array('id'=>'add_group', 'class'=>'form-control')),
			'dropdown' => form_dropdown('by', array('Search By' => array('group_quiz_code'=>'Group Quiz Code', 'quiz_code'=>'Quiz Code')), $search_by, array('class'=>'form-control')),
			'URL' => $URL,
		);
		
		$body = $this->load->view('Admin/quiz_group_items_view', $data, true);
		
		$template = array(
			'title' => 'Quiz Group Items',
			'body' => $body,
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function report($type='html', $id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$this->db->select('query, title');
		$this->db->where('id', $id);
		$get = $this->db->get('reports');
		
		if (! $row = $get->first_row())
			return;
			
		$title = $row->title;
	
		switch ($type)
		{
			case 'csv':
				$query_text = preg_replace("/(delete|truncate|update|drop|create)\\s+/i", '', $row->query);
				$get = $this->db->query($query_text);
				$filename = sys_get_temp_dir().'/'.$this->session->userdata('id').'_'.$id.'.csv';
				
				$file = fopen($filename,"w");
				$n = 0;
				
				foreach ($get->result('array') as $row)
				{
					if ($n == 0)
					{
						$arr_header = array();
						
						foreach ($row as $key => $val)
						{
							$arr_header[] = $key;
						}
						
						fputcsv($file, $arr_header);
					}
					
					fputcsv($file, $row);
					$n++;
				}
				
				fclose($file);
				
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.$title.'.csv"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filename));
				readfile($filename);
				
				return;
				
			break;
			
			default:
				$this->load->library('table');
				
				$template = array(
					'table_open' => '<div class="table-responsive"><table class="table table-striped">',
					'table_close' => '</table></div>',
				);
				$this->table->set_template($template);
				
				$query_text = preg_replace("/(delete|truncate|update|drop|create)\\s+/i", '', $row->query);
				
				$query = $this->db->query($query_text);
				
				$table = $this->table->generate($query);
				
				$this->load->view('Admin/report_html', array('table'=>$table));
		}
	}
	
	public function report_pauli()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$crud = new grocery_CRUD();
		
		$title = 'Report';
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('users');
		$crud->set_subject($title);
		$crud->columns('fullname', 'email');
		
		$crud->add_action('HTML', base_url('assets/images/icons/html.png'), $this->admin_url.'/report_pauli_html', '', '', '_blank');

		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_add();
		
		$output = $crud->render();
		
		$this->_generate_output($title, $output);
	}
	
	public function report_pauli_html($id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$this->db->where('users_id', $id);
		$this->db->where('quiz_code', 'pauli');
		$get = $this->db->get('pauli_jawaban_statistik');
		
		$rows = array();
		$arr_part = array();
		$jumlah = array('Total'=>0, 'Benar'=>0, 'Salah'=>0);
		
		foreach ($get->result() as $row)
		{
			$arr_part[] = $row->part + 1;
			
			$rows['Total'][] = (object) array(
				'num' => $row->total,
				'max' => $row->is_max_total,
				'min' => $row->is_min_total,
			);
			
			$rows['Benar'][] = (object) array(
				'num' => $row->benar,
				'max' => $row->is_max_benar,
				'min' => $row->is_min_benar,
			);
			
			$rows['Salah'][] = (object) array(
				'num' => $row->salah,
				'max' => $row->is_max_salah,
				'min' => $row->is_min_salah,
			);
			
			$jumlah['Total'] += $row->total;
			$jumlah['Benar'] += $row->benar;
			$jumlah['Salah'] += $row->salah;
		}
		
		$data = array('data' => $rows, 'part' => $arr_part, 'jumlah' => (object) $jumlah, 'pdf_url'=>site_url($this->admin_url.'/report_pauli_pdf/'.$id));
		$body = $this->load->view('Admin/report_pauli_view', $data, true);
		
		$template = array(
			'title' => 'Report',
			'body' => $body,
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function report_general_mental_ability()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$crud = new grocery_CRUD();
		
		$title = 'Report';
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('users');
		$crud->set_subject($title);
		$crud->columns('fullname', 'email');
		
		$crud->add_action('HTML', base_url('assets/images/icons/html.png'), $this->admin_url.'/report_general_mental_ability_html', '', '', '_blank');
		
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_add();
		
		$output = $crud->render();
		
		$this->_generate_output($title, $output);
	}
	
	public function report_general_mental_ability_html($id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$catatan_kualitatif = array(
			array(
			'KH' => 'Ceroboh kurang hati-hati, bekerja lamban, kurang sigap', 
			'KN' => 'Tidak memiliki kemampuan untuk memecahkan masalah yang kuantitatif', 
			'WM' => 'Memiliki daya ingat yang baik mampu menyimpan informasi dan menggunakan kelak dikemudian hari'
			),
			array(
			'LG' => 'Memiliki kemampuan untuk berpikir sistematis dengan logika nalar berpikir yang baik', 
			'S2D' => 'Memiliki daya bayang ruang dan gambar 2 dimensi yang baik', 
			'S3D' => 'Memiliki kemampuan memecahkan masalah yang berbentuk tiga dimensi seperti gambar dan bentuk peta'
			),
		);
		
		$this->db->select('email, fullname');
		$this->db->where('id', $id);
		$get = $this->db->get('users');
		$row = $get->first_row();
		
		$body = $this->load->view('Admin/report_general_mental_ability_view', 
			array(
				'data' => array(
					'lanjut' => $id % 2 == 0 ? true : false,
					'agility_level' => $id % 2 == 0 ? 120 : 98,
					'agility_max' => 138,
					'catatan_kualitatif' => $catatan_kualitatif,
					'fullname' => $row->fullname,
					'email' => $row->email,
				), 
				'pdf_url'=>site_url($this->admin_url.'/report_general_mental_ability_pdf/'.$id)
			), true);
		
		$body.= $this->load->view('Admin/report_work_personality_view', 
			array(
				//...
			), 
			true);
			
		$body.= $this->load->view('Admin/report_profiling_d3d_view', 
			array(
				//...
			), 
			true);
		
		$template = array(
			'title' => 'Report',
			'body' => $body,
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function report_generate()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$arr_generated = array();
		
		// Get websocket_url from settings
		$this->db->select('value');
		$this->db->where('name', 'websocket_url');
		$get = $this->db->get('settings');
		
		if ($row = $get->first_row())
		{
			preg_match('/^(ws[s]?):\/\/(.*)/', $row->value, $match);
			
			if (isset($match[2]))
			{
				$websocket_url = $match[1] . '://' . $match[2];
			}
			else
			{
				$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'wss' : 'ws';
				// $websocket_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $row->value;
				$websocket_url = $protocol . '://' . $row->value;
			}
		}
		
		$data = array(
			'arr_generated' => $arr_generated,
			'delete_queue_url' => site_url($this->admin_url.'/ajax_delete_queue'),
			'get_code_url' => site_url($this->admin_url.'/ajax_get_code'),
			'get_status_url' => site_url($this->admin_url.'/ajax_get_queue_status'),
			'generate_report_url' => site_url($this->admin_url.'/ajax_generate_report'),
			'load_report_url' => site_url($this->admin_url.'/ajax_get_report_queue'),
			);
		
		if (isset($websocket_url))
			$data['websocket_url'] = $websocket_url;
		
		$body = $this->load->view('Admin/report_generate_view', $data, true);
		
		$template = array(
			'title' => 'Report - Generate',
			'body' => $body,
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function report_gti()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('gti_result_manual');
		$crud->set_subject('Report');
		$crud->columns('fullname', 'formasi_code', 'gtq_num', 'rank', 'kategori');
		
		//$crud->add_action('PDF', base_url('assets/images/icons/pdf.png'), $this->admin_url.'/report_gti_pdf', '', '', '_blank');
		$crud->add_action('HTML', base_url('assets/images/icons/html.png'), $this->admin_url.'/report_gti_html', '', '', '_blank');
		
		$crud->unset_edit();
		$crud->unset_delete();
		$crud->unset_add();
		 
		$output = $crud->render();
		
		$this->_generate_output('Report', $output);
	}
	
	public function report_gti_html($id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$this->db->where('id', $id);
		$get = $this->db->get('gti_result_manual');
		
		$data = array('data' => $get->first_row(), 'pdf_url'=>site_url($this->admin_url.'/report_gti_pdf/'.$id));
		
		$template = array(
			'title' => 'Report GTI',
			'body' => $this->load->view('Admin/report_gti_view', $data, true),
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function report_gti_pdf($id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$this->db->where('id', $id);
		$get = $this->db->get('gti_result_manual');
		
		$data = array('img'=>$this->input->post('base64img'), 'data'=>$get->first_row());
		$content = $this->load->view('Admin/report_gti_pdf', $data, true);
		
		$path = 'tmp/c414b6ad465fc6a444a88a1adf84d123/';
		
		$filename = session_id();
		$html_file = $path . $filename . '.html';
		$pdf_file = $path . $filename . '.pdf';
		
		$fp = fopen($html_file, 'w');
		fwrite($fp, $content);
		fclose($fp);
		
		exec("wkhtmltopdf --footer-center [page]/[topage] {$html_file} {$pdf_file}");
		
		unlink($html_file);
		
		header("Content-Disposition: attachment; filename=\"LAPORAN DIGITAL HASIL TEST SELEKSI CALON KARYAWAN - {$data['data']->fullname}.pdf\"");   
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");            
		header("Content-Length: " . filesize($pdf_file));
		
		ob_clean();
		flush();
		readfile($pdf_file);
		unlink($pdf_file);
		exit;
	}
	
	public function sesi()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('sesi');
		$crud->set_subject('Sesi');
		$crud->columns('code', 'label', 'time_from', 'time_to', 'part', 'greeting');
		 
		$output = $crud->render();
		
		$this->_generate_output('Sesi', $output);
	}
	
	public function settings()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_table('settings');
		$crud->set_subject('Settings');
		$crud->columns('name', 'value', 'description');
		
		$crud->unique_fields('name');

		//$crud->unset_texteditor('description');
		 
		$output = $crud->render();
		
		$this->_generate_output('Settings', $output);
	}
	
	public function soal($library)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		
		$crud->unset_export();
		$crud->unset_print();
		// $crud->unset_edit();
		$crud->unset_delete();
		// $crud->unset_add();

		switch ($library)
		{
			case 'gti':
				$crud->set_table('gti_questions');
				$crud->set_subject('GTI');
				$crud->set_relation('quiz_code', 'quiz', '{label} - {code}', "quiz.library_code like 'gti_%'");
				$crud->columns('quiz_code', 'nomor', 'soal', 'jawaban', 'is_tutorial');
				
				$crud->field_type('is_tutorial', 'dropdown', array(1=>'Tutorial', 0=>'-'));
				$crud->unset_edit();
			break;
			
			case 'multiplechoice':
				$crud->set_table('multiplechoice_question');
				$crud->set_subject('Multiplechoice');
				$crud->set_relation('multiplechoice_img_code', 'multiplechoice_img', '{code} {img_path}');
				$crud->columns('jenis_soal', 'nomor', 'sulit', 'question', 'parent_nomor', 'multiplechoice_img_code', 'jawaban');
				$crud->order_by('nomor');
				$crud->add_action('Choice', '', $this->admin_url.'/choice', 'text-dark oi oi-expand-left', '', '_self');

				$crud->callback_field('multiplechoice_story_code', array($this,'field_m_story_code'));

			break;
		}
		 
		$output = $crud->render();
		
		$this->_generate_output('Sesi', $output);
	}

	public function field_m_story_code($value, $primary_key, $field, $data){
		$admin_url = $this->admin_url;
		$jenis_soal = $data->jenis_soal;
		$query = "jenis-soal=".$jenis_soal;

		if($field->crud_type == 'readonly'){
			return $value;
		}

		$edit_url = $admin_url.'/story/multiplechoice/index/edit/'.$value;
		$add_url = $admin_url.'/story/multiplechoice/index/add?'.htmlentities($query);
		if($value){
			return '<a class="btn btn-primary" href="'.base_url($edit_url).'">Edit Story</a>';
		} else {
			return '<a class="btn btn-primary" href="'.base_url($add_url).'">Add Story</a>';
		}
	}
	
	public function upload_users()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$this->load->model('quiz_model');
		$this->load->model('users_model');
		$this->load->model('users_quiz_model');
		$this->load->library('form_validation');

		$post_quiz = false;
		
		if (isset($_POST['quiz']) && is_array($_POST['quiz']) && count($_POST['quiz']) > 0)
		{
			$post_quiz = true;
		}
		
		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']) && $post_quiz)
		{
			$csv = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
			
			if (is_array($csv) && count($csv) > 1)
			{
				$this->db->trans_start();
				$jumlah = 0;
				
				foreach ($csv as $key => $row)
				{
					if ($key == 0)
						continue;
					
					$users_data = array(
						'username' => $row[1],
						'fullname' => $row[2],
						'email' => $row[3],
						'password' => $row[4],
						'formasi_code' => $row[5],
						'sesi_code' => $row[6],
						'base_url' => $row[7],
					);
					
					$this->users_model->insert($users_data, $users_id);
					
					foreach ($_POST['quiz'] as $quiz_id)
					{
						$this->db->query("INSERT INTO users_quiz (users_id, quiz_id, active) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE active = 1", array($users_id, $quiz_id));
					}
					
					$jumlah++;
				}
				
				$this->db->trans_complete();
				
				$this->session->set_flashdata('success', "Berhasil ditambahkan {$jumlah} user");
			}
		}
		
		$exams = $this->quiz_model->list_all(array('active'=>1));
		
		$data = array(
			'download_url' => base_url('assets/download/sample.csv'),
			'arr_quiz' => $exams,
		);
			
		$template = array(
			'title' => 'Admin',
			'body' => $this->load->view('Admin/upload_users_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function user_log($users_id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('users_log');
		$crud->set_subject('User Log');
		$crud->columns('time', 'action');
		$crud->order_by('time','desc');
		$crud->where('users_id', $users_id);
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();
		
		$output = $crud->render();
		
		$this->db->select('email, fullname');
		$this->db->where('id', $users_id);
		$get = $this->db->get('users');
		$row = $get->first_row();
		$user_data = $row->fullname.' - '.$row->email;
		
		$back_button = '<div class="row mt-3 mb-3"><div class="col-1"><a href="'. site_url($this->admin_url.'/users') .'" class="btn btn-primary">Back</a></div><div class="col-11"><h3>'.$user_data.'</h3></div></div>';
		
		$this->_generate_output('User Log', $output, $back_button);
	}
	
	public function user_photo($users_id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$this->db->select('agree_code');
		$this->db->where('id', $users_id);
		$get = $this->db->get('users');
		
		if ($row = $get->first_row())
		{
			$hashed_id = sha1($users_id);
			$hashed_agree_code = sha1($row->agree_code);
			$filename = "assets/photos-483900492049403949939392010/{$hashed_agree_code}_{$hashed_id}.jpg";
			
			if (file_exists($filename))
			{
				$im = imagecreatefromjpeg("{$filename}");
				
				header('Content-Type: image/jpeg');

				imagepng($im);
				imagedestroy($im);
			}
		} 
	}
	
	public function user_quiz($users_id)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');

		$this->load->model('users_model');
		$this->load->model('quiz_model');
		$this->load->model('users_quiz_model');
		
		if ($_POST)
		{
			$this->users_quiz_model->add($users_id, $this->input->post('id'));
			$this->users_quiz_model->set_debugs($users_id, $this->input->post('is_debugs'));
		}
		
		$exams = $this->quiz_model->list_all(array('active'=>1, 'is_show' => 1));
		$user_exams = $this->users_quiz_model->get_user_quizes($users_id);
		$arr_exam = array();
		$arr_is_debug = array();
		
		foreach ($user_exams as $row)
		{
			if ($row->active == 1)
				$arr_exam[] = $row->id;

			if($row->is_debug == 1)
				$arr_is_debug[] = $row->id;
		}
		
		// ambil jadwal
		$jadwal_lookup = array();
		
		$this->db->select('quiz_id, date, time_from, time_to');
		$this->db->where('users_id', $users_id);
		$this->db->where('active', 1);
		$this->db->where("concat(`date`,' ',`time_to`) >", "NOW()", false);
		$get = $this->db->get('users_quiz_schedule');
		
		foreach ($get->result() as $row)
		{
			$jadwal_lookup[$row->quiz_id][] = $row->date.'<br /> '.preg_replace("/:00$/",'',$row->time_from).' - '.preg_replace("/:00$/",'',$row->time_to);
		}
		
		$data = array('list' => $exams, 'jadwal_lookup' => $jadwal_lookup, 'user_exams' => $arr_exam, 'user_debugs' => $arr_is_debug, 'users_url' => site_url($this->admin_url.'/users'));
		
		$template = array(
			'title' => 'Admin',
			'body' => $this->load->view('Admin/exams_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function user_quiz_delete()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$out = array('success' => false);
		
		try
		{
			if (! isset($_POST['users_id'], $_POST['quiz_code'])) 
			{
				throw new Exception('Argument tidak memenuhi syarat');
			}
			
			$users_id = $_POST['users_id'];
			$quiz_code = $_POST['quiz_code'];
			
			$log_data = array();
			$log_path = APPPATH . 'logs/delete_' . date('YmdHis') . '_by_' . $this->session->userdata('id') . '_for_' . $users_id . '_' . $quiz_code . '.json';
			$args = array($users_id, $quiz_code);
			
			$query = $this->db->query("SELECT a.*, b.library_code FROM users_quiz_log a, quiz b WHERE a.quiz_code = b.code AND a.users_id = ? AND a.quiz_code = ?", $args);
			
			if ($row = $query->first_row())
			{
				// Get User data
				$this->db->where('id', $users_id);
				$get = $this->db->get('users');
				
				$user = $get->first_row();
				$log_data['user'] = $user;				
				
				//--------------------------------------------------------------------
				$this->db->trans_start();
				
				// Simpan dulu ke log
				$log_data['quiz'] = $row;
					
				// Hapus jawaban sesuai dengan library
				switch ($row->library_code)
				{
					case 'gti':
						$table = 'gti_jawaban';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '.$table.' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;
					
					case 'ist':
						$table = 'ist_jawaban';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;
					
					case 'personal':
						$table = 'personal_jawaban';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;
					
					case 'multiplechoice':
						$table = 'multiplechoice_jawaban';
						
						$this->load->model('Generate_exam_mdl');
						$this->load->model('Group_quiz_item_model');
						if($this->Generate_exam_mdl->has_group_quiz_code($quiz_code)){
							$list_group_item = $this->Group_quiz_item_model->get_quiz_code_by_group($quiz_code);
							foreach($list_group_item as $group_item){
								$this->db->where('users_id', $users_id);
								$this->db->where('jenis_soal', $group_item['quiz_code']);
								$get = $this->db->get($table);
	
								if ($get->num_rows() > 0)
								{
									$log_data['data'] = $get->result();

									$this->db->where('users_id', $users_id);
									$this->db->where('jenis_soal', $group_item['quiz_code']);
									$this->db->delete($table);
								}
							}

							$this->db->where('users_id', $users_id);
							$this->db->where('jenis_soal', $quiz_code);
							$this->db->delete($table);

						}else{
							// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
							$this->db->where('users_id', $users_id);
							$this->db->where('jenis_soal', $quiz_code);
							$get = $this->db->get($table);
							
							if ($get->num_rows() > 0)
							{
								$log_data['data'] = $get->result();
								
								$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND jenis_soal = ?', $args);
							}
						}
					break;
					
					case 'pauli':
						$table = 'pauli_jawaban_log';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['log'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
						
						$table = 'pauli_jawaban_statistik';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;
					
					case 'essay':
						$table = 'essay_jawaban';
						
						// Ambil dulu datanya, lalu jadikan json dan disimpan ke file
						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);
						
						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;

					case 'disc':
						$table = 'disc_jawaban';

						$this->db->where('users_id', $users_id);
						$this->db->where('quiz_code', $quiz_code);
						$get = $this->db->get($table);

						if ($get->num_rows() > 0)
						{
							$log_data['data'] = $get->result();
							
							$this->db->query('DELETE FROM '. $table .' WHERE users_id = ? AND quiz_code = ?', $args);
						}
					break;
					
					default: throw new Exception('Library tidak terdaftar');
				}
				
				// Hapus users_quiz_log
				$this->db->query('DELETE FROM users_quiz_log WHERE users_id = ? AND quiz_code = ?', $args);
				
				$this->db->trans_complete();
				//--------------------------------------------------------------------
				
				$fp = fopen($log_path, 'w');
				fwrite($fp, json_encode($log_data));
				fclose($fp);
			}
			else
			{
				throw new Exception('Library tidak ditemukan');
			}
			
			$out['success'] = true;
		}
		catch (Exception $e)
		{
			$out['msg'] = $e->getMessage();
		}
		
		header('Content-type: Application/json');
		echo json_encode($out);
	}
	
	public function user_quiz_jawaban($users_id=0,$quiz_code='')
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$quiz_data = array();
		$user_data = '';
		$benar = 'Benar';
		$status = '-';
		$type = 'default';
		
		if ($users_id > 0)
		{
			$this->db->select('email, fullname');
			$this->db->where('id', $users_id);
			$get = $this->db->get('users');
			$row = $get->first_row();
			$user_data = $row->fullname.' - '.$row->email;
			
			$this->db->select('label, code, library_code, sub_library_code');
			$this->db->where('code', $quiz_code);
			$get = $this->db->get('quiz');
			
			if ($row = $get->first_row())
			{
				$title = $row->code . ' (' .$row->label . ')';
				$library = $row->library_code;
				$sub_library = $row->sub_library_code;
				$field_quiz_code = 'quiz_code';
				
				$this->db->select('time_end');
				$this->db->where('users_id', $users_id);
				$this->db->where('quiz_code', $quiz_code);
				$get = $this->db->get('users_quiz_log');
				
				if ($row = $get->first_row())
				{
					$status = ($row->time_end == '') ? '-' : 'Selesai';
				}
				
				$table_name = $library.'_jawaban';
				$order_by = 'nomor';
				
				switch ($library)
				{
					case 'multiplechoice':
						//$field_quiz_code = 'jenis_soal';
					
						//$this->db->select('nomor, jawaban_choice as jawaban, jawaban_benar');
						$this->load->model('Generate_exam_mdl');
						if($this->Generate_exam_mdl->has_group_quiz_code($quiz_code)){
							$this->load->library('exam_multiplechoice');
							$quiz_data = $this->exam_multiplechoice->get_jawaban_group_quiz_code($quiz_code,$users_id);
						}else{
							$get = $this->db->query("
								SELECT
									b.nomor, c.choice as jawaban, b.jawaban as jawaban_benar
								FROM
									multiplechoice_jawaban a,
									multiplechoice_question b,
									multiplechoice_choices c
								WHERE
									a.jenis_soal = b.jenis_soal
									AND
									a.multiplechoice_question_id = b.id
									AND
									a.multiplechoice_choices_id = c.id
									AND
									b.id = c.multiplechoice_question_id
									AND
									a.jenis_soal = ?
									AND
									a.users_id = ?
								ORDER BY
									#b.nomor ASC
																	a.date_created ASC
								", array($quiz_code, $users_id));
								$quiz_data = $get->result();						
						};
					break;
					
					case 'personal':
						$benar = 'Trait';
						
						//$this->db->select('nomor, jawaban, jawaban_trait as jawaban_benar');
						$type = 'personal';
						
						if ($sub_library == 'd3ad')
						{
							$get = $this->db->query("
							SELECT
								b.nomor, b.trait as jawaban, b.trait as jawaban_benar
							FROM
								personal_jawaban a,
								personal_questions b
							WHERE
								a.quiz_code = b.quiz_code
								AND
								a.jawaban = b.id
								AND
								a.quiz_code = ?
								AND
								a.users_id = ?
							ORDER BY
								#b.nomor ASC
                                a.created ASC
							", array($quiz_code, $users_id));
						}
						else
						{
							$get = $this->db->query("
							SELECT
								b.nomor, a.jawaban, b.trait as jawaban_benar
							FROM
								personal_jawaban a
							LEFT JOIN
								personal_questions b ON (a.personal_questions_id = b.id)
							WHERE
								a.quiz_code = ?
								AND
								a.users_id = ?
							ORDER BY
								#b.nomor ASC
                                a.created ASC
							", array($quiz_code, $users_id));
						}
						$quiz_data = $get->result();
					break;
					
					case 'pauli':
						/*
						$this->db->select('part, total, benar, salah');
						$table_name = 'pauli_jawaban_statistik';
						$order_by = 'part';
						*/
						$type = 'pauli';
						
						$get = $this->db->query("
							SELECT
								`part`, `total`, `benar`, `salah`
							FROM
								pauli_jawaban_statistik
							WHERE
								quiz_code = ?
								AND
								users_id = ?
							ORDER BY
								`part` ASC
							", array($quiz_code, $users_id));
							$quiz_data = $get->result();
					break;
					
					case 'essay':
						$type = 'essay';
						
						$get = $this->db->query("
							SELECT
								b.nomor, a.jawaban, b.question
							FROM
								{$library}_jawaban a,
								{$library}_questions b
							WHERE
								a.quiz_code = b.quiz_code
								AND
								a.{$library}_questions_id = b.id
								AND
								a.quiz_code = ?
								AND
								a.users_id = ?
							ORDER BY
								#b.nomor ASC
                                a.created ASC
							", array($quiz_code, $users_id));

							$quiz_data = $get->result();
					break;

					case 'disc':
						$this->load->library('Disc_result');
						$quiz_data = $this->disc_result->result($users_id, $quiz_code);

					break;
					
					default:
						//$this->db->select('nomor, jawaban, jawaban_benar');
						$get = $this->db->query("
							SELECT
								b.nomor, a.jawaban, b.jawaban as jawaban_benar
							FROM
								{$library}_jawaban a,
								{$library}_questions b
							WHERE
								a.quiz_code = b.quiz_code
								AND
								a.{$library}_questions_id = b.id
								AND
								a.quiz_code = ?
								AND
								a.users_id = ?
							ORDER BY
								#b.nomor ASC
                                a.created ASC
							", array($quiz_code, $users_id));

							$quiz_data = $get->result();
					break;
				}
				
				/*
				$this->db->where('users_id', $users_id);
				$this->db->where($field_quiz_code, $quiz_code);
				$this->db->order_by($order_by, 'asc');
				$get = $this->db->get($table_name);
				*/
			}

		}
		
		$export_url = $this->admin_url.'/export_excel/'.$users_id.'/'.$quiz_code;

		$data = array(
			'benar'=>$benar, 
			'data'=>$quiz_data, 
			'user_data'=>$user_data, 
			'back_url'=>$this->admin_url.'/user_quiz_log/'.$users_id, 
			'export_excel_url'=> $export_url,
			'status'=>$status, 
			'type'=>$type, 
			'title'=>$title
		);
		
		$template = array(
			'title' => 'User Quiz Log Data',
			'body' => $this->load->view('Admin/user_quiz_jawaban_view', $data, true),
			'report_url' => $this->report_url,
		);

		if($library == 'disc'){
			$this->load->model("users_model");
			$users = $this->users_model->get_by("id", $users_id);
			$sesi = $users[0]["sesi_code"];
			$data = array(
				'data'=>$quiz_data,
				'user_data'=>$user_data, 
				'back_url'=>$this->admin_url.'/user_quiz_log/'.$users_id, 
				'export_excel_url'=>$export_url, 
				'download_pdf_url'=>base_url($this->admin_url."/psycogram/disc_pdf"."/".$sesi."?users_id=".$users_id),
				'status'=>$status, 
				'type'=>$type, 
				'title'=>$title
			);
			$template = array(
				'title' => 'User Quiz Log Data',
				'body' => $this->load->view('Admin/user_quiz_jawaban_disc_view', $data, true),
				'report_url' => $this->report_url,
			);
		}
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function export_excel($users_id=0,$quiz_code='')
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');

		$this->load->library('Generate_excel');
		$this->generate_excel->create_excel($users_id,$quiz_code);
	}

	public function user_quiz_log($users_id=0)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$log_data = array();
		$user_data = '';
		
		if ($users_id > 0)
		{
			$this->db->select('email, fullname');
			$this->db->where('id', $users_id);
			$get = $this->db->get('users');
			$row = $get->first_row();
			$user_data = $row->fullname.' - '.$row->email;
			
			$this->db->select('a.*, b.label');
			$this->db->where('a.users_id', $users_id);
			$this->db->join('quiz b','b.code = a.quiz_code');
			$this->db->order_by('a.time_start','asc');
			
			$get = $this->db->get('users_quiz_log a');
			$log_data = $get->result();
		}
	
		$data = array('data'=>$log_data, 'user_data'=>$user_data);
		
		$template = array(
			'title' => 'User Quiz Log',
			'body' => $this->load->view('Admin/user_quiz_log_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function user_quiz_log_data($users_id=0, $quiz_code='')
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		$quiz_data = array();
		$user_data = '';
		$json_data = '';
		$title = '';
		
		if ($users_id > 0)
		{
			$this->db->select('email, fullname');
			$this->db->where('id', $users_id);
			$get = $this->db->get('users');
			$row = $get->first_row();
			$user_data = $row->fullname.' - '.$row->email;
			
			$this->db->select('label, code');
			$this->db->where('code', $quiz_code);
			$get = $this->db->get('quiz');
			$row = $get->first_row();
			$title = $row->code . ' (' .$row->label . ')';
			
			$this->db->select('a.rows, b.id, b.rows as rows_paket_soal');
			$this->db->where('a.quiz_code', $quiz_code);
			$this->db->where('a.users_id', $users_id);
      $this->db->join('quiz_paket_soal b', 'b.id = a.quiz_paket_soal_id', 'left');
			$get = $this->db->get('users_quiz_log a');
			$row = $get->first_row();
			
            $rows = $row->rows;
            
            if ($row->rows_paket_soal !== null)
            {
                $rows = $row->rows_paket_soal;
            }
            
			$json_data = print_r(json_decode($rows), true);
		}	
		
		$data = array(
			'data'=>$quiz_data, 
			'user_data'=>$user_data, 
			'json_data'=>$json_data, 
			'back_url'=>$this->admin_url.'/user_quiz_log/'.$users_id,
			'title'=>$title);
		
		$template = array(
			'title' => 'User Quiz Log Data',
			'body' => $this->load->view('Admin/user_quiz_log_data_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	private function users_quiz_terjadwal_save($users_id, $quiz_id, $date, $time_from, $time_to, $sesi_code = null)
	{
		// transaction per baris
		$this->db->trans_start();
							
		// Simpan ke users_quiz
		$this->db->query('
		INSERT INTO `users_quiz` (`quiz_id`, `users_id`, `active`) VALUES (?, ?, 0)
		ON DUPLICATE KEY UPDATE `active` = 0
		', array($quiz_id, $users_id));
		
		// Simpan ke users_quiz_schedule
		$this->db->query('
		INSERT INTO `users_quiz_schedule` (`quiz_id`, `users_id`, `date`, `time_from`, `time_to`)
		VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `time_from` = ?, `time_to` = ?, `active` = 1
		', array($quiz_id, $users_id, $date, $time_from, $time_to, $time_from, $time_to));
		
		// Ubah sesi code
		if ($sesi_code !== null)
		{
			$this->db->set('sesi_code', $sesi_code);
			$this->db->where('id', $users_id);
			$this->db->update('users');
		}
		
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	public function users_quiz_terjadwal()
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
		
		if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']))
		{
			try
			{
				$csv = array_map('str_getcsv', file($_FILES['file']['tmp_name']));
				
				if (isset($csv[0][0]) && mb_check_encoding($csv[0][0]) != 1)
				{
					throw new Exception('Data yang diupload harus format CVS');
				}
				
				if (true === is_array($csv) && count($csv) > 1)
				{
					// Kumpulkan daftar error
					$error_karena_quiz_code = array();
					$error_karena_email = array();
					$error_karena_format_date = array();
					$error_karena_format_time = array();
					$error_karena_sesi_code = array();
					
					// Overwrite data
					$overwrite_quiz = array();
					$arr_users_id = array();
					$arr_users_quiz_set = array();
					
					// Perika kalau ada overwrite
					if (isset($_POST['overwrite']))
					{
						foreach ($_POST['overwrite'] as $quiz_id => $init)
						{
							// Periksa format date, time_from, dan time_to
							// Kalau error langsung lewati, karena nanti validasi dibuat di interface saja
							if (! isset($_POST['date'][$quiz_id])) continue;
							
							if (! isset($_POST['time_from'][$quiz_id])) continue;
							
							if (! isset($_POST['time_to'][$quiz_id])) continue;
							
							$dt = DateTime::createFromFormat("Y-m-d", $_POST['date'][$quiz_id]);
							if ($dt === false) continue;
							
							$time_ok = 0;
							
							foreach (array($_POST['time_from'][$quiz_id], $_POST['time_to'][$quiz_id]) as $time_data)
							{
								$tm = DateTime::createFromFormat("H:i", $time_data);
								preg_match('/[0|5]$/', $time_data, $kelipatan_lima_menit);
								
								if ($tm === false || false === $kelipatan_lima_menit) break;
								
								$time_ok += 1;
							}
							
							if ($time_ok < 2) continue;
							
							// Simpan sebagai data overwrite
							$overwrite_quiz[$quiz_id] = array(
								'date' => $_POST['date'][$quiz_id],
								'time_from' => $_POST['time_from'][$quiz_id],
								'time_to' => $_POST['time_to'][$quiz_id],
							);
						}
					}
					
					// Ambil lookup quiz
					$quiz_id_lookup = array();
					
					$this->db->select('id, code');
					$this->db->where('active', 1);
					$get = $this->db->get('quiz');
					
					foreach ($get->result() as $row)
					{
						$quiz_id_lookup[$row->code] = $row->id;
					}
					
					$success = 0;
					
					foreach ($csv as $key => $row)
					{
						if ($key == 0)
							continue;
						
						$found_error = false;
						
						// Data dari row VCS
						$no = $key + 1;
						$email = $row[0];
						$quiz_code = $row[1];
						$date = $row[2];
						$time_from = $row[3];
						$time_to = $row[4];
						$sesi_code = trim($row[5]);
						
						// Check quiz code
						if (! isset($quiz_id_lookup[$quiz_code]))
						{
							$found_error = true;
							$error_karena_quiz_code[] = $no;
						}
							
						// Check date
						$dt = DateTime::createFromFormat("Y-m-d", $date);
						if ($dt === false)
						{
							$found_error = true;
							$error_karena_format_date[] = $no;
						}
							
						// Check time from
						foreach (array($time_from, $time_to) as $time_data)
						{
							$tm = DateTime::createFromFormat("H:i", $time_data);
							preg_match('/[0|5]$/', $time_data, $kelipatan_lima_menit);
							
							if ($tm === false || false === $kelipatan_lima_menit)
							{
								$found_error = true;
								$error_karena_format_time[] = $no;
								break;
							}
						}
						
						// Check email
						$this->db->select('id');
						$this->db->where('email', $email);
						$this->db->limit(1);
						$get = $this->db->get('users');
						
						if ($users_row = $get->first_row())
						{
							$users_id = $users_row->id;
						}
						else
						{
							$found_error = true;
							$error_karena_email[] = $no;
						}
						
						if (! empty($sesi_code))
						{
							// Check sesi code
							$this->db->select('code');
							$this->db->where('code', $sesi_code);
							$this->db->limit(1);
							$get = $this->db->get('sesi');
							
							if ($get->num_rows() == 0)
							{
								$found_error = true;
								$error_karena_sesi_code[] = $no;
							}
						}
						else
						{
							$sesi_code = null;
						}
						
						if (false === $found_error)
						{
							$quiz_id = $quiz_id_lookup[$quiz_code];
							
							if ($this->users_quiz_terjadwal_save($users_id, $quiz_id, $date, $time_from, $time_to, $sesi_code))
							{
								if (count($overwrite_quiz) > 0)
								{
									// kumpulkan users_id untuk ditambah overwrite data
									$arr_users_id[$users_id] = 1;
								}
								
								if ($this->input->post('unset_quiz') == 1)
								{
									$arr_users_quiz_set[$users_id][] = $quiz_id;
								}
								
								$success += 1;
							}
						}
						
						$sesi_code = null;
					}
					
					foreach ($arr_users_id as $users_id => $dummy_value)
					{
						// simpan overwrite
						foreach ($overwrite_quiz as $quiz_id => $data)
						{
							$this->users_quiz_terjadwal_save($users_id, $quiz_id, $data['date'], $data['time_from'], $data['time_to']);
						}
					}
					
					foreach ($arr_users_quiz_set as $users_id => $arr_quiz_id)
					{
						$this->db->set('active', 0);
						$this->db->where('users_id', $users_id);
						$this->db->where_not_in('quiz_id', $arr_quiz_id);
						$this->db->update('users_quiz');
					}
					
					$this->session->set_flashdata('success', $success);
					$error = '';
					
					if (count($error_karena_quiz_code) > 0)
					{
						$error.='Quiz Code: '.implode(', ', $error_karena_quiz_code)."<br/>";
					}
					
					if (count($error_karena_email) > 0)
					{
						$error.='Email: '.implode(', ', $error_karena_email)."<br/>";
					}
					
					if (count($error_karena_format_date) > 0)
					{
						$error.='Date Format: '.implode(', ', $error_karena_format_date)."<br/>";
					}
					
					if (count($error_karena_format_time) > 0)
					{
						$error.='Time Format: '.implode(', ', $error_karena_format_time)."<br/>";
					}
					
					if (count($error_karena_sesi_code) > 0)
					{
						$error.='Sesi Code: '.implode(', ', $error_karena_sesi_code)."<br/>";
					}
					
					if ($error != '')
						throw new Exception($error);
				}
				else
				{
					throw new Exception('Data tidak ditemukan');
				}
			}
			catch (Exception $e)
			{
				$this->session->set_flashdata('error', $e->getMessage());
			}
			
			redirect($this->admin_url.'/'.__function__);
		}
		
		$this->load->model('quiz_model');
		
		$data = array(
			'arr_quiz' => $this->quiz_model->list_all(array('active'=>1)),
			'csv_sample_url' => base_url('assets/download/quiz_terjadwal_sample.csv'),
			'error' => $this->session->flashdata('error'),
			'success' => $this->session->flashdata('success'),
		);
		
		$template = array(
			'title' => 'User Quiz Terjadwal',
			'body' => $this->load->view('Admin/user_quiz_terjadwal_view', $data, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);
	}
	
	public function users($username='', $users_id=0)
	{
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();
		
		$crud->set_model('Grocery_custom_model');
		$crud->set_table('users');
		$crud->set_subject('Users');
		$crud->set_relation('formasi_code', 'formasi', '{label} "{code}"');
		$crud->set_relation('sesi_code', 'sesi', '{label} "{code}" ({time_from} - {time_to})');
        $crud->columns('username', 'fullname', 'password', 'email', 'email_sent', 'tgl_lahir', 'active', 'formasi_code', 'sesi_code', 'first_login', 'agree_code', 'agree_time', 'base_url');
         
        $crud->fields('username', 'fullname', 'password', 'email', 'tgl_lahir', 'formasi_code', 'sesi_code', 'base_url', 'active');
		$crud->add_action('Set Quiz', '', $this->admin_url.'/user_quiz', 'text-dark oi oi-task', '', '_self');
		$crud->add_action('Photo', '', $this->admin_url.'/user_photo', 'text-dark oi oi-camera-slr', '', 'photo');
		$crud->add_action('User Log', '', $this->admin_url.'/user_log', 'text-dark oi oi-clock', '', '_self');
		$crud->add_action('Quiz Log', '', $this->admin_url.'/user_quiz_log', 'text-dark oi oi-timer', '', '_self');
		
		$crud->display_as('formasi_code', 'Formasi');
		$crud->display_as('sesi_code', 'Sesi');
		
		$crud->field_type('active', 'dropdown', array(1=>'Active', 0=>'Inactive'));
		
		$output = $crud->render();
		
		$this->_generate_output('Users', $output);
	}
	
	public function valid_old_password($str)
	{
		if ($this->session->userdata('is_admin') <= 0) die();
		
		$get = $this->db->get_where('admins', array('username'=> $this->session->userdata('username'), 'password'=>sha1($str)));
		
		if ($get->num_rows() == 1)
			return true;
		
		$this->form_validation->set_message('valid_old_password', '{field} salah'); 
		return false;
	}
}


