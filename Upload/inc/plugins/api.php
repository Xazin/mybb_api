<?php

/**
 * Author: Mathias M
 * Copyright 2022 MathiasM, All Rights Reserved
 *
 * Website: https://mathiasm.com
 * License: http://www.mybb.com/about/license
 */

if (!defined('IN_MYBB')) {
    die('This file cannot be directly accessed');
}

function api_info()
{
    return [
        'name' => 'MyBB API',
        'description' => 'Easily add an API to your board',
        'website' => 'https://mathiasm.com',
        'author' => 'Mathias M',
        'authorsite' => 'https://mathiasm.com',
        'version' => '0.1',
        'compatibility' => '18*',
        'codename' => 'mybb_api',
    ];
}

function api_install()
{
    global $db, $mybb;

    include_once 'api/templates.php';
    include_once 'api/styles.php';

    echo '<pre><code>' . $api_template . '</code></pre>';

    $template_group = [
        'prefix' => $db->escape_string('api'),
        'title' => $db->escape_string('API'),
        'isdefault' => 0,
    ];

    $db->insert_query('templategroups', $template_group);

    $templates = [];

    $templates[] = [
        'title' => 'api',
        'template' => $db->escape_string($api_template),
        'sid' => -2,
        'version' => '',
        'dateline' => time(),
    ];

    $templates[] = [
        'title' => 'api_menu',
        'template' => $db->escape_string($api_menu_template),
        'sid' => -2,
        'version' => '',
        'dateline' => time(),
    ];

    $templates[] = [
        'title' => 'api_docs',
        'template' => $db->escape_string($api_docs_template),
        'sid' => -2,
        'version' => '',
        'dateline' => time(),
    ];

    foreach ($templates as $template) {
        $db->insert_query('templates', $template);
    }

    $style = [
        'name' => 'api.css',
        'tid' => 1,
        'attachedto' => 'api.php',
        'stylesheet' => $stylesheet,
        'cachefile' => $db->escape_string('api.css'),
        'lastmodified' => TIME_NOW,
    ];

    $sid = $db->insert_query('themestylesheets', $style);

    require_once MYBB_ROOT .
        $mybb->config['admin_dir'] .
        '/inc/functions_themes.php';

    if (
        !cache_stylesheet(
            $style['tid'],
            $style['cachefile'],
            $style['stylesheet']
        )
    ) {
        $db->update_query(
            'themestylesheets',
            ['cachefile' => "css.php?stylesheet={$sid}"],
            "sid='{$sid}'",
            1
        );
    }

    update_theme_stylesheet_list(1, false, true);
}

function api_uninstall()
{
    global $db;

    $db->delete_query('templategroups', "prefix = 'api'");
    $db->delete_query('templates', "title LIKE '%api%'");
}

function api_is_installed()
{
    global $db;

    $query = $db->simple_select('templates', '*', "title LIKE '%api%'");
    $num_rows = $db->num_rows($query);

    if ($num_rows) {
        return true;
    }

    return false;
}

function api_is_active()
{
    // TODO: Implement activated/deactivated guard
    return api_is_installed();
}

// function api_activate() {
//     // TODO: Implement activated/deactivated guard
// }

// function api_deactivate() {
//     // TODO: Implement activated/deactivated guard
// }
