<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends Ci_Model
{
	public function check_jadwal_login($username)
	{
		$this->db->select('
			case when sesi_custom.code is not null then sesi_custom.time_from else sesi.time_from end as time_from,
			case when sesi_custom.code is not null then sesi_custom.time_to else sesi.time_to end as time_to
		', false);
		$this->db->where('username', $username);
		$this->db->join('formasi', 'formasi.code = users.formasi_code');
		$this->db->join('sesi', 'sesi.code = formasi.sesi_code');
		$this->db->join('sesi as sesi_custom', 'sesi_custom.code = users.sesi_code', 'left');

		$get = $this->db->get('users');
		
		return $get->first_row();
	}
	
	public function save_login_data($username, $data)
	{
		$dbsave = $this->load->database('save', TRUE);
		
		$dbsave->set($data);
		$dbsave->where('username', $username);
		
		$dbsave->update('users');
	}
	
	public function validate($username, $password, &$output = array(), &$error = null)
	{
		$this->db->select("*", true);
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		
		$get = $this->db->get('users');
		
		if ($output = $get->first_row('array'))
		{
			$output['is_user'] = 1;
			
			if (trim(strtolower($output['base_url'])) != strtolower($_SERVER['HTTP_HOST']) && ! empty(trim($output['base_url'])))
			{
				$error = 'Silakan melanjutkan tes Anda dengan klik pada link berikut: <a href="https://'.$output['base_url'].'">https://'.$output['base_url'].'</a>.<br>Gunakan username dan password yang sama.';
				
				return false;
			}
			
			// $update_data = array();
			
			// if (trim($output['sesi_code']) == '')
			// {
			// 	$this->db->select('sesi_code');
			// 	$this->db->where('code', $output['formasi_code']);
			// 	$this->db->limit(1);
			// 	$get = $this->db->get('formasi');
			
			// 	if ($row = $get->first_row('array'))
			// 	{
			// 		// harus diset ke user, karena jika ini dikosongi akan menimbulkan banyak masalah saat query
			// 		$update_data['sesi_code'] = $row['sesi_code'];
			// 	}
			// }
			
			// Kalau userskey kosong, maka update
			if (trim($output['userkey']) == '')
			{
				$userkey = crc32($output['id']).'_'.$output['id'].'_'.strlen($output['username']);
				$update_data['userkey'] = $userkey;
			}
			
			if (count($update_data) > 0)
			{
				$this->db->set($update_data);
				$this->db->where('id', $output['id']);
				$this->db->where('username', $output['username']);
				$stat = $this->db->update('users');
				
				if ($stat)
				{
					foreach ($update_data as $key => $val)
					{
						$output[$key] = $val;
					}
				}
				else
					return false;
			}
			
			return true;
		}
		
		return false;
	}
	
	public function save_session($users_id, $session_name)
	{
		$dbsave = $this->load->database('save', TRUE);
		
		$dbsave->set('users_id', $users_id);
		$dbsave->set('session_name', $session_name);

		$res = $dbsave->get_where('users_sessions', array('users_id'=>$users_id), $limit=1);

		if($res->num_rows() > 0 ) {
		   $this->db->where('users_id',$users_id);
		   $this->db->update('users_sessions',array('session_name'=>$session_name));
		} else {
		   $this->db->set('users_id', $users_id);
		   $this->db->insert('users_sessions',array('session_name'=>$session_name));
		}
		
		return $dbsave->insert('users_sessions');
	}

	public function get_session_by_login($username, $password) {
		
		$get_user = $this->db
						->select('*', true)
						->where('username', $username)
						->where('password', $password)
						->get('users')
					->row();
        return $get_user;
	}

	public function get_users_by_session($session){
		$this->db->select('*', true);
		$this->db->where('active_session_id', $session);

		$get = $this->db->get('users');
		return $get->result();
	}
	
	public function get_sessions($users_id, $current_session)
	{
		$this->db->select('session_name');
		$this->db->where('users_id', $users_id);
		$this->db->where('session_name !=', $current_session);
		
		$get = $this->db->get('users_sessions');
		
		return $get->result();
	}
	
	public function delete_saved_session($users_id, $session_name)
	{
		$this->db->where('users_id', $users_id);
		$this->db->where('session_name', $session_name);
		
		return $this->db->delete('users_sessions');
	}

	//Faisal, ubah isi di kolom session_name jadi NULL
	public function session_logout($users_id){
		$dbsave = $this->load->database('save', TRUE);

		$dbsave->set('session_name', 'NULL', false);
		$dbsave->where('users_id', $users_id);
		return $dbsave->update('users_sessions');
	}

	//Faisal, cek sudah login belum
	public function session_check($users_id){
		$res = $this->db->get_where('users_sessions', array('users_id'=>$users_id), $limit=1);
		if($res->num_rows() > 0 ) {
			$row = $res->row(); 
			if($row->session_name!=NULL){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
}
