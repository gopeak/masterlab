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
    //用户uid
    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;
    //用户操作行为
    protected $uid;
    protected $permId;

    public function __construct($uid, $permId)
    {
        if (empty($uid) || empty($permId)) {
            return false;
        }

        $this->uid = $uid;
        $this->permId = $permId;

    }

    /**
     * 创建一个自身的单例对象
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($uid = 0, $permId = 10000)
    {
        if (!isset(self::$instance) || !is_object(self::$instance)) {
            self::$instance = new self( $uid, $permId );
        }
        return self::$instance;
    }

    /**
     * 当前用户的全局权限检测
     * @return false|true
     */
    public function check()
    {
        $userGroupModel = new UserGroupModel();

        $userGroups = $userGroupModel->getGroupsByUid( $this->uid );

        unset( $userGroupModel );
        if ( empty( $userGroups ) )
        {
            return false;
        }


        //获取权限模块列表
        $permissionGlobalList = $this->getPermissionListByUserGroups( $userGroups );

        if ( in_array($this->permId, $permissionGlobalList) )
        {
            return true;
        }

        return false;
    }

    /**
     * 获取角色所有的全局权限模块
     * @return array
     */
    private function getPermissionListByUserGroups( $userGroups )
    {
        $permissionGlobalGroupModel = new  PermissionGlobalGroupModel();

        $permIds = $permissionGlobalGroupModel->getPermIdsByUserGroups( $userGroups );

        unset($permissionGlobalGroupModel);

        return  $permIds;

    }


}
