<?php


$_config['mods'] = array( 'admin','framework' ,'project','issue','module_test');

$_config['noAuthFnc'] = array( 'issue.main.QrMobileUpload','issue.main.mobileUpload','issue.main.uploadDelete');

$_config['csrf'] = false;

$_config['perpages'] = array(
    '25'=> '25',
    '50'=>'50',
    '100'=>'100',
    '200'=>'200',
);
 

?>