<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Ajax_quiz extends CI_Controller 
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

                $model = array('Admin_quiz_mdl');
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

    public function get_pilihan()
    {
        $id = $this->input->post('id_multi');
        $get = $this->Admin_quiz_mdl->get_pilihan_jawaban($id);
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data pilihan';
        } else {
            $res = $get;
        }
        echo json_encode($res);
    }

    public function submit_pilihan()
    {
        $id = $this->input->post('id');
        $pilihan = $this->input->post('pilihan');
        $label = $this->input->post('label');

        $data = array();
        foreach($pilihan as $key => $val) {
            $data[] = array('choice' => $val,
                'label' => $label[$key]);
        }

        if($data) {
            $submit = $this->proses_submitpilihan($id, $data);
            $res = $submit;
        } else {
            $res['status'] = true;
            $res['message'] = 'Tidak ada data yg disimpan';
            $res['data'] = null;
        }
        echo json_encode($res);
    }

    function proses_submitpilihan($id, $data)
    {
        $reset = $this->Admin_quiz_mdl->reset_pilihan($id);
        if(!$reset) {
            $res['status'] = false;
            $res['message'] = 'Terjadi kesalahan sistem';
            $res['data'] = $data;
        } else {
            $submit = array();
            foreach($data as $key => $val) {
                if($val['choice']) {
                    $submit[] = $this->Admin_quiz_mdl->submit_pilihan($id, $val);
                } else {
                    $submit = false;
                }
            }
            
            if(in_array($submit, false)) {
                $res['status'] = false;
                $res['message'] = 'Gagal disimpan';
                $res['data'] = $data;
            } else {
                $res['status'] = true;
                $res['message'] = 'Berhasil disimpan';
                $res['data'] = $data;
            }
        }
        return $res;
    }

}
?>
