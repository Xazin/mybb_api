<?php

define('IN_MYBB', 1);
define('THIS_SCRIPT', 'api.php');

$templatelist = 'api';

require_once 'global.php';

add_breadcrumb('API Documentation', 'api.php');

$plugins->run_hooks('api_start');

eval("\$menu = \"".$templates->get('api_menu')."\";");
eval("\$docs = \"".$templates->get('api_docs')."\";");

$plugins->run_hooks('api_end');

eval("\$page = \"".$templates->get('api')."\";");
output_page($page);