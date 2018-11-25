<?php
$env_items = array();
$dirfile_items = array(
		array('type' => 'dir', 'path' => 'data'),
		array('type' => 'dir', 'path' => 'install'),
        array('type' => 'dir', 'path' => '../../storage'),
        array('type' => 'dir', 'path' => '../../config'),
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
    array('name' => 'mysql_pdo'),
    array('name' => 'json_encode'),
    array('name' => 'curl_init'),
);