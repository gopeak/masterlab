<?php
	ob_start();
	include ('config/config.php');
	$app = new Application();
	$GLOBALS['app'] = $app;
	init_config();
	$app->run();
?>
