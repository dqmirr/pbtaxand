<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sesi extends CI_Controller
{
    private $admin_url;
    private $base;
    public function __construct()
    {
		parent::__construct();
        $help = array('view_helper',
            'time_helper',
            'sesi_helper');
        $this->load->helper($help);

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

        $model = array('Table_sesi',
            'Table_users');
        $this->load->model($model);

        $lib = array('form_validation','help');
        $this->load->library($lib);
    }

    public function index()
    {
        if ($this->session->userdata('is_admin') <= 0) {
			redirect($this->admin_url.'/login');
        }

        $sess = $this->session->userdata();
        $dt_view['session'] = $this->help->set_return_session($sess);
        $dt_view['nav'] = nav_data('sesi');
        $dt_view['url'] = array(
            'base' => $this->base,
            'logout' => $this->base.'/ajax_logout',
            'action' => array('add' => $this->base.'/sesi/add',
                'edit' => $this->base.'/sesi/edit/',
                'delete' => $this->base.'/sesi/del/',
                'view' => $this->base.'/sesi/view/',));
        $dt_view['data'] = $this->data_sesi();
        
        $this->load->view('Admin/sesi_grid', $dt_view);
        // array_view($dt_view);
    }

    private function data_sesi()
    {
		$page = $this->input->get('page');
		$page = intval($page);
		if($page <= 0) $page = 1;

        $sesi = $this->Table_sesi->get_all($page);

        if($sesi['status'] == true) {
            $dt_sesi = $sesi['data'];
            foreach($dt_sesi as $key => $val) {
                $users = $this->Table_users->get_by_sesi($val['code']);
                $set_users = array('users' => count($users['data']));
                $dt_merge[$key] = array_merge($val, $set_users);
            }
            $res['status'] = true;
            $res['message'] = 'Menampilkan data sesi';
            $res['data'] = $dt_merge;
			$res['pagination'] = $sesi['pagination'];
        } else {
            $res['status'] = false;
            $res['message'] = 'Data tidak ditemukan';
            $res['data'] = null;
        }
        return $res;
    }

    private function form($id = null)
    {
        if ($this->session->userdata('is_admin') <= 0) {
			redirect($this->admin_url.'/login');
        }
        $sess = $this->session->userdata();
        $dt_view['session'] = $this->help->set_return_session($sess);
        $dt_view['nav'] = nav_data('sesi');

        if($id) {
            $url_form = '/edit';
        } else {
            $url_form = '/add';
        }

        $dt_view['url'] = array(
            'base' => $this->base,
            'action' => array('form' => $this->base.'/sesi'.$url_form,
                'back' => $this->base.'/sesi'));

        if($id) {
            $dt_view['data'] = $this->select_sesi($id);
        }
        
        $this->load->view('Admin/sesi_form', $dt_view);
        // array_view($dt_view);
    }

    private function select_sesi($id)
    {
        $get = $this->Table_sesi->get($id);
        return $get;
    }
    
    public function edit($id = null) 
    {
        $req = $_SERVER['REQUEST_METHOD'];
        if($req == 'GET') {
            $this->form($id);
        } else {
            $this->submit_edit();
        }
    }

    private function submit_edit()
    {
        $id = $this->input->post('id');
        if(!$id) {
            $res['status'] = false;
            $res['message'] = 'Terjadi kesalahan sistem';
            $res['data'] = null;
            $res['redirect'] = $this->base.'/sesi';
            alert_js($res);
        } else {
            $valid = $this->valid_post();
            if($valid['status'] == false) {
                $this->form($id);
            } else {
                $from = $this->input->post('time_from');
                $to = $this->input->post('time_to');
                $rpl_from = str_replace('T',' ', $from);
                $rpl_to = str_replace('T',' ', $to);
    
                $data = array(
                    'code' => $this->input->post('code'),
                    'label' => $this->input->post('label'),
                    'time_from' => $rpl_from,
                    'time_to' => $rpl_to,
                    'part' => $this->input->post('part'),
                    'greeting' => $this->input->post('greeting'));

                $edit = $this->Table_sesi->edit($id, $data);
                if($edit['status'] == false) {
                    $res['message'] = 'Terjadi kesalahan sistem';
                    $res['redirect'] = $this->base.'/sesi/edit/'.$id;
                } else {
                    $res['message'] = 'Berhasil disimpan';
                    $res['redirect'] = $this->base.'/sesi';
                }
                alert_js($res);
            }
        }
    }

    private function valid_post()
    {
        $config = array(
            array('field' => 'code',
                'label' => 'Code',
                'rules' => 'required|callback_valid_code'),
            array('field' => 'label',
                'label' => 'Label',
                'rules' => 'required'),
            array('field' => 'time_from',
                'label' => 'Waktu',
                'rules' => 'required'),
            array('field' => 'time_to',
                'label' => 'Waktu',
                'rules' => 'required'),
            // array('field' => 'part',
            //     'label' => 'Part',
            //     'rules' => 'required'),
            // array('field' => 'greeting',
            //     'label' => 'Greeting',
            //     'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == false) {
            $res['status'] = false;
            $res['message'] = validation_errors();
        } else {
            $res['status'] = true;
            $res['data'] = $this->input->post();
        }
        return $res;
    }

    public function valid_code($str)
    {
        $code_lama = $this->input->post('code_ori');
        if(!$code_lama) {
            // Valid add form
            $cek = $this->Table_sesi->get_bycode($str);
            if($cek['status'] == false) {
                $this->form_validation->set_message('valid_code', 'Terjadi kesalahan sistem');
                return false;
            } else {
                if(count($cek['data']) > 0) {
                    $this->form_validation->set_message('valid_code', '{field} sudah digunakans');
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            // Valid edit form
            if($str != $code_lama) {
                $cek = $this->Table_sesi->get_bycode($str);
                if($cek['status'] == false) {
                    $this->form_validation->set_message('valid_code', 'Terjadi kesalahan sistem');
                    return false;
                } else {
                    if(count($cek['data']) > 0) {
                        $this->form_validation->set_message('valid_code', '{field} sudah digunakans');
                        return false;
                    } else {
                        return true;
                    }
                }
            } else {
                return true;
            }
        }
    }

    public function add()
    {
        $req = $_SERVER['REQUEST_METHOD'];
        if($req == 'GET') {
            $this->form();
        } else {
            $this->submit_add();
        }
    }

    private function submit_add()
    {
        $valid = $this->valid_post();
        if($valid['status'] == false) {
            $this->form();
        } else {
            $from = $this->input->post('time_from');
            $to = $this->input->post('time_to');
            $rpl_from = str_replace('T',' ', $from);
            $rpl_to = str_replace('T',' ', $to);

            $data = array(
                'code' => $this->input->post('code'),
                'label' => $this->input->post('label'),
                'time_from' => $rpl_from,
                'time_to' => $rpl_to,
                'part' => $this->input->post('part'),
                'greeting' => $this->input->post('greeting'));

            $edit = $this->Table_sesi->insert($data);
            if($edit['status'] == false) {
                $res['message'] = 'Terjadi kesalahan sistem';
                $res['redirect'] = $this->base.'/sesi/add/';
            } else {
                $res['message'] = 'Berhasil disimpan';
                $res['redirect'] = $this->base.'/sesi';
            }
            alert_js($res);
        }
    }

    public function del($id = null)
    {
        if(!$id) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/sesi';
        } else {
            $get = $this->get_code_for_del($id);
            if(!$get) {
                $res['message'] = 'Data tidak ditemukan';
                $res['redirect'] = $this->base.'/sesi';
            } else {
                $reset_peserta = $this->reset_peserta($get['data']);
                if($reset_peserta == false) {
                    $res['message'] = 'Terjadi kesalahan menghapus peserta';
                    $res['redirect'] = $this->base.'/sesi';
                } else {
                    $del_sesi = $this->Table_sesi->delete($id);
                    if($del_sesi['status'] == false) {
                        $res['message'] = $del_sesi['message'];
                        $res['redirect'] = $this->base.'/sesi';
                    } else {
                        $res['message'] = $del_sesi['message'];
                        $res['redirect'] = $this->base.'/sesi';
                    }
                }
            }
        }
        alert_js($res);
    }

    private function reset_peserta($code)
    {
        if(!$code) {
            return false;
        } else {
            $get_reset = $this->Table_users->get_for_reset($code['code']);
            if($get_reset['status'] == false) {
                return false;
            } else {
                foreach($get_reset['data'] as $key => $val) {
                    $reset_peserta[] = $this->Table_users->reset_field_sesi($val['id']);
                }

                if(in_array('false', $reset_peserta)) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    private function get_code_for_del($id_sesi)
    {
        if(!$id_sesi) {
            return false;
        } else {
            $field = array('code');
            $get_code = $this->Table_sesi->get_field($id_sesi, $field);
            return $get_code;
        }
    }
}
?>
