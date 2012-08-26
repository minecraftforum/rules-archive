<?php

    function preint_r ($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    
    function rpc_array($array, $type = false)
    {
        if($type == "nested") {
            $array = $array["struct"]["member"];
        }
        
        foreach($array as $k => $detail) {
            $val = $detail['value'][key($detail['value'])];
            if(key($detail['value']) == "base64")
                $val = base64_decode($val);
            
            $arr[$detail["name"]] = array("type" => key($detail['value']), "value" => $val);
        }
        return $arr;
    }