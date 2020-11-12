<?php

require_once './bootstrap.php';

print_r($config);

$seq = 1;
$sendArr['cmd'] = 'Mail';
$sendArr['seq'] = $seq;
$sendArr['sid'] = $seq;
$sendArr['token'] = '';
$sendArr['ver'] = '1.0';
$sendArr = [];
$sendArr['host'] = trimStr($config['mail_host']);
$sendArr['port'] = (int)$config['mail_port'];
$sendArr['timeout'] = (int)$config['mail_timeout'];
$sendArr['user'] = trimStr($config['mail_account']);
$sendArr['password'] = trimStr($config['mail_password']);
$sendArr['from'] = trimStr($config['send_mailer']);
$sendArr['from_name'] =   $config['mail_prefix'];
$sendArr['to'] = ['121642038@qq.com'];
$sendArr['cc'] = ['79720699@qq.com'];
$sendArr['bcc'] =  [];
$sendArr['subject'] = '测试邮件异步发送';
$sendArr['body'] = '邮件内容';
$sendArr['content_type'] =  'html';
$sendArr['attach'] =  '';
$body = json_encode($sendArr).PHP_EOL;


$socketHost = trimStr($config['socket_server_host']);
$socketPort = (int)$config['socket_server_port'];
$fp = @fsockopen($socketHost, $socketPort, $errno, $errstr, 10);
if (!$fp) {
    $err = 'fsockopen failed:' . mb_convert_encoding($errno . ' ' . $errstr, "UTF-8", "GBK");
    echo $err;
    die;
}

$packge = pack('N',strlen($body)).$body;
echo $packge;
fwrite($fp, $packge);
fclose($fp);
