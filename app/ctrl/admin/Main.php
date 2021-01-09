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
        $mysqlVersionStr = $settingModel->getFieldBySql($versionSql);

        $dbConf = getYamlConfigByModule('database');

        $data['sys_domain'] = ROOT_URL;//ServerInfo::getDomain();
        $data['sys_datetime'] = date('Y-m-d  H:i:s', time());
        $data['sys_timezone'] = date_default_timezone_get();
        $data['sys_workpath'] = PRE_APP_PATH;
        $data['sys_php_version'] = PHP_VERSION;
        $data['sys_os'] = ServerInfo::getSysOS();
        $data['sys_web_engine'] = ServerInfo::getWebEngine();
        $data['sys_hostname'] = ServerInfo::getLocalHostName();
        $data['sys_php_user'] = isset($_SERVER['USER']) ? $_SERVER['USER'] : ServerInfo::getLocalServerUser();
        $data['sys_mysql_version'] = $mysqlVersionStr;
        $data['sys_mysql_host'] = $dbConf['default']['host'];
        $data['sys_mysql_port'] = $dbConf['default']['port'];
        $data['sys_mysql_dbname'] = $dbConf['default']['db_name'];
        $data['sys_mysql_use_user'] = $dbConf['default']['user'];

        $data['php_ini_loaded_file'] = php_ini_loaded_file();
        $data['session_save_handler'] = ini_get('session.save_handler');
        $data['session_save_path'] = ini_get('session.save_path');
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');

        $data['masterlab_version'] = MASTERLAB_VERSION;
        $data['ip'] = ServerInfo::getLocalIp();
        $data['port'] = ServerInfo::getLocalPort();

        $settingMailArr = $settingModel->getSettingByModule('mail');
        $data['setting_mail'] = array_column($settingMailArr,'_value', '_key');

        $socketServerConnectMsg = '<span style="color:green">连接成功</span>';
        $fp = @fsockopen($data['setting_mail']['socket_server_host'], (int)$data['setting_mail']['socket_server_port'], $errno, $errstr, 5);
        if (!$fp) {
            $socketServerConnectMsg = '<span style="color:red">连接失败</span>';
        }
        $data['setting_mail']['socket_server_connect_msg'] = $socketServerConnectMsg;

        // $data['lang'] = ServerInfo::getLocalLang();
        $data['extListFormat'] = $extListFormat;

        //echo ini_get('file_uploads');
        //echo ini_get('upload_max_filesize');
        //echo ini_get('post_max_size');

        $this->render('twig/admin/main/index.twig', $data);
    }

}
