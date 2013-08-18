<?php

    if(empty($_REQUEST['payload']))
        die();
    
    $commit_data = json_decode($_REQUEST['payload']);
    
    require_once 'vendor/autoload.php';
    
    $repo = new PHPGit_Repository(dirname(__FILE__));
    $repo->git('fetch upstream'); 
    $repo->git('merge upstream/master');
    
    use dflydev\markdown\MarkdownParser;
    $markdownParser = new MarkdownParser();

    function safe_id_string($str) {
        $clean = iconv('UTF-8', 'ASCII//PLAIN', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
        $clean = str_replace(array("amp"), array("and"), $clean);
        return $clean;
    }
    
    $rule_sets = array_slice(scandir('rules'), 2);
    $all_rules = "";
    
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
        $compiled = $markdownParser->transformMarkdown($rule_set["rules"]);
        $compiled = str_replace("{last_updated}", $meta->last_updated, $compiled);
        $rules = '<div class="section_rules" data-section="'.$meta->id.'" data-lastupdate="'.$meta->last_updated.'">'."\n\n".$compiled."\n\n".'</div>';
        $all_rules .= $rules;
    }

    $rules_html = $markdownParser->transformMarkdown($all_rules);
    
    $html = new simple_html_dom();
    $html->load($rules_html);

    $heading_size = $heading_count = $open_ul = 0; // is this bad practice?

    $page = "";
    
    foreach ($html->find("h1,h2,h3,h4,h5,h6") as $element) { // loop through all headings
        $size = substr($element->tag, 1);
        $current[$size] = $element->id;

        $element->class = "heading";
        $element->id = ($size == 1 ? null : "{$parent_id}:") . safe_id_string($element->plaintext); // clean string for ID

        if($size == 1) // if it's a h1, set the element ID as the parent
            $parent_id = $element->id;

        if($size == 1 && !isset($page_title)) 
            $page_title = $element->innertext;

        $nav_list[] = array("size" => $size, "title" => $element->innertext, "id" => $element->id, "page" => $page);

        $element->innertext = '<a href="'.$page.'#'.$element->id.'" class="rule-anchor">'.$element->innertext.'</a>'; // anchor link next to each heading 
    }
    
    $open_ul = 0;
    $navigation = "";

    $heading_size = $heading_count = 0;

    foreach ($nav_list as $link) {
        if ($link['size'] < $heading_size) { // if the size is SMALLER than the previous, close the open lists
            $navigation .= str_repeat('</ul>', ($heading_size - $link['size']));
            $open_ul--;
        }

        if ($link['size'] > $heading_size) { // if the size is BIGGER than the previous size, open a new list
            $navigation .= '<ul>';
            $open_ul++;
        }

        $navigation .= '<li><a href="' . $link['page'] . '#' . $link['id'] . '">' . $link['title'] . '</a></li>';

        $element->innertext = '<a href="' . $link['page'] . '#' . $link['id'] . '" class="rule-anchor">' . $link['title'] . '</a>'; // anchor link next to each heading 

        $heading_size = $link['size']; // set previous size for next pass
        $heading_count++;
    }

    unset($heading_size, $heading_count);

    $navigation .= str_repeat("</ul>", $open_ul); // close any open lists
    
    $search = array(
        "{rules}",
        "{document-navigation}",
        "{date}",
        "{pretty-date}",
        "{commit-url}",
        "{commit-id}",
        "{commit-id-short}",
    );
    
    $replace = array(
        $html,
        $navigation,
        date("r", $commit_data->repository->pushed_at),
        date('d F Y', $commit_data->repository->pushed_at),
        $commit_data->repository->url,
        $commit_data->after,
        substr($commit_data->after, 0, 8),
    );
    
    $template = str_replace($search, $replace, file_get_contents("template/minecraftforum.html"));
    
    $fh = fopen("index.html", "w");
    fwrite($fh, $template);
    
?>