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
            foreach ($rows as &$row) {
                $_value = $row['_value'];
                $row['text'] = $_value;

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
    public function globalPermissionBak()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'security';
        $data['left_nav_active'] = 'global_permission_bak';
        $this->render('twig/admin/system/system_global_permission_bak.twig', $data);
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

        $userModel = new UserModel();
        $users = $userModel->getAll();
        foreach ($users as &$user) {
            $user = UserLogic::format($user);
        }
        $data['users'] = $users;

        $this->render('twig/admin/system/system_global_permission.twig', $data);
    }


    public function fetchGlobalPermissionRole()
    {
        $model = new PermissionGlobalRoleModel();
        $roles = $model->getsAll();

        $data = [];
        $data['roles'] = $roles;
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function globalPermissionFetch()
    {
        $model = new PermissionGlobalModel();
        $perms = $model->getAll(false);
        $permGroupModel = new PermissionGlobalGroupModel();
        $permsGroups = $permGroupModel->getAll(false);

        $groupModel = new GroupModel();
        $groups = $groupModel->getAll();
        if (!empty($perms)) {
            foreach ($perms as &$p) {
                $has_groups = [];
                if (!empty($permsGroups)) {
                    foreach ($permsGroups as $pg) {
                        if ($pg['perm_global_id'] == $p['id']) {
                            if (isset($groups[$pg['group_id']])) {
                                $tmp = $groups[$pg['group_id']];
                                $tmp['perm_group_id'] = $pg['id'];
                                //$tmp['is_system'] = $pg['is_system'];
                                $has_groups[] = $tmp;
                            }
                        }
                    }
                }
                $p['groups'] = $has_groups;
            }
        }

        $data = [];
        $data['items'] = $perms;
        $data['groups'] = array_values($groups);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function globalPermissionGroupAdd($params)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $err = [];
        if (!isset($params['perm_id'])) {
            $err['perm_id'] = '权限项不能为空';
        }

        if (!isset($params['group_id'])) {
            $err['group_id'] = '用户组不能为空';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $model = new PermissionGlobalGroupModel();

        // 判断是否重复
        $row = $model->getByParentIdAndGroupId((int)$params['perm_id'], (int)$params['group_id']);
        if (isset($row['id'])) {
            $this->ajaxFailed('提示', '您已经拥有此权限', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $last_insert_id) = $model->add((int)$params['perm_id'], (int)$params['group_id']);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据失败,详情:' . $last_insert_id);
        }
        // @todo 清除缓存
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 通过角色ID获取角色信息
     * @throws \Exception
     */
    public function getGlobalPermissionRole()
    {
        if (isset($_GET['role_id'])) {
            $id = (int)$_GET['role_id'];
        }

        $model = new PermissionGlobalRoleModel();
        $data = $model->getById($id);

        if (empty($data)) {
            $this->ajaxFailed('参数错误', '数据为空');
        }
        $this->ajaxSuccess('success', $data);
    }


    /**
     * 添加全局角色ajax
     * @param $params
     * @throws \Exception
     */
    public function globalPermissionRoleAdd($params)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        $err = [];
        if (!isset($params['name']) || empty($params['name'])) {
            $err['perm_id'] = '角色名不能为空';
        }

        if (!isset($params['description'])) {
            $params['description'] = '';
        }

        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $params['name'] = trim($params['name']);

        $model = new PermissionGlobalRoleModel();

        // 判断是否重复
        $row = $model->getByName($params['name']);

        if (isset($row['id'])) {
            $this->ajaxFailed('提示', '您已经设置过该角色', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $last_insert_id) = $model->add($params['name'], $params['description']);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '新增数据失败,详情:' . $last_insert_id);
        }
        // @todo 清除缓存
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 更新一个自定义的角色
     * @param array $params
     * @throws \Exception
     */
    public function globalPermissionRoleUpdate($params = [])
    {
        $globalRoleId = null;
        if (isset($_REQUEST['id'])) {
            $globalRoleId = (int)$_REQUEST['id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        $model = new PermissionGlobalRoleModel();
        $currentRow = $model->getById($globalRoleId);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'ID错误,找不到对应的数据');
        }
        if ($currentRow['is_system'] == '1') {
            $this->ajaxFailed('提示', '预定义的全局角色不能编辑', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $row = $model->getByName($params['name']);
        //var_dump($row);
        if (isset($row['id']) && ($row['id'] != $globalRoleId)) {
            $errorMsg['name'] = '角色名已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $id = (int)$globalRoleId;
        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }
        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('更新完成');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }


    /**
     * 获取全局角色树形关系的json格式
     */
    public function permTree()
    {
        $globalRoleId = null;

        if (isset($_REQUEST['role_id'])) {
            $globalRoleId = (int)$_REQUEST['role_id'];
        }
        if (!$globalRoleId) {
            //$this->ajaxFailed('参数错误', 'role_id不能为空');
            @header('Content-Type:application/json');
            echo json_encode([]);
            exit;
        }
        $globalRoleId = intval($globalRoleId);
        $globalPermModel = new PermissionGlobalModel();
        $globalPermRoleRelationModel = new PermissionGlobalRoleRelationModel();

        $parentList = $globalPermModel->getParent();
        $childrenList = $globalPermModel->getChildren();
        $permIdList = $globalPermRoleRelationModel->getPermIdsByRoleId($globalRoleId);

        unset($globalPermModel);
        unset($globalPermRoleRelationModel);

        //组装数据
        $data = [];
        $i = 0;
        foreach ($parentList as $p) {
            $data[$i]['id'] = $p['id'];
            $data[$i]['text'] = $p['name'];
            $data[$i]['state'] = in_array($p['id'], $permIdList) ? ['selected' => true] : ['selected' => false];
            $data[$i]['icon'] = "fa fa-lock";

            $data[$i]['children'] = [];
            $j = 0;
            foreach ($childrenList as $k => $c) {
                if ($c['parent_id'] == $p['id']) {
                    $data[$i]['children'][$j]['id'] = $k;
                    $data[$i]['children'][$j]['text'] = $c['name'];
                    $data[$i]['children'][$j]['state'] = in_array($k, $permIdList) ? ['selected' => true] : ['selected' => false];
                    $j++;
                }
            }
            $i++;
        }
        @header('Content-Type:application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * 更新全局角色权限
     * @throws \Exception
     */
    public function updatePerm()
    {
        $globalRoleId = null;

        if (isset($_REQUEST['role_id'])) {
            $globalRoleId = (int)$_REQUEST['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }
        $globalRoleId = intval($globalRoleId);
        if (!isset($_REQUEST['permission_ids'])) {
            $this->ajaxFailed(' 参数错误 ', 'permission_Ids不能为空');
        }

        $permissionIds = $_REQUEST['permission_ids'];
        $permIdsList = explode(',', $permissionIds);
        if (!is_array($permIdsList)) {
            $this->ajaxFailed(' 参数错误 ', '获取权限数据失败');
        }

        /*
        // @todo 判断是否拥有权限
        $userId = UserAuth::getId();
        $model = new ProjectRoleModel();
        $role = $model->getById($globalRoleId);
        if (!PermissionLogic::check($role['project_id'], $userId, PermissionLogic::ADMINISTER_PROJECTS)) {
            $this->ajaxFailed(' 权限受限 ', '您没有权限执行此操作');
        }
        */

        $model = new PermissionGlobalRoleRelationModel();
        $model->db->connect();
        try {
            $model->db->beginTransaction();
            $model->deleteByRoleId($globalRoleId);
            foreach ($permIdsList as $perm) {
                $model->add($globalRoleId, $perm);
            }
            $model->db->commit();

        } catch (\PDOException $exception) {
            $model->db->rollBack();
            unset($model->db);
            unset($model);
            $this->ajaxFailed(' 服务器错误 ', '执行数据库操作失败,详情:' . $exception->getMessage());
        }
        unset($model);
        $this->ajaxSuccess('ok', []);
    }

    /**
     * 删除全局角色
     * @param $id
     * @throws \Exception
     */
    public function globalPermissionRoleDelete()
    {
        $globalRoleId = null;
        if (isset($_REQUEST['role_id'])) {
            $globalRoleId = (int)$_REQUEST['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }

        $globalRoleId = intval($globalRoleId);
        $model = new PermissionGlobalRoleModel();
        $role = $model->getById($globalRoleId);

        if (!isset($role['id'])) {
            $this->ajaxFailed('参数错误', '找不到对应的用户角色');
        }
        if ($role['is_system'] == 1) {
            $this->ajaxFailed('提示', '预定义的全局角色不能删除', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        $model->db->beginTransaction();

        $globalPermRoleRelationModel = new PermissionGlobalRoleRelationModel();
        $globalPermUserRoleModel = new PermissionGlobalUserRoleModel();
        if ($model->deleteById($globalRoleId)
            && $globalPermRoleRelationModel->deleteByRoleId($globalRoleId)
            && $globalPermUserRoleModel->deleteByRoleId($globalRoleId)) {
            $model->db->commit();
            $this->ajaxSuccess('ok');
        } else {
            $model->db->rollBack();
            $this->ajaxFailed('服务器错误', '删除角色失败');
        }
    }

    /**
     * 获取全局角色的用户列表
     * @throws \Exception
     */
    public function fetchGlobalPermRoleUsers()
    {
        $globalRoleId = null;
        if (isset($_REQUEST['role_id'])) {
            $globalRoleId = (int)$_REQUEST['role_id'];
        }
        if (!$globalRoleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $globalRoleId = intval($globalRoleId);

        // @todo 判断是否拥有权限

        $model = new PermissionGlobalUserRoleModel();
        $roleUsers = $model->getsRoleId($globalRoleId);

        if ($globalRoleId == 1) {
            foreach ($roleUsers as &$user) {
                if ($user['user_id'] == 1) {
                    $user['root'] = 1; // 是超级管理员角色并且是超级管理员账号
                } else {
                    $user['root'] = 0;
                }
            }
        }
        unset($user);

        $data['role_users'] = $roleUsers;

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 为全局角色添加用户
     * @throws \Exception
     */
    public function addGlobalPermRoleUser()
    {
        $roleId = null;
        if (isset($_REQUEST['role_id'])) {
            $roleId = (int)$_REQUEST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $roleId = intval($roleId);

        $userId = null;
        if (isset($_REQUEST['user_id'])) {
            $userId = (int)$_REQUEST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        $userId = intval($userId);

        // @todo 判断是否拥有权限

        $model = new PermissionGlobalUserRoleModel();
        if ($model->checkUniqueItemExist($userId, $roleId)) {
            $this->ajaxFailed(' 已添加过该用户 ', '不要重复添加');
        }

        list($ret, $msg) = $model->insertRole($userId, $roleId);
        if (!$ret) {
            $this->ajaxFailed(' 服务器错误 ', '数据库新增失败,详情:' . $msg);
        }

        $data['role_users'] = $model->getsRoleId($roleId);

        unset($model);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 从全局角色中删除用户
     * @throws \Exception
     */
    public function deleteGlobalPermRoleUser()
    {
        if (!isPost()) {
            $this->ajaxFailed('服务器错误', '请求失败');
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'ID不能为空');
        }
        if (isset($_POST['user_id'])) {
            $userId = (int)$_POST['user_id'];
        }
        if (!$userId) {
            $this->ajaxFailed('参数错误', 'user_id不能为空');
        }

        if (isset($_POST['role_id'])) {
            $roleId = (int)$_POST['role_id'];
        }
        if (!$roleId) {
            $this->ajaxFailed('参数错误', 'role_id不能为空');
        }

        $id = intval($id);
        $userId = intval($userId);
        $roleId = intval($roleId);

        if ($userId == 1 && $roleId == 1) {
            $this->ajaxFailed('参数错误', '超级管理员不能删除');
        }

        $model = new PermissionGlobalUserRoleModel();
        $model->deleteUniqueItem($id, $userId, $roleId);

        $this->ajaxSuccess('操作成功');
    }



    /**
     * 移除权限
     * @param $id
     * @throws \Exception
     */
    public function globalPermissionGroupDelete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $id = intval($id);

        $model = new PermissionGlobalGroupModel();
        $row = $model->getRowById($id);
        if (!isset($row['id'])) {
            $this->ajaxFailed('参数错误', '提交的参数错误,找不到对应的数据');
        }
        $ret = $model->deleteById($id);

        if (!$ret) {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
        // @todo  清除关联数据 清除缓存
        $this->ajaxSuccess('操作成功');
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
    public function pageLdap()
    {
        $data = [];
        $data['title'] = 'System';
        $data['nav_links_active'] = 'system';
        $data['sub_nav_active'] = 'setting';
        $data['left_nav_active'] = 'ldap';
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

        $cacheConfigFile = APP_PATH."config/".APP_STATUS."/cache.cfg.php";
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

            $cacheConfig = getConfigVar('cache');

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
                $this->ajaxFailed('操作失败', 'redis缓存没有启动,请检查配置文件:cache.cfg.twig');
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
            $fields = $model->db->getFullFields($model->getTable());
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
