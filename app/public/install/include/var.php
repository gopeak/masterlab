<?php
$env_items = array();
$dirfile_items = array(
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/public/install/data')),
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/public/install')),
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/storage')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/app.cfg.php')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/database.cfg.php')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/cache.cfg.php')),
);

$func_items = array(
    #array('name' => 'mysql_connect'),
    array('name' => 'fsockopen'),
    array('name' => 'file_get_contents'),
    array('name' => 'mb_convert_encoding'),
    array('name' => 'json_encode'),
    array('name' => 'curl_init'),
);

$extension_items = array(
    array('name' => 'redis'),
    array('name' => 'pdo'),
    array('name' => 'pdo_mysql'),
    array('name' => 'curl'),
);