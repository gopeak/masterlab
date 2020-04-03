<?php
/**
*  项目统一加载文件
*/


// 项目文件根目录（文件系统，即本文件所在目录）
define('APP_PATH', realpath(dirname(__FILE__)) . '/');
define('PRE_APP_PATH', realpath(dirname(__FILE__).'/../') . '/');

// composer自动加载文件
require_once APP_PATH. '/../vendor/autoload.php';

// 加载自定义的函数库
include_once APP_PATH . 'function/autoload.php';

// 项目状态:deploy | development
$appStatus = "";
if (file_exists(PRE_APP_PATH . 'env.ini')) {
    $envArr = parse_ini_file(PRE_APP_PATH . 'env.ini');
    $appStatus = $envArr['APP_STATUS'];
    unset($envArr);
}
if (isset($_SERVER['APP_STATUS'])) {
    $appStatus = $_SERVER['APP_STATUS'];
}
define('APP_STATUS', $appStatus);

// 加载主配置文件 config.yml
use Symfony\Component\Yaml\Yaml;
$GLOBALS['_yml_config'] = Yaml::parseFile(PRE_APP_PATH.'config.'.$appStatus.'.yml');


// 加载公共常量定义文件
include_once  APP_PATH."constants.php";

// 加载主配置文件
include_once  APP_PATH."config/app.cfg.php";

