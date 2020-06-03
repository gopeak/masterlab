<?php
	ob_start();
	require_once '../globals.php';

	include (APP_PATH.'plugin/document/kod/config/config.php');
	$app = new Application();
	init_config();
	$app->run();
?>
