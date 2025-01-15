<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('jumlah_hari')) {
  function jumlah_hari($start, $end)
  {
    $str_start = strtotime($start);
    $str_end = strtotime($end);
    $selisih = abs($str_end - $str_start);

    // 86400 seconds in one day
    $hasil = $selisih/86400; 

    // convert to integer
    $hasil = intval($hasil+1);
    return $hasil;
  }
}

if(!function_exists('hari_indo')) {
    function hari_indo($day, $lengkap = true) 
    {
        $str_day = strtotime($day);
        $week = date('w', $str_day);
        if($lengkap == false) {
            switch ($week) {
                case 0: return 'Min';
                case 1: return 'Sen';
                case 2: return 'Sel';
                case 3: return 'Rab';
                case 4: return 'Kam';
                case 5: return 'Jum';
                case 6: return 'Sab';
                default: return 'hari tidak valid';
            }
        } else {
            switch ($week) {
                case 0: return 'Minggu';
                case 1: return 'Senin';
                case 2: return 'Selasa';
                case 3: return 'Rabu';
                case 4: return 'Kamis';
                case 5: return 'Jumat';
                case 6: return 'Sabtu';
                default: return 'hari tidak valid';
            }
        }
    }
}

if(!function_exists('jam')) {
    function jam($date) 
    {
        $dt = new DateTime($date);
        $time = $dt->format('H:i');
        return $time;
    }
}

if(!function_exists('bulan_indo')) {
    function bulan_indo($date, $lengkap = true) 
    {
        $str_day = strtotime($date);
        $bln = date('m', $str_day);
        if($lengkap == false) {
            switch ($bln) {
                case 1: return 'Jan';
                case 2: return 'Feb';
                case 3: return 'Mar';
                case 4: return 'Apr';
                case 5: return 'Mei';
                case 6: return 'Jun';
                case 7: return 'Jul';
                case 8: return 'Agus';
                case 9: return 'Sept';
                case 10: return 'Okt';
                case 11: return 'Nov';
                case 12: return 'Des';
                default: return 'bulan tidak valid';
            }
        } else {
            switch ($bln) {
                case 1: return 'Januari';
                case 2: return 'Februari';
                case 3: return 'Maret';
                case 4: return 'April';
                case 5: return 'Mei';
                case 6: return 'Juni';
                case 7: return 'Juli';
                case 8: return 'Agustus';
                case 9: return 'September';
                case 10: return 'Oktober';
                case 11: return 'November';
                case 12: return 'Desember';
                default: return 'bulan tidak valid';
            }
        }
    }
}


if(!function_exists('tgl_indo')) {
    function tgl_indo($date, $format = null) 
    {
        $hari_lkp = array('Minggu', 'Senin', 'Selasa',
            'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        $hari_skt = array('Min', 'Sen', 'Sel',
            'Rab', 'Kam', 'Jum', 'Sab');

        $bulan_lkp = array(1 => 'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember');
        $bulan_skt = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei',
            'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des');


        $str_date = strtotime($date);
        $for_date = date('Y-m-d', $str_date);
        $week = date('w', $str_date);
        $ex_date = explode('-', $for_date);

        if($format == 'dm') {
            $hasil = $ex_date[2].' '.$bulan_skt[(int)$ex_date[1]];
        } 

        if($format == 'dM') {
            $hasil = $ex_date[2].' '.$bulan_lkp[(int)$ex_date[1]];
        }

        if($format == 'd-m') {
            $hasil = $ex_date[2].'-'.$bulan_skt[(int)$ex_date[1]];
        }

        if($format == 'd-M') {
            $hasil = $ex_date[2].'-'.$bulan_lkp[(int)$ex_date[1]];
        }

        if(!$format) {
            $hasil = $ex_date[2].' '.$bulan_lkp[(int)$ex_date[1]].' '.$ex_date[0];
        }
        return $hasil;

    }
}

if(!function_exists('tgl_fromto')) {
    function tgl_fromto($start, $end) 
    {
        $bulan_lkp = array(1 => 'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember');
        $bulan_skt = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei',
            'Jun', 'Jul', 'Agus', 'Sep', 'Okt', 'Nov', 'Des');


        $str_start = strtotime($start);
        $str_end = strtotime($end);

        $for_start = date('Y-m-d', $str_start);
        $for_end = date('Y-m-d', $str_end);
        
        $ex_start = explode('-', $for_start);
        $ex_end = explode('-', $for_end);

        $bln_lkp_start = $bulan_lkp[(int)$ex_start[1]];
        $bln_lkp_end = $bulan_lkp[(int)$ex_end[1]];

        // if($bln_lkp_start != $bln_lkp_end) {
        //     $hasil = $ex_start[2].' '.$bln_lkp_start.' '.$ex_start[0].' - '.$ex_end[2].' '.$bln_lkp_end;
        // } else {
        //     $hasil = $ex_start[2].' - '.$ex_end[2].' '.$bln_lkp_end;
        // }
        return $ex_start[2].' '.$bln_lkp_start.' '.$ex_start[0].' - '.$ex_end[2].' '.$bln_lkp_end.' '.$ex_end[0];
    }
}


if(!function_exists('tgl_expaired')) {
    function tgl_expaired($date) 
    {
        $now = date('Y-m-d H:i');
        $str_now = strtotime($now);
        $str_date = strtotime($date);
		return $str_now >= $str_date;
        // if($str_date <= $str_now) {
        //     return false;
        // } else {
        //     return true;
        // }
    }
}

if(!function_exists('hitung_persen')) {
    function hitung_persen($start, $end)
    {
        $str_start = strtotime($start);
        $str_now = time(date('d/M/Y H:i:s'));
        $str_end = strtotime($end);

        $date_divide_by = $str_end - $str_start;
        $date_divide = $str_now - $str_start;
        $divide_product = $date_divide / $date_divide_by;
        $date_percent = round($divide_product * 100);

        if($date_percent > 100) {
            $res = 100;
        } else {
            $res = $date_percent;
        }
        return $res;
    }
}
?>
