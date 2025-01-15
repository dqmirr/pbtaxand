<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends Ci_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('users_quiz_model');
        $session_id = session_id();
        
		// redirect to admin panel if session is admin
		if ($this->session->userdata('is_admin') == true) redirect($this->session->userdata('admin_controller'));

        if ($this->session->userdata('current_session_id') != $session_id)
        {
            $this->users_quiz_model->save_session_id($session_id);
        }

    }

	private function _check_quiz_group_item_log($code, $users_id){
		$quiz = $this->db->select("*")->where('code', $code)->get('quiz')->row();

		if($quiz->group_quiz_code){
			$group_quiz = $this->db->select("*")->where('code', $quiz->group_quiz_code)->get('group_quiz')->row();
            $group_items_count[$group_quiz->code] = $group_quiz->items;
		}
	}

	private function _check_quiz_log($code, $users_id){

		$this->db->select("`a`.`rows`, `a`.`time_start`, `a`.`index`, (case when `a`.`seconds` > `a`.`seconds_used` then (`a`.`seconds` - `a`.`seconds_used`) else 0 end) as `seconds_left`, `a`.`seconds`, `b`.`rows` as `paket_soal_rows`", false);
        $this->db->join('quiz_paket_soal b', 'a.quiz_paket_soal_id = b.id', 'left');
		$this->db->where('a.quiz_code', $code);
		$this->db->where('a.users_id', $users_id);
		$this->db->where('b.deleted', false);
        $this->db->limit(1);
		
		$get = $this->db->get('users_quiz_log a');
		return $get->first_row();
	}
	
	private function _ambil_soal_tersimpan($code, $users_id, &$is_tutorial, &$json, &$index, $epoch_now)
	{
		if(!property_exists($this, 'users_quiz_log_model')){
			$this->load->model('users_quiz_log_model');
		}

		$user_quiz_log = $this->_check_quiz_log($code, $users_id);
		if($user_quiz_log){
			$is_tutorial = 0;
		}

		if ($is_tutorial == 1 || $is_tutorial == 2)
			return false;
		
		// $now = date('Y-m-d H:i:s'); // setting time start berdasarkan waktu server
		if($epoch_now){
			$epoch_seconds = intval($epoch_now)/1000;
			$now = date('Y-m-d H:i:s', $epoch_seconds); // setting time start test berdasarkan browser dari client
		} else {
			$now = date('Y-m-d H:i:s');
		}


		// Sebelum ambil soal, pastikan dia masih berada di dalam jadwal ujian
		// if ($is_finished_quiz != false)
		if ($now < $this->session->userdata('time_from') || $now > $this->session->userdata('time_to'))
		{
			$json['rows'] = array();
			$json['seconds'] = 0;
			$json['opsi_jawaban'] = array();
			$json['sub_library'] = '';
			$json['redirect'] = site_url('exam');
			$json['msg'] = 'Waktu ujian sudah selesai.';
			
			$index = 0;
			$is_tutorial = 0;
			
			return true;
		}
		
		// Check dulu di table users_quiz apakah soalnya sudah pernah disimpan, jika ada, ambil data dari sini
		//$this->db->select("rows, `index`, TIMESTAMPDIFF(SECOND, time_start,'{$now}') as selisih, seconds", false);
		
		// Sekarang menggunakan selisih waktu update dan time_start, jadi bisa diulangi lagi
		$this->db->select("`a`.`rows`, `a`.`time_start`,`a`.`epoch_start`, `a`.`index`, (case when `a`.`seconds` > `a`.`seconds_used` then (`a`.`seconds` - `a`.`seconds_used`) else 0 end) as `seconds_left`, `a`.`seconds`, `b`.`rows` as `paket_soal_rows`", false);
        $this->db->join('quiz_paket_soal b', 'a.quiz_paket_soal_id = b.id', 'left');
		$this->db->where('a.quiz_code', $code);
		$this->db->where('a.users_id', $users_id);
		$this->db->where('b.deleted', false);
        $this->db->limit(1);
		
		$get = $this->db->get('users_quiz_log a');
		
		if ($row = $get->first_row())
		{
            if ($row->paket_soal_rows !== null)
            {
                $row->rows = $row->paket_soal_rows;
            }
            
			$json = json_decode($row->rows, true);
			// if(gettype($json) == 'array' && (in_array('rows', $json) && (count($json["rows"]) == 0))){
			// 	$this->users_quiz_log_model->remove_by($users_id, $code);
			// 	return false;
			// }

			if($row->time_start){
				$json["time_start"] = $row->time_start; 
			}

			if($row->epoch_start){
				$json["epoch_start"] = $row->epoch_start; 
			}

			// var_dump($json["rows"]["no_recalculate_seconds"]);
			
			if($row->seconds_left){
				$json['seconds_left'] = $row->seconds_left;
			}

			if($row->seconds){
				$json['total_seconds'] = $row->seconds;
			}
			// if (isset($json['rows']['no_recalculate_seconds']))
			// 	$json['seconds'] = $row->seconds;
			// else
			// 	$json['seconds'] = $row->seconds_left;
			// 	$json['seconds'] = ($row->selisih <= $row->seconds) ? ($row->seconds - $row->selisih) : 0;
			
            $json['validation'] = md5($row->time_start);
            
            // Check seconds_extra from settings
            $this->db->select('value');
            $this->db->where('name', $code.'_seconds_extra');
            $get_settings = $this->db->get('settings');
            
            if ($row_settings = $get_settings->first_row())
            {
                $json['seconds_extra'] = $row_settings->value;
            }
            
			$is_tutorial = 0;
			$index = $row->index;
			
			return true;
		}
		
		return false;
	}
	
	private function _session_invalid()
	{
		//Faisal, kosongin session di DB
		$this->load->model('auth_model');
		$this->auth_model->session_logout($this->session->userdata('id'));

		header('Content-Type: Application/JSON');
		
		echo json_encode(array(
			'error' => TRUE, 
			'msg' => 'Harap Login', 
			'redirect' => site_url('/'))
		);
		
		exit;
	}
	
	public function ajax_get_questions()
	{
		if ($this->session->userdata('is_user') <= 0) $this->_session_invalid();
		
		$json = array();
		
		$is_tutorial = $this->input->post('tutorial');
		$library_code = $this->input->post('library');
		$code = $this->input->post('code');
		$users_id = $this->session->userdata('id');
		$epoch_now = $this->input->post('epoch_now');
		$index = 0;
		
		try
		{
			if (! $this->users_quiz_model->validate_user_code_and_library($users_id, $code, $library_code))
				throw new Exception('Anda tidak memiliki hak untuk mengakses quiz ini');
			
			// Misalkan $library_code = multiplechoice, maka librarynya bernama exam_multiplechoice
			$library_name = 'exam_'.$library_code;
			
			$this->load->library($library_name);
			
			if (false === $this->_ambil_soal_tersimpan($code, $users_id, $is_tutorial, $json, $index, $epoch_now))
			{
				$is_debug = $this->users_quiz_model->validate_is_debug($users_id, $code);
				if($is_debug==true && $library_code == 'multiplechoice'){
					$json = $this->{$library_name}->get_questions_without_gen($code, $is_tutorial);
				}else{
					$json = $this->{$library_name}->get_questions($code, $is_tutorial, $library_name, $epoch_now);
				}
			}
			
			$json['success'] = true;
			$json['clientkey'] = $this->session->userdata('userkey');
			$json['clientUsername'] = md5($this->session->userdata('username'));
			$json['index'] = $index;
			
			switch($is_tutorial)
			{
				case 1: $this->userslog->log('mengambil tutorial '.$code);
				break;
				
				case 2: $this->userslog->log('demo hasil '.$code);
				break;
				
				default: 
					$this->userslog->log('memulai test '.$code);
					break;
			}
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();

			$this->userslog->log('gagal memulai test(0)/tutorial(1)/demo(2) '.$code.', ('.$is_tutorial.') error: '.$e->getMessage());
		}
		
		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}

	public function ajax_next_test_to_done()
	{
		if ($this->session->userdata('is_user') <= 0) $this->_session_invalid();

		$json = array();

		$users_id = $this->session->userdata('id');
		$code = $this->input->post('code');
		$seconds_used = $this->input->post('used');

		$json['success'] = $this->users_quiz_model->done($users_id, $code, $seconds_used);

		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}
	
	public function ajax_save_answers()
	{
		if ($this->session->userdata('is_user') <= 0) $this->_session_invalid();
		
		$json = array();
		
		try
		{
			$library_code = $this->input->post('library');
			$code = $this->input->post('code');
			$jawaban = $this->input->post('answers');
			$users_id = $this->session->userdata('id');
			$done = $this->input->post('done');
            $index = $this->input->post('index');
            $seconds_used = $this->input->post('used');
			
			if (! $this->users_quiz_model->validate_user_code_and_library($users_id, $code, $library_code))
				throw new Exception('Anda tidak memiliki hak untuk mengakses quiz ini');
			
			// Misalkan $library_code = multiplechoice, maka librarynya bernama exam_multiplechoice
			$library_name = 'exam_'.$library_code;
			
			$this->load->library($library_name);
			
			if ($done == 1)
			{
				if (is_array($jawaban) && count($jawaban) > 0){
					$this->load->model('Generate_exam_mdl');
					if($library_code == 'multiplechoice' and $this->Generate_exam_mdl->has_group_quiz_code($code) == TRUE){
						$this->{$library_name}->save_answers_group($users_id, $code, $jawaban, $seconds_used, $index);
					} else{
						$this->{$library_name}->save_answers($users_id, $code, $jawaban, $seconds_used, $index);
					}
				
				}

				$json['success'] = $this->users_quiz_model->done($users_id, $code, $seconds_used);
			}
			else {
				$this->load->model('Generate_exam_mdl');
				if($library_code == 'multiplechoice' and $this->Generate_exam_mdl->has_group_quiz_code($code) == TRUE){
					$json['success'] = $this->{$library_name}->save_answers_group($users_id, $code, $jawaban, $seconds_used, $index);
				} else{
					$json['success'] = $this->{$library_name}->save_answers($users_id, $code, $jawaban, $seconds_used, $index);
				}
			}
			
			$this->userslog->log('menyimpan jawaban test '.$code);
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
			
			$this->userslog->log('gagal menyimpan jawaban test '.$code.', error: '.$e->getMessage());
		}
		
		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}
	
	public function ajax_save_index()
	{
		if ($this->session->userdata('is_user') <= 0) $this->_session_invalid();
		
		$json = array();
		
		header('Content-Type: application/json; charset=UTF8');
		
		try
		{
			$code = $this->input->post('code');
			$tutorial = ($this->input->post('tutorial') == false) ? 0 : $this->input->post('tutorial');
			$index = ($this->input->post('index') == '') ? 0 : $this->input->post('index');
			$seconds_left = $this->input->post('check_id');
			
			$users_id = $this->session->userdata('id');
			
			if ($code != '' && $index >= 0 && $tutorial == 0 && $seconds_left != '')
			{
				// Kalau 0 anggap saja sebagai null
				$index = ($index == 0) ? null : $index;
				
				$dbsave = $this->load->database('save', TRUE);
				
				$stat = $dbsave->query('UPDATE users_quiz_log SET `index` = ?, `seconds_used` = (seconds - ?), last_update = NOW() WHERE users_id = ? AND quiz_code = ?', array($index, $seconds_left, $users_id, $code));
				
				if (! $stat) throw new Exception('Gagal update index');
				
				$json['success'] = true;
			}
			else
			{
				throw new Exception('Invalid Data');
			}
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
		}
		
		echo json_encode($json);
		
	}
	
	public function ajax_restart()
	{
		if ($this->session->userdata('is_user') <= 0) $this->_session_invalid();
		
		$json = array();
		
		try
		{
			throw new Exception('Fungsi ini sementara dimatikan di versi ini.');
			
			$code = $this->input->post('code');
			$users_id = $this->session->userdata('id');
			
			if (! $this->users_quiz_model->valid_user_quiz_code($users_id, $code, $quiz_info, $arr_library_code))
				throw new Exception('Anda tidak memiliki hak untuk mengakses quiz ini');
			
			$arr_code = array($code);
			
			$this->db->trans_start();
			
			foreach ($arr_library_code as $quiz_code => $library_code)
			{
				if ($library_code['allow_restart'] != 1)
				{
					foreach ($arr_code as $k => $v)
					{
						if ($v == $quiz_code)
							unset($arr_code[$k]);
					}
					
					continue;
				}
				
				$arr_code[] = $quiz_code;
				$library_name = 'exam_'.$library_code['library'];
				$this->load->library($library_name);
				$this->{$library_name}->restart($users_id, $quiz_code);
			}
			
			$arr_code = array_unique($arr_code);
			
			$this->db->trans_complete();

			$json['success'] = $this->db->trans_status();
			$json['arr_code'] = $arr_code;
			
			$this->userslog->log('restart test '.$code);
		}
		catch (Exception $e)
		{
			$json['error'] = true;
			$json['msg'] = $e->getMessage();
			
			$code = isset($code) ? $code : '[NONE]';
			$this->userslog->log('gagal restart test '.$code.', error: '.$e->getMessage());
		}
		
		header('Content-Type: Application/JSON');
		echo json_encode($json);
	}
	

	public function index()
	{
		if ($this->session->userdata('is_user') <= 0) redirect('/');
		
		$this->load->model('disclaimer_model');
		// if ($this->session->userdata('agree_code') == '') redirect('page/disclaimer');
		if (!$this->disclaimer_model->validate_gco_policy($this->session->userdata('id'))) redirect('page/disclaimer');
		
		$this->load->library('parser');
		$this->load->model('users_quiz_log_model');
		
		$users_id = $this->session->userdata('id');
		
		$arr_quiz = $this->users_quiz_model->get_user_quizes($users_id);
		
		$this->users_quiz_log_model->tandai_sudah_selesai($users_id, $arr_quiz);
		
		$data = array(
			'arr_quiz' => $arr_quiz,
			'quiz_url' => site_url('exam/code/'),
			'restart_url' => site_url('exam/ajax_restart'),
			'arr_code' => array(),

			'user' => (object) array(
				'nama' => $this->session->userdata('fullname'),
				'kode' => $this->session->userdata('username'),
				'time_from' => date('j F Y, H:i:s', strtotime($this->session->userdata('time_from'))),
				'time_to' => date('j F Y, H:i:s', strtotime($this->session->userdata('time_to'))),
			),
			
			'quiz_url_suffix' => '',
			'greeting' => $this->config->item('app_greeting'),
		);
		
		$sesi = $this->session->userdata('sesi_code');

		
		// TEXT
		$sesi_part = null;
		$sesi_greeting = null;
		
		// Coba ambil dari table sesi dulu
		$this->db->select('trim(part) as part, trim(greeting) as greeting');
		$this->db->where('code', $sesi);
		$this->db->limit(1);
		$get = $this->db->get('sesi');
		
		if ($row = $get->first_row())
		{
			$sesi_part = $row->part == '' ? null : $row->part;
			$sesi_greeting = $row->greeting == '' ? null : $row->greeting;
		}
		
		
		if ($sesi_part === null && $sesi_greeting === null)
		{
			// Ambil nama part (jika ada), dan greeting dari setting kalau dari sesi tidak ditemukan
			$this->db->select('name, value, description');
			$this->db->where_in('name', array('exam_part','exam_greeting'));
			$get = $this->db->get('settings');
			
			foreach ($get->result() as $row)
			{			
				if ($row->name == 'exam_part')
					$data['part'] = $row->value;
				
				if ($row->name == 'exam_greeting')
				{
					if (trim($row->value) != '')
						$data['greeting'] = $this->config->item($row->value);
					elseif (trim($row->description) != '')
						$data['greeting'] = $row->description;
				}
			}
		}
		
		if ($sesi_part !== null)
			$data['part'] = $sesi_part;
		
		if ($sesi_greeting !== null)
			$data['greeting'] = /*$sesi_greeting*/"Selamat mengerjakan";
		
		foreach ($data['arr_quiz'] as $quiz)
		{
			$data['arr_code'][] = $quiz->code;
		}
		
		$template = array(
			'title' => 'Home',
			'body' => $this->load->view('Exam/index_view', $data, true),
			'breadcrumb' => '',
		);
		
		$this->parser->parse('templates/main', $template);
	}

	public function code($code='')
	{
		$this->load->model('setting_model', 'global_setting');
		if ($this->session->userdata('is_user') <= 0) redirect('/');
		
		if ($code == '') redirect('exam');
		
		$this->load->library('parser');
		
		$users_id = $this->session->userdata('id');

		$quiz_setting = $this->global_setting->get_quiz_setting();

		// Check exam code
		if (! $this->users_quiz_model->valid_user_quiz_code($users_id, $code, $quiz_info, $arr_library_code))
		{
			$this->userslog->log('membuka halaman exam code '.$code.' dan tidak memiliki hak akses');
			redirect('exam');
		}
		
		$this->userslog->log('membuka halaman exam code '.$code);
		
		$questions = array();
		$libraries = array();
		$library_views = array();
		
		// Check dulu apakah quiz ini sudah selesai dilaksanakan?
		// Jika sudah maka buang dari $arr_library_code
		$this->load->model('users_quiz_log_model');
		//updating used time
		
		$this->users_quiz_log_model->hanya_yang_belum_selesai($users_id, $arr_library_code);
		
		$has_next_quiz = false;
		$quiz_data = null;
		
		if (count($libraries) > 0)
		{
				$has_next_quiz = true;
		}
        
		foreach ($arr_library_code as $quiz_code => $library_code)
		{
			$quiz_data = array(
				'code' => $quiz_code, 
				'library' => $library_code['library'],
				'sub_library' => $library_code['sub_library'], 
				'label' => $library_code['label'],
				'index' => null,
				'check_id' => null,
        		'validation' => isset($library_code['validation']) ? $library_code['validation'] : null,
			);
			
			foreach($library_code as $key => $value){
				$quiz_data[$key] = $value;
			}
                
            $questions[] = $quiz_data;
			
            // ini di-break karena mulai sekarang hanya menampilkan 1 quiz saja. jika pindah quiz maka reload halaman lagi.
            break;
		}

		$libraries = array_unique($libraries);
        
        if (isset($quiz_data['library']))
        {
            if ($quiz_data['library'] == 'pauli')
            {
                $library_views[] = $this->load->view('Exam/lib_'.$quiz_data['library'].'_view', array(), true);
            }
            else
            {
                $library_view = 'lib_'.$quiz_data['library'].'_view.php';
            }
        }
        else
        {
            $library_view = 'finish_view.php';
        }
        
        // Khusus pauli
        if (count($library_views) > 0)
        {
            $data = array(
                'img_path' => base_url('assets/images/'),
                'main_quiz_code' => $code,
                'main_quiz_title' => $quiz_info['label'],
                'quiz_codes' => $questions, 
                'library_views' => $library_views,
                'back_to_main_menu_url' => site_url('exam'),
                'get_questions_url' => site_url('exam/ajax_get_questions'),
                'ajax_next_test_to_done_url' => site_url('exam/ajax_next_test_to_done'),
                'save_answers_url' => site_url('exam/ajax_save_answers'),
                'save_index_url' => site_url('exam/ajax_save_index'),
            );
		
            $breadcrumb_data = array('items' => array($quiz_info['label']));

			$data['quiz_setting'] = $quiz_setting;
            
            $template = array(
                'title' => 'Home',
                'body' => $this->load->view('Exam/code_view', $data, true), 
                'breadcrumb' => $this->load->view('templates/breadcrumb', $breadcrumb_data, true),
            );
    
            $this->parser->parse('templates/main', $template);
        }
		else
        {
            $data = array(
                'img_path' => base_url('assets/images/'),
                'main_quiz_code' => $code,
                'main_quiz_title' => $quiz_info['label'],
                'quiz_data' => $quiz_data,
                'library_view' => $this->load->view('Exam/jquery/'.$library_view, $quiz_data, true),
                'back_to_main_menu_url' => site_url('exam'),
                'get_questions_url' => site_url('exam/ajax_get_questions'),
				'ajax_next_test_to_done_url' => site_url('exam/ajax_next_test_to_done'),
                'save_answers_url' => site_url('exam/ajax_save_answers'),
                'save_index_url' => site_url('exam/ajax_save_index'),
            );
            
            $breadcrumb_data = array('items' => array($quiz_info['label']));
            
			$data['quiz_setting'] = $quiz_setting;
            $template = array(
                'title' => 'Home',
                'body' => $this->load->view('Exam/jquery/code_view', $data, true), 
                'breadcrumb' => $this->load->view('templates/breadcrumb', $breadcrumb_data, true),
            );
            
            $this->parser->parse('templates/main_jquery', $template);
        }
	}
	
	public function queue()
	{
		header('Content-Type: application/json; charset=UTF8');
		$out = array();
		
		try
		{
			if ($this->session->userdata('is_user') <= 0)
				throw new Exception('Silahkan Login Kembali');
			
			if (! isset($_POST['library'], $_POST['code']))
				throw new Exception('Data yang dikirim tidak lengkap');
			
			$this->load->library('rabbitmqclient');
			
			$data = array(
				'users_id' => $this->session->userdata('id'),
				'key' => $this->session->userdata('userkey'), // sudah tidak dipake tapi tetap dikirim
				'answers' => isset($_POST['answers']) ? $_POST['answers'] : array(),
				'code' => $_POST['code'],
				'done' => isset($_POST['done']) ? $_POST['done'] : 0,
				'id' => isset($_POST['id']) ? $_POST['id'] : '',
				'library' => $_POST['library'],
			);
			
			$status = $this->rabbitmqclient->send($data);
			
			if (! $status) throw new Exception('Terjadi kesalahan saat mengirim jawaban');
			
			$time_end = '';
			
			// langsung update table tanpa harus menunggu queue diproses rabbitmq
			if ($data['done'] == 1)
			{
				$time_end = ', time_end = NOW()';
			}
			
			$seconds_left = $this->input->post('check_id');
			
			$stat = $this->db->query('
			UPDATE 
				users_quiz_log 
			SET 
				`seconds_used` = (seconds - ?), 
				last_update = NOW()
				'.$time_end.'
			WHERE 
				users_id = ? 
				AND 
				quiz_code = ?
			', array(
				$seconds_left, 
				$data['users_id'], 
				$data['code']
				)
			);
			
			$out['success'] = true;
		}
		catch(Exception $e)
		{
			$out['error'] = true;
			$out['msg'] = $e->getMessage();
		}
		
		echo json_encode($out);
	}
	
	public function queue_test()
	{
		$this->session->set_userdata('is_user', 1);
		$this->session->set_userdata('id', 1);
		$this->session->set_userdata('userkey', 1);
		
		$this->queue();
		
		$this->session->sess_destroy();
	}

	// This is modified code for testing
			private function _qtest_ambil_soal_tersimpan($code, $users_id, &$is_tutorial, &$json, &$index)
			{
					if ($is_tutorial == 1 || $is_tutorial == 2){
							return false;   }

					$now = date('Y-m-d H:i:s');
					$this->db->select("`rows`, `index`, (case when seconds > seconds_used then (seconds -

	seconds_used) else 0 end) as seconds_left, seconds", false);
					$this->db->where('quiz_code', $code);
					$this->db->where('users_id', $users_id);

					$get = $this->db->get('users_quiz_log');

					if ($row = $get->first_row())
					{
							$json = json_decode($row->rows, true);
							
							if (isset($json['rows']['no_recalculate_seconds']))
									$json['seconds'] = $row->seconds;
							else
									$json['seconds'] = $row->seconds_left;

							$is_tutorial = 0;
							$index = $row->index;

							return true;
					}
					$get->free_result();
					//$this->db->close();

					return false;
			}

			public function queue_test_get_questions()
			{
					$json = array();
					$is_tutorial = 'false';
					$library_code = 'gti';
					$code = 'gti_pci_r';
					//$users_id = '769701';
					$sampling=array('809461','809465','809469','809473','809477','809481','809485','809489','809493','809497','809501','809505','809509','809513','809517','809521','809525','809529','809533','809537','809541','809545','809549','809553','809557','809561','809565','809569','809573','809577');

			$rand_id=rand(0,29);
			$users_id = $sampling[$rand_id];
					$index = 0;
					try
					{
							$library_name = 'exam_'.$library_code;

							$this->load->library($library_name);

							if (false === $this->_qtest_ambil_soal_tersimpan($code, $users_id, $is_tutorial, $json,

	$index))
							{
									$json = $this->{$library_name}->get_questions_queue_test($code, $is_tutorial, $users_id);
							}


							$json['success'] = true;
							$json['clientkey'] = $this->session->userdata('userkey');
							$json['clientUsername'] = md5($this->session->userdata('username'));
							$json['index'] = $index;
					}
					catch (Exception $e)
					{
							$json['error'] = true;
							$json['msg'] = $e->getMessage();
				}

					header('Content-Type: Application/JSON');
					echo json_encode($json);
			}

			private function _queue_test_get_data()
			{
					$json = array();
					$is_tutorial = 'false';


					$library_code = 'gti';
					$code = 'gti_pci_r';
					$users_id = '769701';
					$index = 0;
					try
					{
							$library_name = 'exam_'.$library_code;

							$this->load->library($library_name);
							$this->load->library($library_name);

							if (false === $this->_qtest_ambil_soal_tersimpan($code, $users_id, $is_tutorial, $json,

	$index))
                        {
                                $json = $this->{$library_name}->get_questions_queue_test($code, $is_tutorial, $users_id);
                        }

                        $json['success'] = true;
                        $json['clientkey'] = $this->session->userdata('userkey');
                        $json['clientUsername'] = md5($this->session->userdata('username'));
                       $json['index'] = $index;
                }
                catch (Exception $e)
                {
                        $json['error'] = true;
                        $json['msg'] = $e->getMessage();
                }


                $json['users_id'] = $users_id;
                header('Content-Type: Application/JSON');
                //return json_encode($json);
                return $json;
        }

       function queue_test_get_and_save(){
                $dbsave = $this->load->database('save', TRUE);
                $dbsave->initialize();

                // Save / Insert data to Queue Test
                $data = $this->_queue_test_get_data();
                //print($data);
                $write_data['seconds'] = $data['seconds'];
                $write_data['opsi_jawaban'] = $data['opsi_jawaban'];
                $write_data['sub_library'] = $data['sub_library'];
                $write_data['success'] = $data['success'];
                $write_data['clientUsername'] = $data['clientUsername'];
                $write_data['index'] = $data['index'];
                $users_id = $data['users_id'];
                $write_data['rows'] = $data['rows'][0];

                $insert_data =  json_encode($write_data);
                $dbsave->set('data', $insert_data);
                $dbsave->set('datetime', date('Y-m-d H:i:s'));

        if (!$dbsave->insert('queue_test'))
           {
              throw new Exception('Unknown Error. Gagal Tambah Data Queue Test');
           }else{
              echo "Queue Test : Data Retrieved and Saved to Database.";
           }

                // Insert ke Log sebagai activity
                $dbsave->set('time', 'NOW()', false);
                $code = rand(1000,2000);
                $action = 'menyimpan jawaban test '.$code;
                $dbsave->set('action', $action);
                $dbsave->set('users_id', $users_id);
                $dbsave->insert('queue_test_users_log');
                // Update ke users agar tau kapan terakhir update
                $dbsave->set('last_update', 'NOW()', false);
                $dbsave->where('id', $users_id);
                $dbsave->update('queue_test_users');


        $dbsave->close();
        }




}
