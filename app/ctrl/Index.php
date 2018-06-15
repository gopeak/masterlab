<?php

namespace main\app\ctrl;

class Index extends BaseCtrl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {
        header("location:/passport/login");
    }

    public function showError()
    {
        $enableXdebug = '0';
        if(isset($_GET['enable_xdebug']) && $_GET['enable_xdebug']=='1' && extension_loaded('xdebug')){
            $enableXdebug =  $_GET['enable_xdebug'];
        }
        ini_set('xdebug.default_enable',$enableXdebug);

        // throw new \ErrorException('sssss', 0, 1, 'file', 121);


        echo $bb / 0;
        $arr = [];
        echo $arr['ee'];

        $errorTypes = [];
        $errorTypes['E_USER_DEPRECATED'] =  16384;
        $errorTypes['E_USER_NOTICE'] =  1024;
        $errorTypes['E_USER_WARNING'] =  512;
       // $errorTypes['E_USER_ERROR'] =  256;

        foreach ( $errorTypes as $key =>$errorNo ) {
            trigger_error('trigger:'.$key, $errorNo);
        }
       //throw new \Error('error', 4);
        //throw new \Exception('Division by zero.');
    }

    public function test_curl_error(){

        $curl = new \Curl\Curl();
        $curl->get(ROOT_URL.'index/showError');
        preg_match_all('%[^>]+:[^>]+in\s([^<]+)on\sline\s<i>(\d+)<\/i>%m', $curl->rawResponse, $result, PREG_PATTERN_ORDER);
        var_dump($result);

    }

}