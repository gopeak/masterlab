<?php

namespace main\app\ctrl\admin;

use main\app\classes\ServerInfo;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\classes\PermissionGlobal;
use main\app\model\SettingModel;

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
            $extListFormat .= $value . ' | ';
        }

        $extListFormat = trim($extListFormat, ' | ');

        // 获取mysql版本
        $versionSql = 'select version() as vv';
        $settingModel = new SettingModel();
        $mysqlVersionStr = $settingModel->db->getOne($versionSql);

        $dbConf = getConfigVar('database');


        $data['sys_domain'] = ROOT_URL;//ServerInfo::getDomain();
        $data['sys_datetime'] = date('l, d F Y   H:i:s', time());
        $data['sys_timezone'] = date_default_timezone_get();
        $data['sys_workpath'] = PRE_APP_PATH;
        $data['sys_php_version'] = PHP_VERSION;
        $data['sys_os'] = ServerInfo::getSysOS();
        $data['sys_web_engine'] = ServerInfo::getWebEngine();
        $data['sys_hostname'] = ServerInfo::getLocalHostName();
        $data['sys_php_user'] = ServerInfo::getLocalServerUser();
        $data['sys_mysql_version'] = $mysqlVersionStr;
        $data['sys_mysql_host'] = $dbConf['database']['default']['host'];
        $data['sys_mysql_port'] = $dbConf['database']['default']['port'];
        $data['sys_mysql_dbname'] = $dbConf['database']['default']['db_name'];
        $data['sys_mysql_use_user'] = $dbConf['database']['default']['user'];


        $data['masterlab_version'] = MASTERLAB_VERSION;
        $data['ip'] = ServerInfo::getLocalIp();
        $data['port'] = ServerInfo::getLocalPort();


        // $data['lang'] = ServerInfo::getLocalLang();
        $data['extListFormat'] = $extListFormat;

        $this->render('gitlab/admin/index.php', $data);
    }

}
