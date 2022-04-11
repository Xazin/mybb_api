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
        <li><a href="#users" class="sidebar-nav-item">User</a></li>
        <li><a href="#threads" class="sidebar-nav-item">Thread</a></li>
        <li><a href="#posts" class="sidebar-nav-item">Post</a></li>
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
	
<section id="users" class="method">
    <div class="method-area">
        <div class="method-doc">
            <div class="method-title">
                <h1>Users</h1>
            </div>
            <p>
				The users endpoint can retrieve and search for a user either by their <strong>id</strong> or by their <b>username</b>. Currently both methods 
				look for an exact match, if you need to do a search on users you can use the <i>search</i> parameter.
            </p>
			<p>
				Either parameter must exist, and if multiple parameters are given only one will be used after prioritization. (ID = High, Name = Medium, Search = Low)
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

</div>';
