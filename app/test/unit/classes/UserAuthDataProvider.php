<?php

/**
 * Created by PhpStorm.
 * User: sven
 */

namespace main\app\test\unit\classes;

use main\app\model\user\UserModel;
use main\app\model\user\UserGroupModel;
use main\app\test\BaseDataProvider;

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
        $user = BaseDataProvider::createUser($info);
        self::$insertUserIdArr[] = $user['uid'];
        return $user;
    }


    public static function initUserGroup($uid, $groupId)
    {
        $row = BaseDataProvider::createUserGroup($uid, $groupId);
        self::$insertUserGroupIdArr[] = $row['id'];
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
