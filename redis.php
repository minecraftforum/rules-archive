<?php

    if(php_sapi_name() != 'cli') {
        die('CLI access only');
    }

    require 'helper.php';
    require 'class/minecraftforum.php';
    require 'class/ipbxmlrpc.php';
    
    require 'config/application.php';

    $redis = new Redis();
    $redis->connect(REDIS_IP, REDIS_PORT);
    $redis->auth(REDIS_AUTH);
    
    $minecraftforum = new Minecraftforum();
    $minecraftforum->authenticate(MCF_USER, MCF_PASS);

    $user_updates = array();
    
    echo 'Authenticated with IPB'."\n";
    
    while(true)
    {
        // listen for new users
        $user = $redis->blPop("users", 5);

        if(!$user)
            continue;
        
        $user_data = json_decode($user[1]);
        
        if(@isset($user_updates[$user_data->member_id]) && @$user_updates[$user_data->member_id] > (time() - 120)) {
            echo "user {$user_data->member_id} skipping, already updated in the last 120 seconds (2 mins) :)\n";
            continue;
        }
    
        $update = $minecraftforum->edit_member($user_data->member_id, array("field_16" => $user_data->time), $user_data->view_key);
        
        if($update) {
            $log_string = "user {$user_data->member_id} updated (time: {$user_data->time})"."\n";
            $user_updates[$user_data->member_id] = time();
            
        } else {
            $log_string = "user {$user_data->member_id} could not be updated, invalid key :( (time: {$user_data->time})"."\n";
        }
        
        $fh = fopen("../logs/user_updates.log", "a");
        fwrite($fh, $log_string);
        
        echo $log_string;
    }
    
    echo "oh no, we died :-( SOMEONE ALERT CITRICSQUID";