<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require(APPPATH.'libraries/Prince.php');
// use Prince\Prince;

class Admin_psycogram extends CI_Controller
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
            // $this->prince = new Prince('/usr/local/bin/prince');
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

    public function index()
    {
        $dt_view = $this->data_default();
        $dt_view['data'] = $this->set_outdata();
        $this->load->view('Admin/psycogram_grid', $dt_view);
        // json_view($dt_view);
    }

    private function load_help()
    {
        $help = array('view_helper');
        $this->load->helper($help);
    }

    private function load_model()
    {
        $model = array('Psycogram_mdl');
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
        $dt_view['nav'] = nav_data('report','psycogram');
        $dt_view['url'] = array(
            'base' => $this->base,
            'logout' => $this->base.'/ajax_logout',
            'action' => array('download' => $this->base.'/psycogram/pdf/',
                'view' => $this->base.'/psycogram/view/'));
        return $dt_view;
    }

    private function set_outdata()
    {
        $get_sesi = $this->get_sesi();
        foreach($get_sesi['data'] as $key => $val) {
            $peserta = $this->get_jmlpeserta($val['code']);
            if($peserta == '0') {
                $extra['download'] = false;
                $extra['peserta'] = 'Tidak ada Peserta';
            } else {
                $extra['download'] = true;
                $extra['peserta'] = $peserta.' Peserta';
            }

            $get_sts = $this->status($val['code']);

            if($get_sts['used'] > 0) {
                if($get_sts['used'] == $get_sts['original']) {
                    $extra['status'] = 'Selesai';
                    $extra['badge'] = 'badge-success';
                } else {
                    $extra['status'] = 'Progres';
                    $extra['badge'] = 'badge-warning';
                }
            } else {
                $extra['status'] = 'Belum';
                $extra['badge'] = 'badge-danger';
            }

            $dt_out[] = array_merge($val, $extra);
            // $dt_out[] = $cek;
        }
        return $dt_out;
    }

    private function get_sesi()
    {
        $this->load->model('Table_sesi');
        return $this->Table_sesi->get_all();
    }

    private function get_jmlpeserta($sesi)
    {
        $this->load->model('Table_users');
        $get = $this->Table_users->get_by_sesi($sesi);
        return count($get['data']);
    }

    private function get_userbysesi($sesi)
    {
        $get = $this->Psycogram_mdl->get_userbysesi($sesi);
        return $get['data'];
    }

    private function get_detail_quiz($user)
    {
        $get = $this->Psycogram_mdl->get_detail_quiz($user);
        return $get['data'];
    }

    private function status($user)
    {
        $get = $this->Psycogram_mdl->for_status($user);
        return $get;
    }

    public function view($id = null)
    {
        if(!$id) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            // $res['message'] = 'lanjut';
            $this->page_view($id);
        }
        // var_dump($res);
    }

    private function page_view($id)
    {
        if(!$id) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->set_outview($id);
            $this->load->view('Admin/psycogram_view', $dt_view);
        }
    }

    private function set_outview($sesi)
    {
        $get_sesi = $this->get_sesibyid($sesi);
        $get_user = $this->get_userbysesi($get_sesi['code']);
        
        $nilai = array();
        foreach($get_user as $key => $val) {
            $set_user[] = $val;
        }

        $extra = array('users' => $set_user);
        $res = array_merge($get_sesi, $extra);
        return $res;
    }

    private function get_sesibyid($id)
    {
        $this->load->model('Table_sesi');
        $get = $this->Table_sesi->get($id);
        return $get['data'][0];
    }

    public function pdf($id)
    {
        if(!$id) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->set_outview($id);
            $this->load->view('Admin/psycogram_pdf', $dt_view);
        }
    }

}
?>