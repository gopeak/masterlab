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
        $data['current_user']  = UserModel::getInstance()->getByUid(UserAuth::getId());

        $this->twigRender('index.twig', $data);
        //header("location:/kod_index.php?user/login&kod=1");
        //require_once realpath(__DIR__).'/kod/index.php';
        //$this->phpRender('index.php', $data);
    }


}
