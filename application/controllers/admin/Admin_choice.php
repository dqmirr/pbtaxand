<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_choice extends Ci_Controller {

	private $multiplechoice_id;

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
	}

	public function index($multiplechoice_id)
	{
	
		if ($this->session->userdata('is_admin') <= 0)
			redirect($this->admin_url.'/login');
			
		$crud = new grocery_CRUD();

		$this->multiplechoice_id = $multiplechoice_id;
		$crud->unset_export();
		$crud->unset_print();
		$crud->unset_read();

		$crud->where('multiplechoice_question_id', $multiplechoice_id);
		$crud->set_table('multiplechoice_choices');
		$crud->set_subject('Choice');
		$crud->columns('multiplechoice_question_id','choice', 'label');

		$crud->callback_field('multiplechoice_question_id',array($this,'field_m_question_id'));


		$output = $crud->render();
		$this->_generate_output("Choice", $output);
	}

	public function field_m_question_id($value = '', $primary_key = null, $obj){
		$value = $this->multiplechoice_id;
		return '<input type="text" maxlength="50" value="'.$value.'" name="'.$obj->name.'" style="width:462px">';
	}

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
