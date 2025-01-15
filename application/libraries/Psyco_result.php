<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Psyco_result
{
    private $users_id;
    private $quiz_code;
    private $db;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function result($users_id)
    {
        $get_aspect = $this->get_aspect();
        $eng_acc = $this->getpoint_eng_acc($users_id);
        $get_wpt = $this->hitung_wpt($users_id);
        $data = array();
        $for_matching = array();
        foreach($get_aspect['data'] as $key => $val) {
            $get_child = $this->get_child($val['id']);
            if(count($get_child['data']) > 0) {
                $child = array();
                foreach($get_child['data'] as $key1 => $val1) {
                    $acc_match = $this->like_match('ACC%', $val1['child']);
                    $eng_match = $this->like_match('ENG%', $val1['child']);
                    
                    $code_match = $this->like_match('GTQ%', $val1['child']);
                    if($code_match == true) {
                        $gti_point = $this->getdata_gti($users_id, $val1['child']);
                        $child[$val1['child']] = $gti_point;
                    } else if($val1['child'] == 'DISC') {
                        $disc_point = $this->setdata_disc($users_id, $val['label']);
                        $child[$val1['child']] = $disc_point;
                    } else if($acc_match == true) {
                        $child[$val1['child']] = $eng_acc['ACCOUNTING'];
                    } else if($eng_match == true) {
                        $child[$val1['child']] = $eng_acc['ENGLISH'];
                    } else if($val1['child'] == 'AGIL') {
                        $child[$val1['child']] = $get_wpt['point'];
                    } else {
                        $info_hexaco = $this->getinfo_hexaco();
                        foreach($info_hexaco['data'] as $key2 => $val2) {
                            if($val1['child'] == $val2['code']) {
                                $hexaco_point = $this->nilaidec_hexaco($users_id, $val2['name']);
                                if($hexaco_point == '') {
                                    $child[$val1['child']] = '0';
                                } else {
                                    $child[$val1['child']] = ($hexaco_point/4);
                                }
                            }
                        }
                    }
                    
                    
                }

                $arr_sum = array_sum($child);
                $arr_cou = count($child);
                if($arr_sum == 0) {
                    $total = 0;
                } else {
                    $total = ($arr_sum/$arr_cou);
                }
                $round_total = round($total, 0);

                $std_nilai = $this->get_std($users_id, $val['code']);
                $bg_color = array('fillColor' => [250,210,135]);
                $row = array('no' => ($key+1),
                    'aspects' => $val['label'],
                    'sum' => $arr_sum,
                    'count' => $arr_cou,
                    'total' => $total,
                    'point' => $round_total,
                    'std' => intval($std_nilai),
                    'satu' => array(
                        'content' => $round_total==1?'X':'',
                        'styles' => $std_nilai==1?$bg_color:''
                    ),
                    'dua' => array(
                        'content' => $round_total==2?'X':'',
                        'styles' => $std_nilai==2?$bg_color:''
                    ),
                    'tiga' => array(
                        'content' => $round_total==3?'X':'',
                        'styles' => $std_nilai==3?$bg_color:''
                    ),
                    'empat' => array(
                        'content' => $round_total==4?'X':'',
                        'styles' => $std_nilai==4?$bg_color:''
                    ),
                    'lima' => array(
                        'content' => $round_total==5?'X':'',
                        'styles' => $std_nilai==5?$bg_color:''
                    )
                );

                $for_matching[] = array(
					'code' => $val["code"],
					'point' => $round_total,
                    'std' => intval($std_nilai),
                    'aspect' => $val['id']);
                $data[] = $row;
            }
        }

        
        $style = array(
            'cellPadding' => 6,
            'fontStyle' => 'bold',
            'fontSize' => 14);

        // $get_wpt = $this->hitung_wpt($users_id, $quiz_code);
        $wpt_row = array('content' => $get_wpt['benar'],
            'colSpan' => '2',
            'styles' => $style);

        $get_match = $this->hitung_job_matching($for_matching);
        $job_row = array('content' => $get_match,
            'colSpan' => '2',
            'styles' => $style);
        
        $style_head = array_merge($style, array('halign' => 'right'));
        $extra_row[] = array(
            'no' => array('content' => 'WPT Score',
                'colSpan' => '5',
                'styles' => $style_head),
            'empat' => $wpt_row);
        $extra_row[] = array(
            'no' => array('content' => 'Job Person Match',
                'colSpan' => '5',
                'styles' => $style_head),
            'empat' => $job_row);



        // $deskrip = $this->set_psycodesc($for_matching);
        $strength_weakness = $this->set_psyco_strength_weakness($for_matching);
        
        $result_data = array_merge($data, $extra_row);

        // $cek = $this->set_psycodesc($for_matching);
        $descrip = $this->description_disc($users_id);
        
        $return = array('psyco' => $result_data,
            'strength' => $strength_weakness['strength'],
            'weakness' => $strength_weakness['weakness'],
            'description' => $descrip,
			'wpt_score' => $get_wpt['benar'],
			'english_score'=> $eng_acc['ENGLISH_DETAIL']['detail']['total_bobot'],
			'accounting_score'=> $eng_acc['ACCOUNTING_DETAIL']['detail']['total_bobot'],
		);

        return $return;
        // return $cek;
    }

    public function get_aspect()
    {
        $sql = "SELECT *
            FROM psyco_aspect
            WHERE 1";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    private function get_child($aspect)
    {
        $sql = "SELECT child
            FROM psyco_aspect_child
            WHERE 1
            AND aspect_id = '$aspect'";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }


    // GTI
    private function getdata_gti($users_id, $code)
    {
        $this->ci->load->model('Gti_model');
        $get = $this->ci->Gti_model->get_report($users_id);
        $key_gti = $this->set_key_gti($code);
        $perc_gti = $get['result'][$key_gti]['PERC'];

        $set_point = $this->setpoint_gti($perc_gti);

        return $set_point;
    }

    private function setpoint_gti($perc)
    {
        if($perc > 0) {
            $get_point = $this->getpoint_gti($perc);
            if($get_point['status'] == false) {
                $point = '0';
            } else {
                $point = $get_point['data']['point'];
            }
        } else {
            $point = '0';
        }
        return $point;
    }

    private function getpoint_gti($point)
    {
        $sql = "SELECT point FROM psyco_point
            WHERE 1
            AND quiz_code = 'gti_group'
            AND min <= '$point'
            AND max >= '$point'";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            $res['message'] = 'Menampilkan data point';
            $res['data'] = $kueri->result_array()[0];
        }
        return $res;
    }



    // DISC
    private function getdata_disc($users_id)
    {
        $this->ci->load->library('Disc_result');
        $result = $this->ci->disc_result->result_v2($users_id, 'disc1');
        return $result;
    }

    private function setdata_disc($users_id, $aspect)
    {
        $aspect_disc = $this->add_underscore($aspect);
        $data = $this->getdata_disc($users_id);
        $m_disc = $data['m_disc'];
        $c_disc = $data['c_disc'];

        $valid_cdisc = $this->validprofile_disc($c_disc['segment_16_list']);
        if($valid_cdisc == true) {
            $nilai_profile = $this->setnilai_disc($c_disc['profile'], $aspect_disc);
        } else {
            $nilai_profile = $this->setnilai_disc($m_disc['profile'], $aspect_disc);
        }
        return $nilai_profile;
    }

    private function validprofile_disc($data)
    {
        $satuan_valid = array();
        foreach($data as $key => $val) {
            if($val <= 2) {
                if($val >= -2) {
                    $satuan_valid[] = false;
                } else {
                    $satuan_valid[] = true;
                }
            } else {
                $satuan_valid[] = true;
            }
        }

        if(in_array(true, $satuan_valid)) {
            return true;
        } else {
            return false;
        }
    }

    private function setnilai_disc($profile, $aspect)
    {
        $get = $this->getnilai_disc($profile, $aspect);
        if($get['data']['value'] == '') {
            $data = '0';
        } else {
            $data = $get['data']['value'];
        }
        return $data;
    }

    private function getnilai_disc($profile, $aspect)
    {
        $sql = "SELECT disc_aspect.value
            FROM disc_aspect
            LEFT JOIN ref_disc_aspect
            ON ref_disc_aspect.id = disc_aspect.ref_disc_aspect_id
            WHERE 1
            AND code = '$profile'
            AND name = '$aspect'";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() == 1) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array()[0];
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    // HEXACO
    private function getinfo_hexaco()
    {
        $sql = "SELECT code, name
            FROM hexaco_info
            WHERE 1
            AND LENGTH(REPLACE(TRIM(code), CHAR(0x00 using utf8), '')) > 1";
        $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }

    private function getnilai_hexaco($user, $trait)
    {
        $this->ci->load->model('Psycogram_mdl');
        $get = $this->ci->Psycogram_mdl->get_nilai_hexaco($user, $trait);
        return $get;
    }

    private function nilaidec_hexaco($user, $trait)
    {
        $get_nilai = $this->getnilai_hexaco($user, $trait);
        foreach($get_nilai as $key => $val) {
            if($val['reversed_score'] != 1) {
                $nilai[] = $val['jawaban'];
            } else {
                $nilai[] = $this->reversed($val['jawaban']);
            }
        }
        return array_sum($nilai);
    }


    // ENGLISH & ACCOUNTING
    private function getpoint_eng_acc($users_id)
    {
        $this->ci->load->library('Exam_multiplechoice');
        $data = $this->ci->exam_multiplechoice->get_psyco_point($users_id);
        return $data;
    }

    private function get_wpt($users_id)
    {
        $sql = "SELECT
                b.nomor, c.choice as jawaban, b.jawaban as jawaban_benar
            FROM
                multiplechoice_jawaban a,
                multiplechoice_question b,
                multiplechoice_choices c
            WHERE
                a.jenis_soal = b.jenis_soal
                AND
                a.multiplechoice_question_id = b.id
                AND
                a.multiplechoice_choices_id = c.id
                AND
                b.id = c.multiplechoice_question_id
                AND
                a.jenis_soal = 'wpt_taxand'
                AND
                a.users_id = ?
            ORDER BY a.date_created ASC";
        $kueri = $this->ci->db->query($sql, array($users_id));

        // $sql = "SELECT *
        //     FROM dummy_wpt
        //     WHERE 1
        //     LIMIT 100";
        // $kueri = $this->ci->db->query($sql);
        if(!$kueri) {
            $err = $this->ci->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data formasi';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $kueri->result_array();
    }

    private function hitung_wpt($users_id)
    {
        $data = $this->get_wpt($users_id);
        $nilai = 0;
        foreach($data as $key => $val) {
            if($val['jawaban'] == $val['jawaban_benar']) {
                $nilai += 1;
            } else {
                $nilai += 0;
            }
        }
        return array('benar' => $nilai,
            'salah' => (count($data)-$nilai),
            'terjawab' => count($data),
            'point' => (INT) $this->getpoint_wpt($nilai));
    }

    private function getpoint_wpt($nilai)
    {
        $sql = "SELECT point FROM psyco_point
            WHERE 1
            AND quiz_code = 'wpt_taxand'
            AND min <= ?
            AND max >= ?";
        $escape = array($nilai, $nilai);
        $kueri = $this->ci->db->query($sql, $escape);
        if(!$kueri) {
            return 0;
        } else {
            return $kueri->result_array()[0]['point'];
        }
    }

    
    



    private function hitung_job_matching($data)
    {
        $point = array();
        $std = array();
        foreach($data as $key => $val) {
            $point[] = $val['point'];
            $std[] = $val['std'];
			$queries[] = "SELECT '".$val["code"]."' AS code, skor, std, job_person_match FROM job_match_std jms WHERE jms.std = ".$val['std']." AND jms.skor = ".$val['point']." ";
        }

		$sql = join(" UNION ", $queries).";";

		$exe_sql = $this->ci->db->query($sql);
		$list_job_person_match = $exe_sql->result_array();

		$sum_job_person_match = array_reduce($list_job_person_match, function($a, $b){
			$b_num = intval(explode("%",$b["job_person_match"])[0]);
			return $a + $b_num;
		},0);

		$average_job_person_match = round($sum_job_person_match/count($list_job_person_match), 0);
		if(!is_nan($average_job_person_match)){
			return $average_job_person_match.'%';
		} else {
			return '0%';
		}
    }












    // NILAI STANDAR PER POSISI
    private function get_std($users_id, $code_aspect)
    {
        $get_posisi = $this->get_posisi_user($users_id);
        $posisi = $get_posisi['data'];
        $get_nilai = $this->get_nilai_std($posisi['posisi'], $posisi['tingkatan'], $code_aspect);
        return $get_nilai;
    }

    private function get_posisi_user($users_id)
    {
        $sql = "SELECT posisi, tingkatan
            FROM formasi
            LEFT JOIN users
            ON users.formasi_code = formasi.code
            WHERE 1
            AND users.id = ?";
        $kueri = $this->ci->db->query($sql, array($users_id));
        if(!$kueri) {
            $err = $this->db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            $res['message'] = 'Menampilkan data point';
            $res['data'] = $kueri->result_array()[0];
        }
        return $res;
    }

    private function get_nilai_std($posisi, $level, $aspect)
    {
        if($level) {
            $sql_level = 'AND posisi_level.id = ?';
            $escape = array($aspect, $posisi, $level);
        } else {
            $sql_level = '';
            $escape = array($aspect, $posisi);
        }

        $sql = "SELECT
            psyco_std.nilai
            FROM psyco_std
            LEFT JOIN posisi_jabatan
            ON posisi_jabatan.id = psyco_std.posisi
            LEFT JOIN posisi_level
            ON posisi_level.id = psyco_std.level
            LEFT JOIN psyco_aspect
            ON psyco_aspect.id = psyco_std.aspect
            WHERE 1
            AND psyco_aspect.code = ?
            AND posisi_jabatan.id = ?
            $sql_level";
        $kueri = $this->ci->db->query($sql, $escape);
        if(!$kueri) {
            return '0';
        } else {
            return $kueri->result_array()[0]['nilai'];
        }
    }


    // DESKRIPSI PSYCHOGRAM
    private function get_psycodesc($aspect, $point)
    {
        $sql = "SELECT *
            FROM psyco_desc
            WHERE 1
            AND aspect = ?
            AND point = ?";
        $escape = array($aspect, $point);
        $kueri = $this->ci->db->query($sql, $escape);
        if(!$kueri) {
            return '0';
        } else {
            return $kueri->result_array()[0];
        }
    }

    public function set_psyco_strength_weakness($for_matching)
    {
        $this->ci->load->model("psycogram_mdl");

        $aspects = $this->ci->psycogram_mdl->get_psyco_aspect();
        $strg = array();
        $weak = array();

        $dt_strength = array();
        $dt_weakness = array();
        

        foreach($for_matching as $key => $val) {
            $i_aspects = array_search($val["code"], array_column($aspects["data"],"code"));
            $val["label"] = $aspects["data"][$i_aspects]["label"];

            if($val['std'] != 0 && $val['point'] != 0) {
                if($val['point'] < $val['std']) {
                    $weak[] = $val;
                } else {
                    $strg[] = $val;
                }
            }
        }

        if(count($weak) > 0){
            $weak = $this->aasort_array($weak, 'point', SORT_ASC);
            $weak = array_slice($weak, 0,3);
            $dt_weakness = array_column($weak,"label");
        }

        if(count($strg) > 0){
            $strg = $this->aasort_array($strg, 'point', SORT_DESC);
            $strg = array_slice($strg, 0,3);
            $dt_strength = array_column($strg,"label");
        }

        return array('strength' => $dt_strength,
            'weakness' => $dt_weakness);
    }


    public function set_psycodesc($for_matching)
    {
        $strg = array();
        $weak = array();

        foreach($for_matching as $key => $val) {
            if($val['std'] != 0 && $val['point'] != 0) {
                if($val['point'] < $val['std']) {
                    $weak[] = $val;
                } else {
                    $strg[] = $val;
                }
            }
        }

        if($strg != null) {
            $strength = $this->set_strengths($strg);
            foreach($strength as $key => $val) {
                $get = $this->get_psycodesc($val['aspect'], $val['point']);
                if($get != NULL) {
                    $dt_strength[] = $get['deskripsi'];
                }
            }
        }

        if($weak != null) {
            $weakness = $this->set_weakness($weak);
            foreach($weakness as $key => $val) {
                $get = $this->get_psycodesc($val['aspect'], $val['point']);
                if($get != NULL) {
                    $dt_weakness[] = $get['deskripsi'];
                }
            }
        }

        return array('strength' => $dt_strength,
            'weakness' => $dt_weakness);
    }

    private function set_strengths($for_matching)
    {
        $unset = $this->unset_aspect($for_matching);
        $sort = $this->aasort_array($unset, 'point', SORT_DESC);
        $data = array();
        foreach($sort as $key => $val) {
            if($key < 3) {
                $data[] = $val;
            }
        }
        return $data;
    }

    

    private function set_weakness($for_matching)
    {
        $unset = $this->unset_aspect($for_matching);
        $sort = $this->aasort_array($unset, 'point', SORT_ASC);
        $data = array();
        foreach($sort as $key => $val) {
            if($key < 3) {
                $data[] = $val;
            }
        }
        return $data;
    }




    
    



    // HELPER
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

    private function like_match($pattern, $subject)
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    private function set_key_gti($code)
    {
        switch($code) {
            case 'GTQ1':
                return 'Subtest 1'; break;
            case 'GTQ2':
                return 'Subtest 2'; break;
            case 'GTQ3':
                return 'Subtest 3'; break;
            case 'GTQ4':
                return 'Subtest 4'; break;
        }
    }

    private function add_underscore($text)
    {
        $ex = explode(" ",$text);
        if(count($ex) > 0) {
            foreach($ex as $key => $val) {
                if($key == 0) {
                    $jadi .= 'disc_'.$val;
                } else {
                    $jadi .= '_'.$val;
                }
            }
        } else {
            $jadi = $aspect;
        }
        return $jadi;
    }

    private function aasort_array($array, $by, $sorting)
    {
        $data = array();
        foreach ($array as $key => $row)
        {
            $data[$key] = $row[$by];
        }
        array_multisort($data, $sorting, $array);
        return $array;
    }

    private function unset_aspect($data)
    {
        foreach($data as $key => $val) {
            if($val['aspect'] <= 10) {
                $unset[] = $val;
            }
        }
        return $unset;
    }

    private function description_disc($users_id){
        $descrip = array();
        $this->ci->load->library('Disc_result');
        $disc = $this->ci->disc_result->result_v2($users_id, 'disc1');
        
        if($this->ci->disc_result->is_profile_can_descip($disc["c_disc"]["profile"])){

            $disc_descrip = $this->get_description_profile($disc["c_disc"]["profile"]);
            $key_desc = array_rand($disc_descrip["data"][0], 1);
            return $disc_descrip["data"][0][$key_desc];

        } else if($this->ci->disc_result->is_profile_can_descip($disc["m_disc"]["profile"])){

            $disc_descrip = $this->get_description_profile($disc["m_disc"]["profile"]);
            $key_desc = array_rand($disc_descrip["data"][0], 1);
            return $disc_descrip["data"][0][$key_desc];

        } else if($this->ci->disc_result->is_profile_can_descip($disc["l_disc"]["profile"])){

            $disc_descrip = $this->get_description_profile($disc["l_disc"]["profile"]);
            $key_desc = array_rand($disc_descrip["data"][0], 1);
            return $disc_descrip["data"][0][$key_desc];

        }

        return "";
    }

    public function get_description_profile($profile){
        $res = array();
        $db = $this->ci->db;
        $db->select("description_1, description_2");
        $db->where("profil", $profile);
        $kueri = $db->get("disc_description");
        if(!$kueri) {
            $err = $db->error();
            $res['status'] = false;
            $res['message'] = $err['message'];
            $res['data'] = $err;
        } else {
            $res['status'] = true;
            if($kueri->num_rows() > 0) {
                $res['message'] = 'Menampilkan data disc description';
                $res['data'] = $kueri->result_array();
            } else {
                $res['message'] = 'Tidak Ada Data';
                $res['data'] = null;
            }
        }
        return $res;
    }
    
}
?>
