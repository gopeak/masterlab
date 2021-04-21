<?php

/**
 * 注:以下配置已经弃用
 */
$_config = array(
    'host' => 'smtpdm.aliyun.com',
    'port' => 25,
    'from' => array('address' => 'sender@smtp.masterlab.vip', 'name' => 'MasterlabSender'),
    'encryption' => 'ssl',
    'username' => 'sender@smtp.masterlab.vip',
    'password' => '',
    'sendmail' => '/usr/sbin/sendmail -bs',
    // 管理员邮箱
    'amdin_email' => 'sender@smtp.masterlab.vip',
    'timeout'=>16
);


return $_config;
