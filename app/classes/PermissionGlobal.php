<?php

namespace main\app\classes;

use main\app\model\permission\PermissionGlobalModel;
use main\app\model\permission\PermissionGlobalGroupModel;
use main\app\model\permission\PermissionGlobalRoleRelationModel;
use main\app\model\permission\ProjectPermissionModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\permission\PermissionGlobalUserRoleModel;

/**
 * 全局权限处理类
 *
 */
class PermissionGlobal
{

    /**
     * 超级管理员的角色ID， 这个角色为系统默认角色，无法删除，具有全局属性
     * @var
     */
    const ADMINISTRATOR = 1;

    /**
     * 系统设置的全局权限ID
     */
    const MANAGER_SYSTEM_SETTING_PERM_ID = 1;
    /**
     * 管理用户的全局权限ID
     */
    const MANAGER_USER_PERM_ID = 2;
    /**
     * 事项管理的全局权限ID
     */
    const MANAGER_ISSUE_PERM_ID = 3;
    /**
     * 项目管理的全局权限ID
     */
    const MANAGER_PROJECT_PERM_ID = 4;
    /**
     * 组织管理的全局权限ID
     */
    const MANAGER_ORG_PERM_ID = 5;

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
        $globalUserRoleModel = new PermissionGlobalUserRoleModel();
        $userRoleIdArr = $globalUserRoleModel->getsByUid($userId);
        unset($globalUserRoleModel);
        if (empty($userRoleIdArr)) {
            return false;
        }

        //获取权限模块列表
        $permissionGlobalList = self::getGlobalPermListByUserRoles($userRoleIdArr);
        if (in_array($permId, $permissionGlobalList)) {
            return true;
        }

        return false;
    }

    /**
     * 判断用户是否为全局用户，全局用户可以进入后台。
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public static function isGlobalUser($userId)
    {
        $globalUserRoleModel = new PermissionGlobalUserRoleModel();
        $userRoleIdArr = $globalUserRoleModel->getsByUid($userId);
        if (!empty($userRoleIdArr)) {
            return true;
        }

        return false;
    }

    /**
     * @param $userRoleIdArr
     * @return array
     * @throws \Exception
     */
    private static function getGlobalPermListByUserRoles($userRoleIdArr)
    {
        $permissionGlobalGroupModel = new  PermissionGlobalRoleRelationModel();
        $permIds = $permissionGlobalGroupModel->getPermIdsByUserRoles($userRoleIdArr);
        unset($permissionGlobalGroupModel);
        return $permIds;
    }


    /**
     * 用户在某一项目中拥有的权限列表
     * @param $userId
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public static function getUserHaveProjectPermissions($userId, $projectId, $haveAdminPerm)
    {
        $permModel = new ProjectPermissionModel();
        $permissionArr = $permModel->getAll();
        //print_r($permissionArr);
        $ret = [];
        if ($haveAdminPerm) {
            foreach ($permissionArr as $item) {
                $ret[$item['_key']] = true;
            }
            return $ret;
        }
        // 项目角色id
        $userProjectRoleModel = new ProjectUserRoleModel($userId);
        $userProjectRoles = $userProjectRoleModel->getUserRoles($userId);
        $roleIdArr = [];
        foreach ($userProjectRoles as $userProjectRole) {
            $roleIdArr[] = $userProjectRole['role_id'];
        }
        unset($userProjectRoles);
        $roleIdArr = array_unique($roleIdArr);

        // 项目角色和用户关系
        $model = new ProjectRoleRelationModel();
        $roleRelations = $model->getRows('*', ['project_id' => $projectId]);
        $havePermArr = [];
        foreach ($roleRelations as $item) {
            $perm_id = $item['perm_id'];
            if (in_array($item['role_id'], $roleIdArr)) {
                if (isset($permissionArr[$perm_id])) {
                    $havePermArr[$permissionArr[$perm_id]['_key']] = true; // $permissionArr[$perm_id];
                }
            }
        }
        unset($permissionArr, $roleRelations);
        return $havePermArr;
    }
}
