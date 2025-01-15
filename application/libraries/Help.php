<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help
{
    public function set_edit_sql($data)
    {
        foreach($data as $key => $val) {
            if($key == $this->array_key_last($data)) {
                $str .= $key.' = ? ';
            } else {
                $str .= $key.' = ?, ';
            }
        }
        return $str;
    }

    public function set_insert_sql($data, $except = null)
    {
        if(is_null($except)) {
            foreach($data as $key => $val) {
                if($key == $this->array_key_last($data)) {
                    $str .= $key.' = ? ';
                } else {
                    $str .= $key.' = ?, ';
                }
            }
        } else {
            foreach($data as $key => $val) {
                if($key != $except) {
                    if($key == $this->array_key_last($data)) {
                        $str .= $key.' = ? ';
                    } else {
                        $str .= $key.' = ?, ';
                    }
                }
            }
        }
        return $str;
    }

    public function set_escape_sql($data, $except = null)
    {
        if(is_null($except)) {
            foreach($data as $key => $val) {
                $set[] = $val;
            }
        } else {
            foreach($data as $key => $val) {
                if($key != $except) {
                    $set[] = $val;
                }
            }
        }
        return $set;
    }

    public function set_field_sql($array)
    {
        foreach($array as $key => $val) {
            if($key == $this->array_key_last($array)) {
                $str .= $val;
            } else {
                $str .= $val.', ';
            }
        }
        return $str;
    }

    public function array_key_last($array) 
    {
        if(!empty($array)) {
            return key(array_slice($array, -1, 1, true));
        }
    }

    public function array_key_first($arr) 
    {
        foreach($arr as $key => $unused) {
            return $key;
        }
    }

    public function set_return_session($sess)
    {
        $res['__ci_last_regenerate'] = $sess['__ci_last_regenerate'];
        $res['username'] = $sess['username'];
        $res['fullname'] = $sess['fullname'];
        $res['email'] = $sess['email'];
        return $res;
    }

    public function set_foreign_off()
    {
        $this->ci =& get_instance();
        $sql = "SET FOREIGN_KEY_CHECKS = 0";
        $set = $this->ci->db->query($sql);
        return $set;
    }

    public function set_foreign_on()
    {
        $this->ci =& get_instance();
        $sql = "SET FOREIGN_KEY_CHECKS = 1";
        $this->ci->db->query($sql);
    }
}
?>
