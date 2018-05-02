<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/10/20 0020
 * Time: 下午 4:11
 */

namespace main\app\classes;

use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\user\PermissionSchemeItemModel;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserProjectRoleModel;
use main\app\model\user\GroupModel;

class Permission
{
    const   ADMINISTER_PROJECTS = 'ADMINISTER_PROJECTS';
    const  BROWSE_PROJECTS = 'BROWSE_PROJECTS';
    const  CREATE_ISSUES = 'CREATE_ISSUES';
    const  ADD_COMMENTS = 'ADD_COMMENTS';
    const  CREATE_ATTACHMENTS = 'CREATE_ATTACHMENTS';
    const  ASSIGN_ISSUES = 'ASSIGN_ISSUES';
    const  ASSIGNABLE_USER = 'ASSIGNABLE_USER';
    const  RESOLVE_ISSUES = 'RESOLVE_ISSUES';
    const  LINK_ISSUES = 'LINK_ISSUES';
    const  EDIT_ISSUES = 'EDIT_ISSUES';
    const  DELETE_ISSUES = 'DELETE_ISSUES';
    const  CLOSE_ISSUES = 'CLOSE_ISSUES';
    const  MOVE_ISSUES = 'MOVE_ISSUES';
    const  SCHEDULE_ISSUES = 'SCHEDULE_ISSUES';
    const  MODIFY_REPORTER = 'MODIFY_REPORTER';
    const  WORK_ON_ISSUES = 'WORK_ON_ISSUES';
    const  DELETE_ALL_WORKLOGS = 'DELETE_ALL_WORKLOGS';
    const  DELETE_OWN_WORKLOGS = 'DELETE_OWN_WORKLOGS';
    const  EDIT_ALL_WORKLOGS = 'EDIT_ALL_WORKLOGS';
    const  EDIT_OWN_WORKLOGS = 'EDIT_OWN_WORKLOGS';
    const  VIEW_VOTERS_AND_WATCHERS = 'VIEW_VOTERS_AND_WATCHERS';
    const  MANAGE_WATCHERS = 'MANAGE_WATCHERS';
    const  EDIT_ALL_COMMENTS = 'EDIT_ALL_COMMENTS';
    const  EDIT_OWN_COMMENTS = 'EDIT_OWN_COMMENTS';
    const  DELETE_ALL_COMMENTS = 'DELETE_ALL_COMMENTS';
    const  DELETE_OWN_COMMENTS = 'DELETE_OWN_COMMENTS';
    const  DELETE_ALL_ATTACHMENTS = 'DELETE_ALL_ATTACHMENTS';
    const  DELETE_OWN_ATTACHMENTS = 'DELETE_OWN_ATTACHMENTS';
    const  VIEW_DEV_TOOLS = 'VIEW_DEV_TOOLS';
    const  VIEW_READONLY_WORKFLOW = 'VIEW_READONLY_WORKFLOW';
    const  TRANSITION_ISSUES = 'TRANSITION_ISSUES';
    const  MANAGE_SPRINTS_PERMISSION = 'MANAGE_SPRINTS_PERMISSION';

    /**
     * 检查用户在项目中的权限
     * @param $uid
     * @param $projectId
     * @return bool
     */
    public function checkUserHaveProjectItem($uid, $projectId)
    {
        $projectModel = new ProjectModel();
        $schemeId = $projectModel->getFieldById('permission_scheme_id', $projectId);

        $schemeModel = new PermissionSchemeItemModel($uid);
        $items = $schemeModel->getItemsById($schemeId);

        $userProjectRoleModel = new UserProjectRoleModel($uid);
        $userProjectRoles = $userProjectRoleModel->getUserRolesByProject($uid, $projectId);

        $userGroupModel = new UserGroupModel($uid);
        $userGroups = $userGroupModel->getGroupsByUid($uid);

        foreach ($items as $item) {
            if ($item['perm_type'] == 'group') {
                if (in_array($item['perm_parameter'], $userGroups)) {
                    return true;
                }
            }
            if ($item['perm_type'] == 'project_role') {
                if (in_array($item['perm_parameter'], $userProjectRoles)) {
                    return true;
                }
            }
            if ($item['perm_type'] == 'uid') {
                $uids = explode(',', $item['perm_parameter']);
                if (in_array($uid, $uids)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 获取项目的权限
     * @param $projectId
     * @return array
     */
    public function projectPermission($projectId)
    {
        $projectModel = new ProjectModel();
        $schemeId = $projectModel->getFieldById('permission_scheme_id', $projectId);

        $schemeModel = new PermissionSchemeItemModel();
        $items = $schemeModel->getItemsById($schemeId);

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getAll();

        $groupModel = new GroupModel();
        $groups = $groupModel->getAll();

        return [$items, $projectRoles, $groups];
    }

    /**
     * 获取用户在项目中的权限
     * @param $uid
     * @param $projectId
     * @return array
     */
    public function getUserHaveProjectPermissions($uid, $projectId)
    {
        $projectModel = new ProjectModel();
        $schemeId = $projectModel->getFieldById('permission_scheme_id', $projectId);

        $schemeModel = new PermissionSchemeItemModel($uid);
        $items = $schemeModel->getItemsById($schemeId);

        $userProjectRoleModel = new UserProjectRoleModel($uid);
        $userProjectRoles = $userProjectRoleModel->getUserRolesByProject($uid, $projectId);

        $userGroupModel = new UserGroupModel($uid);
        $userGroups = $userGroupModel->getGroupsByUid($uid);

        $ret = [];
        foreach ($items as $item) {
            if ($item['perm_type'] == 'group') {
                if (in_array($item['perm_parameter'], $userGroups)) {
                    $ret[$item['permission_key']] = true;
                    continue;
                }
            }
            if ($item['perm_type'] == 'project_role') {
                if (in_array($item['perm_parameter'], $userProjectRoles)) {
                    $ret[$item['permission_key']] = true;
                    continue;
                }
            }
            if ($item['perm_type'] == 'uid') {
                $uids = explode(',', $item['perm_parameter']);
                if (in_array($uid, $uids)) {
                    $ret[$item['permission_key']] = true;
                    continue;
                }
            }
            $ret[$item['permission_key']] = false;
        }
        return $ret;
    }

    /**
     * 获取用户在项目的角色
     * @param $uid
     * @return array
     */
    public function getUserProjectRoles($uid)
    {
        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();
        if (empty($projects)) {
            return [];
        }

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getAll();

        $userProjectRoleModel = new UserProjectRoleModel($uid);
        $userProjectRoles = $userProjectRoleModel->getUserRoles($uid);

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
     * @param $uid
     * @param $data
     * @return array
     */
    public function updateUserProjectRole($uid, $data)
    {
        if (empty($data)) {
            return [false, 'data_is_empty'];
        }

        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();
        if (empty($projects)) {
            return [false, 'projects_is_empty'];
        }

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getAll();

        $userProjectRoleModel = new UserProjectRoleModel($uid);

        foreach ($projects as $project) {
            $projectId = $project['id'];
            foreach ($projectRoles as $role) {
                $roleId = $role['id'];
                $key = $projectId . '_' . $roleId;
                if (isset($data[$key])) {
                    $userProjectRoleModel->insertRole($uid, $projectId, $roleId);
                } else {
                    $userProjectRoleModel->deleteByProjectRole($uid, $projectId, $roleId);
                }
            }
        }
        return [true, 'ok'];
    }
}
