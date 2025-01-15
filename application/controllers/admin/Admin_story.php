<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_story extends Ci_Controller {

	protected $admin_url;
	public function __construct()
	{
		parent::__construct();

		$target = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['SERVER_ADDR'];

		if (! in_array($target, $this->config->item('admin_allow_host')))
			die('Method Not Allowed');

		$this->load->database();
		$this->load->library('template/Template_admin','', 'template_admin');
		$this->load->library('grocery_CRUD');
		$this->load->library('parser');
		$this->admin_url = $this->uri->segment(1);
		
		if ($this->session->userdata('is_admin'))
		{
			$this->session->set_userdata('admin_controller', $this->admin_url);
		}

	}

	public function index($library){
		// $library = 'multiplechoice';
		/**
		 * 
		 * list_jenis_soal = [
		 * 	[
		 * 		"no" => 1,
		 * 		"code" => 'accounting_junior', 
		 * 		"label" => 'Accounting Junior', 
		 * 	]
		 * ] 
		 * 
		 */
		$crud = new grocery_CRUD();
		$jenis_soal = $this->input->get('jenis-soal');

		switch($library){
			case 'multiplechoice':
				$this->load->model('Multiplechoice_model', 'multiplechoice');

				$crud->unset_export();
				$crud->unset_print();
				$crud->unset_read();
				$crud->unset_back_to_list();
		
				$crud->set_table('multiplechoice_story');
				$crud->set_subject('Story');
				$crud->columns('code','story');
				break;
			default:
				$list_jenis_soal = array();
				break;
		}
		$output = $crud->render();
		$this->_generate_output("Story", $output);
	}

	// public function story(){
	// 	$this->load->model('Multiplechoice_model', 'm_model');
		
	// 	$story = $this->m_model->get_story_all();
	// 	$list = array(); 
		
	// 	foreach($story["data"] as $key => $item){
	// 		array_push($list,array(
	// 			'key' => $key+=1, 
	// 			'code' => $item['code'], 
	// 			'story' => $item['story']));
	// 	}

	// 	$data = array(
	// 		'list_head' => ["No","Code", "Story", "View Soal"],
	// 		'list' => $list,
	// 	);
	// 	$this->_gen_output("Admin/story/main_view", $data);
	// }

	// private function _gen_output($view_path,$output = null)
	// { 
	// 	$title = "Story";
	// 	$this->template->render($title, $view_path, (array) $output);  
	// }
	private function _generate_output($title, $output = null, $header = '')
	{ 
		$template = array(
			'title' => $title,
			'body' => $header . $this->load->view('Admin/choice/output_view', (array) $output, true),
			'report_url' => $this->report_url,
		);
		
		$this->parser->parse('templates/admin', $template);  
	}

}
