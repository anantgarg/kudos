<?php

// Database details

define('SERVERNAME','localhost');
define('SERVERPORT','3306');
define('DBUSERNAME','');
define('DBPASSWORD','');
define('DBNAME','');

// URL to Kudos with trailing slash

define('BASE_URL','http://localhost/kudos/');

// Facebook integration

define('FB_APPID','');
define('FB_APPSECRET','');

// Twitter integration

define('TWITTER_APIKEY','');
define('TWITTER_APISECRET','');

// Use any random value. Do not change this value after installation.

define('SERVER_SALT','');
define('API_KEY','');

// Integrations

define('BASE_DIR',dirname(__FILE__));

$integrations = array(
'facebook' => array('icon' => 'facebook'),
'twitter' => array('icon' => 'twitter'),
'zendesk' => array('icon' => 'circle-o'),
'form' => array('icon' => 'pencil'),
'appstore' => array('icon' => 'android'),
'showcase' => array('icon' => 'star'),


);