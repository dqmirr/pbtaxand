<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_admin {
	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('parser');
		$this->CI->load->helper('html_helper');
		$this->CI->load->helper('url');

	}

	public function render($title = "", $view_path = "", $output= array()){

		$template_path = "/templates/admin_generate";

		$stylesheets = array(
			array('link' => base_url('assets/css/bootstrap.min.css')),
			array('link' => base_url('assets/css/open-iconic-bootstrap.min.css')),
			array('link' => base_url('assets/css/tempusdominus-bootstrap-4.min.css')),
			array('link' => "https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"),
			array('link' => base_url('assets/css/datatable_custom.css')),
			array('link' => base_url('assets/css/styles.css'))
		);

		// if(in_array('stylesheets',$output) && is_array($output['stylesheets']))
		// {
		// 	foreach($output['stylesheets'] as $record){
		// 		if(is_array($record) && in_array('link', $record)){
		// 			array_push($stylesheets,array('link'=> $record['link']));
		// 		}
		// 	}
		// }

		$javascripts = array(
			array('src'=> base_url('assets/js/jquery-3.2.1.min.js')),
			array('src'=> base_url('assets/js/angular.min.js')),
			array('src'=> base_url('assets/js/Chart.bundle.min.js')),
			array('src'=> base_url('assets/js/Chart.PieceLabel.min.js')),
			array('src'=> base_url('assets/js/chartjs-plugin-datalabels.min.js')),
			array('src'=> "https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js")
		);

		// if(in_array('javascripts',$output) && is_array($output['javascripts']))
		// {
		// 	foreach($output['javascripts'] as $record){
		// 		if(is_array($record) && in_array('link', $record)){
		// 			array_push($javascripts,array('link'=> $record['link']));
		// 		}
		// 	}
		// }
		$template = array(
			'title' => $title,
			'stylesheets' => render_stylesheets($stylesheets),
			'javascripts' => render_javascripts($javascripts),
			'body' => $this->CI->load->view($view_path, (array) $output, true),
		);
		
		$this->CI->parser->parse($template_path, $template);
		// echo "Hello library";
	}
}

?>
