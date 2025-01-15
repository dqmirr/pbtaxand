<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require('./../Admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b');

class Admin_generate extends Ci_Controller {
	
	protected $parent_url;

	protected $admin_url;
	protected $base;

	private $create_template = array(
		'library'=>'multiplechoice'
	);
	
  	public function __construct()
	{
      parent::__construct();
        
	  $this->admin_url = $this->uri->segment(1);
	  $this->base = base_url($this->admin_url);
		if($this->session->userdata('is_admin') <= 0) {
			$res['message'] = 'Session Berakhir';
			$res['redirect'] = $this->base.'/login';
			alert_js($res);
			die();
		} else {
			$this->session->set_userdata('admin_controller', $this->admin_url);
			$this->load->helper(array(
				'html_helper',
				'case_helper',
				'generate_helper',
				'view_helper',
				'time_helper'
			));
			$this->load->library('template/Template_admin');
			$this->load->database();
			$this->load->model('Generate_exam_mdl');
			
			$this->admin_url = $this->uri->segment(1);
		}
    
        // $dir_mdl = '../../../models/';
        // $model = array('admin_quiz_mdl',
        //     $dir_mdl.'table_quiz',
        //     $dir_mdl.'table_library',
        //     $dir_mdl.'table_group_quiz');
        // $this->load->model($model);
		// $this->admin_url = $admin_url;
	}

	private function data_default()
    {
        $sess = $this->session->userdata();
        $dt_view['session'] = $this->help->set_return_session($sess);
        $dt_view['nav'] = nav_data('formasi');
        return $dt_view;
    }

	public function index()
	{

		$this->is_admin();

		$parent_url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
		$this->parent_url = $parent_url;


		$list_jenis_soal = $this->Generate_exam_mdl->get_list_jenis_soal();

		$dt_view = array(
			'list_jenis_soal' => []
		);

		foreach( $list_jenis_soal as $record){
			array_push(
				$dt_view['list_jenis_soal'],
				array(
					'jenis_soal' => ucwords(str_replace("_"," ",$record['jenis_soal'])),
					'link' => base_url($parent_url."/detail/".$record['jenis_soal'])
				)
			);
		};

		$this->_generate_output("Admin/generate_exam/main_view",$dt_view);
	}

	public function create_template(){
		$dt_view = array();
		// $dt_view = $this->data_default();
		$list_quiz = $this->get_quiz();
		$list_library = $this->get_library();
		$dt_view['list_quiz'] = $list_quiz;
		$dt_view['list_library'] = $list_library;
		$dt_view['available_library'] = array('multiplechoice');
		$dt_view['library'] = $this->create_template['library'];
		$current_path = '/soal/generate_exam';
		$dt_view['url_create_template_rule'] = base_url().$this->admin_url.$current_path.'/ajax_create_template_rule';

		$this->load->view("Admin/generate_exam/create_template_grid",$dt_view);
	}

	private function get_quiz(){
		$this->load->model("Table_quiz");
		
		$options = array(
			'page' => 1,
		);

		if($this->input->get('library')){
			$this->create_template['library'] = $this->input->get('library');
		}
		
		if($this->create_template['library']){
			$options['library'] = $this->create_template['library'];
		}

		return $this->Table_quiz->get_all($options);
	}

	private function get_library()
	{
		$this->load->model('Table_library');

		$list_library = $this->Table_library->get_all();

		foreach($list_library['data'] as $key => $data){
			$data['selected'] = $data['code'] == $this->create_template['library'];
			$list_library['data'][$key] = $data;
		}
		return $list_library;
	}

	public function ajax_create_template_rule(){
		$this->is_admin();
		$quiz_code = $this->input->get('code');
		$data = array();
		if($quiz_code){
			$data['list'] = $this->Generate_exam_mdl->get_list_data($quiz_code);
		}
		$this->output_json((object) array(
			'status' => 'OK',
			'data' => $data,
			'next_url' => base_url($parent_url.'/generate_paket_soal'),
			'message' => 'Berhasil generate soal'
		),200);

		exit();
	}

	public function detail(){
		$this->is_admin();
		$jenis_soal = $this->uri->segment(5);
		$parent_url = $this->uri->segment(1);
		
		$this->load->model('Table_quiz_paket');

		$list_data = $this->Generate_exam_mdl->get_list_data($jenis_soal);
		$total_paket = $this->Table_quiz_paket->get_count_by_quiz_code($jenis_soal);

		$dt_view = array(
			'header'=> $jenis_soal,
			'get_modal_soal'=> base_url($parent_url.'/soal/generate_exam/ajax_generate_soal'),
			'list_data' => $list_data,
			'link_save_generate' => base_url($parent_url.'/soal/generate_exam/ajax_save_generate'),
			'total_paket_soal' => $total_paket['data']['count'],
			'ajax_update_all_generate' => base_url($parent_url.'/soal/generate_exam/ajax_update_all_generate')
		);

		$this->_generate_output("Admin/generate_exam/detail_view",$dt_view);
	}

	public function ajax_save_generate(){
		// untuk menyimpan setting generate
		$this->is_admin();
		$parent_url = $this->uri->segment(1);
		$request = $this->input->post('result');

		if($request){
			$save = $this->Generate_exam_mdl->save_generate($request);
		}

		$this->output_json((object) array(
			'status' => 'ok',
			'data' => null,
			'message' => $save['message']
		),200);
		exit;
	}

	public function ajax_generate_soal()
	{
		$this->is_admin();
		$parent_url = $this->uri->segment(1);

		if(!isset($_POST['options']))
		{
			$this->output_json((object) array(
				'status'=> 'ERROR_OPTIONS',
				'message'=> "error options not define"
			),400);
		}

		$list_question = array();
		$options = $_POST['options'];

		$list_generated_soal = $this->Generate_exam_mdl->list_generated_soal($options);

		$this->output_json((object) array(
			'status' => 'OK',
			'data' => $list_generated_soal,
			'next_url' => base_url($parent_url.'/generate_paket_soal'),
			'message' => 'Berhasil generate soal'
		),200);
		exit;
	}

	public function ajax_update_all_generate(){
		$this->is_admin();
		$parent_url = $this->uri->segment(1);

		$options = $this->input->post('options');

		$quiz_code = $this->input->post('quiz_code');
		if(!$options)
		{
			$this->output_json((object) array(
				'status'=> 'ERROR_OPTIONS',
				'message'=> "error options not define"
			),400);
		}

		$update = $this->Generate_exam_mdl->update_all_generated_soal($options,$quiz_code);

		$this->output_json((object) array(
			'status' => 'OK',
			'data' => $update,
			'message' => 'Berhasil resolve semua generate soal'
		),200);
		exit;
	}

	private function _generate_output($view_path,$output = null)
	{ 
		$title = "Generate Exam Config";
		$this->template_admin->render($title, $view_path, (array) $output);  
	}

	private function is_admin(){
		if ($this->session->userdata('is_admin') <= 0) {
			redirect($this->admin_url.'/login');
        }
	}

	private function output_json($response, $status_code){
		$this->output
        	->set_status_header($status_code)
        	->set_content_type('application/json', 'utf-8')
        	->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
        	->_display();
	}
}
