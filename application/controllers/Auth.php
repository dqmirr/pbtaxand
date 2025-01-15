<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Ci_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('cookie');
	}
	
	public function ajax_auth()
	{
		$json = array();
		
		try
		{
			$this->load->model('auth_model');

			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			$ci_session = $_COOKIE['ci_session'];

			
			if ($this->auth_model->validate($username, $password, $output, $error))
			{
				// Check active_session_id
				$users_by_session = $this->auth_model->get_users_by_session($ci_session);
				if(count($users_by_session) > 0 && $this->config->item('sess_driver') == 'files'){
					$this->check_session_active($users_by_session[0]);
				}

                if ($output['active_session_id'] != '' && $this->config->item('sess_driver') == 'files')
                {
					$this->check_session_active((object) $output);
                }
                
                $output['current_session_id'] = session_id();
                
				$this->session->set_userdata($output);
				$this->userslog->log('login');
				$redirect = site_url('exam');
			}
			else
			{
				if ($error !== null)
				{
					throw new Exception($error);
				}
				
				throw new Exception('Cek kembali email dan password anda.');
			}
			
			$time = date('Y-m-d H:i:s');
			
			$data_login = array('last_login' => $time, 'active_session_id' => $output['current_session_id']);
			
			if ($output['first_login'] == '')
			{
				$data_login['first_login'] = $data_login['last_login'];
				
				$this->userslog->log('login pertama kali');
			}
			
			$this->auth_model->save_login_data($username, $data_login);
			
			$jadwal_login = $this->auth_model->check_jadwal_login($username);
			
			if (! $jadwal_login)
			{
				$this->ajax_logout(true);
				throw new Exception('Anda belum memiliki jadwal ujian.');
			}
			
			if ($time < $jadwal_login->time_from || $time > $jadwal_login->time_to)
			{
				$this->ajax_logout(true);
				throw new Exception('Saat ini bukan jadwal ujian Anda.');
			}
			else
			{
				//Faisal, Disini, cek jika sudah login ditempat lain
				if(!$this->auth_model->session_check($output['id'])){
					$this->ajax_logout(true, $default=false);
					//$this->session->sess_destroy();
					$json['ganda']=true;
					throw new Exception('Anda sudah login di tempat lain. Mohon logout terlebih dahulu');
				}

				$this->session->set_userdata('time_from', $jadwal_login->time_from);
				$this->session->set_userdata('time_to', $jadwal_login->time_to);

				// Faisal, simpan ci_session di tabel users_sessions
				$this->auth_model->save_session($output['id'], $_COOKIE['ci_session']);
			}
			
			// Get saved sessions
			$sessions = $this->auth_model->get_sessions($output['id'], $_COOKIE['ci_session']);
			
			if (count($sessions) > 0)
			{
				$redisClient = new Redis();
				$redisClient->connect('redis', 6379 );
			
				foreach ($sessions as $sname)
				{
					$redisClient->delete('ci_session:'.$sname->session_name);
					
					if (method_exists($redisClient, 'unlink'))
					{
						$redisClient->unlink('ci_session:'.$sname->session_name);
					}
					
					$this->auth_model->delete_saved_session($output['id'], $sname->session_name);
				}
			}
			
			// Save Session
			$this->auth_model->save_session($output['id'], $_COOKIE['ci_session']);
		//	
			
			if ($output['agree_code'] == '')
			{
				$text = 'setuju';
				$disclaimer = '';
				
				for ($i=0; $i<strlen($text); $i++)
				{
					if (rand(0,1))
						$disclaimer .= strtoupper($text[$i]);
					else
						$disclaimer .= $text[$i];
				}
				
				$this->session->set_userdata('disclaimer', $disclaimer);
				$redirect = site_url('page/disclaimer');
			}
			
			$json['redirect'] = $redirect;
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
	
	public function ajax_logout($no_return=false, $default=true)
	{
		if (! $this->session->userdata('username'))
		{
			$json = array('success'=>true, 'redirect'=>site_url('/'));
			
			header('Content-Type: Application/JSON');
			echo json_encode($json);
			return;
		}
		
		$this->load->model('auth_model');
		$this->auth_model->save_login_data($this->session->userdata('username'), array('active_session_id' => null, 'last_logout' => date('Y-m-d H:i:s')));

		//Delete all cookies
		foreach($_COOKIE as $key=>$value){
			delete_cookie($key);
		}
		
		$this->userslog->log('logout');

		if($default==true){
			$this->auth_model->session_logout($this->session->userdata('id'));
			$this->session->sess_destroy();		
		}
		$this->session->sess_destroy();
		
		if ($no_return==false)
		{
			$json = array('success'=>true, 'redirect'=>site_url('/'));
			
			echo json_encode($json);
		}
	}

	public function ajax_is_valid_session(){
		$requst_body = json_decode(file_get_contents('php://input'),true); 
		$session_user_client = $requst_body["session_user"];
		$session_user_server = md5($this->session->userdata('username'));
		
		$is_session_valid = true;
		

		if ($session_user_client != $session_user_server)
		{
			$is_session_valid = false;
		}

		$json = array(
			'success'=>true, 
			'client' => $session_user_client,
			'server' => $session_user_server,
			'isSessionValid'=> $is_session_valid,
			'redirect'=>site_url('/loginulang')
		);
		
		header('Content-Type: Application/Json');
		echo json_encode($json);
		exit;
	
	}

	private function check_session_active($users){

		$kick = $this->input->post('kick') == 1 ? true : false;

		$users_id = $users->id;
		$active_session_id = $users->active_session_id;
		$session_id = $this->session->userdata('id');
		// Load Session
		$prefix = $this->config->item('sess_cookie_name');
                    
		$session_path = ini_get('session.save_path');
		$session_file = rtrim($session_path).'/'.$prefix.$active_session_id;
		
		
		if (file_exists($session_file))
		{
			$content = file_get_contents($session_file);
			session_decode($content);
			
			if (isset($session_id) && $users_id == $session_id && $kick === false)
			{
				session_destroy();
				
				header('Content-Type: Application/JSON');
				$json['error'] = true;
				$json['msg'] = 'Masih ada session yang sedang aktif. Jika ingin tetap melanjutkan login, maka session yang sedang aktif akan dinon-aktifkan. Tekan <a href="javascript:void(0)" onclick="kick_session()">di sini</a> untuk melanjutkan.';
				
				echo json_encode($json);
				exit;
			}
			else if (isset($session_id) && $users_id == $session_id)
			{
				unlink($session_file);
			}
		}
	}
}
