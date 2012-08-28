<?php

define('baseURL','http://'.$_SERVER['HTTP_HOST'].'/');
define('basePath',dirname($_SERVER['DOCUMENT_ROOT']).'/');

define('publicURL',baseURL.'');
define('publicPath',basePath.'public_html/');

define('incPath',basePath.'protected/');

set_include_path(basePath.'protected/');


define('dbHost', '');
define('dbName', '');
define('dbUser', '');
define('dbPass', '');

define('smtpServer','');
define('smtpUser','');
define('smtpPass','');
