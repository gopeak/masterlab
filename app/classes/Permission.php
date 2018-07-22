<?php

namespace main\app\classes;

use main\app\model\permission\PermissionModel;
use main\app\model\permission\PermissionRoleModel;
use main\app\model\permission\PermissionRoleRelationModel;
use main\app\model\permission\PermissionUserRoleModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
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

    public function __construct($uid, $action)
    {
        if (empty($uid) || empty($action)) {
            return false;
        }

        $this->uid = $uid;
        $this->action = $action;

    }

    /**
     * 创建一个自身的单例对象
     * @throws \PDOException
     * @return self
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
     * @return false|true
     */
    public function check()
    {
        $userRoleModelObj = new PermissionUserRoleModel();

        $roleIds = $userRoleModelObj->getsByUid($this->uid);

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
        $userRoleModel = new PermissionUserRoleModel();
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
        return   $projects;
    }

    /**
     * 获取角色所有的权限模块
     * @return array
     */
    private function getPermissionListByRoleIds($roleIds)
    {
        $roleRelationModelObj = new  PermissionRoleRelationModel();
        $permIds = $roleRelationModelObj->getPermIdsByRoleIds($roleIds);

        $permissionModelObj = new PermissionModel();

        return $permissionModelObj->getKeysById($permIds);

    }
}
