<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_formasi extends CI_Controller
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
                $this->load_model();
                $this->load_lib();
            }
        }
    }

    private function load_help()
    {
        $help = array('view_helper',
            'time_helper');
        $this->load->helper($help);
    }

    private function load_model()
    {
        $model = array('Table_formasi');
        $this->load->model($model);
    }

    private function load_lib()
    {
        $lib = array('form_validation',
            'help');
        $this->load->library($lib);
    }

    private function data_default()
    {
        $sess = $this->session->userdata();
        $dt_view['session'] = $this->help->set_return_session($sess);
        $dt_view['nav'] = nav_data('formasi');
        return $dt_view;
    }

    public function index()
    {
        $dt_view = $this->data_default();
        $dt_view['url'] = array(
            'base' => $this->base,
            'action' => array('add' => $this->base.'/formasi/add',
                'edit' => $this->base.'/formasi/edit/',
                'delete' => $this->base.'/formasi/del/',
                'view' => $this->base.'/formasi/view/'));
        $get_data = $this->get_all();
        foreach($get_data as $key => $val) {
            $tgl = tgl_fromto($val['time_from'], $val['time_to']);
            $sesi = $val['label_sesi'].' ('.$tgl.')';
            $dt_table[] = array_merge($val, array('sesi' => $sesi));
        }
        $dt_view['data'] = $dt_table;
        
        $this->load->view('Admin/formasi_grid', $dt_view);
        // array_view($dt_view);
    }

    private function get_all()
    {
        $get = $this->Table_formasi->get_allwith_relation();
        return $get['data'];
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

    private function form($code = null)
    {
        $dt_view = $this->data_default();
        if(!$code) {
            $url_form = '/add';
        } else {
            $url_form = '/edit/'.$code;
        }

        $dt_view['url'] = array(
            'base' => $this->base,
            'action' => array('form' => $this->base.'/formasi'.$url_form,
                'back' => $this->base.'/formasi'));
        if($code) {
            $get_data = $this->select_data($code);
            $dt_view['data'] = $get_data['data'];
        }

        $dt_view['form'] = $this->data_form();

        $this->load->view('Admin/formasi_form', $dt_view);
        // array_view($dt_view);
    }

    private function data_form()
    {
        return array(
            'select_sesi' => $this->get_selectsesi(),
            'select_divisi' => $this->get_selectdivisi(),
            'select_level' => $this->get_selectlevel());
    }


    private function get_selectsesi()
    {
        $this->load->model('Table_sesi');
        $get_sesi = $this->Table_sesi->get_all_without_limit();
        foreach($get_sesi['data'] as $key => $val) {
            $tgl = tgl_fromto($val['time_from'], $val['time_to']);
            $label = $val['label'].' ('.$tgl.')';
            $data[] = array('id' => $val['code'],
                'label' => $label);
        }
        return $data;
    }

    private function get_selectdivisi()
    {
        $this->load->model('Table_posisi_jabatan');
        $get_divisi = $this->Table_posisi_jabatan->get_all();
        foreach($get_divisi['data'] as $key => $val) {
            $data[] = array('id' => $val['id'],
                'label' => $val['label']);
        }
        return $data;
    }

    private function get_selectlevel()
    {
        $this->load->model('Table_posisi_level');
        $get_level = $this->Table_posisi_level->get_all();
        foreach($get_level['data'] as $key => $val) {
            $data[] = array('id' => $val['id'],
                'label' => $val['label']);
        }
        return $data;
    }

    private function submit_add()
    {
        $valid = $this->valid_post();
        if($valid['status'] == false) {
            $this->form();
        } else {
            $data = array('code' => $this->input->post('code'),
                'label' => $this->input->post('label'),
                'sesi_code' => $this->input->post('sesi'),
                'posisi' => $this->input->post('divisi'),
                'tingkatan' => $this->input->post('level'));
            $submit = $this->Table_formasi->insert($data);
            if($submit['status'] == false) {
                $res['status'] = false;
                $res['message'] = 'Terjadi kesalahan sistem';
                $res['redirect'] = $this->base.'/formasi/add';
            } else {
                $res['status'] = true;
                $res['message'] = 'Berhasil disimpan';
                $res['redirect'] = $this->base.'/formasi';
            }
            alert_js($res);
        }
        // echo json_encode($valid);
        // $code = $this->input->post('code');
        // $cek = $this->Table_formasi->get_bycode($code);
        // echo json_encode($valid);
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
            array('field' => 'sesi',
                'label' => 'Sesi',
                'rules' => 'required'),
            array('field' => 'divisi',
                'label' => 'Divisi',
                'rules' => 'required')
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
        $code_lama = $this->input->post('code_lama');
        if(!$code_lama) {
            // Valid add form
            $cek = $this->Table_formasi->get_bycode($str);
            if($cek['status'] == false) {
                $this->form_validation->set_message('valid_code', 'Terjadi kesalahan sistem');
                return false;
            } else {
                if(count($cek['data']) > 0) {
                    $this->form_validation->set_message('valid_code', '{field} sudah digunakan ');
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            // Valid edit form
            if($str != $code_lama) {
                $cek = $this->Table_formasi->get_bycode($str);
                if($cek['status'] == false) {
                    $this->form_validation->set_message('valid_code', 'Terjadi kesalahan sistem');
                    return false;
                } else {
                    if(count($cek['data']) > 0) {
                        $this->form_validation->set_message('valid_code', '{field} sudah digunakan');
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

    public function edit($code = null)
    {
        $req = $_SERVER['REQUEST_METHOD'];
        if($req == 'GET') {
            $this->form($code);
        } else {
            $this->submit_edit($code);
        }
    }

    private function select_data($code = null)
    {
        if(!$code) {
            $res['status'] = false;
            $res['message'] = 'Data tidak ditemukan';
        } else {
            $get_data = $this->Table_formasi->get_bycode($code);
            if($get_data['status'] == false) {
                $res['status'] = false;
                $res['message'] = 'Terjadi kesalahan';
            } else {
                $res['status'] = true;
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $get_data['data'][0];
            }
        }
        return $res;
    }

    private function submit_edit($code)
    {
        $id = $this->input->post('id');
        if(!$id) {
            $res['status'] = false;
            $res['message'] = 'Terjadi kesalahan sistem';
            $res['redirect'] = $this->base.'/formasi';
            alert_js($res);
        } else {
            $valid = $this->valid_post();
            if($valid['status'] == false) {
                $this->form($code);
            } else {
                $data = array('code' => $this->input->post('code'),
                    'label' => $this->input->post('label'),
                    'sesi_code' => $this->input->post('sesi'),
                    'posisi' => $this->input->post('divisi'),
                    'tingkatan' => $this->input->post('level'));
                $edit = $this->Table_formasi->edit($id, $data);
                if($edit['status'] == false) {
                    $res['message'] = 'Terjadi kesalahan sistem';
                    $res['redirect'] = $this->base.'/formasi/edit/'.$code;
                } else {
                    $res['message'] = 'Berhasil disimpan';
                    $res['redirect'] = $this->base.'/formasi';
                }
                alert_js($res);
            }
        }
    }

    public function del($code)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/formasi';
        } else {
            $del_formasi = $this->Table_formasi->delete($code);
            if($del_formasi['status'] == false) {
                $res['message'] = $del_formasi['message'];
                $res['redirect'] = $this->base.'/formasi';
            } else {
                $res['message'] = $del_formasi['message'];
                $res['redirect'] = $this->base.'/formasi';
            }
        }
        alert_js($res);
    }
}
?>
