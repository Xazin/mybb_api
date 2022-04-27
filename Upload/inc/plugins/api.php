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

$templatelist .= 'api_usercp_nav,api_usercp_manage';

$plugins->add_hook('usercp_menu', 'usercp_nav', 40);
$plugins->add_hook('usercp_start', 'usercp_manage');

const API_KEY_LENGTH = 16;
const API_KEY_PARTS_LENGTH = 8;
const HIDDEN_STYLE = 'display:none;';
const UNLOCKED_STYLE = 'color:green';

function api_info()
{
    return [
        'name' => 'MyBB API',
        'description' => 'Easily add an API to your board',
        'website' => 'https://mathiasm.com',
        'author' => 'Mathias M',
        'authorsite' => 'https://mathiasm.com',
        'version' => '0.2',
        'compatibility' => '18*',
        'codename' => 'mybb_api',
    ];
}

function api_install()
{
    global $db, $mybb;

    // API Key Fields
    if (!$db->field_exists('api_key', 'users')) {
        $db->add_column('users', 'api_key', 'varchar(32) NOT NULL');
    }

    if (!$db->field_exists('api_key_updated', 'users')) {
        $db->add_column('users', 'api_key_updated', 'int(11) NOT NULL');
    }

    // Settings
    $query = $db->query(
        'SELECT disporder FROM ' .
            TABLE_PREFIX .
            'settinggroups ORDER BY `disporder` DESC LIMIT 1'
    );
    $disporder = $db->fetch_field($query, 'disporder') + 1;

    $settings_api = [
        'name' => 'api_settings',
        'title' => 'API Settings',
        'description' => 'Manage settings for the API',
        'disporder' => intval($disporder),
        'isdefault' => 0,
    ];

    $db->insert_query('settinggroups', $settings_api);

    $group_id = (int) $db->insert_id();

    $prefix = [
        'name' => 'api_prefix',
        'title' => 'API Key Prefix',
        'description' => 'Enter an API Key Prefix',
        'optionscode' => 'text',
        'value' => '',
        'disporder' => '0',
        'gid' => $group_id,
    ];

    $hours_per_generate = [
        'name' => 'api_hpg',
        'title' => 'Hours between API key regeneration',
        'description' =>
            'Choose how many hours a user must wait before they can generate a new API key',
        'optionscode' => 'numeric',
        'value' => '24',
        'disporder' => '0',
        'gid' => $group_id,
    ];

    $posts_requirement = [
        'name' => 'api_posts_requirement',
        'title' => 'Number of Posts required to generate an API key',
        'description' =>
            'If higher than 0, users must have this amount of posts to be able to generate an API key',
        'optionscode' => 'numeric',
        'value' => '0',
        'disporder' => '1',
        'gid' => $group_id,
    ];

    $threads_requirement = [
        'name' => 'api_threads_requirement',
        'title' => 'Number of Threads required to generate an API key',
        'description' =>
            'If higher than 0, users must have this amount of threads to be able to generate an API key',
        'optionscode' => 'numeric',
        'value' => '0',
        'disporder' => '2',
        'gid' => $group_id,
    ];

    $reputation_requirement = [
        'name' => 'api_rep_requirement',
        'title' =>
            'Number of Positive Reputation required to generate an API key',
        'description' =>
            'If higher than 0, users must have this amount of positive reputation to be able to generate an API key',
        'optionscode' => 'numeric',
        'value' => '0',
        'disporder' => '3',
        'gid' => $group_id,
    ];

    $db->insert_query('settings', $prefix);
    $db->insert_query('settings', $hours_per_generate);
    $db->insert_query('settings', $posts_requirement);
    $db->insert_query('settings', $threads_requirement);
    $db->insert_query('settings', $reputation_requirement);

    rebuild_settings();

    // Templates & Styles
    include_once 'api/templates.php';
    include_once 'api/styles.php';

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

    $templates[] = [
        'title' => 'api_usercp_nav',
        'template' => $db->escape_string($api_usercp_nav_template),
        'sid' => -2,
        'version' => '',
        'dateline' => time(),
    ];

    $templates[] = [
        'title' => 'api_usercp_manage',
        'template' => $db->escape_string($api_usercp_manage_template),
        'sid' => -2,
        'version' => '',
        'dateline' => time(),
    ];

    foreach ($templates as $template) {
        $db->insert_query('templates', $template);
    }

    require_once MYBB_ROOT . 'inc/adminfunctions_templates.php';

    find_replace_templatesets(
        'usercp_nav_misc',
        '#{\$lang->ucp_nav_view_profile\}</a></td></tr>#',
        '{$lang->ucp_nav_view_profile}</a></td></tr>
   {$api_usercp_nav}'
    );

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

    if ($db->field_exists('api_key', 'users')) {
        $db->drop_column('users', 'api_key');
    }

    if ($db->field_exists('api_key_updated', 'users')) {
        $db->drop_column('users', 'api_key_updated');
    }

    $db->write_query(
        ' DELETE FROM ' . TABLE_PREFIX . "settings WHERE name LIKE '%api_%' "
    );

    $db->write_query(
        ' DELETE FROM ' .
            TABLE_PREFIX .
            "settinggroups WHERE name = 'api_settings' "
    );
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

function generate_key()
{
    global $mybb;

    if (!empty($mybb->settings['api_prefix'])) {
        $key = clean_prefix($mybb->settings['api_prefix']) . '-';
    }

    $binaryString = random_bytes(API_KEY_LENGTH);
    $parts = str_split(bin2hex($binaryString), API_KEY_PARTS_LENGTH);
    $key .= implode('-', $parts);
    return $key;
}

function clean_prefix($prefix)
{
    return preg_replace(
        '/[^A-Za-z0-9\-]/',
        '',
        str_replace(' ', '', trim($prefix))
    );
}

function usercp_nav()
{
    global $templates, $usercpmenu;
    eval("\$usercpmenu .= \"" . $templates->get('api_usercp_nav') . "\";");
}

function usercp_manage()
{
    global $db, $mybb, $templates, $headerinclude, $usercpnav, $header, $footer;

    if ($mybb->input['action'] == 'api_key') {
        $api_key;
        if ($mybb->request_method == 'post') {
            $error;

            if (!can_generate_key()) {
                $error =
                    'You do not fulfill the requirements to generate a key.';
            }

            if (
                empty($error) &&
                !empty($mybb->user['api_key']) &&
                !empty($mybb->user['api_key_updated'])
            ) {
                $now = TIME_NOW / 60 / 60;
                $updatedAt = $mybb->user['api_key_updated'] / 60 / 60;
                $diff = floor($now - $updatedAt);

                if ($diff <= $mybb->settings['api_hpg']) {
                    $error = "{$diff} hours have passed since your last API key update. Please wait {$mybb->settings['api_hpg']} hours before updating your API key again.";
                }
            }

            if (empty($error)) {
                $api_key = generate_key();
                $db->update_query(
                    'users',
                    [
                        'api_key' => $db->escape_string($api_key),
                        'api_key_updated' => TIME_NOW,
                    ],
                    "uid = '{$mybb->user['uid']}'"
                );
            }
        }

        if (empty($api_key)) {
            $api_key = $mybb->user['api_key'];
        }

        if (
            (empty($mybb->settings['api_posts_requirement']) ||
                $mybb->settings['api_posts_requirement'] <= 0) &&
            (empty($mybb->settings['api_threads_requirement']) ||
                $mybb->settings['api_threads_requirement'] <= 0) &&
            (empty($mybb->settings['api_rep_requirement']) ||
                $mybb->settings['api_rep_requirement'] <= 0)
        ) {
            $width = '100%';
            $style = HIDDEN_STYLE;
        } else {
            $width = '50%';
            $style = '';
        }

        if (
            empty($mybb->settings['api_posts_requirement']) ||
            $mybb->settings['api_posts_requirement'] <= 0
        ) {
            $poststyle = HIDDEN_STYLE;
        } else {
            $postreq = $mybb->settings['api_posts_requirement'];

            if ($mybb->user['postnum'] >= $postreq) {
                $poststyle_text = UNLOCKED_STYLE;
            }
        }

        if (
            empty($mybb->settings['api_threads_requirement']) ||
            $mybb->settings['api_threads_requirement'] <= 0
        ) {
            $threadstyle = HIDDEN_STYLE;
        } else {
            $threadreq = $mybb->settings['api_threads_requirement'];

            if ($mybb->user['threadnum'] >= $threadreq) {
                $threadstyle_text = UNLOCKED_STYLE;
            }
        }

        if (
            empty($mybb->settings['api_rep_requirement']) ||
            $mybb->settings['api_rep_requirement'] <= 0
        ) {
            $repstyle = HIDDEN_STYLE;
        } else {
            $repreq = $mybb->settings['api_rep_requirement'];

            if ($mybb->user['reputation'] >= $repreq) {
                $repstyle_text = UNLOCKED_STYLE;
            }
        }

        eval(
            "\$api_usercp_manage = \"" .
                $templates->get('api_usercp_manage') .
                "\";"
        );

        output_page($api_usercp_manage);
    }
}

function can_generate_key()
{
    global $mybb;

    if (
        !empty($mybb->settings['api_posts_requirement']) &&
        $mybb->settings['api_posts_requirement'] > 0 &&
        $mybb->user['postnum'] < $mybb->settings['api_posts_requirement']
    ) {
        return false;
    }

    if (
        !empty($mybb->settings['api_threads_requirement']) &&
        $mybb->settings['api_threads_requirement'] > 0 &&
        $mybb->user['threadnum'] < $mybb->settings['api_threads_requirement']
    ) {
        return false;
    }

    if (
        !empty($mybb->settings['api_rep_requirement']) &&
        $mybb->settings['api_rep_requirement'] > 0 &&
        $mybb->user['reputation'] < $mybb->settings['api_rep_requirement']
    ) {
        return false;
    }

    return true;
}
