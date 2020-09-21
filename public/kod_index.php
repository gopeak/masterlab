<?php
	ob_start();
	require_once '../app/globals.php';
	//var_dump(PRE_APP_PATH . 'plugin/document/kod/config/config.php');
	include(PRE_APP_PATH . 'plugin/document/kod/config/config.php');
	$app = new Application();
	init_config();
	$app->run();
?>
