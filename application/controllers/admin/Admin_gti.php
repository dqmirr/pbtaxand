<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_gti extends CI_Controller
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
            $this->load->database();
            $this->admin_url = $this->uri->segment(1);
            $current_controller = $this->uri->segment(2);
            $this->base = base_url($this->admin_url.'/'.$current_controller);
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

        $dt_view['url']['action'] = array(
            'download' => $this->base.'/gti',
            'grafik' => $this->base.'/sesi/',
            'detail' => $this->base.'/detail/',
        );
        
        $this->load->view('Admin/gti/grid', $dt_view);
    }

    public function sesi($sesi_id)
    {
        $arg_list = func_get_args();
        $dt_view = $this->data_default();
        switch(count($arg_list)){
            case 1:
				$sesi_id = urldecode($sesi_id);
                $get_sesi = $this->get_sesibycode($sesi_id);
                $dt_view['sesi_label'] = $get_sesi['label'];
                $dt_view["data"] = $this->get_peserta_by_sesi($sesi_id);
                $dt_view['back'] = base_url($this->admin_url).'/psycogram';
                $dt_view["url"]["base"] = $this->base;
                $dt_view["url"]['action'] = array(
                    'grafik' => $this->base.'/sesi/'.$sesi_id.'/',
                    'detail' => $this->base.'/detail/'.$sesi_id.'/'
                );
                $this->load->view('Admin/gti/peserta', $dt_view);
                break;
            case 2:
                $sesi_id = urldecode($arg_list[0]);
                $users_id = urldecode($arg_list[1]);
                $this->load->model('Gti_model');
                $dt_view['data'] = $this->Gti_model->get_report($users_id);
                $config_gti = $this->config->item('config_gti');

                $val_gtq = $dt_view['data']['gtq']['value'];
                $dt_view['data']['gtq']['keterangan'] = generate_gti_info($config_gti,$val_gtq);

                $keterangan_warna = $config_gti["keterangan_warna"];
                usort($keterangan_warna, function($a, $b) {return $a->value > $b->value;});

                $dt_view['data']["keterangan_warna"] = $keterangan_warna;
                $dt_view['data']['result_json'] = json_encode((object) array(
                    'data' => (object) array(
                        'letter_checking' => $dt_view['data']["result"]["Subtest 1"]["GTQ"],
                        'reasoning' => $dt_view['data']["result"]["Subtest 2"]["GTQ"],
                        'letter_distance' => $dt_view['data']["result"]["Subtest 3"]["GTQ"],
                        'number_distance' => $dt_view['data']["result"]["Subtest 4"]["GTQ"],
                        'spatial_oriantation' => $dt_view['data']["result"]["Subtest 5"]["GTQ"],
                    ),
                    'meta' => (object) array(
                        'keterangan_warna' => $keterangan_warna
                    )
                ));

                $dt_view['data']['date'] = date('d F Y');

                $dt_view['data']["pdf_name"] = 'Report Gti - '.$dt_view['data']['name'].' - '.$dt_view['data']['date'];
                $this->load->view('Admin/gti/report', $dt_view);
                break;
            default:
                redirect($this->admin_url.'/report_gti');
                break;
        }
    }

    public function detail($sesi_id)
    {
        $arg_list = func_get_args();

        $dt_view = $this->data_default();
        $dt_view["url"]["base"] = $this->base;
        switch(count($arg_list)){
            case 1:
                $dt_view["data"] = $this->get_peserta_by_sesi($sesi_id);
                $dt_view["url"]["base"] = $this->base;
                $dt_view["url"]['action'] = array(
                    'grafik' => $this->base.'/sesi/'.$sesi_id.'/',
                    'detail' => $this->base.'/detail/'.$sesi_id.'/'
                );
                $this->load->view('Admin/gti/peserta', $dt_view);
                break;
            case 2:
                
                $sesi_id = $arg_list[0];
                $users_id = $arg_list[1];
                $this->load->model('Gti_model');
                $dt_view['data'] = $this->Gti_model->get_report($users_id);
                $config_gti = $this->config->item('config_gti');

                $val_gtq = $dt_view['data']['gtq']['value'];
                $dt_view['data']['gtq']['keterangan'] = generate_gti_info($config_gti,$val_gtq);

                $keterangan_warna = $config_gti["keterangan_warna"];
                usort($keterangan_warna, function($a, $b) {return $a->value > $b->value;});

                $dt_view['data']["keterangan_warna"] = $keterangan_warna;
                $dt_view['data']['result_json'] = json_encode((object) array(
                    'data' => (object) array(
                        'letter_checking' => $dt_view['data']["result"]["Subtest 1"]["GTQ"],
                        'reasoning' => $dt_view['data']["result"]["Subtest 2"]["GTQ"],
                        'letter_distance' => $dt_view['data']["result"]["Subtest 3"]["GTQ"],
                        'number_distance' => $dt_view['data']["result"]["Subtest 4"]["GTQ"],
                        'spatial_oriantation' => $dt_view['data']["result"]["Subtest 5"]["GTQ"],
                    ),
                    'meta' => (object) array(
                        'keterangan_warna' => $keterangan_warna
                    )
                ));

                $dt_view['data']['date'] = date('d F Y');
                $dt_view["url"]['action'] = array(
                    'back' => $this->base.'/sesi/'.$sesi_id,
                );

                $dt_view['data']["pdf_name"] = 'Report Gti - '.$dt_view['data']['name'].' - '.$dt_view['data']['date'];
                $this->load->view('Admin/gti/detail', $dt_view);

                break;
            default:
                redirect($this->admin_url.'/report_gti');
                break;
        }

    }

    private function load_help()
    {
        $help = array('view_helper', 'generate_helper');
        $this->load->helper($help);
    }

    private function load_model()
    {
        $model = array('Gti_model');
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
                    'logout' => $this->base.'/ajax_logout',);
            return $dt_view;
    }

    private function set_outdata()
    {
        $get_sesi = $this->get_sesi();
        $get_users_gti = $this->Gti_model->get_countbysesi();
        foreach($get_sesi['data'] as $key => $val) {
            $peserta = '0';
        
            foreach($get_users_gti["data"] as $key => $user_gti){
                if($user_gti['sesi_code'] == $val['code']){
                    $peserta = $user_gti["jumlah_peserta"];
                }
            }

            if($peserta == '0') {
                $extra['peserta'] = 'Tidak ada Peserta';
            } else {
                $extra['peserta'] = $peserta.' Peserta';
            }

            $dt_out[] = array_merge($val, $extra);
        }
        return $dt_out;
    }

    private function get_peserta_by_sesi($sesi_id){
        $res = array();
        $data = array();
        $this->load->model("Quiz_model");
        $this->load->model("Users_quiz_log_model", "Users_quiz_log");
        // $gti_datas = $this->Gti_model->get_peserta_by_sesi($sesi_id);
		$this->load->model('Table_users');
        $gti_datas = $this->Table_users->get_by_sesi($sesi_id);
        foreach($gti_datas["data"] as $record){
			$record["users_id"] = $record["id"];
			$record["quiz_id"] = 47;
			$record["group_quiz_code"] = 'gti';
            $users_id = $record["users_id"];

            if(!isset($data[$record["users_id"]])){
                $data[$record["users_id"]] = array(
                    "users_id" => $record["users_id"],
                    "peserta" => $record["fullname"],
                );
            }

            if(!empty($record["quiz_id"])){
                $data[$record["users_id"]]["quiz"][$record["quiz_id"]] = array(
                    "quiz_id" => $record["quiz_id"],
                    "users_id" => $record["users_id"],
                    "quiz_label" => $record["label"]
                );
            }

			
            if(!empty($record["group_quiz_code"])){
                $group_quiz = $this->Quiz_model->get_group_items($record["group_quiz_code"]);
                $list_group_quiz = array();
                $total_status_value = 0;
                $total_data = 0;
                foreach($group_quiz['data'] as $r_group_quiz){
                    $status = $this->Users_quiz_log->get_status_quiz($users_id, $r_group_quiz['quiz_code']);
                    switch($status['id']){
                        case 1:
                            $status_badge = 'badge-warning';
                            $status_value = 0.5;
                            break;
                        case 2:
                            $status_badge = 'badge-success';
                            $status_value = 1;
                            break;
                        default:
                            $status_badge = 'badge-danger';
                            $status_value = 0;
                            break;
                    }
                    array_push(
                        $list_group_quiz,
                        array(
                            'label' => $r_group_quiz['label'],
                            'status' => $status,
                            'badge' => $status_badge,
                            'value' => $status_value
                        )
                    );
                    $total_status_value += floatval($status_value);
                    $total_data += 1;
                }
                $data[$record["users_id"]]["quiz"][$record["quiz_id"]]["quiz_child"] = $list_group_quiz;
                $data[$record["users_id"]]["quiz"][$record["quiz_id"]]["total_progress"] = $total_status_value;
                $data[$record["users_id"]]["quiz"][$record["quiz_id"]]["total_data"] = $total_data;
                $total_percentage = round((floatval($total_status_value)/floatval($total_data)) * 100, 0);
                $data[$record["users_id"]]["quiz"][$record["quiz_id"]]["total_percentage"] = $total_percentage;

                if($total_percentage > 60){
                    $progress_color = 'bg-success';
                } else if($total_percentage >30){
                    $progress_color = 'bg-warning';
                } else if($total_percentage >= 0) {
                    $progress_color = 'bg-danger';
                }

                $data[$record["users_id"]]["quiz"][$record["quiz_id"]]["progress_color"] = $progress_color;
                $data[$record["users_id"]]["button"]["is_disabled"] = !($total_percentage == 100) ? 'disabled' : '';
            }
            
        }
        // array_view($data);

        $nomor = 1;
        foreach($data as $record){
            $res['data'][] = array(
                'id' => $record["users_id"],
                'nomor' => $nomor,
                'peserta' => $record["peserta"],
                'quiz' => $this->quiz_html($record["quiz"],$nomor),
                'button' => $record["button"]
            );

            $nomor++;
        }

        return $res["data"];
    }

    private function quiz_html($data, $nomor){
        $html = "";
        if(is_array($data)){
            $html .= '<ul class="list-group">';
            foreach($data as $record) {
                $html .= '<li class="list-group-item bg-light">
                <div class="row">
                    <div class="col-3 m-0 p-0 pr-2"><a data-toggle="collapse" href="#quizItems_'.$nomor.'">'.$record['quiz_label'].'</a></div>
                    <div class="col-8 m-0 p-0 pr-2">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped '.$record['progress_color'].'" style="width: '.$record['total_percentage'].'%;" role="progressbar" aria-valuenow="'.$record['total_percentage'].'" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-1 m-0 p-0">
                        '.$record['total_percentage'].'%
                    </div>
                </div>
                </li>';
                if(isset($record["quiz_child"])){
                    $html .= '<div class="collapse" id="quizItems_'.$nomor.'">';
                    $html .= '<ul class="list-group">';
                    foreach($record["quiz_child"] as $r_child){
                        $html .= '<li class="list-group-item">';
                        $html .= '<div class="d-flex justify-content-between">';
                        $html .= '<div class="d-flex">'.$r_child['label'].'</div>';

                        $html .= '<div class="d-flex"><span class="my-1 badge '.$r_child['badge'].'">'.$r_child['status']['label'].'</span></div>';
                        $html .= '</div>';
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                    $html .= '</div>';
                }
            }
            $html .= "</ul>";
        }
        return $html;
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

    private function get_userbysesi($sesi)
    {
        // $this->load->model('Gti_model');
        // $get = $this->Gti_model->get_userbysesi($sesi);
        // return $get['data'];
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
            $res['redirect'] = $this->base.'/gti';
            alert_js($res);
        } else {
            // $res['message'] = 'lanjut';
            $this->page_view($id);
        }
        // var_dump($res);
    }

    private function page_view($id)
    {
        $dt_view = $this->data_default();
        $dt_view['data'] = $this->set_outview($id);
        $this->load->view('Admin/gti/view', $dt_view);
    }

    private function set_outview($sesi)
    {
        $get_sesi = $this->get_sesibyid($sesi);
        $get_user = $this->get_userbysesi($get_sesi['code']);
        $set_user = array('users' => $get_user);
        $res = array_merge($get_sesi, $set_user);
        return $res;
    }

    private function get_sesibycode($code)
    {
        $this->load->model('Table_sesi');
        $get = $this->Table_sesi->get_bycode($code);
        return $get['data'][0];
    }
}
?>
