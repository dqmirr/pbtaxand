<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_soal extends CI_Controller
{
	private $admin_url;
    private $base;
	private $libraries_soal;
	private $cors = array(
		"http://localhost:3000"
	);
    public function __construct()
    {
		parent::__construct();
        $help = array('view_helper',
            'time_helper',
            'sesi_helper');
        $this->load->helper($help);

		$domains = implode( ', ', $this->cors );
		header('Access-Control-Allow-Origin: '.$domains, true);
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
		header('Access-Control-Allow-Credentials: *');
		if ("OPTIONS" === $_SERVER['REQUEST_METHOD'] ) {
			die();
		}

		$this->libraries_soal = array(
			'multiplechoice'
		);
		$this->load->database();
        $lib = array('form_validation','help');
        $this->load->library($lib);
    }

	function list_soal(){
		$arg_list = func_get_args();
		$response = array(
			"status" => "ok",
		);
		if(count($arg_list) < 0){
			$response["data"] = [];
			$response["message"] = "please input library";
			$this->output_json($response);
		}
		$library = $arg_list[0];

		switch($library){
			case 'multiplechoice':
				$this->load->model('Multiplechoice_model', 'multiplechoice');
		
				$filters = array(
					'pagination' => (integer) $this->input->get('pagination', true),
					'page' => (integer) $this->input->get('page', true),
				);

				if($this->input->get('jenis_soal')){
					$filters['jenis_soal'] = $this->input->get('jenis_soal');
				}

				if($this->input->get('soal')){
					$filters['soal'] = $this->input->get('soal');
				}
		
				$soal = $this->multiplechoice->get_soal($filters);
				$data = $this->handleListSoal($soal["list"]);
		
				$response["data"] = $data;
				$response["meta"] = (object) array(
						"total" => $soal["total"]
				);
				break;
				
			default:
				$response["data"] = [];
				$response["message"] = 'not available';
				$response["meta"] = (object) array(
					'total' => 0,
					'libraries' => $this->libraries_soal
				);
				break;
		}

		
		$this->output_json($response);
	}

	public function list_library(){
		$response = array(
			"status" => "ok",
			"data" => $this->libraries_soal,
			"meta" => (object) array(
				"total" => count($this->libraries_soal),
			)
		);
		$this->output_json($response);
	}

	public function list_jenis_soal(){
		$this->load->model('Multiplechoice_model', 'multiplechoice');

		$jenis_soal = $this->multiplechoice->get_jenis_soal();

		$response = array(
			"status" => "ok",
			"data" => $jenis_soal,
			"meta" => (object) array(
				"total" => count($jenis_soal)
			)
		);
		$this->output_json($response);
	}

	private function handleListSoal($list = []){
		$this->load->model('Table_multi_choice', 'choices');
		$res = array();
		
		foreach($list as $key => $val){
			$choices = $this->choices->choice_by_multiplechoices_id($val[id]);
			array_push($res,(object) array(
				"id" => $val["id"],
				"soal" => $val["question"],
				"jawabanBenar" => $val["jawaban"],
				"choices" => $choices
			));
		}
		return $res;
	}

	private function output_json($response){
		$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
		exit;
	}

}
