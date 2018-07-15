<?php
namespace main\lib;

class Trigger
{
    function request($url){
        $opts = array(
            'http'=>array(
                'method' => 'GET',
                'timeout' => 1,
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);
        return $html;
    }

    function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        if($ret === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $ret;
    }

}

