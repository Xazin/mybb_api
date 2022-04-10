<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'posts.php');

require_once '../global.php';
require_once './utils/errors.php';
require_once './classes/classes.php';

global $mybb, $db;

if ($mybb->request_method == 'post') {
    http_response_code(501);
    $error = new ApiError(false, 'POST request failed: cannot POST here');
    $error->display();
    return;
}

header('Content-Type: Application/Json');

if ($_GET['id'] || $_GET['tid'] || $_GET['fid']) {
    $identifier = $_GET['id'] ?? $_GET['tid'];
    
    
    $isId = false;
    $isFid = false;
    if ($_GET['id']) {
        $isId = true;
    }
    
    if (!$identifier && $_GET['fid']) {
        $isFid = true;
        $identifier = $_GET['fid'];
    }

    $page = 10 * (($_GET['page'] ?? 0) - 1);
    $page = $page < 1 ? 0 : $page;
    
    $query = $db->simple_select('posts', '*', $isId ? "pid = $identifier" : ($isFid ? "fid = $identifier" : "tid = $identifier"), array('limit' => 10, 'limit_start' => $page));
    
    if ($isId) {
        $post = $db->fetch_array($query);
        
        if ($post && $post['visible']) {
            http_response_code(200);
            
            $post = new Post($post);
            echo $post->toJson();
            return;
        } else {
            http_response_code(404);
            $error = new ApiError(false, "GET request failed: no post matching given identifier ($identifier)");
            $error->display();
            return;
        }
    }

    $num_rows = $db->num_rows($query);
    
    $posts = "{ \"posts\": [";
    
    $counter = 0;
    while ($post = $db->fetch_array($query)) {
        $post = new Post($post);
        $posts .= $post->toJson();

        if ($num_rows != $counter + 1) {
            $posts .= ',';
        }

        $counter++;
    }
    $posts .= "], \"count\": $counter }";

    if (!empty($posts)) {
        http_response_code(200);
        echo $posts;
    }
} else {
    http_response_code(400);
    $error = new ApiError(false, 'GET request failed: missing identifier to find a post, please use a thread or forum id');
    $error->display();
}
