<?php

$_config = [];
$_config['redis']['data'] =  [ [ 'localhost', 6379] ]  ;
$_config['redis']['session'] =  [ [ 'localhost', 6379] ]  ;
$_config['mongodb']['server'] =  array( '127.0.0.1', 27017  , 'mongodb' );

$_config['enable'] = true;

// 千分之几的概率
$_config['cache_gc_rate'] = 100;

$_config['default_expire'] = 24*3600*14;

return $_config;
