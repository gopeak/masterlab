<?php

namespace main\app\classes;

use main\app\model\permission\PermissionModel;
use main\app\model\permission\PermissionRoleRelationModel;
use main\app\model\permission\PermissionUserRoleModel;

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

        $roleIds = $userRoleModelObj->getsByUid( $this->uid ) ;

        unset($userRoleModelObj);

        if ( empty( $roleIds ) )
        {
            return false;
        }

        //获取权限模块列表
        $permissionList = $this->getPermissionListByRoleIds( $roleIds );

        if ( in_array($this->action, $permissionList) )
        {
            return true;
        }

        return false;
    }

    /**
     * 获取角色所有的权限模块
     * @return array
     */
    private function getPermissionListByRoleIds( $roleIds )
    {
        $roleRelationModelObj = new  PermissionRoleRelationModel();
        $permIds = $roleRelationModelObj->getPermIdsByRoleIds( $roleIds );

        $permissionModelObj = new PermissionModel();

        $data = $permissionModelObj->getKeysById( $permIds );

        unset($permissionModelObj);

        return $data;

    }


}
