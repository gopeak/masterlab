<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2020/6/6
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\SettingModel;

class MasterlabSocketClient
{

    /**
     * @param string $command
     * @param array $sendArr
     * @param string $sid
     * @param string $token
     * @return array
     * @throws \Exception
     */
    public static function send($command, $sendArr, $sid = "", $token = "")
    {
        ignore_user_abort(true);

        $settingModel = new SettingModel();
        $settings = $settingModel->getSettingByModule('mail');
        $config = [];
        if (empty($settings)) {
            return [false, 'fetch mail setting error'];
        }
        foreach ($settings as $s) {
            $config[$s['_key']] = $settingModel->formatValue($s);
        }
        unset($settings);
        $seq = msectime();
        $sendArr['seq'] = strval($seq);

        $socketHost = '127.0.0.1';
        $socketPort = 9002;
        $socketConnectTimeout = 10;
        $socketType = 'swoole';
        if (isset($config['socket_server_host']) && !empty($config['socket_server_host'])) {
            $socketHost = trimStr($config['socket_server_host']);
        }
        if (isset($config['socket_server_port']) && !empty($config['socket_server_port'])) {
            $socketPort = intval($config['socket_server_port']);
        }
        if (isset($config['socket_connect_timeout']) && !empty($config['socket_connect_timeout'])) {
            $socketConnectTimeout = trimStr($config['socket_connect_timeout']);
        }
        $fp = @fsockopen($socketHost, $socketPort, $errno, $errstr, $socketConnectTimeout);
        if (!$fp) {
            $err = 'fsockopen failed:' . mb_convert_encoding($errno . ' ' . $errstr, "UTF-8", "GBK");
            return [false, $err];
        } else {
            if($socketType=='swoole'){
                $sendArr['cmd'] = $command;
                $sendArr['sid'] = $sid;
                $sendArr['token'] = $token;
                $sendArr['ver'] = '1.0';
                $body = json_encode($sendArr);
                $binData = pack('N',strlen($body)).$body;
            }else{
                $header = '{"cmd":"' . $command . '","sid":"' . $sid . '","ver":"1.0","seq":' . $sendArr['seq'] . ',"token":"' . $token . '"}';
                $body = json_encode($sendArr);
                $headerLen = mbstrlen($header);
                $bodyLen = mbstrlen($body);
                $totalSize = mbstrlen($header) + $bodyLen + 4;

                $binTotalSize = uInt32($totalSize);
                $binType = uInt32(1);
                $binHeaderSize = uInt32($headerLen);
                $binData = $binTotalSize . $binType . $binHeaderSize . $header . $body;
            }
            fwrite($fp, $binData);
            fclose($fp);
        }
        return [true, 'send data to async server success'];
    }

}
