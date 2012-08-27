<?php

    require 'helper.php';
    require 'class/klein.php';
    require 'class/markdown.php';
    
    require 'config/application.php';
    
    respond('/', function ($request, $response) {         
        $compiled_rules = array_slice(scandir('compiled', 1), 0, (count(scandir('compiled', 1)) - 2));
        $new_rule_file = file_get_contents("compiled/".$compiled_rules[0]);
        
        $old_time = $request->cookie('rule_set', false);
        $member_id = $request->cookie('rule_member_id', false);
        
        if(is_numeric($member_id)) {
            $redis = new Redis();
            $redis->connect(REDIS_IP, REDIS_PORT);
            $redis->auth(REDIS_AUTH);

            if(!$redis->ping())
                die('aw no redis :(');

            $redis->lPush('users', json_encode(array("member_id" => $member_id, "time" => time())));   
        }
        
        if($old_time) {
            
            foreach($compiled_rules as $c_r) {
                $expl = explode(".html", $c_r);
                $comp_rules[] = $expl[0];
            }

            sort($comp_rules);
            foreach ($comp_rules as $key => $c) {
                if($c >= $old_time) {
                    $old = (@$comp_rules[($key - 1)] ?: $c);
                    break;
                }
            }
            
            $old_rule_file = @file_get_contents("compiled/".$old.".html");
            
            if($old_rule_file) {
                $old_lines = explode("\n", $old_rule_file);
                foreach($old_lines as $key => $line) {
                    if(strlen(trim($line)) > 0)
                        $o_lines[sha1(strtolower($line))] = $line;
                }

                $new_lines = explode("\n", $new_rule_file);
                foreach($new_lines as $key => $line) {
                    if(strlen(trim($line)) > 0)
                        $n_lines[sha1(strtolower($line))] = $line;
                }

                foreach($n_lines as $key => $line) {
                    if(!isset($o_lines[$key])) {
                        $new_line = str_replace(array("<p>", "<li>"), array('<p class="new">', '<li class="new">'), $line);
                        $new_rule_file = str_replace($line, $new_line, $new_rule_file);
                    }
                }
            }
        }
        
        $response->render('views/rules.php', array("rules" => $new_rule_file));
    });
    
    respond('/changes/[i:old]/[i:member_id]', function ($request, $response) {    
        $old = $request->param('old');
        $member_id = $request->param('member_id', false);
        
        $response->cookie('rule_set', $old);
        
        if($member_id) {
            $response->cookie('rule_member_id', $member_id);
        }
        
        $response->redirect('/', 301);
    });
    
    respond('/compile/[*:secure_key]', function ($request, $response) {
        $secure_key = $request->param('secure_key', false);
        if($secure_key != SECURE_KEY) {
            die('invalid secure key');
        }
        
        $time = time();
        
        $rule_sets = array_slice(scandir('rules'), 2);
        $all_rules = "<!-- compiled at ".$time." -->"."\n\n";
        
        $reserved_rules = array("template");
        
        foreach($rule_sets as $set) {
            if(!in_array($set, $reserved_rules)) {
                $meta = json_decode(file_get_contents("rules/$set/meta.json"));
                $rules = file_get_contents("rules/$set/rules.markdown");
                if($meta->hidden == "0") { 
                    $rules_positioned[$meta->position] = array("rules" => $rules, "meta" => $meta);
                }
            }
        }
        
        ksort($rules_positioned);
        foreach($rules_positioned as $rule_set) {
            $meta = $rule_set["meta"];
            $compiled = Markdown($rule_set["rules"]);
            $compiled = str_replace("{last_updated}", $meta->last_updated, $compiled);
            $rules = '<div class="section_rules" data-section="'.$meta->id.'" data-lastupdate="'.$meta->last_updated.'">'."\n\n".$compiled."\n\n".'</div>';
            $all_rules .= $rules;
        }
        
        $compiled = Markdown($all_rules);
        $fh = fopen("compiled/".$time.".html", "w");
        fwrite($fh, $compiled);
        
        echo '<pre><textarea cols="100" rows="10">'.htmlspecialchars('<li id="'.$time.'">add summary here</li>').'</textarea></pre>';
    });
    
    respond('404', function ($request, $response) {
        echo '404';
    });
    
    dispatch();