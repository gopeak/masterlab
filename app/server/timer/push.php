<?php
$appDir = realpath(dirname(__FILE__). '/../../') ;
$wwwDir = realpath(dirname(__FILE__). '/../../../../') ;

require_once $appDir.'/globals.php';
require_once $wwwDir.'/hornet-framework/src/framework/bootstrap.php';

$sid = "8725173355";
$socketHost = '127.0.0.1';
$socketPort = 9002;
$socketConnectTimeout = 10;

$fp = @fsockopen($socketHost, $socketPort, $errno, $errstr, $socketConnectTimeout);
if (!$fp) {
    $err = 'fsockopen failed:' . mb_convert_encoding($errno . ' ' . $errstr, "UTF-8", "GBK");

} else {

    $header = '{"cmd":"Push","sid":"'.$sid.'","ver":"1.0","seq":0,"token":""}';
    $sendArr = [];
    $sendArr['sid'] = $sid;
    $sendArr['data'] = ["action"=>"create", "title"=>"xxxxxxxxxxxx"];
    $body = json_encode($sendArr);
    $header_len = mbstrlen($header);
    $body_len = mbstrlen($body);
    $total_size = mbstrlen($header) + $body_len + 4;

    $bin_total_size = uInt32($total_size);
    $bin_type = uInt32(1);
    $bin_header_size = uInt32($header_len);
    $bin_data = $bin_total_size . $bin_type . $bin_header_size . $header . $body;

    fwrite($fp, $bin_data);
    fclose($fp);
}