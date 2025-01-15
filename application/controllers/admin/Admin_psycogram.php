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
        $help = array('view_helper',
            'time_helper');
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
            'logout' => $this->base.'/ajax_logout');

        $dt_view['button'] = array(
            'hexaco' => array('label' => 'Hexaco',
                'view' => $this->base.'/psycogram/hexaco/',
                'download' => $this->base.'/psycogram/hexaco_pdf/'),
            'gti' => array('label' => 'GTI',
                'view' => $this->base.'/report_gti/sesi/',
                'download' => $this->base),
            // 'accounting' => array('label' => 'Accounting',
            //     'view' => $this->base.'/psycogram/accounting/'),
            'disc' => array('label' => 'DISC',
                'view' => $this->base.'/psycogram/disc/',
                'download' => $this->base.'/psycogram/disc_pdf/'),
            'psycogram' => array('label' => 'Psychogram',
                // 'view' => $this->base.'/psycogram/result/',
                'view' => $this->base.'/psycogram/list/',
                'download' => $this->base),
        );
        return $dt_view;
    }

    private function set_outdata()
    {
        $get_sesi = $this->get_sesi();
        foreach($get_sesi['data'] as $key => $val) {
            $peserta = $this->get_jmlpeserta($val['code']);
            if($peserta == '0') {
                $extra['peserta'] = 'Tidak ada Peserta';
            } else {
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
        }
        return $dt_out;
    }

    private function get_sesi()
    {
        $this->load->model('Table_sesi');
        return $this->Table_sesi->get_all_without_limit();
    }

    private function get_jmlpeserta($sesi)
    {
        $this->load->model('Table_users');
        $get = $this->Table_users->get_by_sesi($sesi);
        return count($get['data']);
    }

    private function get_userbysesi($sesi, $users_id)
    {
        $get = $this->Psycogram_mdl->get_userbysesi($sesi, $users_id);
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

    private function set_outview($sesi)
    {
		$users_id = $this->input->get('users_id');

		$sesi = urldecode($sesi);
        $get_sesi = $this->get_sesibycode($sesi);
        $get_user = $this->get_userbysesi($sesi, $users_id);

        $nilai = array();
        foreach($get_user as $key => $val) {
            if($val['tgl_lahir'] == NULL) {
                $tgl = '-';
            } else {
                $tgl = tgl_indo($val['tgl_lahir']);
            }


            $set_user[] = array_merge($val, array('tgl_lahir' => $tgl));
        }

        $extra = array('users' => $set_user);
        $res = array_merge($get_sesi, $extra);
        return $res;
    }

    private function get_sesibycode($code)
    {
        $this->load->model('Table_sesi');
        $get = $this->Table_sesi->get_bycode($code);
        return $get['data'][0];
    }

    public function hexaco_pdf($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->set_outview($code);
            $this->load->view('Admin/hexaco_pdf', $dt_view);
        }
    }

    public function hexaco($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->set_outview($code);
            $this->load->view('Admin/hexaco_grid', $dt_view);
        }
    }

    public function accounting($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->set_outview($code);
            $this->load->view('Admin/accounting_view', $dt_view);
        }
    }

    public function disc($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->setdata_disc($code);
            $this->load->view('Admin/disc_grid', $dt_view);
            // json_view($dt_view);
        }
    }

    private function setdata_disc($code)
    {
        $view = $this->set_outview($code);
        $this->load->library('Disc_result');
		$this->load->model("Users_quiz_log_model", "Users_quiz_log");
        $disc = array();
		$list_group_quiz = array();
		$total_status_value = 0;
		$total_data = 0;
        foreach($view['users'] as $key => $val) {
            $extra['disc'] = $this->disc_result->result_v2($val['id'], 'disc1');
			$status = $this->Users_quiz_log->get_status_quiz($val["id"], 'disc1');
			switch($status['id']){
				case 1:
					$status_badge = 'badge-warning';
					break;
				case 2:
					$status_badge = 'badge-success';
					break;
				default:
					$status_badge = 'badge-danger';
					break;
			}
			$extra['status'] = '
				<span class="my-1 badge '.$status_badge.'">'.$status['label'].'</span>
			';
            $disc[] = array_merge($val, $extra);
        }

        unset($view['users']);
        $user = array('users' => $disc);
        $data = array_merge($view, $user);
        return $data;
    }

    public function disc_pdf($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $dt_view['data'] = $this->setdata_disc($code);
            $this->load->view('Admin/disc_pdf', $dt_view);
        }
    }





    public function list($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $view = $this->set_outview($code);
            $extra['download'] = $this->base.'/psycogram/result/'.$code;
            $extra['aksi'] = $this->base.'/psycogram/user/';
            $dt_view['data'] = array_merge($view, $extra);
            $this->load->view('Admin/psycogram_list', $dt_view);
            // array_view($view);
        }
    }

    public function user($username = null)
    {
        if(!$username) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            unset($dt_view['button']);
            $data_result = $this->setdata_user($username);
            $dt_view['data'] = $data_result;
            $this->load->view('Admin/psycogram_pdf', $dt_view);
            // json_view($data_result);
        }
    }

    private function setdata_user($username)
    {
        $this->load->library('psyco_result');
        $get = $this->get_userby_username($username);
        foreach($get as $key => $val) {
			if($key == 'id') {
				$dt_user['tgl_test'] = $this->get_tgl_test_user($val);
			}
			
            if($key == 'tgl_lahir') {
                if($val != NULL) {
                    $dt_user[$key] = tgl_indo($val);
                } else {
                    $dt_user[$key] = '';
                }
            } else {
                $dt_user[$key] = $val;
            }

        }
        $result = $this->psyco_result->result($dt_user['id']);
        $data = array_merge($dt_user, $result);
        return array('users' => array($data));
    }

	private function get_tgl_test_user($user_id) {
		$this->load->model('Users_quiz_log_model', 'uqlm');
		$uqlm = $this->uqlm->find_one_by_user_id($user_id);
		$tgl_test = $uqlm['time_end']!= null ? $uqlm['time_end'] : $uqlm['time_start'];
		return tgl_indo($tgl_test);
	}

    private function get_userby_username($username)
    {
        $this->load->model('Table_users');
        $get = $this->Table_users->get_byusername($username);
		$result = $get['data'][0];

        return $result;
    }

    private function setdata_result($code)
    {
        $view = $this->set_outview($code);
        $this->load->library('psyco_result');

        $psyco = array();
        foreach($view['users'] as $key => $val) {
            $extra = $this->psyco_result->result($val['id']);
			$extra['tgl_test'] = $this->get_tgl_test_user($val['id']);
            // $extra['eng'] = $this->psyco_result->get_psyco_point($val['id']);
            // $extra['psyco_new'] = $this->psyco_result->new_result($par_result);
            $psyco[] = array_merge($val, $extra);
        }

        unset($view['users']);
        $user = array('users' => $psyco);
        $data = array_merge($view, $user);
        return $data;
    }

    public function result($code = null)
    {
        if(!$code) {
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/psycogram';
            alert_js($res);
        } else {
            $dt_view = $this->data_default();
            $data_result = $this->setdata_result($code);
            $dt_view['data'] = $data_result;

            // $this->load->library('psyco_result');
            // $dummy = $this->psyco_result->dummy_std();

            // $get_aspect = $this->psyco_result->get_aspect();

            $this->load->view('Admin/psycogram_pdf', $dt_view);
            // json_view($data_result);
        }
    }

}
?>
