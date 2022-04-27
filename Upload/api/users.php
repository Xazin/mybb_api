<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'users.php');

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

if ($_GET['id'] || $_GET['name']) {
    $identifier = $_GET['id'] ?? $_GET['name'];

    $isId = false;
    if ($_GET['id']) {
        $isId = true;
    }

    $query = $db->simple_select(
        'users',
        '*',
        $isId ? "uid = $identifier" : "username = '$identifier'"
    );
    $user = $db->fetch_array($query);

    if ($user) {
        global $mybb;

        http_response_code(200);

        if (!$user['avatar'] || empty($user['avatar'])) {
            $user['avatar'] = $mybb->settings['useravatar'];
        }

        $user = new User($user);
        echo $user->toJson();
    } else {
        http_response_code(404);
        $error = new ApiError(
            false,
            "GET request failed: no user matching given identifier ($identifier)"
        );
        $error->display();
    }
} else {
    // TODO: Implement paginated Users
    http_response_code(400);
    $error = new ApiError(
        false,
        'GET request failed: missing identifier to find a user'
    );
    $error->display();
}
