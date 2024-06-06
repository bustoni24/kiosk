<?php
date_default_timezone_set('Asia/Jakarta');
ob_start("ob_gzhandler");
session_set_cookie_params(3600);
session_start();

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
header('Access-Control-Allow-Headers', '*');
header("Access-Control-Allow-Headers: Content-Type");
header("Cache-Control: public;max-age=604800;");

$dateExp = date('D, j M Y h:i:s');
header("Expires: ".$dateExp." GMT");

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
// require_once('dbConfig.php');
require_once('config.php');
Yii::createWebApplication($config)->run();

