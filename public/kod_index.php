<?php
	ob_start();
	require_once '../app/globals.php';

	include(PRE_APP_PATH . 'plugin/document/kod/config/config.php');
	$app = new Application();
	init_config();
	$app->run();
?>
