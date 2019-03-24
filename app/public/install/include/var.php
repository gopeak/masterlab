<?php
$env_items = array();
$dirfile_items = array(
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/public/install/data')),
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/public/install')),
    array('type' => 'dir', 'path' => realpath(ROOT_PATH . '/../../app/storage')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/app.cfg.php')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/database.cfg.php')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../app/config/deploy/cache.cfg.php')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../bin/config.toml')),
    array('type' => 'file', 'path' => realpath(ROOT_PATH . '/../../bin/cron.json')),
);
if (ini_get('session.save_handler') == 'files') {
    $sessionPath = session_save_path();
    if (strpos($sessionPath, ";") !== false) {
        $sessionPath = substr($sessionPath, strpos($sessionPath, ";") + 1);
    }
    $dirfile_items[] = ['type' => 'file', 'path' => realpath($sessionPath)];
}

$func_items = array(
    array('name' => 'fsockopen'),
    array('name' => 'file_get_contents'),
    array('name' => 'mb_convert_encoding'),
    array('name' => 'json_encode'),
);

$extension_items = array(
    array('name' => 'redis'),
    array('name' => 'pdo'),
    array('name' => 'pdo_mysql'),
    array('name' => 'curl'),
);
