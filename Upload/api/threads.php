<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'threads.php');

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
    $identifier = htmlspecialchars($_GET['id']);

    $query = $db->simple_select('threads', '*', "tid = $identifier");
    $thread = $db->fetch_array($query);

    if ($thread && $thread['visible']) {
        http_response_code(200);

        $query = $db->simple_select(
            'posts',
            '*',
            "pid = {$thread['firstpost']}"
        );
        $post = $db->fetch_array($query);

        $thread = new Thread($thread, new Post($post));
        echo $thread->toJson();
    } else {
        http_response_code(404);
        $error = new ApiError(
            false,
            "GET request failed: no thread matching given identifier ($identifier)"
        );
        $error->display();
    }
    return;
} else {
    $page = 10 * (($_GET['page'] ?? 0) - 1);
    $page = $page < 1 ? 0 : $page;

    $fid = htmlspecialchars($_GET['fid']);

    $query = $db->simple_select(
        'threads',
        '*',
        $fid ? "fid = $fid AND visible = 1" : null,
        [
            'limit' => 10,
            'limit_start' => $page,
            'order_by' => 'dateline',
            'order_dir' => 'DESC',
        ]
    );

    $num_rows = $db->num_rows($query);
    if ($num_rows) {
        $threads = "{ \"threads\": [\n";

        $counter = 0;
        while ($thread = $db->fetch_array($query)) {
            $postQuery = $db->simple_select(
                'posts',
                '*',
                "pid = {$thread['firstpost']}"
            );
            $post = $db->fetch_array($postQuery);

            $thread = new Thread($thread, new Post($post));
            $threads .= $thread->toJson();

            if ($num_rows != $counter + 1) {
                $threads .= ",\n";
            }

            $counter++;
        }
        $threads .= "\n], \"count\": $counter }";

        http_response_code(200);
        echo $threads;
    } else {
        http_response_code(404);
        $error = new ApiError(
            false,
            'GET request failed: no threads were found'
        );
        $error->display();
    }
}
