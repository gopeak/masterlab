<?php

$currentDir = realpath(dirname(__FILE__). '/') ;

require $currentDir.'/bootstrap.php';

$issueModel = new \main\app\model\issue\IssueModel();
$issueModel->cache->redis = null;
$issueModel->cache->pconnect();
var_dump($issueModel->cache->redis);
while (1) {
    try {
        $get = $issueModel->cache->redis->LPOP('webhook');
        if($get){
            $jsonArr = unserialize($get);
            var_dump($jsonArr);
            if(!empty($jsonArr)){
                fsockopenPost($jsonArr['url'], $jsonArr['data'], $jsonArr['timeout']);
            }
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function fsockopenPost($url, $data, $timeout)
{
    $urlInfo = parse_url($url);
    if (!isset($urlInfo["port"])) {
        $urlInfo["port"] = 80;
    }
    $fp = fsockopen($urlInfo["host"], $urlInfo["port"], $errno, $errStr, $timeout);
    $content = http_build_query($data);
    fwrite($fp, "POST " . $urlInfo["path"] . " HTTP/1.1\r\n");
    fwrite($fp, "Host: " . $urlInfo["host"] . "\r\n");
    fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
    fwrite($fp, "Content-Length: " . strlen($content) . "\r\n");
    fwrite($fp, "Connection: close\r\n");
    fwrite($fp, "\r\n");
    fwrite($fp, $content);
    $result = "";
    while (!feof($fp)) {
        $result .= fgets($fp, 1024);
    }
    fclose($fp);
    return $result;
}