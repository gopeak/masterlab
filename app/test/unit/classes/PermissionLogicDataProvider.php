<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\user\UserModel;
use main\app\model\user\PermissionSchemeItemModel;
use main\app\model\user\UserProjectRoleModel;
use main\app\model\user\UserGroupModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;

/**
 *  为 PermissionLogicDataProvider 逻辑类提供测试数据
 */
class PermissionLogicDataProvider
{

    public static $insertProjectIdArr = [];

    public static $insertUserIdArr = [];

    public static $insertSchemeIdArr = [];

    public static $insertUserProjectRoleArr = [];

    public static $insertUserGroupIdArr = [];

    /**
     * 生成一条项目记录
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initProject($info = [])
    {
        // 表单数据 $post_data
        if (!isset($info['name'])) {
            $info['name'] = 'project-' . mt_rand(12345678, 92345678);
        }
        if (!isset($info['key'])) {
            $info['key'] = $info['name'];
        }
        if (!isset($info['origin_id'])) {
            $info['origin_id'] = 0;
        }
        if (!isset($info['create_uid'])) {
            $info['create_uid'] = 0;
        }
        if (!isset($info['type'])) {
            $info['type'] = 1;
        }

        if (!isset($info['permission_scheme_id'])) {
            $info['permission_scheme_id'] = 0;
        }

        $model = new ProjectModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            parent::fail(__CLASS__.'/initProject  failed,' . $insertId);
            return [];
        }
        self::$insertProjectIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    /**
     * 初始化用户
     */
    public static function initUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);

        // 表单数据 $post_data
        $postData = [];
        $postData['username'] = $username;
        $postData['phone'] = $username;
        $postData['email'] = $username . '@masterlab.org';
        $postData['display_name'] = $username;
        $postData['status'] = UserLogic::STATUS_OK;
        $postData['openid'] = UserAuth::createOpenid($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            var_dump(__CLASS__ . '/initUser  failed,' . $msg);
            return;
        }
        self::$insertUserIdArr[] = $msg;
        $user = $userModel->getRowById($msg);
        return $user;
    }

    /**
     * 生成一条类型方案记录
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initScheme($info = [])
    {
        if (!isset($info['name'])) {
            $info['name'] = 'test-name-' . mt_rand(100, 999);
        }
        if (!isset($info['description'])) {
            $info['description'] = 'test-description';
        }

        $model = new PermissionSchemeItemModel();
        list($ret, $insertId) = $model->insert($info);
        if (!$ret) {
            var_dump(__CLASS__.'/initScheme  failed,' . $insertId);
            return [];
        }
        self::$insertSchemeIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function initUserProjectRole($uid, $projectId, $roleId)
    {
        $model = new UserProjectRoleModel();
        list($ret, $insertId) = $model->insertRole($uid, $projectId, $roleId);
        if (!$ret) {
            var_dump(__CLASS__.'/initUserProjectRole  failed,' . $insertId);
            return [];
        }
        self::$insertUserProjectRoleArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    public static function initUserGroup($uid, $groupId)
    {
        $model = new UserGroupModel();
        list($ret, $insertId) = $model->add($uid, $groupId);
        if (!$ret) {
            var_dump(__CLASS__.'/UserGroupModel  failed,' . $insertId);
            return [];
        }
        self::$insertUserGroupIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
    }

    /**
     * 清除项目记录
     */
    public static function clearProject()
    {
        if (!empty(self::$insertProjectIdArr)) {
            $model = new ProjectModel();
            foreach (self::$insertProjectIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearUser()
    {
        if (!empty(self::$insertUserIdArr)) {
            $model = new UserModel();
            foreach (self::$insertUserIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    /**
     * 清除项目记录
     */
    public static function clearScheme()
    {
        if (!empty(self::$insertSchemeIdArr)) {
            $model = new PermissionSchemeItemModel();
            foreach (self::$insertSchemeIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearUserProjectRole()
    {
        if (!empty(self::$insertUserProjectRoleArr)) {
            $model = new UserProjectRoleModel();
            foreach (self::$insertUserProjectRoleArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clearUserGroup()
    {
        if (!empty(self::$insertUserGroupIdArr)) {
            $model = new UserGroupModel();
            foreach (self::$insertUserGroupIdArr as $id) {
                $model->deleteById($id);
            }
        }
    }

    public static function clear()
    {
        self::clearProject();
        self::clearUser();
        self::clearScheme();
        self::clearUserProjectRole();
        self::clearUserGroup();
    }
}
