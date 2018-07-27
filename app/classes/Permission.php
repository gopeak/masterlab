<?php

namespace main\app\classes;

use main\app\model\permission\PermissionModel;
use main\app\model\permission\PermissionUserRoleModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\project\ProjectRoleRelationModel;
use main\app\model\OrgModel;

/**
 * 用户角色权限处理类
 *
 */
class Permission
{
    //用户uid
    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;
    //用户操作行为
    protected $uid;
    protected $action;
    public static $errorMsg = '当前角色无此操作权限!';

    /**
     * Permission constructor.
     * @param $uid
     * @param $action
     */
    public function __construct($uid, $action)
    {
        if (empty($uid) || empty($action)) {
            return false;
        }

        $this->uid = $uid;
        $this->action = $action;
    }


    /**
     * @todo 此处有bug
     * @param int $uid
     * @param string $action
     * @return Permission
     */
    public static function getInstance($uid = 0, $action = '')
    {
        if (!isset(self::$instance) || !is_object(self::$instance)) {
            self::$instance = new self($uid, $action);
        }
        return self::$instance;
    }

    /**
     * 当前用户的权限检测
     * @return bool
     * @throws \Exception
     */
    public function check()
    {
        $userRoleModelObj = new ProjectUserRoleModel();
        $roleIds = $userRoleModelObj->getsByUid($this->uid);
        unset($userRoleModelObj);

        if (empty($roleIds)) {
            return false;
        }

        //获取权限模块列表
        $permissionList = $this->getPermissionListByRoleIds($roleIds);

        if (in_array($this->action, $permissionList)) {
            return true;
        }

        return false;
    }


    /**
     * 获取用户参与的 项目id 数组
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public static function getUserRelationProjects($userId)
    {
        $userRoleModel = new ProjectUserRoleModel();
        $roleIdArr = $userRoleModel->getsByUid($userId);
        if (empty($roleIdArr)) {
            return [];
        }

        $params['ids'] = implode(',', $roleIdArr);
        $projectRoleModel = new ProjectRoleModel();
        $table = $projectRoleModel->getTable();
        $sql = "SELECT DISTINCT project_id FROM {$table} WHERE role_id IN (:ids)  ";
        $rows = $projectRoleModel->db->getRows($sql, $params);

        $projectIdArr = [];
        foreach ($rows as $row) {
            $projectIdArr[] = $row['project_id'];
        }
        //print_r($projectIdArr);
        $projectModel = new ProjectModel();
        $table = $projectModel->getTable();
        $params['ids'] = implode(',', $projectIdArr);
        $sql = "SELECT * FROM {$table} WHERE id IN (:ids) ";
        $projects = $projectModel->db->getRows($sql, $params);

        $model = new OrgModel();
        $originsMap = $model->getMapIdAndPath();
        $types = ProjectLogic::$typeAll;
        foreach ($projects as &$item) {
            $item['type_name'] = isset($types[$item['type']]) ? $types[$item['type']] : '--';
            $item['path'] = isset($originsMap[$item['org_id']]) ? $originsMap[$item['org_id']] : 'default';
            $item['create_time_text'] = format_unix_time($item['create_time'], time());
            $item['create_time_origin'] = date('y-m-d H:i:s', $item['create_time']);
            $item['first_word'] = mb_substr(ucfirst($item['name']), 0, 1, 'utf-8');
            list($item['avatar'], $item['avatar_exist']) = ProjectLogic::formatAvatar($item['avatar']);
        }
        return $projects;
    }

    /**
     * 获取角色所有的权限模块
     * @param $roleIds
     * @return array
     */
    private function getPermissionListByRoleIds($roleIds)
    {
        $relationModelObj = new  ProjectRoleRelationModel();
        $permIds = $relationModelObj->getPermIdsByRoleIds($roleIds);

        $permissionModelObj = new PermissionModel();
        $data = $permissionModelObj->getKeysById($permIds);
        unset($permissionModelObj);

        return $data;
    }
}
