<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Ajax_sesi extends CI_Controller 
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

    public function get_val_peserta_for_tags()
    {
        $code = $this->input->post('code_sesi');
        $get = $this->Table_users->get_by_sesi_for_tags($code);
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data Peserta';
            $res['data'] = $code;
        } else {
            $res = $get;
        }
        echo json_encode($res);
    }

    public function get_all_peserta_for_tags()
    {
        $get = $this->Table_users->get_all_for_tags();
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data Peserta';
            $res['data'] = $code;
        } else {
            $res = $get;
        }
        echo json_encode($res);
    }

    public function submit_peserta()
    {
        $form = $this->input->post('form');
        foreach($form as $key => $val) {
            if($val['name'] == 'id') {
                $code_sesi = $val['value'];
            } else {
                $dt_form = $val['value'];
            }
        }

        $for_reset = $this->get_for_reset($code_sesi);
        if($for_reset === false) {
            $res['status'] = false;
            $res['message'] = 'Terjadi kesalahan sistems';
            $res['data'] = $code_sesi;
        } else {
            foreach($for_reset as $key => $val) {
                $reset[] = $this->reset_field_sesi($val['id']);
            }

            if(in_array(false, $reset)) {
                $res['status'] = false;
                $res['message'] = 'Terjadi kesalahan sistem';
                $res['data'] = $code_sesi;
            } else {
                $ex_form = explode(',', $dt_form);
                foreach($ex_form as $key => $val) {
                    $edit[] = $this->edit_field_sesi($val, $code_sesi);
                }

                if(in_array(false, $edit)) {
                    $res['status'] = false;
                    $res['message'] = 'Terjadi kesalahan sistem';
                    $res['data'] = $code_sesi;
                } else {
                    $res['status'] = true;
                    $res['message'] = 'Berhasil disimpan';
                    $res['data'] = $code_sesi;
                }
            }
        }
        echo json_encode($res);
    }

    private function get_for_reset($code)
    {
        if(!$code) {
            return false;
        } else {
            $get = $this->Table_users->get_for_reset($code);
            if($get['status'] == true) {
                return $get['data'];
            } else {
                return false;
            }
        }
    }

    private function reset_field_sesi($id_user)
    {
        if(!$id_user) {
            return false;
        } else {
            $reset = $this->Table_users->reset_field_sesi($id_user);
            if($reset['status'] == false) {
                return false;
            } else {
                return true;
            }
        }
    }

    private function edit_field_sesi($id_user, $code)
    {
        if((!$id_user) && (!$code)) {
            return false;
        } else {
            $data = array('sesi_code' => $code);
            $edit = $this->Table_users->edit_users($id_user, $data);
            if($edit['status'] == false) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function valid_code_add()
    {
        $val = $this->input->post('val');
        $get = $this->Table_sesi->get_bycode($val);
        if($get['status'] == false) {
            $res = $get;
        } else {
            if(count($get['data']) == 0) {
                $res['status'] = true;
                $res['message'] = 'Tidak ada code yg sama';
            } else {
                $res['status'] = false;
                $res['message'] = 'Terdapat code yg sama';
            }
        }
        echo json_encode($res);
    }

    public function valid_code_edit()
    {
        $ori = $this->input->post('ori');
        $new = $this->input->post('new');
        if($new == $ori) {
            $res['status'] = true;
            $res['message'] = 'Tidak ada perubahan';
        } else {
            $get = $this->Table_sesi->get_bycode($new);
            if($get['status'] == false) {
                $res = $get;
            } else {
                if(count($get['data']) == 0) {
                    $res['status'] = true;
                    $res['message'] = 'Tidak ada code yg sama';
                } else {
                    $res['status'] = false;
                    $res['message'] = 'Terdapat code yg sama';
                }
            }
        }
        echo json_encode($res);
    }
}
?>