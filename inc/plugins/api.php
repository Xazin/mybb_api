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

 include __DIR__.'/api/templates.php';
 include __DIR__.'/api/styles.php';

 function api_info() {
     return array(
         'name'          => 'MyBB API',
         'description'   => 'Easily add an API to your board',
         'website'       => 'https://mathiasm.com',
         'author'        => 'Mathias M',
         'authorsite'    => 'https://mathiasm.com',
         'version'       => '0.1',
         'compatibility' => '18*',
         'codename'      => 'mybb_api'
     );
 }

 function api_install() {
     global $db, $mybb;

     $template_group = array(
         'prefix'    => $db->escape_string('api'),
         'title'     => $db->escape_string('API'),
         'isdefault' => 0
     );

     $db->insert_query('templategroups', $template_group);

     $templates = [];

     $templates[] = array(
         'title'    => 'api',
         'template' => $db->escape_string('<html>
         <head>
         <title>{$mybb->settings[\'bbname\']}</title>
         {$headerinclude}
         </head>
         <body>
             
         {$header}
         
         <table width="100%" cellspacing="0" cellpadding="{$theme[\'tablespace\']}" border="0" align="center">
             <tr>
                 <td valign="top" width="200">
                     {$menu}
                 </td>
                 <td valign="top">
                     {$docs}
                 </td>
             </tr>
         </table>
         
         {$footer}
         
         </body>
         </html>'),
         'sid'      => -2,
         'version'  => '',
         'dateline' => time()
     );

     $templates[] = array(
        'title'    => 'api_menu',
        'template' => $db->escape_string('<div id="sidebar">
        <div id="sidebar-header">
            <h3>API Documentation</h3>
        </div>
        <nav role="navigation" class="sidebar-nav">
            <ul class="sidebar-nav-items">
                <li><a href="#introduction" class="sidebar-nav-item">Introduction</a></li>
                <li><a href="#authentication" class="sidebar-nav-item">Authentication</a></li>
            </ul>
            <div class="sidebar-nav-heading">
                <h5>ENDPOINTS</h5>
            </div>
            <ul class="sidebar-nav-items">
                <li><a href="#user" class="sidebar-nav-item">User</a></li>
                <li><a href="#thread" class="sidebar-nav-item">Thread</a></li>
                <li><a href="#post" class="sidebar-nav-item">Post</a></li>
            </ul>
        </nav>
        </div>'),
        'sid'      => -2,
        'version'  => '',
        'dateline' => time()
    );

    $templates[] = array(
        'title'    => 'api_docs',
        'template' => $db->escape_string('<div class="content">
        <section id="introduction" class="method">
            <div class="method-area">
                <div class="method-doc">
                    <div class="method-title">
                        <h1>API Introduction</h1>
                    </div>
                    <p>
                        This API specification enables external software to easily fetch information about the board, this includes Users and their affiliations (groups, threads, posts), 
                        Threads (specific forums, specific author), Groups (members), and more.
                    </p>
                    <p>
                        Currently there is no rate-limit nor authentication required to access the API, but it is planned that every Software must be authenticated by a private and unique
                        API Key, that must be introduced and authenticated in each headers request in the near future.
                    </p>
                    <p>
                        This project is still under development, and therefore some endpoints and options might be missing, this specification is used not only as a reference, but also as a
                        plan for upcoming features.
                    </p>
                </div>
                <div class="method-example">
                    <div class="method-example-request">
                        <div class="method-example-request-topbar">
                            <div class="method-example-request-title">BASE URI</div>
                        </div>
                        <pre><code>{$bburl}/api/</code></pre>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="authentication" class="method">
            <div class="method-area">
                <div class="method-doc">
                    <div class="method-title">
                        <h1>Authentication</h1>
                    </div>
                    <p>
                        Authentcation is currently not implemented, everyone can access all endpoints.
                    </p>
                    <p>
                        Authentication will be implemented such that, each external client must use a uniquely generated API token, and use it as the Bearer when accessing the API.
                        As plans are not final, this might change in the future. Each user can generate <strong>one</strong> API key, and can then authenticate requests using it.
                    </p>
                </div>
                <div class="method-example">
                    <div class="method-example-request">
                        <div class="method-example-request-topbar">
                            <div class="method-example-request-title">BEARER TOKEN</div>
                        </div>
                        <pre><code>Bearer: MYBB-AW6A-DWA9-A131-A69A</code></pre>
                    </div>
                </div>
            </div>
        </section>
        
        </div>'),
        'sid'      => -2,
        'version'  => '',
        'dateline' => time()
    );

    foreach ($templates as $template) {
        $db->insert_query('templates', $template);
    }

    $style = array(
        'name'         => 'api.css',
        'tid'          => 1,
        'attachedto'   => 'api.php',
        'stylesheet'   => "    .wrapper {
            max-width: 90%!important;
        }
    
        li {
            list-style: none;
            margin: 0;
            padding: 0;
            font-weight: inherit;
            font-size: inherit;
        }
        
        ul {
            margin: 0;
            padding: 0;
            font-weight: inherit;
            font-size: inherit;
            margin-block-start: 0;
            margin-block-end: 0;
        }
        
        .sidebar {
            width: 220px;
            height: 100%;
            position: relative;
            background: #fff;
            box-shadow: inset -1px 0 0 0 #e3e8ee;
            z-index: 3;
        }
        
        .sidebar-header {
            height: 80px;
            width: 220px;
            z-index: 5;
        }
        
        .sidebar-nav {
            top: 80px;
            bottom: 52px;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
            width: 100%;
            padding-top: 12px;
        }
        
        .sidebar-nav-items {
            padding: 0;
            padding-bottom: 10px;
        }
        
        .sidebar-nav-item {
            display: block;
            margin: 0;
            margin-top: 2px;
            padding: 4px 16px;
            font-weight: 500;
            font-size: 14px;
            line-height: 20px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }
        
        .sidebar-nav-item:active, .sidebar-nav-item:focus, .sidebar-nav-item:hover {
            color: #7f8fa2 !important;
        }
        
        a, a:link {
            color: #333 !important;
        }
        
        a, a:hover {
            text-decoration: none;
            outline: 0;
            cursor: pointer;
        }
    
        .content {
            top: 0;
            left: 220px;
            bottom: 0;
            right: 0;
            box-sizing: border-box;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
            background: #fff;
            outline: none!important;
            overflow-x: hidden;
        }
        
        .method {
            width: 100%;
            align-items: center;
            background: #fff;
        }
        
        .method-doc {
            width: 35vw;
            max-width: 600px;
            margin-right: 5vw;
            flex-shrink: 0;
        }
        
        .method-title {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
        }
        
        .method-example {
            padding-top: 60px;
            flex-grow: 1;
            position: sticky;
            align-self: flex-start;
            top: 0;
        }
        
        .method-area {
            display: flex;
            flex-direction: row;
            padding: 3vw;
        }
        
         .method-example-request {
            border-radius: 8px;
            background: #7f8fa2;
        }
        
        .method-example-request-topbar {
            background: #485564;
            padding: 4px;
            border-top-right-radius: 8px;
            border-top-left-radius: 8px;
        }
        
        .method-example-request-title {
            color: #cbcbcb;
            padding: 8px;
            padding-left: 12px;
        }
        
        pre {
            padding: 12px 20px;
            margin: 0;
        }
        
        code {
            color: #fff;
        }",
        'cachefile'    => $db->escape_string('api.css'),
        'lastmodified' => TIME_NOW,
    );

    $sid = $db->insert_query('themestylesheets', $style);

    require_once MYBB_ROOT . $mybb->config['admin_dir'] . '/inc/functions_themes.php';

    if (!cache_stylesheet($style['tid'], $style['cachefile'], $style['stylesheet'])) {
        $db->update_query("themestylesheets", array('cachefile' => "css.php?stylesheet={$sid}"), "sid='{$sid}'", 1);
    }

    update_theme_stylesheet_list(1, false, true);
 }

function api_uninstall() {
    global $db;

    $db->delete_query('templategroups', "prefix = 'api'");
    $db->delete_query('templates', "title LIKE '%api%'");
}

function api_is_installed() {
    global $db;

    $query = $db->simple_select('templates', '*', "title LIKE '%api%'");
    $num_rows = $db->num_rows($query);

    if ($num_rows) {
        return true;
    }

    return false;
}

function api_is_active() {
    // TODO: Implement activated/deactivated guard
    return api_is_installed();
}

// function api_activate() {
//     // TODO: Implement activated/deactivated guard
// }

// function api_deactivate() {
//     // TODO: Implement activated/deactivated guard
// }
