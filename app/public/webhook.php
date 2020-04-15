<?php

require_once '../globals.php';

$ret = file_put_contents(STORAGE_PATH . 'log/webhook.log', print_r($_POST['event_name'], true), FILE_APPEND);
$ret = file_put_contents(STORAGE_PATH . 'log/webhook.log', print_r(json_decode($_POST['json'], true), true), FILE_APPEND);

print_r($ret);