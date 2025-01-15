<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends Ci_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_admin') == true) redirect($this->session->userdata('admin_controller'));
	}
	
	public function index()
	{
		if ($this->session->userdata('is_user') > 0)
		{
			redirect('exam');
		}
		else
		{
			$this->load->database();
			
			$query = $this->db->query("SELECT name, value, description FROM settings WHERE name in ('survey_mode', 'login_info')");
			$rows = $query->result();
			
			$data = array();
			$data['survey_mode'] = 0;
			
			foreach ($rows as $row)
			{
				switch ($row->name)
				{
					case 'survey_mode':
						$data['survey_mode'] = (isset($row->value) && $row->value == 1) ? 1 : 0;
					break;
					
					case 'login_info':
						$data['login_info'] = array('value' => $row->value, 'description' => $row->description);
					break;
				}
			}
			
			$data['login_url'] = site_url('auth/ajax_auth');
			$data['btn_class'] = 'btn-primary';
			
			$this->load->view('Page/index_view', $data);
		}
	}
	
	public function disclaimer()
	{
		$this->load->database();
		$this->load->library('parser');
		$this->load->model('disclaimer_model');
		if ($this->session->userdata('is_user') <= 0) redirect('exam');
		
		// if ($this->session->userdata('agree_code') != '') redirect('exam');
		if ($this->disclaimer_model->validate_gco_policy($this->session->userdata('id'))) redirect('exam');
		
		
		$upload_foto_required = true;
		$survey_mode = 0;
		$disclaimer_text = null;
		$disclaimer_survey_text = null;
		
		// Check ke setting, apakah perlu upload foto?
		/*
		$this->db->select('value');
		$this->db->where('name', 'disable_photo_upload');
		$this->db->where('value', 1);
		$get = $this->db->get('settings');
		
		if ($row = $get->first_row())
			$upload_foto_required = false;
		*/
		
		$this->db->select('name, value, description');
		$this->db->where_in('name', array('disable_photo_upload', 'survey_mode', 'disclaimer', 'disclaimer_survey','petunjuk_dan_ketentuan'));
		$get = $this->db->get('settings');
										

		$sql_policy = $this->disclaimer_model->get_gco_policy($this->session->userdata('id'));

		if($sql_policy->num_rows() <= 0){
			$this->disclaimer_model->insert_gco_policy($this->session->userdata('id'));
			$sql_policy = $this->disclaimer_model->get_gco_policy($this->session->userdata('id'));
			$sql_policy->result();
		}

		$list_policy = $sql_policy->result();
		
		foreach ($get->result() as $row)
		{
			switch ($row->name)
			{
				case 'disable_photo_upload':
					if ($row->value == 1)
						$upload_foto_required = false;
				break;
				
				case 'survey_mode':
					$survey_mode = $row->value;
				break;
				
				case 'disclaimer':
					$disclaimer_text = $row->description;
				break;
				
				case 'disclaimer_survey':
					$disclaimer_survey_text = $row->description;
				break;

				case 'petunjuk_dan_ketentuan':
					$PETUNJUK_TEXT = array(
						'header' => $row->value,
						'content' => $row->description
					);
				break;
			}
		}
		
		$DISCLAIMER_TEXT = $this->config->item('app_disclaimer');
		
		if ($survey_mode == 1 && $disclaimer_survey_text !== null)
		{
			$DISCLAIMER_TEXT = $disclaimer_survey_text;
		}
		elseif ($disclaimer_text !== null)
		{
			$DISCLAIMER_TEXT = $disclaimer_text;
		}
		
		if ($_POST)
		{
			// $agree_code = $this->input->post('text_setuju');
			$pic = $this->input->post('pic');
			$list_unchecked = array();
			$list_checked = array();
			foreach($list_policy as $row){
				$select = $this->input->post($row->value);
				if($select == "on"){
					array_push($list_checked, intval($row->value));
				}else{
					array_push($list_unchecked, intval($row->value));
				}
			}
			
			if(count($list_unchecked)>0){
				$this->disclaimer_model->set_unchecked_gco_policy(
					$this->session->userdata('id'),
					$list_unchecked
				);

				$this->session->set_flashdata("warning", "Mohon untuk menyetujui semua kebijakan");
			}

			if(count($list_checked) > 0){
				$this->disclaimer_model->set_checked_gco_policy(
					$this->session->userdata('id'),
					$list_checked
				);
			}

			if ($this->disclaimer_model->validate_gco_policy($this->session->userdata('id')))
			{
				$agree_code = $this->session->userdata('disclaimer');

				if ($upload_foto_required)
				{
					if ($pic == '')
					{
						echo 'Foto harus diupload. <a href="'.site_url('page/disclaimer').'">Kembali</a>';
						return;
					}
					
					$users_id = $this->session->userdata('id');
					$hashed_users_id = sha1($users_id);
					$pic_img = str_replace('data:image/jpeg;base64,', '', $pic);
					$hashed_agree_code = sha1($agree_code);
					
					// Langsung disimpan sebagai JPEG
					file_put_contents("assets/photos-483900492049403949939392010/{$hashed_agree_code}_{$hashed_users_id}.jpg", base64_decode($pic_img));

					/*
					// Menggunakan PHP GD
					$image = imagecreatefromstring(base64_decode($pic_img));
					$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
					imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
					imagealphablending($bg, TRUE);
					imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
					imagedestroy($image);
					$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
					imagejpeg($bg, "assets/photos-483900492049403949939392010/{$hashed_agree_code}_{$hashed_users_id}.jpg", $quality);
					imagedestroy($bg);
					
					// Menggunakan Imagick
					try {
						$img = new Imagick();
						$decoded = base64_decode($pic_img);
						$img->readimageblob($decoded);
						$img->setImageBackgroundColor('white');
						$img = $img->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
						
						$img->setImageFormat('jpg');
						$img->setImageCompressionQuality(85);
						$img->writeImage("assets/photos-483900492049403949939392010/{$hashed_agree_code}_{$hashed_users_id}.jpg");
					}
					catch (ImagickException $e) 
					{
						var_dump($e);
						return;
					}
					*/
				}
				
				$this->load->model('users_model');
				
				$time = date('Y-m-d H:i:s');
				
				$data = array(
					'agree_code' => $agree_code,
					'agree_time' => $time,
				);
				
				$ok = $this->users_model->update($this->session->userdata('username'), $data);
				


				if ($ok)
				{
					$this->session->set_userdata('agree_code', $agree_code);
					$this->session->set_userdata('agree_time', $time);
					$list_gco_policy = $this->disclaimer_model->get_gco_policy($this->session->userdata('id'))->result();
					$text_gco_policy = "";
					$count_text_policy = 0;
					foreach($list_gco_policy as $row){
						if($row->is_checked){
							$text_gco_policy .= $row->value.". ".$row->text."\n";
							$count_text_policy++;
						}
					}
					$this->userslog->log('menyetujui disclaimer dengan aturan: '.$text_gco_policy);
					
					redirect('exam');
				}
				else
				{
					$this->userslog->log('terjadi kesalahan saat menyimpan persetujuan discalimer ke database');
				}
			}
			else
			{
				$unchecked_gco_policy = $this->disclaimer_model->show_unchecked_gco_policy($this->session->userdata('id'));
				$text_error = "";
				foreach ( $unchecked_gco_policy as $row){
					$text_error .= $row->text."\n";
				}

				$sql_policy = $this->disclaimer_model->get_gco_policy($this->session->userdata('id'));
				$list_policy = $sql_policy->result();
				$this->userslog->log('persetujuan disclaimer tidak valid, ada beberapa data yang harus disetujui: '.$text_error);
			}
		}
		
		$this->userslog->log('membuka halaman disclaimer');
		
		$arr_pattern = array();
		$arr_replace = array();
		
		foreach ($this->session->userdata() as $key => $val)
		{
			$arr_pattern[] = '/{SESSION_'.$key.'}/';
			$arr_replace[] = $val;
		}
		
		$arr_pattern[] = '/{CONFIG_app_name}/';
		$arr_replace[] = $this->config->item('app_name');
		
		$data = array(
			'target_url' => site_url('page/disclaimer'),
			'harus_upload_foto' => $upload_foto_required,
			'disclaimer_text' => preg_replace($arr_pattern, $arr_replace, $DISCLAIMER_TEXT),
			'petunjuk_text' => $PETUNJUK_TEXT,
			'list_policy' => $list_policy
		);
		
		$template = array(
			'title' => 'Disclaimer',
			'body' => $this->load->view('Page/disclaimer_view', $data, true),
			'breadcrumb' => '',
		);
		
		$this->parser->parse('templates/main_jquery', $template);
	}
}
