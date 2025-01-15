<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Ajax_dashboard extends CI_Controller 
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
                $model = array('Table_users',
                    'Dashboard_mdl',
                    'Table_sesi');
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

    private function jumlah_quiz($id)
    {
        $get = $this->Dashboard_mdl->getjumlah_quiz($id);
        if($get['status'] == false) {
            $res = '0';
        } else {
            $res = $get['data'];
        }
        return $res;
    }

    public function get_userquiz()
    {
        $code = $this->input->post('code_sesi');
        $get = $this->Dashboard_mdl->get_userbysesi($code);
        if($get['status'] == false) {
            $res['status'] = false;
            $res['message'] = 'Terjadi kesalahan sistem';
            $res['data'] = null;
        } else {
            $res['status'] = true;
            $res['message'] = 'Menampilkan data users';
            foreach($get['data'] as $key => $val) {
                $get_quiz = $this->Dashboard_mdl->get_detail_quiz($val['id']);
                $dt_quiz = array();
                foreach($get_quiz['data'] as $key2 => $val2) {
                    $dt_quiz[] = $val2;
                }

                if($val['formasi'] == null) {
                    $formasi = '-';
                } else {
                    $formasi = $val['formasi'];
                }

                $jml = $this->jumlah_quiz($val['id']);
                $get_sts = $this->status($val['id']);
                $sts = 0;
                switch(true) {
                    case ($get_sts['used'] == 0):
                        $sts = 'Belum';
                        break;
                    case ($get_sts['used'] > 0):
                        $sts = 'Progres';
                        break;
                    case ($get_sts['used'] == $get_sts['original']):
                        $sts = 'Selesai';
                        break;
                    default:
                        $sts = 'Belum';
                        break;
                }
                
                $res['data'][] = array('id' => $val['id'],
                    'no' => ($key+1),
                    'fullname' => $val['fullname'],
                    'formasi' => $formasi,
                    'jml_quiz' => $jml,
                    'status' => $sts,
                    'quiz' => $dt_quiz);
            }
            // $res['data'] = $get['data'];
        }
        echo json_encode($res);
    }

    private function status($user)
    {
        $get = $this->Dashboard_mdl->for_status($user);
        return $get;
    }

    public function get_list()
    {
        $tahun = $this->input->post('tahun');
        $get = $this->Table_sesi->get_forchart($tahun);

        $loop = array();
        foreach($get['data'] as $key => $val) {
            $get_belum = $this->Dashboard_mdl->get_belumchart($val['code']);
            $get_prgrs = $this->Dashboard_mdl->get_progreschart($val['code']);
            $get_selesai = $this->Dashboard_mdl->get_selesaichart($val['code']);
            $loop[] = array('code' => $val['code'],
                'chart' => array($get_belum, $get_prgrs, $get_selesai));
        }
        unset($get['data']);
        $res = $get;
        $res['data'] = $loop;
            
        echo json_encode($res);
    }
}
?>