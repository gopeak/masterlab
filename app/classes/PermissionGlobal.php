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
     * 系统管理员的全局权限ID
     * @var
     */
    const ADMINISTRATOR = 1;

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
        $userGroupModel = new PermissionGlobalUserRoleModel();
        $userRoleIdArr = $userGroupModel->getsByUid($userId);
        unset($userGroupModel);
        if (empty($userRoleIdArr)) {
            return false;
        }

        //获取权限模块列表
        $permissionGlobalList = self::getPermissionListByUserRoles($userRoleIdArr);
        if (in_array($permId, $permissionGlobalList)) {
            return true;
        }

        return false;
    }

    /**
     * @param $userRoleIdArr
     * @return array
     */
    private static function getPermissionListByUserRoles($userRoleIdArr)
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
