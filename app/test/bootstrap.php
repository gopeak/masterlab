<?php

// 通用的加载文件

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('TEST_PATH', realpath(dirname(__FILE__)) . DS);
define('TEST_LOG', TEST_PATH . 'data/log');
$_SERVER['APP_STATUS'] = 'test';

require_once TEST_PATH . '../globals.php';
require_once TEST_PATH . 'BaseTestCase.php';
require_once TEST_PATH . 'BaseAppTestCase.php';
//require_once TEST_PATH . '../../../hornet-framework/src/framework/bootstrap.php';




