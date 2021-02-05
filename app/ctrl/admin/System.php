<?php

namespace main\app\ctrl\admin;

use main\app\classes\IssueLogic;
use main\app\classes\LogOperatingLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueModel;
use main\app\model\permission\PermissionGlobalRoleModel;
use main\app\model\permission\PermissionGlobalRoleRelationModel;
use main\app\model\permission\PermissionGlobalUserRoleModel;
use main\app\model\system\MailQueueModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectModel;
use main\app\model\SettingModel;
use main\app\model\CacheKeyModel;
use main\app\model\system\AnnouncementModel;
use main\app\model\system\NotifySchemeDataModel;
use main\app\model\system\NotifySchemeModel;
use main\app\model\user\GroupModel;
use main\app\model\permission\PermissionGlobalModel;
use main\app\model\permission\PermissionGlobalGroupModel;
use main\app\classes\SystemLogic;
use main\app\classes\MailQueueLogic;
use main\app\classes\PermissionGlobal;
use main\app\model\user\UserModel;

/**
 * 系统控制器
 */
class System extends BaseAdminCtrl
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
        $check = PermissionGlobal::check($userId, PermissionGlobal::MANAGER_SYSTEM_SETTING_PERM_ID);

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
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'setting';
        $this->render('twig/admin/system/system_basic_setting.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageBasicSettingEdit()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'setting';
        $this->render('twig/admin/system/system_basic_setting_form.twig', $data);
    }

    /**
     * 获取设置信息
     * @param string $module
     * @throws \Exception
     */
    public function settingFetch($module = '')
    {
        $settingModel = new SettingModel();
        $rows = $settingModel->getSettingByModule($module);
        if (!empty($rows)) {
            $json_type = ['radio', 'select', 'checkbox'];
            foreach ($rows as $k=> &$row) {
                $_value = $row['_value'];
                $row['text'] = $_value;
                if(APP_STATUS=='sass' && $row['_key']=='attachment_dir'){
                    unset($rows[$k]);
                }
                if (in_array($row['form_input_type'], $json_type)) {
                    $row['form_optional_value'] = json_decode($row['form_optional_value'], true);
                    // 单选值显示
                    if (in_array($row['form_input_type'], ['radio', 'select'])) {
                        if (isset($row['form_optional_value'] [$_value])) {
                            $row['text'] = $row['form_optional_value'] [$_value];
                        }
                    }
                    // 多选值显示
                    if ($row['form_input_type'] == 'checkbox') {
                        $tmp = [];
                        $_value_arr = explode(',', $_value);
                        if (!empty($row['form_optional_value'])) {
                            foreach ($_value_arr as $v) {
                                if (isset($row['form_optional_value'] [$v])) {
                                    $tmp[] = $row['form_optional_value'] [$v];
                                }
                            }
                        }
                        if (!empty($tmp)) {
                            $row['text'] = implode(',', $tmp);
                        }
                    }
                }
            }
        }
        sort($rows);
        $data = [];
        $data['settings'] = $rows;
        $this->ajaxSuccess('操作成功', $data);
    }

    /**
     * 更新基本设置
     * @param $params
     * @throws \Exception
     */
    public function basicSettingUpdate($params)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $settingModel = new SettingModel();
        foreach ($params as $key => $value) {
            $settingModel->updateSetting($key, $value);
        }
        CacheKeyModel::getInstance()->clearCache($settingModel->table);
        // @todo 清除缓存
        $this->ajaxSuccess('操作成功');
    }

    /**
     * @throws \Exception
     */
    public function globalPermission()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'security';
        $data['left_nav_active'] = 'global_permission';

        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser(10000, false);
        $data['users'] = $users;

        $this->render('twig/admin/system/system_global_permission.twig', $data);
    }


    /**
     * @throws \Exception
     */
    public function pagePasswordStrategy()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'security';
        $data['left_nav_active'] = 'password_strategy';
        $this->render('twig/admin/system/system_password_strategy.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageUserSession()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'security';
        $data['left_nav_active'] = 'user_session';
        $this->render('twig/admin/system/system_user_session.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageDatetimeSetting()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'datetime_setting';
        $this->render('twig/admin/system/system_datetime_setting.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageAttachmentSetting()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'attachment_setting';
        $this->render('twig/admin/system/system_attachment_setting.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageUiSetting()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'ui_setting';
        $this->render('twig/admin/system/system_ui_setting.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageUserDefaultSetting()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'ui';
        $data['left_nav_active'] = 'user_default_setting';
        $this->render('twig/admin/system/system_user_default_setting.twig', $data);
    }

    public function pageCache()
    {
        $data = [];
        $data['title'] = '缓存';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'advanced';
        $data['left_nav_active'] = 'system_cache';

        $issueModel = new IssueModel();
        $data['redis_configs'] = $issueModel->cache->config;
        $data['redis_is_used'] = $issueModel->cache->use ? '开启':'未开启';

        $this->render('twig/admin/system/system_cache.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageApi()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'api';

        $settingModel = new SettingModel();
        $data['enable_api'] = $settingModel->getSettingValue('enable_api');
        $data['app_key']  = $settingModel->getSettingValue('app_key');
        $data['app_secret']  = $settingModel->getSettingValue('app_secret');
        $this->render('twig/admin/system/system_api.twig', $data);
    }

    /**
     * 清空redis缓存中的数据
     * @throws \Exception
     */
    public function saveApi()
    {
        $issueModel = new IssueModel();

        $this->ajaxSuccess('操作成功');
    }

    /**
     * @throws \Exception
     */
    public function pageLdap()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'ldap';
        $data['ldap_extension_loaded'] = extension_loaded('ldap');
        $this->render('twig/admin/system/system_ldap.twig', $data);
    }

    /**
     * 缓存配置：获取redis缓存连接配置
     * @throws \Exception
     */
    public function fetchCacheConfig()
    {
        $issueModel = new IssueModel();
        $data['redis_configs'] = $issueModel->cache->config;
        $data['redis_configs_length'] = sizeof($issueModel->cache->config);
        $data['redis_is_used'] = $issueModel->cache->use ? 1:0;
        // 是否分组显示
        $data['show_cache_group'] = $data['redis_configs_length'] > 1 ? 1:0;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 更新缓存配置文件
     * @param $params
     * @throws \Exception
     */
    public function settingCacheConfig($params)
    {
        if (!isset($params['redis']) || !isset($params['enable'])) {
            $this->ajaxFailed('请求失败', '缺少参数');
        }

        if (!is_array($params['redis'])) {
            $this->ajaxFailed('请求失败', '缺少错误');
        }

        $cacheConfigFile = APP_PATH."config/cache.cfg.php";
        if (file_exists($cacheConfigFile)) {
            if ((int)$params['enable'] && !empty($params['redis'])) {
                try {
                    $redis = new \Redis();
                    foreach ($params['redis'] as $linkConfig) {
                        $redis->connect($linkConfig[0], $linkConfig[1], 5);
                    }
                } catch (\RedisException $e) {
                    $this->ajaxFailed('连接失败', 'Redis连接测试失败，请检查配置');
                    //throw new \Exception('\Redis connect failed:' . $e->getMessage(), 500);
                }
            }

            $cacheConfig = getYamlConfigByModule('cache');

            if ((int)$params['enable']) {
                $cacheConfig['redis']['data'] = $params['redis'];
            }
            $cacheConfig['enable'] = (int)$params['enable'] ? true : false;

            $contents = "<?php \n" . '$_config = ' . var_export($cacheConfig, true) . ';' . "\n\n" . 'return $_config;';

            if (file_put_contents($cacheConfigFile, $contents) === false) {
                $this->ajaxFailed('操作失败', '请检查缓存配置文件写入权限');
            }
        } else {
            $this->ajaxFailed('操作失败', '请检查缓存配置文件是否存在');
        }

        $this->ajaxSuccess('缓存配置已生效');
    }

    /**
     * 清空redis缓存中的数据
     * @throws \Exception
     */
    public function flushCache()
    {
        $issueModel = new IssueModel();
        try {
            if (!$issueModel->cache->use) {
                $configFile = 'config.yml';
                if($GLOBALS['_yml_config']['app_status']!='deploy'){
                    $configFile = 'config.'.$GLOBALS['_yml_config']['app_status'].'.yml';
                }
                $this->ajaxFailed('操作失败', 'redis缓存没有启动,请检查配置文件:'.$configFile);
            }
            $issueModel->cache->connect();
            $ret = $issueModel->cache->flush();
            if (!$ret) {
                $this->ajaxFailed('操作失败', '执行 flushAll 命令失败');
            }
        } catch (\Exception $e) {
            $this->ajaxFailed('操作失败', $e->getMessage());
        }
        $this->ajaxSuccess('操作成功');
    }

    /**
     * 升级1.2版本，同步事项的关注和评论数
     * @throws \Exception
     */
    public function computeIssueData()
    {
        $issuLogic = new IssueLogic();
        try {
            $issuLogic->syncFollowCount();
            $issuLogic->syncCommentCount();
        } catch (\Exception $e) {
            $this->ajaxFailed('操作失败', $e->getMessage());
        }
        $this->ajaxSuccess('操作成功');
    }
    /**
     * @throws \Exception
     */
    public function pageAnnouncement()
    {
        $model = new AnnouncementModel();
        $row = $model->getRow('*', []);

        if (empty($row)) {
            $fields = $model->getFullFields($model->getTable());
            foreach ($fields as &$field) {
                $field = '';
            }
            $row = $fields;
        } else {
            $row['expire_time'] = date("Y-m-d H:i:s", $row['expire_time']);
        }

        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'ui';
        $data['left_nav_active'] = 'announcement';

        $data['info'] = $row;

        $this->render('twig/admin/system/system_announcement.twig', $data);
    }

    /**
     * 发布公告
     * @param $content
     * @param $expire_time
     * @throws \Exception
     */
    public function announcementRelease($content, $expire_time)
    {

        if (empty($content)) {
            $this->ajaxFailed('公告发布失败', '内容不能为空');
        }

        if (date("Y-m-d H:i:s", strtotime($expire_time)) != $expire_time) {
            $this->ajaxFailed('公告发布失败', '时间格式不对');
        }

        $model = new AnnouncementModel();
        $ret = $model->release($content, $expire_time);

        if (!$ret) {
            $this->ajaxFailed('公告发布失败', '数据更新失败');
        } else {
            $this->ajaxSuccess('公告发布成功');
        }
    }

    /**
     * 禁用公告
     * @throws \Exception
     */
    public function announcementDisable()
    {
        $model = new  AnnouncementModel();
        $model->disable();

        // @todo 清除缓存
        $this->ajaxSuccess('公告已禁用');
    }

    /**
     * 发送邮件配置页面
     */
    public function pageSmtpConfig()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'smtp_config';
        $this->render('twig/admin/system/system_smtp_config.twig', $data);
    }

    /**
     * 测试发送邮件
     * @param array $params
     * @throws \Exception
     */
    public function mailTest($params = [])
    {
        $title = $params['title'];
        $content = $params['content'];
        $reply = $params['recipients'];
        $contentType = $params['content_type'];
        $mailer = $params['recipients'];
        unset($params);
        $systemLogic = new SystemLogic();
        ob_start();
        $others = [];
        $others['content_type'] = $contentType;
        list($ret, $err) = $systemLogic->directMail($title, $content, $mailer, $reply, $others, true);
        unset($systemLogic);
        $data['err'] = $err;
        $data['verbose'] = ob_get_contents();
        ob_clean();
        ob_end_clean();
        if ($ret) {
            $this->ajaxSuccess('send_ok', $data);
        } else {
            $this->ajaxFailed("发送失败", $data);
        }
    }

    /**
     * @throws \Exception
     */
    public function pageEmailQueue()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'email_queue';
        $this->render('twig/admin/system/system_email_queue.twig', $data);
    }

    /**
     * 获取邮件发送队列
     * @throws \Exception
     */
    public function mailQueueFetch()
    {
        $ret = [];
        $page = 1;
        if (isset($_GET['page'])) {
            $page = max(1, (int)$_GET['page']);
        }

        if (empty($page)) {
            $page = 1;
        } else {
            $page = intval($page);
        }
        $conditions = [];
        if (isset($_GET['status']) && !empty(trimStr($_GET['status']))) {
            $conditions['status'] = trimStr($_GET['status']);
        }
        $logic = new MailQueueLogic();
        $model = MailQueueModel::getInstance();
        $pageInfo = $logic->getPageInfo($conditions, $page);
        list($ret['total'], $ret['pages'], $ret['current_page'], $ret['page_html'], $ret['page_size']) = $pageInfo;

        $ret['queues'] = $logic->query($conditions, $page, $model->primaryKey, 'desc');

        $this->ajaxSuccess('ok', $ret);
    }

    /**
     * 清除错误的邮件队列
     * @throws \Exception
     */
    public function emailQueueErrorClear()
    {
        $model = MailQueueModel::getInstance();
        $conditions = [];
        $conditions['status'] = MailQueueModel::STATUS_ERROR;
        $ret = $model->delete($conditions);
        if (!$ret) {
            $this->ajaxFailed('server_error');
        }
        $this->ajaxSuccess('ok');
    }

    /**
     * @throws \Exception
     */
    public function emailQueueAllClear()
    {
        $model = MailQueueModel::getInstance();
        $conditions = [];
        $ret = $model->delete($conditions);
        if (!$ret) {
            $this->ajaxFailed('server_error');
        }
        $this->ajaxSuccess('ok');
    }

    /**
     * @throws \Exception
     */
    public function pageSendMail()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'send_mail';
        $this->render('twig/admin/system/system_send_mail.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function sendMailFetch()
    {
        $data = [];
        $model = new ProjectRoleModel();
        $roles = $model->getsAll();
        $data['roles'] = $roles;

        $model = new ProjectModel();
        $projects = $model->getAll(false);
        $data['projects'] = $projects;

        $model = new GroupModel();
        $groups = $model->getAll(false);
        $data['groups'] = $groups;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 发送邮件通知
     * @param array $params
     * @throws \Exception
     */
    public function sendMailPost($params = [])
    {
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        if (!isset($params['send_to'])) {
            $errorMsg['send_to'] = 'value_is_empty';
        }
        if (!isset($params['title'])) {
            $errorMsg['title'] = 'value_is_empty';
        }
        if (!isset($params['content'])) {
            $errorMsg['content'] = 'value_is_empty';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $emails = [];

        $systemLogic = new SystemLogic();
        if ($params['send_to'] == 'project') {
            $emails = $systemLogic->getUserEmailByProject($params['to_project']);
        }
        if ($params['send_to'] == 'group') {
            $tmp = $systemLogic->getUserEmailByGroup($params['to_group']);
            //$emails = $emails + $tmp;
            foreach ($tmp as $item) {
                $emails[] = $item;
            }
            unset($tmp);
        }
        if (empty($emails)) {
            $this->ajaxFailed('user_no_found');
        }
        $title = $params['title'];
        $content = $params['content'];
        $reply = $params['reply'];
        $contentType = $params['content_type'];
        unset($params);

        $others = [];
        $others['content_type'] = $contentType;
        list($ret, $msg) = $systemLogic->mail($emails, $title, $content, $reply, $others);
        unset($systemLogic);
        $data['verbose'] = ob_get_contents();
        $data['err'] = $msg;
        if ($ret) {
            $this->ajaxSuccess('send_ok', $data);
        } else {
            $this->ajaxFailed("服务器错误", $data);
        }
    }

    /**
     * @throws \Exception
     */
    public function pageEmailNotifySetting()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'email_notify_setting';
        $this->render('twig/admin/system/system_email_notify_setting.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchNotifySchemeData()
    {
        $model = new NotifySchemeDataModel();
        $schemeData = $model->getRows('*', ['scheme_id' => NotifySchemeModel::DEFAULT_SCHEME_ID]);
        $roleUserMap = ["assigee" => '经办人', "reporter" => '报告人', "follow" => '关注人', 'project' => '项目成员'];

        foreach ($schemeData as &$item) {
            $item['user_role_name'] = [];
            $item['user'] = json_decode($item['user'], true);
            foreach ($item['user'] as $user) {
                if (array_key_exists($user, $roleUserMap)) {
                    $item['user_role_name'][] = $roleUserMap[$user];
                }
            }
        }

        unset($item);

        $data['settings'] = $schemeData;
        $data['role_user_map'] = $roleUserMap;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @param $user_role_list
     * @throws \Exception
     */
    public function updateNotifySchemeData($user_role_list)
    {
        if (!is_array($user_role_list)) {
            $data = 'params is error';
            $this->ajaxFailed("服务器错误", $data);
        }
        $model = new NotifySchemeDataModel();
        $notifySchemeDataResult = $model->getSchemeData(NotifySchemeModel::DEFAULT_SCHEME_ID);
        $flagArr = array_column($notifySchemeDataResult, 'flag');

        if (!empty($user_role_list)) {
            foreach ($flagArr as $v) {
                if (!array_key_exists($v, $user_role_list)) {
                    $user_role_list[$v] = [];
                }
            }

            foreach ($user_role_list as $flag => $item) {
                $model->update(['user' => json_encode($item)], ['flag' => $flag]);
            }
        }

        $data = [];
        $this->ajaxSuccess('修改成功', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageBackupData()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'backup_data';
        $this->render('twig/admin/system/system_backup_data.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageRestoreData()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'email';
        $data['left_nav_active'] = 'restore_data';

        $backupPath = STORAGE_PATH . 'backup';
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777);
        }

        $dr = opendir($backupPath);
        if (!$dr) {
            $this->error('错误提示!', 'backup menu is not exist');
            exit;
        }

        $fileList = array();
        while (($file = readdir($dr)) !== false) {
            if (substr($file, -3) == '.gz') {
                $fileList[] = $file;
            }
        }

        $data['file_list'] = $fileList;
        $this->render('twig/admin/system/system_restore_data.twig', $data);
    }
}
