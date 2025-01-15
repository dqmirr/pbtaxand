<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginUlang extends Ci_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view('LoginUlang/login_ulang_view', []);
	}
}
