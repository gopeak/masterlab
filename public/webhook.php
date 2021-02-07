<?php

// 用于测试webhook插件
require_once '../app/globals.php';

print_r($_POST);
$ret = file_put_contents(STORAGE_PATH . 'log/webhook.log', print_r($_POST['event_name'], true).print_r(json_decode($_POST['json'], true), true), FILE_APPEND);

print_r($ret);



