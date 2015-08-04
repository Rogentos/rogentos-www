<?php

define('baseURL','http://'.$_SERVER['HTTP_HOST'].'/');
define('basePath',dirname($_SERVER['DOCUMENT_ROOT']).'/');

define('publicURL',baseURL.'');
define('publicPath',basePath.'public_html/');
define('incPath',basePath.'protected/');


define('fw_pubPath',publicPath.'fw/');
define('fw_pubURL', publicURL.'fw/');
define('fw_incPath',incPath.'fw/');

define('resPath',publicPath.'RES/');
define('resURL',publicURL.'RES/');



set_include_path(basePath.'protected/');


define('dbHost', '');
define('dbName', '');
define('dbUser', '');
define('dbPass', '');

# pt mail
define('smtpServer','');
define('smtpUser','');
define('smtpPass','');
