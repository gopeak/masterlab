<?php

// 通用的加载文件
define('TEST_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('TEST_LOG', TEST_PATH.'data/log' );

require_once TEST_PATH.'../globals.php';
require_once TEST_PATH.'BaseTestCase.php';
define('APP_URL', ROOT_URL);
