<?php

namespace main\app\plugin\plugin_tpl;

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

    public function __construct()
    {
        parent::__construct();
        $dirName = pathinfo(__FILE__)['dirname'];
        $pluginModel = new PluginModel();
        $this->pluginInfo = $pluginModel->getByName($dirName);
    }

    /**
     * 插件首页方法
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '插件首页';
        $data['nav_links_active'] = 'plugin';
        $data['current_user']  = UserModel::getInstance()->getByUid(UserAuth::getId());
        $this->myRender('index.php', $data);
    }


}
