
<?php
if(!function_exists('expaired_sesi')) {
    function expaired_sesi($date)
    {
        $ci =& get_instance();
        $ci->load->helper('time_helper');
        $exp = tgl_expaired($date);
        if($exp == 1) {
            return "Kadaluwarsa";
        } else {
            return "Aktif";
        }
    }
}

if(!function_exists('button_exp')) {
    function button_exp($date)
    {
        $ci =& get_instance();
        $ci->load->helper('time_helper');
        $exp = tgl_expaired($date);
        if(!$exp) {
            $res['class'] = 'disabled';
            $res['return'] = 'return false';
        } else {
            $res['class'] = '';
            $res['return'] = 'return true';
        }
        return $res;
    }
}
?>
