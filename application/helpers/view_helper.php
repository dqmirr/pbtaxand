<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('nav_data')) {
  function nav_data($head, $child = NULL)
  {
    if($head == 'quiz' || 'psycogram') {
        $dt_child = array($child => 'text-primary');
    }

    if($child) {
        $dt_view = array(
            $head => 'text-primary',
            'child' => $dt_child
        );
    } else {
        $dt_view = array(
            $head => 'text-primary'
        );
    }

    $ci =& get_instance();
    $adm_uri = $ci->uri->segment(1);

    $dt_plus = array('base' => base_url($adm_uri),
        'logo' => base_url($ci->config->item('app_header_logo')),
        'app_name' => $ci->config->item('app_name'));
    $dt_view = array_merge($dt_view, $dt_plus);
    
    return $dt_view;
  }
}

if(!function_exists('alert_js')) 
{
  function alert_js($res) 
  {
    ?>
    <script>
      alert('<?=$res['message']?>');
    </script>
    <?php
    if(isset($res['redirect'])) {
      ?>
      <script>
        window.location.href = '<?=$res['redirect']?>';
      </script>
      <?php
    }
  }
}

if(!function_exists('swal_error')) 
{
  function swal_error($message) 
  {
    ?>
    <script> 
		Swal.fire('Error', '<?=$res['message']?>','error')
    </script>
    <?php
    if(isset($res['redirect'])) {
      ?>
      <script>
        window.location.href = '<?=$res['redirect']?>';
      </script>
      <?php
    }
  }
}

if(!function_exists('json_view')) {
    function json_view($data)
    {
        echo json_encode($data);
    }
}

if(!function_exists('checked_post')) {
    function checked_post($val) 
    {
        if(is_null($val)) {
            return '0';
        } else {
            return '1';
        }
    }
}

if(!function_exists('array_view')) {
    // perbanyak lagi
	function array_view($data) 
    {
        ?>
        <style>
        ul.array {
            margin-left: 50px;
        }
        ul.array li {
            padding: 3px 0 3px 0;
            list-style-type: square;
        }
        ul.array li > a { color: #444; }
        ul.array ul { padding-inline-start: 13px; }
        .menu_tog { display: none; }
        .drop_show { display: block; }
        </style>
        <?php

        if(is_array($data)) {
            print('<ul class="array">');
            $el1 = 0;
            foreach($data as $key1 => $val1) {
                if(is_array($val1)) {
                    $click = "array_drop('".$el1."')";
                    print('<li><a href="#" onclick="'.$click.'">'.$key1.' ('.count($val1).')</a></li>');

                    print('<ul id="toggle_menu_'.$el1.'" class="menu_tog drop_show">');

                    $el2 = 0;
                    foreach($val1 as $key2 => $val2) {
                        if(is_array($val2)) {
                            $elm2 = $el1.$el2;

                            $click = "array_drop('".$elm2."')";
                            print('<li><a href="#" onclick="'.$click.'">'.$key2.' ('.count($val2).')</a></li>');

                            print('<ul id="toggle_menu_'.$elm2.'" class="menu_tog drop_show">');

                            $el3 = 0;
                            foreach($val2 as $key3 => $val3) {
                                if(is_array($val3)) { 
                                    $elm3 = $el1.$el2.$el3;

                                    $click = "array_drop('".$elm3."')";
                                    print('<li><a href="#" onclick="'.$click.'">'.$key3.' ('.count($val3).')</a></li>');

                                    print('<ul id="toggle_menu_'.$elm3.'" class="menu_tog drop_show">');

                                    $el4 = 0;
                                    foreach($val3 as $key4 => $val4) {
                                        if(is_array($val4)) {
                                            $elm4 = $el1.$el2.$el3.$el4;

                                            $click = "array_drop('".$elm4."')";
                                            print('<li><a href="#" onclick="'.$click.'">'.$key4.' ('.count($val4).')</a></li>');

                                            print('<ul id="toggle_menu_'.$elm4.'" class="menu_tog drop_show">');

                                            $el5 = 0;
                                            foreach($val4 as $key5 => $val5) {
                                                if(is_array($val5)) {
                                                    $elm5 = $el1.$el2.$el3.$el4.$el5;

                                                    $click = "array_drop('".$elm5."')";
                                                    print('<li><a href="#" onclick="'.$click.'">'.$key5.' ('.count($val5).')</a></li>');

                                                    print('<ul id="toggle_menu_'.$elm5.'" class="menu_tog drop_show">');

                                                    $el6 = 0;
                                                    foreach($val5 as $key6 => $val6) {
                                                        if(is_array($val6)) {
                                                            $elm6 = $el1.$el2.$el3.$el4.$el5.$el6;

                                                            $click = "array_drop('".$elm6."')";
                                                            print('<li><a href="#" onclick="'.$click.'">'.$key6.' ('.count($val6).')</a></li>');

                                                            print('<ul id="toggle_menu_'.$elm6.'" class="menu_tog drop_show">');

                                                            foreach($val6 as $key7 => $val7) {
                                                                print('<li>'.$key7.' : "'.$val7.'"</li>');
                                                            }
                                                            print('</ul>');
                                                        } else {
                                                            print('<li>'.$key6.' : "'.$val6.'"</li>');
                                                        }
                                                        $el6++;
                                                    }
                                                    print('</ul>');
                                                } else {
                                                    print('<li>'.$key5.' : "'.$val5.'"</li>');
                                                }
                                                $el5++; 
                                            }
                                            print('</ul>');
                                        } else {
                                            print('<li>'.$key4.' : "'.$val4.'"</li>');
                                        }
                                        $el4++;
                                    }
                                    print('</ul>');  
                                } else {
                                    print('<li>'.$key3.' : "'.$val3.'"</li>');
                                }
                                $el3++;
                            }
                            print('</ul>');
                        } else {
                            print('<li>'.$key2.' : "'.$val2.'"</li>');
                        }
                        $el2++;
                    }
                    print('</ul>');
                } else {
                    print('<li>'.$key1.' : "'.$val1.'"</li>');
                }
                $el1++;
            }
            print('</ul>');
        } else {
            print('<ul><li>'.$data.'</li></ul>');
        }
        ?>

        <script>
        function array_drop(id) {
            document.getElementById("toggle_menu_"+id).classList.toggle("drop_show");
        }
        </script>

        <?php
    }
}


if(!function_exists('select_html')) {
    /// persingkat lagi
    function select_html($data, $value, $text, $select = null) 
    {
        if(!$data) {
            $res['status'] = false;
            $res['message'] = 'Parameter harus diisi';
            alert_js($res);
        } else {
            if(isset($select)) {
                foreach($data as $key => $val) {
                    if($val[$value] == $select) {
                        $html .= '<option value="'.$val[$value].'" selected>';
                        $html .= ucfirst($val[$text]);
                        $html .= '</option>';
                    } else {
                        $html .= '<option value="'.$val[$value].'">';
                        $html .= ucfirst($val[$text]);
                        $html .= '</option>';
                    }
                }
            } else {
                foreach($data as $key => $val) {
                    $html .= '<option value="'.$val[$value].'">'.ucfirst($val[$text]).'</option>';
                }
            }
            return $html;
        }
    }
}

if(!function_exists('checked_html')) {
    function checked_html($val) 
    {
        if($val != 0) {
            return 'checked';
        } else {
            return '';
        }
    }
}


if(!function_exists('setdata_grid')) {
    function setdata_grid($data, $base = null)
    {
        if(count($data) > 0) {
            foreach($data['data'] as $key => $val) {
                $act = array(
                    'view' => $base.'/view/'.$val['id'],
                    'edit' => $base.'/edit/'.$val['id'],
                    'hapus' => $base.'/hapus/'.$val['id']);
                $set[] = array_merge($val, $act);
            }
            $setdata = array('status' => true,
                'message' => $data['message'],
                'data' => $set);
            return $setdata;
        } 
    }
}


?>
