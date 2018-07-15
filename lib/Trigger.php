<?php
namespace main\lib;

class Trigger
{
    private function _request($url){
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

    private function _curl($url, $post=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, $post?1:0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $ret = curl_exec($ch);
        if($ret === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        return $ret;
    }

    // --------------------Trigger logic------------------

    public function mail($params = array())
    {
        $url = '';
        $this->_curl($url);
    }

    public function sms($params = array())
    {
        $url = '';
        $this->_curl($url);
    }

}

