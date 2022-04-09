# MyBB RestAPI

This plugin allows your MyBB board to expose a Public RestAPI.

## Installation

Download the files and upload the content of the `Upload` folder to your MyBB boards root.

Go to `AdminCP > Configuration > Plugins`, locate `MyBB API` and click `Install`

You can now visit the API documentation by going to your MyBB board and appending `api.php`, eg. `https://your_board.com/api.php`.

## Features

This list describes the progress of the plugin, everything below will be implemented unless otherwise mentioned.

### Users

✅ GET: Users.php?:id
✅ GET: Users.php?:name
❌ GET: Users.php
❌ GET: Users.php?:page

### Threads

✅ GET: Threads.php?:id
❌ GET: Threads.php?:author
❌ GET: Threads.php?:author&:page
❌ GET: Threads.php?:search
❌ GET: Threads.php
❌ GET: Threads.php?:page

Note: the following endpoints are not in planning, but will be considered!
❌ POST: Threads.php
❌ PUT: Threads.php?:id

### Posts

❌ GET: Posts.php?:id
❌ GET: Posts.php?:tid
❌ GET: Posts.php?:author
❌ GET: Posts.php?:author&:page

Note: the following endpoints aer not in planning, but will be considered!
❌ POST: Posts.php
❌ PUT: Posts.php?:id

### Groups

❌ GET: Groups.php
❌ GET: Groups.php?:id
❌ GET: Groups.php?:uid
