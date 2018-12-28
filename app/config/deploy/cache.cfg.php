<?php

$_config = [];
$_config['redis']['data'] =  [ [ 'localhost', 7379] ]  ;
$_config['redis']['session'] =  [ [ 'localhost', 7379] ]  ;
$_config['mongodb']['server'] =  array( '127.0.0.1', 27017  , 'mongodb' );

$_config['enable'] = true;

// 千分之几的概率
$_config['cache_gc_rate'] = 1000;

$_config['default_expire'] = 1000;

return $_config;
