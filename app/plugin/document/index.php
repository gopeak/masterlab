<?php

namespace main\app\plugin\document;

use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\model\PluginModel;
use main\app\model\user\UserModel;
use main\app\plugin\BasePluginCtrl;

/**
 *
 *   插件的入口类
 * @package main\app\ctrl\project
 */
class Index extends BasePluginCtrl
{

    public $pluginInfo = [];

    public $dirName = '';

    public $pluginMethod = 'pageIndex';

    public function __construct()
    {
        parent::__construct();

        // 当前插件目录名
        $this->dirName = basename(pathinfo(__FILE__)['dirname']);

        // 当前插件的配置信息
        $pluginModel = new PluginModel();
        $this->pluginInfo = $pluginModel->getByName($this->dirName);

        $pluginMethod = isset($_GET['_target'][3])? $_GET['_target'][3] :'';
        if($pluginMethod=="/" || $pluginMethod=="\\" || $pluginMethod==''){
            $pluginMethod = "pageIndex";
        }
        if(method_exists($this,$pluginMethod)){
            $this->pluginMethod = $pluginMethod;
            $this->$pluginMethod();
        }
    }

    /**
     * 插件首页方法
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '文档管理';
        $data['nav_links_active'] = 'plugin';
        $data['sub_nav_active'] = 'plugin';
        $data['plugin_name'] = $this->dirName;
        $data['nav_links_active'] = 'document';
        $data = RewriteUrl::setProjectData($data);
        $data['current_user'] = $user  = UserModel::getInstance()->getByUid(UserAuth::getId());

        // http://masterlab.ink/kod_index.php?user/loginSubmit&isAjax=1&getToken=1&name=admin&password=testtest
        $docAdmin = 'admin';
        $docPassword = 'admin';
        $url = sprintf("http://masterlab.ink/kod_index.php?user/loginSubmit&isAjax=1&getToken=1&name=&password=", $docAdmin, $docPassword);

        require_once realpath(__DIR__).'/kod/config/setting_user.php';
        $loginToken = base64_encode('admin').'|'.md5('admin'.$GLOBALS['config']['settings']['apiLoginTonken']);

        $url = sprintf(ROOT_URL."kod_index.php?user/loginSubmit&isAjax=1&getToken=1&login_token=%s", $loginToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $statusCode =  $response->getStatusCode(); // 200
        if($statusCode==200){
            $bodyArr =  json_decode($response->getBody(), true);
            //print_r($bodyArr);
            //die;
        }
        $iframeUrl = sprintf(ROOT_URL."kod_index.php?user/loginSubmit&login_token=%s", $loginToken);
        $data['iframe_url'] = $iframeUrl;
        $this->twigRender('index.twig', $data);
        //header("location:/kod_index.php?user/login&kod=1");
        //require_once realpath(__DIR__).'/kod/index.php';
        //$this->phpRender('index.php', $data);
        // create database mastererp  character set ‘utf8’ collate ‘utf8_general_ci’;
    }


}
