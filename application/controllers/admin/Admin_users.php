<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends CI_Controller
{
    private $admin_url;
    private $base;
    public function __construct()
    {
        parent::__construct();
        $this->load_help();

        $target = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['SERVER_ADDR'];
        if(!in_array($target, $this->config->item('admin_allow_host'))) {
            die('Method Not Allowed');
        } else {
            $this->admin_url = $this->uri->segment(1);
            $this->base = base_url($this->admin_url);
            if($this->session->userdata('is_admin') <= 0) {
                $res['message'] = 'Session Berakhir';
                $res['redirect'] = $this->base.'/login';
                alert_js($res);
                die();
            } else {
                $this->session->set_userdata('admin_controller', $this->admin_url);
            }
        }

        $this->load_model();
        $this->load_lib();
    }

    private function load_help()
    {
        $help = array('view_helper');
        $this->load->helper($help);
    }

    private function load_model()
    {

    }

    private function load_lib()
    {

    }

    public function index()
    {
        $res['status'] = $this->admin_url;
        json_view($res);
    }

}
?>