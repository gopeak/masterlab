<?php

// 通用的加载文件
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('TEST_PATH', realpath(dirname(__FILE__)) . DS);
define('TEST_LOG', TEST_PATH . 'data/log');

require_once TEST_PATH . '../globals.php';
require_once TEST_PATH . 'BaseTestCase.php';
require_once TEST_PATH . 'BaseAppTestCase.php';
require_once PRE_APP_PATH . 'lib/MyPdo.php';
//require_once TEST_PATH . '../../../hornet-framework/src/framework/bootstrap.php';

spl_autoload_register('testAutoload');
function testAutoload($class)
{
    if (strpos($class, 'main\\') === false) {
        return;
    }
    $class = str_replace('main\\', '', $class);
    // var_dump($class );
    $file = realpath(dirname(APP_PATH . '/../../')) . '/' . $class . '.php';
    $file = str_replace(['\\', '//'], ['/', '/'], $file);
    //  var_dump($file );
    if (is_file($file)) {
        include_once $file;
        return;
    }
}
