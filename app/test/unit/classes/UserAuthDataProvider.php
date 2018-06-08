<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\user\UserModel;
use main\app\model\user\UserGroupModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;

/**
 *  为 UserAuth 逻辑类提供测试数据
 */
class UserAuthDataProvider
{

    public static $insertUserIdArr = [];

    public static $insertUserGroupIdArr = [];


    /**
     * 初始化用户
     */
    public static function initUser($info)
    {
        $username = '190' . mt_rand(12345678, 92345678);

        if (!isset($info['username'])) {
            $info['username'] = $username;
        }
        if (!isset($info['phone'])) {
            $info['phone'] = $username;
        }
        if (!isset($info['email'])) {
            $info['email'] = $username . '@masterlab.org';
        }
        if (!isset($info['status'])) {
            $info['status'] = UserLogic::STATUS_OK;
        }
        if (!isset($info['openid'])) {
            $info['openid'] = UserAuth::createOpenid($username);
        }
        if (!isset($info['password'])) {
            $info['password'] = UserAuth::createPassword('123456');
        }

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($info);
        if (!$ret) {
            var_dump(__CLASS__ . '/initUser  failed,' . $msg);
            return;
        }
        self::$insertUserIdArr[] = $msg;
        $user = $userModel->getRowById($msg);
        return $user;
    }


    public static function initUserGroup($uid, $groupId)
    {
        $model = new UserGroupModel();
        list($ret, $insertId) = $model->add($uid, $groupId);
        if (!$ret) {
            var_dump(__CLASS__ . '/UserGroupModel  failed,' . $insertId);
            return [];
        }
        self::$insertUserGroupIdArr[] = $insertId;
        $row = $model->getRowById($insertId);
        return $row;
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
        self::clearUser();
        self::clearUserGroup();
    }
}
