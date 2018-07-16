<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;
/**
 * 用户角色所有权限
 */
class PermissionUserRoleModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'user_role';

    public function __construct($persistent = false)
    {
        parent::__construct( $persistent );

    }

    /**
     * 新增
     * @param $roleId
     * @param $uid
     * @return array
     * @throws \Exception
     */
    public function add($uid, $roleId)
    {
        $info = [];
        $info['role_id'] = $roleId;
        $info['user_id'] = $uid;
        return $this->insert($info);
    }

    /**
     * 删除
     * @param $roleId
     * @param $uid
     * @return array
     * @throws \Exception
     */
    public function del($uid, $roleId)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * 获取某个用户组的角色列表
     * @param $uid
     * @return array
     * @throws \Exception
     */
    public function getsByUid($uid)
    {
        $conditions = [];
        $conditions['user_id'] = $uid;
        $result = $this->getRows("role_id", $conditions, null, 'id', 'asc');

        if ( empty($result) ){
            return  [];
        }
        $data = [];
        foreach ($result as $item)
        {
            $data[] = $item['role_id'];
        }
        return array_values($data);
    }
}
