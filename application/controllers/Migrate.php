<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
	public function index()
	{
		if (php_sapi_name() !== 'cli')
		{
			redirect('/'); return;
		}
			
		$this->load->library('migration');

		if ($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		}
		
	}
	
	public function rollback($version)
	{
		if (php_sapi_name() !== 'cli')
		{
			redirect('/'); return;
		}
		
		$this->load->library('migration');
		
		$this->migration->version($version);
	}
}
