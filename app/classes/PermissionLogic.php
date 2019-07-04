<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/10/20 0020
 * Time: 下午 4:11
 */

namespace main\app\classes;

use main\app\model\permission\PermissionModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectModel;
use main\app\model\OrgModel;

/**
 * 项目权限逻辑类
 * Class PermissionLogic
 * @package main\app\classes
 */
class PermissionLogic
{
    const ADMINISTER_PROJECTS = 'ADMINISTER_PROJECTS';
    const BROWSE_ISSUES = 'BROWSE_ISSUES';
    const CREATE_ISSUES = 'CREATE_ISSUES';
    const ADD_COMMENTS = 'ADD_COMMENTS';
    const EDIT_ISSUES = 'EDIT_ISSUES';
    const DELETE_ISSUES = 'DELETE_ISSUES';
    const CLOSE_ISSUES = 'CLOSE_ISSUES';
    const DELETE_COMMENTS = 'DELETE_COMMENTS';
    const MANAGE_BACKLOG = 'MANAGE_BACKLOG';
    const MANAGE_SPRINT = 'MANAGE_SPRINT';
    const MANAGE_KANBAN = 'MANAGE_KANBAN';
    const MANAGE_COMMENTS = 'MANAGE_COMMENTS';
    const CREATE_ATTACHMENTS = 'CREATE_ATTACHMENTS';
    const IMPORT_EXCEL = 'IMPORT_EXCEL';
    const EXPORT_EXCEL = 'EXPORT_EXCEL';

    public static $errorMsg = '当前角色无此操作权限!';

    /**
     * 检查用户是否拥有某一权限
     * @param $projectId
     * @param $userId
     * @param $permission
     * @return bool
     * @throws \Exception
     */
    public static function check($projectId, $userId, $permission)
    {
        $haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        if ($haveAdminPerm) {
            return true;
        }
        $userRoleModelObj = new ProjectUserRoleModel();
        $roleIds = $userRoleModelObj->getUserRolesByProject($userId, $projectId);
        unset($userRoleModelObj);

        if (empty($roleIds)) {
            return false;
        }

        //获取权限模块列表
        $permissionList = self::getPermissionListByRoleIds($roleIds);

        if (in_array($permission, $permissionList)) {
            return true;
        }

        return false;
    }

    /**
     * 获取用户加入的组织列表,规则：用户加入了项目，而项目属于组织则就加入了组织
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public static function getUserRelationOrgArr($userId)
    {
        $projectIdArr = self::getUserRelationProjectIdArr($userId);
        if (empty($projectIdArr)) {
            return [];
        }

        $orgIdArr = self::getUserRelationOrgArr($projectIdArr);
        // print_r($projectIdArr);
        $orgModel = new OrgModel();
        $table = $orgModel->getTable();
        $orgIdStr = implode(',', $orgIdArr);
        $sql = "SELECT * FROM {$table} WHERE id IN ({$orgIdStr}) ";
        $orgArr = $orgModel->db->getRows($sql);

        return $orgArr;
    }

    /**
     * 获取用户参与的 项目id 数组
     * @param $userId
     * @param $limit
     * @return array
     * @throws \Exception
     */
    public static function getUserRelationProjects($userId, $limit = null)
    {
        $projectIdArr = self::getUserRelationProjectIdArr($userId);
        if (empty($projectIdArr)) {
            return [];
        }
        // print_r($projectIdArr);
        $projectModel = new ProjectModel();
        $table = $projectModel->getTable();
        $projectIdStr = implode(',', $projectIdArr);
        $sql = "SELECT * FROM {$table} WHERE id IN ({$projectIdStr}) ";
        if (!empty($limit)) {
            $sql .= " limit $limit";
        }
        $projects = $projectModel->db->getRows($sql);

        foreach ($projects as &$item) {
            $item = ProjectLogic::formatProject($item);
        }
        return $projects;
    }

    /**
     * 获取用户参与的项目id数组
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public static function getUserRelationProjectIdArr($userId)
    {
        $userRoleModel = new ProjectUserRoleModel();
        $roleIdArr = $userRoleModel->getsByUid($userId);
        //print_r($roleIdArr);
        if (empty($roleIdArr)) {
            return [];
        }

        $roleIdStr = implode(',', $roleIdArr);
        $projectRoleModel = new ProjectRoleModel();
        $table = $projectRoleModel->getTable();
        $sql = "SELECT DISTINCT project_id FROM {$table} WHERE id IN ({$roleIdStr})  ";
        $rows = $projectRoleModel->db->getRows($sql);
        //print_r($rows);
        $projectIdArr = [];
        foreach ($rows as $row) {
            $projectIdArr[] = $row['project_id'];
        }
        return $projectIdArr;
    }

    /**
     * 获取组织id数组，通过项目id数组
     * @param $projectIdArr
     * @return array
     */
    public static function getUserRelationOrgIdArr($projectIdArr)
    {
        //print_r($roleIdArr);
        if (empty($projectIdArr)) {
            return [];
        }

        $projectIdStr = implode(',', $projectIdArr);
        $projectModel = new ProjectModel();
        $table = $projectModel->getTable();
        $sql = "SELECT DISTINCT org_id FROM {$table} WHERE id IN ({$projectIdStr})  ";
        $rows = $projectModel->db->getRows($sql);
        //print_r($rows);
        $orgIdArr = [];
        foreach ($rows as $row) {
            $orgIdArr[] = $row['org_id'];
        }
        return $orgIdArr;
    }

    /**
     * 获取角色所有的权限模块
     * @param $roleIds
     * @return array
     */
    private static function getPermissionListByRoleIds($roleIds)
    {
        $relationModelObj = new  ProjectRoleRelationModel();
        $permIds = $relationModelObj->getPermIdsByRoleIds($roleIds);

        $permissionModelObj = new PermissionModel();
        $data = $permissionModelObj->getKeysById($permIds);
        unset($permissionModelObj);

        return $data;
    }

    /**
     * 检查用户在项目中的权限
     * @param $userId
     * @param $projectId
     * @return bool
     * @throws \Exception
     */
    public static function checkUserHaveProjectItem($userId, $projectId)
    {
        $userProjectRoleModel = new ProjectUserRoleModel($userId);
        $count = $userProjectRoleModel->getCountUserRolesByProject($userId, $projectId);
        return $count > 0;
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
        $permModel = new PermissionModel();
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

    /**
     * 获取用户在所有项目的角色
     * @param $userId
     * @return array
     */
    public static function getUserProjectRoles($userId)
    {
        $projectLogic = new ProjectLogic();
        $projects = $projectLogic->projectListJoinUser();
        if (empty($projects)) {
            return [];
        }

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getsAll();

        $userProjectRoleModel = new ProjectUserRoleModel($userId);
        $userProjectRoles = $userProjectRoleModel->getUserRoles($userId);

        $userProjectRolesFormat = [];
        if (!empty($userProjectRoles)) {
            foreach ($userProjectRoles as $user_role) {
                $key = $user_role['project_id'] . '@' . $user_role['project_role_id'];
                $userProjectRolesFormat[$key] = $user_role['id'];
                unset($key);
            }
        }

        $ret = [];
        foreach ($projects as $p) {
            $tmp = [];
            $project_id = $p['id'];
            $tmp['project_id'] = $project_id;
            foreach ($projectRoles as $role) {
                $role_id = $role['id'];
                $tmp[$role_id] = $role;
                $key = $project_id . '@' . $role_id;
                $tmp[$role_id . '_have'] = isset($userProjectRolesFormat[$key]);
                unset($key);
            }
            $ret[] = $tmp;
        }

        return [$ret, $projects, $projectRoles];
    }


    /**
     * 更新用户项目角色
     * @param $userId
     * @param $data
     * @return array
     * @throws \Exception
     */
    public static function updateUserProjectRole($userId, $data)
    {
        if (empty($data)) {
            return [false, 'data_is_empty'];
        }

        $projectLogic = new ProjectLogic();
        $projects = $projectLogic->projectListJoinUser();

        if (empty($projects)) {
            return [false, 'projects_is_empty'];
        }

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getsAll();

        $userProjectRoleModel = new ProjectUserRoleModel($userId);
        foreach ($projects as $project) {
            $projectId = $project['id'];
            foreach ($projectRoles as $role) {
                $roleId = $role['id'];
                $key = $projectId . '_' . $roleId;
                if (isset($data[$key])) {
                    $userProjectRoleModel->insertRole($userId, $projectId, $roleId);
                } else {
                    $userProjectRoleModel->deleteByProjectRole($userId, $projectId, $roleId);
                }
            }
        }
        return [true, 'ok'];
    }
}
