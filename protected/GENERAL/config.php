<?php

define('baseURL','http://'.$_SERVER['HTTP_HOST'].'/');
define('basePath',dirname($_SERVER['DOCUMENT_ROOT']).'/');

define('publicURL',baseURL.'');
define('publicPath',basePath.'public_html/');

define('incPath',basePath.'protected/');

set_include_path(basePath.'protected/');


define('dbHost', 'localhost');
define('dbName', 'rogentos.ro');
define('dbUser', 'rogentos');
define('dbPass', 'r0g3nt0s');

define('smtpServer','');
define('smtpUser','');
define('smtpPass','');
