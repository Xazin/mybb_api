<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'posts.php');

require_once '../global.php';
require_once './utils/errors.php';
require_once './classes/classes.php';

header('Content-Type: Application/Json');

$apiKey = $_SERVER['HTTP_API_KEY'] ?? (getallheaders()['Api-Key'] ?? null);

if ($apiKey) {
    $name = $_GET['name'] ?? $_POST['name'];
    if (empty($name)) {
        http_response_code(401);
        $error = new ApiError(false, 'Request Failed: Name is missing');
        $error->display();
    }
    
    $name = htmlspecialchars($name);
    $apiKey = htmlspecialchars($apiKey);

    $query = $db->simple_select('users', '*', "api_key = '$apiKey' AND username = '$name'");
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
        http_response_code(401);
        $error = new ApiError(false, 'Request Failed: API Key and Name combination is invalid');
        $error->display();
    }
} else {
    http_response_code(401);
    $error = new ApiError(false, 'Request Failed: API Key is missing');
    $error->display();
}
