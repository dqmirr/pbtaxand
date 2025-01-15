<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_quiz extends CI_Controller
{
    private $admin_url;
    private $base;

	private $library_group_name = 'group';
    public function __construct()
    {
        parent::__construct();
        $help = array('view_helper',
            'array_helper');
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
        
        $model = array('Admin_quiz_mdl',
            'Table_quiz',
            'Table_library',
            'Table_group_quiz',
            'Table_multi_ques',
            'Table_multi_choice');
        $this->load->model($model);
        $this->load->library('form_validation');
        $this->base = base_url($this->admin_url);
        $this->form_validation->set_error_delimiters('<span class="text-danger small">', '</span>');
    }

    public function index()
    {
        if ($this->session->userdata('is_admin') <= 0) {
			redirect($this->admin_url.'/login');
        }

        $get_data = $this->Table_quiz->get_all();
        $dt_view['table'] = $get_data['data'];
        $dt_view['nav'] = nav_data('quiz','quiz');

        $dt_view['sess'] = $this->session->userdata();
        $dt_view['admin_url'] = $this->admin_url;
        $dt_view['url'] = array(
            'base' => $this->base,
            'logout' => $this->base.'/ajax_logout');
        $dt_view['action'] = array('add' => $this->base.'/quiz/add',
            'edit' => $this->base.'/quiz/edit/',
            'del' => $this->base.'/quiz/del/',
            'view' => $this->base.'/quiz/view/');
        $this->load->view('Admin/quiz_grid', $dt_view);
        // json_view($dt_view);
    }

    public function add()
    {
        if($this->input->post()) {
            $valid = $this->validpost_soal();
            if($valid['status'] == false) {
                $this->load_view('Admin/quiz_form');
            } else {
                $this->submit_add();
            }
        } else {
            $this->load_view('Admin/quiz_form');
        }
    }

    public function submit_add()
    {
        $active = $this->input->post('active');
        $restart = $this->input->post('restart');
		$is_show = $this->input->post('is_show');

		$library_code = $this->input->post('lib_code') == $this->library_group_name ? null : $this->input->post('lib_code');
		$seconds = $this->input->post('seconds') == null ? 0 : $this->input->post('seconds');
        $data = array('code' => $this->input->post('code'),
            'library_code' => $library_code,
            'group_quiz_code' => $this->input->post('group_quiz_code'),
            'label' => $this->input->post('label'),
            'description' => $this->input->post('desc'),
            'seconds' => $seconds,
            'active' => checked_post($active),
            'is_show' => checked_post($is_show),
            'allow_restart' => checked_post($restart));

        $submit = $this->Table_quiz->insert($data);
        if($submit['status'] == false) {
            $res['status'] = false;
			$res['message'] = 'Terjadi kesalahan sistem';
			if(!empty($submit["message"])){
				$res['message'] = $submit["message"];
			}
            $res['redirect'] = $this->base.'/quiz/add';
        } else {
            $res['status'] = true;
            $res['message'] = 'Berhasil disimpan';
            $res['redirect'] = $this->base.'/quiz';
        }
        alert_js($res);
    }

    public function get_new_form()
    {
        $data = array(
            'lib_code' => $this->get_library_code(),
            'sub_lib' => $this->get_sub_lib(),
            'jenis_soal' => $this->get_jenis_soal()
        );
        return $data;
    }

    public function edit($id = null) 
    {
        if(!$id) {
            $res['status'] = false;
            $res['message'] = 'Data tidak ditemukan';
            $res['redirect'] = $this->base.'/quiz';
            alert_js($res);
        } else {
            if(!$this->input->post()) {
                $this->load_view('Admin/quiz_form', $id);
            } else {
                $this->submit_edit($id);
            }
        }
    }

    public function load_view($view, $id = null) 
    {
        $dt_view['nav'] = nav_data('quiz','quiz');
		$dt_view['library_group_name'] = $this->library_group_name;
        if(isset($id)) {
            $dt_view['form'] = $this->get_data_form($id);
            $dt_view['action_form'] = $this->base.'/quiz/edit/'.$id;
            // $dt_view['action_form'] = $this->base.'/quiz/del_multiple/'.$id;
            $dt_view['action_del'] = $this->base.'/quiz/del/';
        } else {
            $dt_view['form'] = $this->get_new_form();
            $dt_view['action_form'] = $this->base.'/quiz/add/';
        }
        $dt_view['admin_url'] = $this->admin_url;
        $this->load->view($view, $dt_view);
    }

    public function get_data_form($id)
    {
        $data = array('quiz' => $this->get_quiz($id),
            'lib_code' => $this->get_library_code(),
            'sub_lib' => $this->get_sub_lib(),
            'soal' => array('gti' => '',
                'multiple' => $this->set_multiplechoice($id)),
            'jenis_soal' => $this->get_jenis_soal()
        );
        return $data;
    }

    public function get_quiz($id)
    {
        $get = $this->Table_quiz->get($id);
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data quiz';
            alert_js($res);
        } else {
            $res = $get;
        }
        return $res;
    }

    public function get_library_code()
    {
        $get = $this->Table_library->get_all();
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data library code';
            alert_js($res);
        } else {
            $res = $get;
        }
        return $res;
    }

    public function get_sub_lib()
    {
        $get = $this->Table_group_quiz->get_all();
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data sub library code';
            alert_js($res);
        } else {
            $res = $get;
        }
        return $res;
    }

    public function get_soal_multiplechoice($id)
    {
        $get = $this->Admin_quiz_mdl->quiz_soal_multiple($id);
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data soal multiplechoice';
            alert_js($res);
        } else {
            $res = $get;
        }
        return $res;
    }


    public function set_multiplechoice($id)
    {
        $soal = $this->Admin_quiz_mdl->quiz_soal_multiple($id);
        $data_soal = $soal['data'];
        $res = array();
        $res['status'] = true;
        if(count($data_soal) > 0) {
            foreach($data_soal as $key => $val) {
                $id_multi = $val['id'];
                $get = $this->get_pilihan($id_multi);
                if(!$get['status']) {
                    $res = $get;
                } else {
                    $pilihan['pilihan'] = $get;
                    $res['status'] = true;
                    $res['data'][] = array_merge($val, $pilihan);
                }
            }
        } else {
            $res['message'] = 'Tidak ada data';
        }
        return $res;
    }


    public function get_pilihan($id_multi)
    {
        $get = $this->Admin_quiz_mdl->get_pilihan_jawaban($id_multi);
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data pilihan';
        } else {
            $res = $get;
        }
        return $res;
    }

    public function get_jenis_soal()
    {
        $get = $this->Table_quiz->get_jenis_soal();
        if(!$get['status']) {
            $res['status'] = false;
            $res['message'] = 'Tidak dapat memuat data jenis soal';
            alert_js($res);
        } else {
            $res = $get;
        }
        return $res;
    }

    public function submit_edit($id = null)
    {
        $redirect = base_url($this->admin_url).'/quiz/edit/'.$id;
        if(is_null($id)) {
            $res['message'] = 'Terjadi kesalahan sistem';
            $res['redirect'] = $redirect;
            alert_js($res);
        } else {
			
			$is_show = $this->input->post('is_show');
			// data edit quiz
			$quiz_form_body = array(
				'code' => $this->input->post('code'),
				'label' => $this->input->post('label'),
				'description' => $this->input->post('desc'),
				'library_code' => $this->input->post('lib_code'),
				'group_quiz_code' => $this->input->post('group_quiz_code'),
				'seconds' => $this->input->post('seconds'),
				'active' => $this->input->post('active') == "on" ? '1' : '0',
				'is_show' => checked_post($is_show),
				'allow_restart' => $this->input->post('restart')
			);


			$cek_update = $this->Table_quiz->update($id, $quiz_form_body);
            // $valid = $this->validpost_multiple();

            if($cek_update["status"] == false){
                alert_js($cek_update);
                $this->load_view('Admin/quiz_form', $id);
            } else {
                $res['redirect'] = $redirect;
                if(in_array($submit, false)) {
                    $res['message'] = 'Terjadi kesalahan sistem';
                } else {
                    $res['message'] = 'Berhasil diedit';
                }
                alert_js($res);
            }
            // echo json_encode($cek_update);
            // if($cek_update['status'] == false) {
			// 	alert_js($cek_update);
            //     $this->load_view('Admin/quiz_form', $id);
            // } else {
            //     $id_data = $this->input->post('id');
            //     $nomor = $this->input->post('nomor');
            //     $sulit = $this->input->post('sulit');
            //     $ques = $this->input->post('question');
            //     $parent = $this->input->post('parent_nomor');
            //     $img = $this->input->post('multi_img');
            //     $jawaban = $this->input->post('jawaban');
                
            //     $submit = array();
            //     foreach($id_data as $key => $val) {
            //         $data = array(
            //             'nomor' => $nomor[$key],
            //             'sulit' => $sulit[$key],
            //             'question' => $ques[$key],
            //             'parent_nomor' => $parent[$key],
            //             // 'multiplechoice_img_code' => $img[$key],
            //             'jawaban' => $jawaban[$key]);
            //         $submit[] = $this->Admin_quiz_mdl->edit_soal($val, $data);
            //     }

            //     $res['redirect'] = $redirect;
            //     if(in_array($submit, false)) {
            //         $res['message'] = 'Terjadi kesalahan sistem';
            //     } else {
            //         $res['message'] = 'Berhasil diedit';
            //     }
            //     alert_js($res);
            // }
        }
    }

    public function validpost_multiple()
    {
        // ini belum fix
        $config = array(
            array('field' => 'id[]',
                'rules' => 'required|numeric'),
            array('field' => 'nomor[]',
                'rules' => 'required|numeric'),
            array('field' => 'sulit[]',
                'rules' => 'required|numeric'),
            array('field' => 'parent_nomor[]',
                'rules' => 'numeric')
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

    public function validpost_soal()
    {
        $config = array(
            array('field' => 'code',
                'label' => 'Code',
                'rules' => 'required'),
            // array('field' => 'lib_code',
            //     'label' => 'Library Code',
            //     'rules' => 'required'),
            // array('field' => 'sub_lib_code',
            //     'label' => 'Sub Library Code',
            //     'rules' => 'required'),
            // array('field' => 'label',
            //     'label' => 'Label',
            //     'rules' => 'required'),
            // array('field' => 'desc',
            //     'label' => 'Deskripsi',
            //     'rules' => 'required'),
            // array('field' => 'seconds',
            //     'label' => 'Seconds',
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

    public function del($id)
    {
        // PENDING
        if(!$id) {
            $res['status'] = false;
            $res['message'] = 'Data tidak ditemukan';
        } else {
            $cek = $this->Table_quiz->check_byid($id);
            if($cek['status'] == false) {
                $res['status'] = false;
                $res['message'] = 'Data tidak ditemukan';
            } else {
                $del = $this->Table_quiz->delete($id);
                json_view($del);
            }
        }
    }

    public function del_multiple($id)
    {
        if(!$id) {
            $res['status'] = false;
            $res['message'] = 'Data tidak ditemukan';
        } else {
            $post = $this->input->post();
            $post_id = $this->input->post('id');
            $multiple = $this->get_soal_multiplechoice($id);

            foreach($multiple['data'] as $key => $val) {
                $data_ori[] = $val['id']; 
            }
            foreach($post_id as $key => $val) {
                if($val) {
                    $data_edit[] = $val; 
                }
            }
            foreach($post_id as $key => $val) {
                if(!$val) {
                    $data_add[] = array($key  => $val); 
                }
            }
            $data_delete = array_compare($data_ori, $data_edit);

            $edited = $this->edit_multiple($data_edit, $post);
            if($edited == false) {
                $res['message'] = 'Terjadi kesalahan';
            } else {
                if( !is_null($data_add) && !is_null($data_delete) ) {
                    // var_dump('complete');
                    $add_del = $this->add_and_delete($data_add, $data_delete, $post);
                    if($add_del == false) {
                        $res['message'] = 'Terjadi kesalahan';
                    } else {
                        $res['message'] = 'Berhasil disimpan';
                    }
                }

                if( !is_null($data_add) && is_null($data_delete) ) {
                    // var_dump('hanya tambah data');
                    $add = $this->add_saja($data_add, $post);
                    if($add == false) {
                        $res['message'] = 'Terjadi kesalahan';
                    } else {
                        $res['message'] = 'Berhasil disimpan';
                    }
                    // echo json_encode($add);
                }
                
                if( is_null($data_add) && !is_null($data_delete) ) {
                    // var_dump('hanya delete data');
                    $del = $this->delete_multiple($data_delete);
                    if($del == false) {
                        $res['message'] = 'Terjadi kesalahan';
                    } else {
                        $res['message'] = 'Berhasil disimpan';
                    }
                } 

                if( is_null($data_add) && is_null($data_delete) ) {
                    // var_dump('success');
                    $res['message'] = 'Berhasil disimpan';
                }
            }
            $res['redirect'] = $this->base.'/quiz/edit/'.$id;
            alert_js($res);
        }
    }

    public function add_saja($jml, $post)
    {
        $add = array();
        foreach($jml as $key => $val) {
            $ky = array_keys($val);
            $data = array(
                'jenis_soal' => $post['jenis_soal'][$key],
                'nomor' => $post['nomor'][$ky[0]],
                'sulit' => $post['sulit'][$ky[0]],
                'question' => $post['question'][$ky[0]],
                'parent_nomor' => $post['parent_nomor'][$ky[0]]);
            $add[] = $this->Table_multi_ques->add($data);
        }

        if(in_array($add, false)) {
            return false;
        } else {
            return true;
        }
    }

    public function edit_multiple($data, $post)
    {
        $edited = array();
        foreach($data as $key => $val) {
            $set_edit = array(
                'nomor' => $post['nomor'][$key],
                'sulit' => $post['sulit'][$key],
                'question' => $post['question'][$key],
                'parent_nomor' => $post['parent_nomor'][$key]);
            $edited[] = $this->Admin_quiz_mdl->edit_soal($val, $set_edit);
        }

        if(in_array($edited, false)) {
            return false;
        } else {
            return true;
        }
    }

    public function edit_like_add($jml, $id, $post) 
    {
        $edited = array();
        foreach($jml as $key => $val) {
            $ky = array_keys($val);
            $data = array(
                'jenis_soal' => $post['jenis_soal'][$key],
                'nomor' => $post['nomor'][$ky[$key]],
                'sulit' => $post['sulit'][$ky[$key]],
                'question' => $post['question'][$ky[$key]],
                'parent_nomor' => $post['parent_nomor'][$ky[$key]]);
            $edited[] = $this->Admin_quiz_mdl->edit_soal($id[$key], $data);
        }

        if(in_array($edited, false)) {
            return false;
        } else {
            return true;
        }
    }

    function delete_multiple($id_delete)
    {
        foreach($id_delete as $val) {
            $del_pilihan = $this->Table_multi_choice->delete($val);
            if($del_pilihan == false) {
                $deleted[] = false;
            } else {
                $deleted[] = $this->Table_multi_ques->delete($val);
            }
        }
        if(in_array($deleted, false)) {
            return false;
        } else {
            return true;
        }
    }

    function add_and_delete($add, $del, $post)
    {
        $edit_add = $this->edit_like_add($add, $del, $post);
        if($edit_add == false) {
            return false;
        } else {
            $slice_delete = array_slice($del, count($add));
            $deleted = $this->delete_multiple($slice_delete);
            if($deleted == false) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function view($id)
    {
        $dt_view['nav'] = nav_data('quiz','quiz');
        $dt_view['form'] = $this->get_data_form($id);
        $dt_view['admin_url'] = $this->admin_url;
        $this->load->view('Admin/quiz_detail', $dt_view);
    }
}
?>
