<?php
if(!defined('BASEPATH')) exit('NO direct script access allowed');

class Ajax_psycogram extends CI_Controller 
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
                $model = array('Psycogram_mdl');
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

    private function data_paten()
    {
        $dataset[1] = array(
            'label' => 'sdb',
            'data' => $this->get_sdbsda('sdb'),
            'fill' => false,
            'backgroundColor' => 'rgb(248,198,197, 0.4)',
            'borderColor' => 'rgb(248,198,197)',
            'pointBackgroundColor' => 'rgb(248,198,197)',
            'pointBorderColor' => 'rgb(248,198,197)',
            'pointHoverBackgroundColor' => 'rgb(248,198,197)',
            'pointHoverBorderColor' => 'rgb(248,198,197)',
        );

        $dataset[2] = array(
            'label' => 'sda',
            'data' => $this->get_sdbsda('sda'),
            'fill' => false,
            'backgroundColor' => 'rgb(169,241,168, 0.4)',
            'borderColor' => 'rgb(169,241,168)',
            'pointBackgroundColor' => 'rgb(169,241,168)',
            'pointBorderColor' => 'rgb(169,241,168)',
            'pointHoverBackgroundColor' => 'rgb(169,241,168)',
            'pointHoverBorderColor' => 'rgb(169,241,168)',
        );
        return $dataset;
    }

    public function data_radar()
    {
        $user = $this->input->post('data');
        $set_user = array();
        foreach($user as $key => $val) {
            $out_nilai = $this->set_outnilai($val['id']);
            // $set = array(
            //     'status_nilai' => $this->set_status($out_nilai),
            //     'hexaco' => $out_nilai);
            // $set_user[] = array_merge($val, $set);

            // $data = array('28', '48', '40', '19', '91', '27');
            $set_grafik[0] = array(
                'label' => 'Hexaco',
                'data' => $out_nilai,
                'fill' => true,
                'backgroundColor' => 'rgb(61,165,236, 0.3)',
                'borderColor' => 'rgb(61,165,236)',
                'pointBackgroundColor' => 'rgb(61,165,236)',
                'pointBorderColor' => 'rgb(61,165,236)',
                'pointHoverBackgroundColor' => 'rgb(61,165,236)',
                'pointHoverBorderColor' => 'rgb(61,165,236)');
            $extra = $this->data_paten();
            $grafik = array_merge($set_grafik, $extra);
            
            $dataset[] = array(
                'id' => $val['id'],
                'grafik' => $grafik);
        }


        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        $res['data'] = $dataset;
        echo json_encode($res);
    }

    public function data_bar()
    {
        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        echo json_encode($res);
    }

    private function get_sdbsda($column)
    {
        $get = $this->Psycogram_mdl->get_sdhexaco();
        foreach($get as $key => $val) {
            $res[] = $val[$column];
        }
        return $res;
    }

    private function set_outnilai($user)
    {
        $get_head = $this->get_headtrait();
        $data = array();
        foreach($get_head as $key => $val) {
            $data[] = $val['header'];
        }
        $header = array_unique($data);

        $dt_nilai = array();
        foreach($header as $key => $val) {
            $child = array();
            $decimal_child = array();
            $persen_child = array();
            foreach($get_head as $key1 => $val1) {
                if($val1['header'] == $val) {
                    $nilai = $this->nilai_dec($user, $val1['child']);
                    if($nilai == '') {
                        $decimal = 0;
                    } else {
                        $decimal = $nilai;
                    }

                    $bagi = ($decimal/4);
                    $persen = ($bagi/5)*100;
                    $value_trait = array('decimal' => $decimal,
                        'persen' => round($persen, 0));
                    $child[$val1['child']] = $value_trait;

                    $decimal_child[] = $decimal;
                    $persen_child[] = $persen;
                }
            }
            $sumpersen_child = array_sum($persen_child);
            $sumdecimal_child = array_sum($decimal_child);

            $nilai_head = ($sumdecimal_child/16)*10;
            $persen_head = ($sumpersen_child/4);
            // $dt_nilai[$val] = array(
            //     'nilai' => round($nilai_head, 0),
            //     'persen' => round($persen_head,0),
            //     'child' => $child);

            $dt_nilai[] = round($persen_head,0);
        }
        return $dt_nilai;

    }

    private function set_status($data)
    {
        foreach($data as $key => $val) {
            $persen[] = $val['persen'];
        }
        $sum = array_sum($persen);
        $hasil = ($sum/6);
        if($hasil > 0) {
            if($hasil > 100) {
                $status = 'false';
            } else {
                $status = 'true';
            }
        } else {
            $status = 'false';
        }
        return $status;
    }

    private function get_nilai($user, $trait)
    {
        $get = $this->Psycogram_mdl->get_nilai_hexaco($user, $trait);
        return $get;
    }

    private function nilai_dec($user, $trait)
    {
        $get_nilai = $this->get_nilai($user, $trait);
        foreach($get_nilai as $key => $val) {
            if($val['reversed_score'] != 1) {
                $nilai[] = $val['jawaban'];
            } else {
                $nilai[] = $this->reversed($val['jawaban']);
            }
        }
        return array_sum($nilai);
    }

    private function reversed($nilai)
    {
        switch($nilai) {
            case 5:
                return 1; break;
            case 4:
                return 2; break;
            case 3:
                return 3; break;
            case 2:
                return 4; break;
            case 1:
                return 5; break;
        }
    }

    private function get_headtrait()
    {
        $head = $this->Psycogram_mdl->get_header_trait();
        foreach($head as $key => $val) {
            $array[] = $val;
        }
        return $head;
    }

    private function get_infohexaco()
    {
        $get = $this->Psycogram_mdl->get_infohexaco();
        return $get;
    }

    public function get_usersbysesi()
    {
        $sesi = $this->input->post('code_sesi');
        $this->load->model('Table_users');
        $get = $this->Table_users->get_by_sesi($sesi);
        echo json_encode($get);
    }

    private function data_child($user)
    {
        $get_head = $this->get_headtrait();
        $data = array();
        foreach($get_head as $key => $val) {
            $data[] = $val['header'];
        }
        $header = array_unique($data);

        $dt_nilai = array();
        foreach($header as $key => $val) {
            $child = array();
            $decimal_child = array();
            $persen_child = array();
            foreach($get_head as $key1 => $val1) {
                if($val1['header'] == $val) {
                    $nilai = $this->nilai_dec($user, $val1['child']);
                    if($nilai == '') {
                        $decimal = 0;
                    } else {
                        $decimal = $nilai;
                    }

                    $bagi = ($decimal/4);
                    $persen = ($bagi/5)*100;

                    // $value_trait = array('label' => $val1['child'],
                    //     'nilai' => round($persen, 0));
                    // $child[] = $value_trait;

                    $child['label'][] = $val1['child'];
                    $child['nilai'][] = round($persen, 0);
                    // $child['nilai'][] = 100;

                    $decimal_child[] = $decimal;
                    $persen_child[] = $persen;
                }
            }
            $sumpersen_child = array_sum($persen_child);
            $sumdecimal_child = array_sum($decimal_child);

            $nilai_head = ($sumdecimal_child/16)*10;
            $persen_head = ($sumpersen_child/4);
            $dt_nilai[$val] = array(
                'nilai' => round($persen_head,0),
                'child' => $child);
        }
        return $dt_nilai;
    }

    private function kepanjangan_hexaco($text)
    {
        switch($text) {
            case 'He':
                return 'Honesty-Humility'; break;
            case 'Em':
                return 'Emotionality'; break;
            case 'Ex':
                return 'Extraversion'; break;
            case 'Ag':
                return 'Agreeableness'; break;
            case 'Co':
                return 'Conscientiousnesss'; break;
            case 'Op':
                return 'Openness to Experience'; break;
        }
    }

    public function child_bar()
    {
        $id = $this->input->post('data');
        $dt_child = $this->data_child($id);

        $jadi = array();
        foreach($dt_child as $key => $val) {

            $dataset[0] = array(
                'label' => $this->kepanjangan_hexaco($key),
                'data' => $val['child']['nilai'],
                'fill' => false,
                'borderWidth' => 1,
                'backgroundColor' => array(
                    'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                    'rgba(255, 205, 86, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(153, 102, 255, 0.4)',
                    'rgba(201, 203, 207, 0.4)'),

                    // 'rgb(255, 99, 132)',
                    // 'rgb(255, 159, 64)',
                    // 'rgb(255, 205, 86)',
                    // 'rgb(75, 192, 192)',
                    // 'rgb(54, 162, 235)',
                    // 'rgb(153, 102, 255)',
                    // 'rgb(201, 203, 207)'),
                'borderColor' => array(
                    // 'rgb(255, 99, 132)',
                    // 'rgb(255, 159, 64)',
                    // 'rgb(255, 205, 86)',
                    // 'rgb(75, 192, 192)',
                    // 'rgb(54, 162, 235)',
                    // 'rgb(153, 102, 255)',
                    // 'rgb(201, 203, 207)'),

                    'rgba(255, 99, 132, 0.4)',
                    'rgba(255, 159, 64, 0.4)',
                    'rgba(255, 205, 86, 0.4)',
                    'rgba(75, 192, 192, 0.4)',
                    'rgba(54, 162, 235, 0.4)',
                    'rgba(153, 102, 255, 0.4)',
                    'rgba(201, 203, 207, 0.4)'),
            );

            $set = array('labels' => $val['child']['label'],
                'datasets' => $dataset);

            $data[$key] = array('head' => $val['nilai'],
                'grafik' => $set);
        }
        
        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        $res['data'] = $data;
        echo json_encode($res);
    }


    public function dummy_radar()
    {
            // $set = array(
            //     'status_nilai' => $this->set_status($out_nilai),
            //     'hexaco' => $out_nilai);
            // $set_user[] = array_merge($val, $set);

            $out_nilai = array('28', '48', '40', '19', '91', '27');
            $set_grafik[0] = array(
                'label' => 'Hexaco',
                'data' => $out_nilai,
                'fill' => true,
                'backgroundColor' => 'rgb(61,165,236, 0.3)',
                'borderColor' => 'rgb(61,165,236)',
                'pointBackgroundColor' => 'rgb(61,165,236)',
                'pointBorderColor' => 'rgb(61,165,236)',
                'pointHoverBackgroundColor' => 'rgb(61,165,236)',
                'pointHoverBorderColor' => 'rgb(61,165,236)');
            $extra = $this->data_paten();
            $grafik = array_merge($set_grafik, $extra);
            
            $dataset[] = array(
                'grafik' => $grafik);


        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        $res['data'] = $dataset;
        echo json_encode($res);
    }

    public function data_pdf()
    {
        $sesi = $this->input->post('code_sesi');
        $this->load->model('Psycogram_mdl');
        $get = $this->Psycogram_mdl->get_bysesi($sesi);
        echo json_encode($get);
    }

    private function data_child_pdf($user)
    {
        $get_head = $this->get_headtrait();
        $data = array();
        foreach($get_head as $key => $val) {
            $data[] = $val['header'];
        }
        $header = array_unique($data);

        $dt_nilai = array();
        foreach($header as $key => $val) {
            $child = array();
            $decimal_child = array();
            $persen_child = array();
            foreach($get_head as $key1 => $val1) {
                if($val1['header'] == $val) {
                    $nilai = $this->nilai_dec($user, $val1['child']);
                    if($nilai == '') {
                        $decimal = 0;
                    } else {
                        $decimal = $nilai;
                    }

                    $bagi = ($decimal/4);
                    $persen = ($bagi/5)*100;

                    $value_trait = array('label' => $val1['child'],
                        'nilai' => round($persen, 0));
                    $child[] = $value_trait;

                    $decimal_child[] = $decimal;
                    $persen_child[] = $persen;
                }
            }
            $sumpersen_child = array_sum($persen_child);
            $sumdecimal_child = array_sum($decimal_child);

            $nilai_head = ($sumdecimal_child/16)*10;
            $persen_head = ($sumpersen_child/4);
            $dt_nilai[$val] = array(
                'nilai' => round($persen_head,0),
                'child' => $child);
        }
        return $dt_nilai;
    }

    public function data_pdf_all()
    {
        $sesi = $this->input->post('code_sesi');
		$users_id = $this->input->get('users_id');
        $this->load->model('Psycogram_mdl');
        $get_user = $this->Psycogram_mdl->get_bysesi($sesi, $users_id);

        $dt_user = array();
        foreach($get_user['data'] as $key_user => $val_user) {
            if($val_user['formasi_label'] == '') {
                $formasi = '-';
            } else {
                $formasi = $val_user['formasi_label'];
            }
            $dt_user[] = array(
                'id' => $val_user['id'],
                'fullname' => $val_user['fullname'],
                'sesi' => $val_user['sesi_label'],
                'formasi' => $formasi,
                'data' => $this->data_child_pdf($val_user['id'])
            );
        }

        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        $res['data'] = $dt_user;
        echo json_encode($res);
    }

    public function child_bar_pdf()
    {
        $user = $this->input->post('data');
        $data = array();
        foreach($user as $key => $val) {
            $dt_child = $this->data_child($val['id']);

            $child = array();
            foreach($dt_child as $key1 => $val1) {
                $dataset[0] = array(
                    'label' => $this->kepanjangan_hexaco($key),
                    'data' => $val1['child']['nilai'],
                    'fill' => false,
                    'borderWidth' => 1,
                    'backgroundColor' => array(
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(255, 205, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(201, 203, 207, 0.4)'),
                    'borderColor' => array(
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(255, 205, 86, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(201, 203, 207, 0.4)'),
                );

                $set = array('labels' => $val1['child']['label'],
                    'datasets' => $dataset);

                $child[] = array('id' => $val['id'],
                    'code' => strtolower($key1),
                    'nilai' => $val1['nilai'],
                    'grafik' => $set);
            }
            $data[] = $child;
        }

        $res['status'] = true;
        $res['message'] = 'Menampilkan data';
        $res['data'] = $data;
        echo json_encode($res);
    }
}
?>
