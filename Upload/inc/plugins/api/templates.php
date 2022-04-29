<?php

$api_template = '<html>
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
</html>';

$api_menu_template = '<div id="sidebar">
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
        <li><a href="#users" class="sidebar-nav-item">Users</a></li>
        <li><a href="#threads" class="sidebar-nav-item">Threads</a></li>
        <li><a href="#posts" class="sidebar-nav-item">Posts</a></li>
    </ul>
</nav>
</div>';

$api_docs_template = '<div class="content">
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
                Authentication might be required for some endpoints, this will be specified when required. The API key is a 
				randomly generated string, that should be included in all requests that requires authentication.
            </p>
			<p>
				To include the API key in a request, add the <code style="color:orange">API-KEY</code> header to the request containing the API key.
			</p>
			<p>
				The authentication has it\'s own endpoint, which can be used to authenticate a specific user.
				This allows software to authenticate a user by API key instead of Username and Password.
			</p>
			<p>
				It is up to the external software to lock the usage of their systems to the specific User, this can be done by IP whitelisting, 
				or by implementing a GUID or SID lock and storing the credentials in their own database or storage.
			</p>
            <br />
            <h3>Parameters</h3>
			<table width="100%">
				<tbody>
					<tr>
						<td><div class="params"><badge class="get">GET</badge> <badge class="post" style="margin-left:6px;">POST</badge><span>name</span> <div class="description">Username of the User</div></div></td>
					</tr>
				</tbody>
			</table>
        </div>

		
		<br /><br /><br /><br /><br />
		
		<div class="method-example">
			<div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">API KEY</div>
                </div>
                <pre><code>API-KEY: 22f29bcb-95bd7a92-f91ce791-82069</code></pre>
            </div>
			
			<br /><br /><br /><br /><br />
			
            <div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">ENDPOINT</div>
                </div>
                <pre><code>{$bburl}/api/users.php</code></pre>
            </div>
			
			<br /><br /><br /><br /><br />
			
			<div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">RESPONSE</div>
                </div>
                <pre>
<code>{
    "id": 1,
    "username": "John Doe",
    "avatar": "images/default_avatar.png",
    "usergroup": 4,
    "additionalgroups": [
        "3"
    ],
    "displaygroup": 0,
    "usertitle": "Fantastic Poster",
    "away": false,
    "awayreason": "",
    "referrer": 0,
    "timeonline": 21336,
    "warningpoints": 0
}</code></pre>
            </div>
        </div>
    </div>
</section>
	
<section id="users" class="method">
    <div class="method-area">
        <div class="method-doc">
            <div class="method-title">
                <h1>Users</h1>
            </div>
            <p>
				The users endpoint can retrieve and search for a user either by their <strong>id</strong> or by their <b>username</b>. Currently both methods 
				look for an exact match.
            </p>
			<p>
				Either parameter must exist, and if multiple parameters are given only one will be used after prioritization. (ID = High, Name = Medium)
			</p>
			<br />
            <h3>Parameters</h3>
			<table width="100%">
				<tbody>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>id</span> <div class="description">Unique ID of the User</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>name</span> <div class="description">Username of the User</div></div></td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="method-example">
            <div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">ENDPOINT</div>
                </div>
                <pre><code>{$bburl}/api/users.php</code></pre>
            </div>
			
			<br /><br /><br /><br /><br />
			
			<div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">RESPONSE</div>
                </div>
                <pre>
<code>{
    "id": 1,
    "username": "John Doe",
    "avatar": "images/default_avatar.png",
    "usergroup": 4,
    "additionalgroups": [
        "3"
    ],
    "displaygroup": 0,
    "usertitle": "Fantastic Poster",
    "away": false,
    "awayreason": "",
    "referrer": 0,
    "timeonline": 21336,
    "warningpoints": 0
}</code></pre>
            </div>
        </div>
    </div>
</section>

<section id="threads" class="method">
    <div class="method-area">
        <div class="method-doc">
            <div class="method-title">
                <h1>Threads</h1>
            </div>
            <p>
				The threads endpoint can be used to retrieve either a specific thread, or a paginated list of threads. Additional option to lookup threads in specific Forums by Forum ID (FID).
            </p>
			<p>
				For the paginated response (Automatically by not including ID paramter) the amount per page is set to 10 results.
			</p>
			<br />
            <h3>Parameters</h3>
			<table width="100%">
				<tbody>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>id</span> <div class="description">Unique ID of the Thread</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>fid</span> <div class="description">Forum ID to lookup</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>page</span> <div class="description">Page to lookup</div></div></td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="method-example">
            <div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">ENDPOINT</div>
                </div>
                <pre><code>{$bburl}/api/threads.php</code></pre>
            </div>
			
			<br /><br /><br /><br /><br />
			
			<div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">RESPONSE</div>
                </div>
                <pre>
<code>{
    "id": 8,
    "subject": "Hello World",
    "fid": 2,
    "uid": 1,
    "author": "admin",
    "views": 1,
    "replies": 0,
    "closed": false,
    "sticky": false,
    "createdAt": 1651180770,
    "post": {
        "id": 22,
        "tid": 8,
        "fid": 2,
        "uid": 1,
        "author": "admin",
        "subject": "Hello World",
        "message": "This thread is the first of it\'s kind! Hello World!"
    }
}</code></pre>
            </div>
        </div>
    </div>
</section>
	
<section id="posts" class="method">
    <div class="method-area">
        <div class="method-doc">
            <div class="method-title">
                <h1>Posts</h1>
            </div>
            <p>
				The posts endpoint can be used to retrieve either a specific post, or a paginated list of posts. Additional option to lookup posts in specific Forums by Forum ID (FID) and specific Thread by Thread ID (TID).
            </p>
			<p>
				In case of multiple included parameters, the most suitable one will be picked, even if it will not have any results. (ID = High, FID = Medium, TID = Low)
			</p>
			<p>
				For the paginated response (Automatically by not including ID paramter) the amount per page is set to 10 results.
			</p>
			<br />
            <h3>Parameters</h3>
			<table width="100%">
				<tbody>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>id</span> <div class="description">Unique ID of the Post</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>fid</span> <div class="description">Forum ID to lookup posts</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>tid</span> <div class="description">Thread ID to lookup posts</div></div></td>
					</tr>
					<tr>
						<td><div class="params"><badge class="get">GET</badge><span>page</span> <div class="description">Page to lookup</div></div></td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="method-example">
            <div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">ENDPOINT</div>
                </div>
                <pre><code>{$bburl}/api/posts.php</code></pre>
            </div>
			
			<br /><br /><br /><br /><br />
			
			<div class="method-example-request">
                <div class="method-example-request-topbar">
                    <div class="method-example-request-title">RESPONSE</div>
                </div>
                <pre>
<code>{
    "id": 22,
    "tid": 8,
    "fid": 2,
    "uid": 1,
    "author": "admin",
    "subject": "Hello World",
    "message": "This thread is the first of it\'s kind! Hello World!"
}</code></pre>
            </div>
        </div>
    </div>
</section>
	
</div>';

$api_usercp_nav_template = '<tbody>
    <tr>
        <td class="tcat tcat_menu tcat_collapse">
            <div><span class="smalltext"><strong>API</strong></span></div>
        </td>
    </tr>
</tbody>
<tbody>
    <tr>
        <td class="trow1 smalltext"><a href="usercp.php?action=api_key">API Key</a></td>
    </tr>
</tbody>';

$api_usercp_manage_template = '<html>
<head>
    <title>{$mybb->settings[\'bbname\']} - Manage API Key</title>
    {$headerinclude}
</head>
<body>
    {$header}
    <table width="100%" border="0" align="center">
        <tr>
            {$usercpnav}
            <td valign="top">
                <table border="0" cellspacing="0" cellpadding="5" class="tborder">
                    <tbody>
                        <tr>
                            <td class="thead" colspan="2"><strong>Manage API Key</strong></td>
                        </tr>
                        <tr>
                            <td width="{$width}" class="trow1" valign="top">
                                <fieldset class="trow2">
                                    <legend><strong>API Key</strong></legend>
                                    <table style="width:100%" cellspacing="0" cellpadding="5">
                                        <tbody>
                                            <tr>
                                                <td>{$error}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-right:12px">
                                                    <input type="text" class="textbox" style="width:100%;text-align:center;" name="key" maxlength="75"
                                                        value="{$api_key}" readonly disabled>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <form method="post" action="usercp.php?action=api_key">
                                                        <input type="hidden" name="my_post_key"
                                                            value="{$mybb->post_code}">
                                                        <input type="submit" class="button"
                                                            style="width:100%" value="Generate New API Key">
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </td>
                            <td width="50%" class="trow1" valign="top" style="{$style}">
                                <fieldset class="trow2">
                                    <legend><strong>Requirements</strong></legend>
                                    <table cellspacing="0" cellpadding="5">
                                        <tbody>
                                            <tr style="{$poststyle}">
                                                <td style="{$poststyle_text}"><strong>{$postreq}</strong> Posts required to unlock API <i>(You have {$mybb->user[\'postnum\']})</i></td>
                                            </tr>
                                            <tr style="{$threadstyle}">
                                                <td style="{$threadstyle_text}"><strong>{$threadreq}</strong> Threads required to unlock API <i>(You have {$mybb->user[\'threadnum\']})</i></td>
                                            </tr>
                                            <tr style="{$repstyle}">
                                                <td style="{$repstyle_text}"><strong>{$repreq}</strong> Positive Reputation required to unlock API <i>(You have {$mybb->user[\'reputation\']})</i></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    {$footer}
</body>
</html>';
