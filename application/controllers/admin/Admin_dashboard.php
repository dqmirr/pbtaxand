<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends CI_Controller
{
    private $admin_url;
    private $base;
    public function __construct()
    {
        parent::__construct();
        $this->load_help();
        $this->redis = new CI_Redis();

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
            'time_helper',
            'array_helper');
        $this->load->helper($help);
    }

    private function load_model()
    {
        $model = array('Dashboard_mdl');
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
        $dt_view['nav'] = nav_data('dashboard');
        $dt_view['url'] = array(
            'base' => $this->base,
            'logout' => $this->base.'/ajax_logout',
            'action' => array('form' => $this->base,
                'add' => $this->base.'/formasi/add',
                'edit' => $this->base.'/formasi/edit/',
                'delete' => $this->base.'/formasi/del/',
                'view' => $this->base.'/formasi/view/'));
        return $dt_view;
    }

    public function index()
    {
        $dt_view = $this->data_default();

        // $dash = array('user_active' => $this->user_active(),
        //     'sesi_active' => $this->sesi_active(),
        //     'tahun' => $this->get_tahun(),
        //     'sesi_list' => $this->set_outdata());
        // $dt_view['dashboard'] = $dash;
        // $this->load->view('Admin/dashboard_grid', $dt_view);

        $get_redis = $this->redis->get('dashboard_data');
        $set_dash = array('user_active' => $this->user_active(),
            'jumlah_formasi' => $this->get_jumlah_formasi(),
            'sesi_active' => $this->sesi_active(),
            'jumlah_gti' => $this->get_gti(),
            'jumlah_multiple' => $this->get_multiple(),
            'jumlah_quiz' => $this->get_jumlah_quiz(),
            'tahun' => $this->get_tahun(),
            'sesi_list' => $this->set_outdata());

        if($get_redis == NULL) {
            $dash = $set_dash;
            $this->redis->set('dashboard_data', serialize($dash));
            $this->redis->expire('dashboard_data', 3600);
        } else {
            $from_redis = unserialize($get_redis);
            $diff = array_diff_assoc($from_redis, $set_dash);
            if(count($diff) == 0) {
                $dash = $from_redis;
            } else {
                $dash = $set_dash;
            }
        }

        $dt_view['dashboard'] = $dash;
        $this->load->view('Admin/dashboard_grid', $dt_view);

    }

    private function get_tahun()
    {
        $tahun = $this->input->post('tahun');
        if($tahun) {
            $bln = $tahun;
        } else {
            $bln = date('Y-m');
        }
        return $bln;
    }

    private function get_sesi()
    {
        $this->load->model('Table_sesi');
        $bln = $this->get_tahun();
        return $this->Table_sesi->get_byfromto($bln);
    }

    private function get_formasi($code)
    {
        $this->load->model('Table_formasi');
        return $this->Table_formasi->get_bycodesesi($code);
    }

    private function get_users($code)
    {
        return $this->Dashboard_mdl->get_userbysesi($code);
    }

    private function get_jumlah_quiz()
    {
        $this->load->model('Table_quiz');
        $get = $this->Table_quiz->jumlah_quiz();
        return $get['data'];
    }

    private function get_jumlah_formasi()
    {
        $this->load->model('Table_formasi');
        $get = $this->Table_formasi->get_jumlah();
        return $get['data'];
    }

    private function get_gti()
    {
        $this->load->model('Table_gti_ques');
        $get = $this->Table_gti_ques->get_jumlah();
        return $get['data'];
    }

    private function get_multiple()
    {
        $this->load->model('Table_multi_ques');
        $get = $this->Table_multi_ques->get_jumlah();
        return $get['data'];
    }

    private function set_outdata()
    {
        $get_sesi = $this->get_sesi();
        foreach($get_sesi['data'] as $key => $val) {
            $get_users = $this->get_users($val['code']);

            $set_users = array();
            foreach($get_users['data'] as $key1 => $val1) {
                $get_quiz = $this->Dashboard_mdl->get_detail_quiz($val1['id']);
                if(count($get_quiz['data']) > 0) {
                    $text_quiz = count($get_quiz['data']).' Quiz';
                } else {
                    $text_quiz = 'Tidak ada Quiz';
                }
                
                $set_quiz = array('text_quiz' => $text_quiz,
                    'quiz' => $get_quiz['data']);
                $set_users[] = array_merge($val1, $set_quiz);
            }

            $users = array('users' => $set_users);

            $jumlah = jumlah_hari($val['time_from'], $val['time_to']);
            $tanggal = tgl_fromto($val['time_from'], $val['time_to']);
            $set_expaired = $this->set_expaired($val['time_to']);
            $persen = hitung_persen($val['time_from'], $val['time_to']);

            $extra = array('hari' => $jumlah,
                'tanggal' => $tanggal,
                'persen' => $persen);
            
            $extra = array_merge($extra, $set_expaired);
            $data[] = array_merge($val, $extra, $users);
        }
        return $data;
    }

    private function set_expaired($time)
    {
        $expired = tgl_expaired($time);
        if($expired) {
            $badge = "badge-success";
            $text = "Active";
        } else {
            $badge = "badge-danger";
            $text = "Inactive";
        }

        $interface = array('badge' => $badge,
            'text' => $text);
        return $interface;
    }

    private function set_formasi($formasi)
    {
        if($formasi) {
            return 'Formasi '.$formasi;
        } else {
            return '-';
        }
    }

    private function user_active()
    {
        $this->load->model('Table_users');
        $get = $this->Table_users->get_actived();
        return $get['data'];
    }

    private function sesi_active()
    {
        $this->load->model('Table_sesi');
        $get = $this->Table_sesi->get_jumlahall();
        return $get['data'];
    }
}
?>
