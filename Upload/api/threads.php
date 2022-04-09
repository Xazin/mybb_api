<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'user.php');

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

if ($_GET['id']) {
    $identifier = $_GET['id'];

    $query = $db->simple_select('threads', '*', "tid = $identifier");
    $thread = $db->fetch_array($query);

    if ($thread && $thread['visible']) {
        http_response_code(200);

        $query = $db->simple_select('posts', '*', "pid = {$thread['firstpost']}");
        $post = $db->fetch_array($query);

        $thread = new Thread($thread, new Post($post));
        echo $thread->toJson();
    } else {
        http_response_code(404);
        $error = new ApiError(false, "GET request failed: no thread matching given identifier ($identifier)");
        $error->display();
    }
} else {
    // TODO: Implement paginated Users
    http_response_code(400);
    $error = new ApiError(false, 'GET request failed: missing identifier to find a thread');
    $error->display();
}
