<?php

namespace main\app\ctrl\admin;

use main\app\classes\ServerInfo;
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

        $extList = ServerInfo::getPHPLoadedExt();
        $extListFormat = '';
        foreach ($extList as $k => $value) {
            $extListFormat .= $value . PHP_EOL;
        }

        $data['masterlab_version'] = MASTERLAB_VERSION;
        $data['domain'] = ServerInfo::getDomain();
        $data['ip'] = ServerInfo::getLocalIp();
        $data['port'] = ServerInfo::getLocalPort();
        $data['php_user'] = ServerInfo::getLocalServerUser();
        $data['hostname'] = ServerInfo::getLocalHostName();
        $data['os'] = ServerInfo::getSysOS();
        $data['web_engine'] = ServerInfo::getWebEngine();
        $data['lang'] = ServerInfo::getLocalLang();
        $data['extListFormat'] = $extListFormat;

        $this->render('gitlab/admin/index.php', $data);
    }

}
