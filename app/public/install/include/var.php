<?php
$env_items = array();
$dirfile_items = array(
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/public/install/data')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/public/install')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/public/attachment')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../upgrade')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/storage')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/storage/session')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/storage/tmp')),
    array('type' => 'dir', 'path' => realpath(INSTALL_PATH . '/../../app/storage/log/slow')),
    array('type' => 'file', 'path' => realpath(INSTALL_PATH . '/../../bin/config.toml')),
    array('type' => 'file', 'path' => realpath(INSTALL_PATH . '/../../bin/cron.json')),
);
if (ini_get('session.save_handler') == 'files') {
    $sessionPath = session_save_path();
    if (strpos($sessionPath, ";") !== false) {
        $sessionPath = substr($sessionPath, strpos($sessionPath, ";") + 1);
    }
    if(file_exists($sessionPath)){
        $sessionPath = realpath($sessionPath);
        $dirfile_items[] = ['type' => 'file', 'path' => $sessionPath];
    }

}

$func_items = array(
    array('name' => 'fsockopen'),
    array('name' => 'file_get_contents'),
    array('name' => 'mb_convert_encoding'),
    array('name' => 'json_encode'),
);

$extension_items = array(
    array('name' => 'pdo'),
    array('name' => 'pdo_mysql'),
    array('name' => 'curl'),
);
