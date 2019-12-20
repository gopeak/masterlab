<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\classes\PermissionGlobal;

/**
 * 系统管理入口控制器
 */
class Main extends BaseAdminCtrl
{

    /**
     * 后台的系统设置类的构造函数
     * System constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $userId = UserAuth::getId();
        $this->addGVar('top_menu_active', 'system');
        $check = PermissionGlobal::isGlobalUser($userId);

        if (!$check) {
            $this->error('权限错误', '您还未获取此模块的权限！');
            exit;
        }
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Index';
        $data['nav_links_active'] = 'index';

        $data['masterlab_version'] = MASTERLAB_VERSION;
        $this->render('gitlab/admin/index.php', $data);
    }

}
