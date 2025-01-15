<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Disc_description_model extends Ci_Model {

    public function get_description_profile($profile){
        $res = array();

        echo json_encode($profile);
        $this->db->select("*");
        $this->db->where("profil", $profile);
        $kueri = $this->db->get("disc_description");
        if(!$kueri) {
            $err = $this->db->error();
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