<?php

namespace main\app\classes;

use main\app\model\permission\PermissionGlobalModel;
use main\app\model\permission\PermissionGlobalGroupModel;
use main\app\model\user\UserGroupModel;

/**
 * 全局权限处理类
 *
 */
class PermissionGlobal
{

    /**
     * 系统管理员的全局权限ID
     * @var
     */
    const ADMINISTRATOR = 10000;

    /**
     * 判断用户是否拥有某一全局权限
     * @param $userId
     * @param $permId
     * @return bool
     * @throws \Exception
     */
    public static function check($userId, $permId)
    {
        if (empty($userId)) {
            return false;
        }
        $userGroupModel = new UserGroupModel();
        $userGroups = $userGroupModel->getGroupsByUid($userId);
        unset($userGroupModel);
        if (empty($userGroups)) {
            return false;
        }

        //获取权限模块列表
        $permissionGlobalList = self::getPermissionListByUserGroups($userGroups);
        if (in_array($permId, $permissionGlobalList)) {
            return true;
        }

        return false;
    }

    /**
     * 获取角色所有的全局权限模块
     * @param $userGroups
     * @return array
     * @throws \Exception
     */
    private static function getPermissionListByUserGroups($userGroups)
    {
        $permissionGlobalGroupModel = new  PermissionGlobalGroupModel();
        $permIds = $permissionGlobalGroupModel->getPermIdsByUserGroups($userGroups);
        unset($permissionGlobalGroupModel);
        return $permIds;
    }
}
