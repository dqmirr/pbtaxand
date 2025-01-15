<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Ajax_formasi extends CI_Controller 
{
    private $admin_url;
	public function __construct()
	{
		parent::__construct();

		$target = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['SERVER_ADDR'];
        if(!in_array($target, $this->config->item('admin_allow_host'))) {
            $res['status'] = false;
            $res['message'] = 'Method Not Allowed';
            echo json_encode($res);
            die();
        } else {
            if($this->session->userdata('is_admin') <= 0) {
                $res['status'] = false;
                $res['message'] = 'Session Not Allowed';
                echo json_encode($res);
                die();
            } else {
                $this->admin_url = $this->uri->segment(1);
                $this->session->set_userdata('admin_controller', $this->admin_url);

                $help = array('view_helper');
                $this->load->helper($help);

                $model = array('Table_sesi');
                $this->load->model($model);
            }
        }
	}

    public function index()
    {
        if($this->session->userdata('is_admin') <= 0) {
			$res['status'] = false;
            $res['message'] = 'Session Not Allowed';
            echo json_encode($res);
            die();
        }
    }

    public function getall_sesi()
    {
        $get = $this->Table_sesi->get_all_without_limit();
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data sesi';
        } else {
            $res = $get;
        }
        echo json_encode($res);
    }
}
?>
