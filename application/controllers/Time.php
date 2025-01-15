<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Time extends Ci_Controller {

	function index(){
		while(true){
			$time = date('r');
			$output="data: {$time}\n\n";
			$this->output->set_content_type('text/event-stream')->_display($output);
			$this->output->set_header('Cache-Control: no-cache');

			ob_end_flush();     // Strange behaviour, will not work
			flush();            // Unless both are called !
		
			// Wait one second.
			sleep(1);
		}
	}

}
