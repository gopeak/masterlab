<?php

/**
 *
 * 用于处理接收webhook提交过来的数据
 */

// 如果事项创建完毕后
if ($_POST['event_name'] == 'onIssueCreateAfter') {
    $issueArr = json_decode($_POST['json'], true);
    $summary = $issueArr['summary'];
    $postData = [];
    $postData['chat_id'] = '122333';
    $postData['text'] = $summary . '\r\ntask_name:{{.TaskName}}........';

    $telegramPostUrl = 'https://www.telegram.org/xxxxxxxxxxxxxxxxxxx';
    fsockopenPost($telegramPostUrl, $postData, 10);

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
    //while (!feof($fp)) {
    //$result .= fgets($fp, 1024);
    //}
    fclose($fp);
    return $result;
}