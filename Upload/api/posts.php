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

$apiKey = $_SERVER['HTTP_API_KEY'] ?? (getallheaders()['Api-Key'] ?? null);

if ($apiKey) {
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

		$identifier = htmlspecialchars($identifier);
		$query = $db->simple_select(
			'posts',
			'*',
			$isId
				? "pid = $identifier"
				: ($isFid
					? "fid = $identifier"
					: "tid = $identifier"),
			[
				'limit' => 10,
				'limit_start' => $page,
				'order_by' => 'dateline',
				'order_dir' => 'DESC',
			]
		);

		if ($isId) {
			$post = $db->fetch_array($query);

			if ($post && $post['visible']) {
				http_response_code(200);
				$post['message'] = preg_replace("/\[hide\](.*?)\[\/hide\]/", "This content is hidden and can't be shown using the API", $post['message']);
				$post = new Post($post);
				echo $post->toJson();
				return;
			} else {
				http_response_code(404);
				$error = new ApiError(
					false,
					"GET request failed: no posts matching given identifier ($identifier)"
				);
				$error->display();
				return;
			}
		}

		$num_rows = $db->num_rows($query);
			if ($num_rows) {
				$posts = "{ \"posts\": [\n";

				$counter = 0;
				while ($post = $db->fetch_array($query)) {
					$post['message'] = preg_replace("/\[hide\](.*?)\[\/hide\]/", "This content is hidden and can't be shown using the API", $post['message']);
					$post = new Post($post);
					$posts .= $post->toJson();

					if ($num_rows != $counter + 1) {
						$posts .= ",\n";
					}

					$counter++;
				}
				$posts .= "\n], \"count\": $counter }";
				http_response_code(200);
				echo $posts;
			
			} else {
				http_response_code(404);
				$error = new ApiError(false, 'GET request failed: no posts were found');
				$error->display();
			}
			
		} else {
			http_response_code(400);
			$error = new ApiError(
				false,
				'GET request failed: missing identifier to find a post, please use a thread or forum id'
			);
			$error->display();
		}
	
} else {
    http_response_code(401);
    $error = new ApiError(false, 'Request Failed: API Key is missing');
    $error->display();
}


