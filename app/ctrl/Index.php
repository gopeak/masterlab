<?php

namespace main\app\ctrl;

use main\app\classes\SystemLogic;
use main\app\classes\UserAuth;

/**
 * Class Index
 * @package main\app\ctrl
 */
class Index extends BaseCtrl
{


    /**
     * 首页的控制器
     * Index constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * index
     */
    public function pageIndex()
    {
        $dashboard = new Dashboard();
        $dashboard->pageIndex();
    }

    /**
     * @param array $params
     * @throws \Exception
     */
    public function mailTest($params = [])
    {
    }

    public function test()
    {
        $companyInfo = [];
        $companyInfo['company'] = 'company';
        $companyInfo['company_linkman'] = 'company_linkman';
        $companyInfo['company_phone'] = 'company_phone';
        $postInfo = array(
            'company_info' => $companyInfo,
            'os' => PHP_OS,
            'server' => php_uname(),
            'env' => $_SERVER["SERVER_SOFTWARE"],
            'php_sapi_name' => php_sapi_name(),
            'php_version' => PHP_VERSION,
            'zend_version' => Zend_Version(),
            'mysql_version' => '5.6',
            'server_ip' => $_SERVER['SERVER_ADDR'],
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'host' => $_SERVER["HTTP_HOST"],
            'port' => $_SERVER['SERVER_PORT'],
            'masterlab_version' => MASTERLAB_VERSION,
            'upload_max' => ini_get('upload_max_filesize'),
            'max_execution' => ini_get('max_execution_time'),
            'server_time' => time(),
            'server_name' => $_SERVER['SERVER_NAME'] . ' [ ' . gethostbyname($_SERVER['SERVER_NAME']) . ' ]',
        );
        $curl = new \Curl\Curl();
        $curl->setTimeout(10);
        $curl->post('http://www.masterlab.vip/client_info.php', $postInfo);
        echo $curl->rawResponse;
    }


}
