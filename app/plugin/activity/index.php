<?php

namespace main\app\plugin\activity;

use main\app\classes\ConfigLogic;
use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\PluginModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\ActivityModel;
use main\app\model\user\UserModel;
use main\app\plugin\BasePluginCtrl;

/**
 *
 *  活动日志插件的入口
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


        $pluginMethod = isset($_GET['_target'][3]) ? $_GET['_target'][3] : '';
        if ($pluginMethod == "/" || $pluginMethod == "\\" || $pluginMethod == '') {
            $pluginMethod = "pageIndex";
        }
        if (method_exists($this, $pluginMethod)) {
            $this->pluginMethod = $pluginMethod;
            $this->$pluginMethod();
        }
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['sub_nav_active'] = 'plugin';
        $data['plugin_name'] = $this->dirName;
        $data['title'] = '活动日志';
        $data['nav_links_active'] = 'activity';
        $data = RewriteUrl::setProjectData($data);
        // 权限判断
        if (!empty($data['project_id'])) {
            if (!$this->isAdmin && !PermissionLogic::checkUserHaveProjectItem(UserAuth::getId(), $data['project_id'])) {
                $this->warn('提 示', '您没有权限访问该项目,请联系管理员申请加入该项目');
                die;
            }
        }
        $userModel = new UserModel();
        $users = $userModel->getAll(false);
        foreach ($users as &$user) {
            $user = UserLogic::format($user);
        }
        $data['users'] = $users;

        $data['type_arr'] = [
            ActivityModel::TYPE_ISSUE => '事项',
            ActivityModel::TYPE_AGILE => '敏捷',
            ActivityModel::TYPE_USER => '用户',
            ActivityModel::TYPE_PROJECT => '项目',
        ];
        $this->twigRender('index.twig', $data);
    }


}
