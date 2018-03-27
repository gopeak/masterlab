<?php
/**
*  项目统一加载文件
*/


//时区设置
date_default_timezone_set('Asia/Shanghai');

// 项目文件根目录（文件系统，即本文件所在目录）
define('APP_PATH', realpath(dirname(__FILE__)) . '/');
define('PRE_APP_PATH', realpath(dirname(__FILE__).'/../') . '/');

// 加载自定义的函数库
include_once APP_PATH . 'function/autoload.php';

// 加载公共常量定义文件
include_once  APP_PATH."constants.php";

// 加载主配置文件
include_once  APP_PATH."config/".APP_STATUS."/app.cfg.php";

// composer自动加载文件
require_once APP_PATH. '/../vendor/autoload.php';
