
<?php
if(!function_exists('array_compare')) {
    function array_compare($array1, $array2) 
    {
        $jml_array1 = count($array1);
        $jml_array2 = count($array2);

        if($jml_array1 > $jml_array2) {
            $compare = array_diff($array1, $array2);
        } 
        
        if($jml_array2 > $jml_array1) {
            $compare = array_diff($array2, $array1);
        }

        return array_values($compare);
    }
}
if(!function_exists('array_key_last') )  {
    function array_key_last($array) 
    {
        if( !empty($array) ) return key(array_slice($array, -1, 1, true));
    }
}

if(!function_exists('array_key_first')) {
    function array_key_first($arr) 
    {
        foreach($arr as $key => $unused) return $key;
    }
}

if(!function_exists('arraycompress_byvalue')) {
    function arraycompress_byvalue($arr, $value, $nilai) 
    {
        if($arr == $value) {
            $data[strtolower($value)] = $nilai;
        }
        return $data;
    }
}
?>