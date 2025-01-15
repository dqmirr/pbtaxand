<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Prince\Prince;

class CI_Prince
{

	private $config;

	private $prince;

	public function __construct() {
		$this->ci =& get_instance();
		$this->config = array(
			'bin' => '/usr/local/bin/prince',
			'log_path' => '/Applications/XAMPP/xamppfiles/htdocs/pbtaxand/log/prince/log.txt'
		);
	}

	public function run()
	{
		$this->prince = new Prince($this->config['bin']);
		$this->prepareConfig();

		$path_input = APPPATH.'/views/index.html';
		$path_output = APPPATH.'/views/index.pdf';
		$output = $this->prince->convert_file_to_file($path_input, $path_output);
	}

	public function prepareConfig() {
		if(empty($this->prince)){
			throw "Prince not have instance";
		}

		$this->prince->setLog($this->config['log_path']);
	}

	public function addStylesheet($path)
	{
		$this->prince
		->addStyleSheet($path);
	}

	public function addScript($path)
	{
		$this->prince
		->addScript($path)
		->setJavaScript(true);
	}

	public function convertFile($path)
	{
		$this->prince->convertFile($path);
	}
}
