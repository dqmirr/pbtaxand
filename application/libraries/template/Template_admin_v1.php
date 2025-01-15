<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_admin_v1 {
	protected $CI;
	protected $head;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->head = json_decode('{
			"css":[
				{"href": "assets/css/bootstrap.min.css"},
				{"href": "assets/css/open-iconic-bootstrap.min.css"},
				{"href": "assets/css/tempusdominus-bootstrap-4.min.css"},
				{"href": "assets/css/styles.css"}
			],
			"js":[
				{"src": "assets/js/jquery-3.2.1.min.js"},
				{"src": "assets/js/angular.min.js"},
				{"src": "assets/js/Chart.bundle.min.js"},
				{"src": "assets/js/Chart.PieceLabel.min.js"},
				{"src": "assets/js/chartjs-plugin-datalabels.min.js"}
			]
		}', true);
	 
	}

	public function render($title, $view_path, $data = array()){
		$head_assets_css = '';
		$head_assets_js = '';
		foreach($this->head as $key=>$item){
			switch($key){
				case "css":
					foreach($this->head[$key] as $val_css){
						$link = base_url($val_css["href"]);
						$head_assets_css .= '<link rel="stylesheet" href="'.$link.'" />';
					}
					break;
				case "js":
					foreach($this->head[$key] as $val_js){
						$link = base_url($val_js["src"]);
						$head_assets_js .= '<script src="'.$link.'"></script>';
					}
			}
			
		}
		$header_path = 'templates/admin_template_v1/header';
		$footer_path = 'templates/admin_template_v1/footer';
		$body_path = 'templates/admin_template_v1/body';
		$this->CI->load->view($header_path, array(
			'head_assets_css' => $head_assets_css,
			'head_assets_js' => $head_assets_js,
			'title' => $title
		));
		$this->CI->load->view($body_path, array(
			'body'=> $this->CI->load->view($view_path, $data, true)
		));
		$this->CI->load->view($footer_path, array());
		
	}
}
?>
