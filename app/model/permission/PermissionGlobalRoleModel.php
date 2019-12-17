<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 全局权限角色定义
 */
class PermissionGlobalRoleModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'global_role';

    /**
     * PermissionGlobalRoleModel constructor.
     * @param string $uid
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     * 通过id获取数据
     * @param $id
     * @return array
     */
    public function getById($id)
    {
        return $this->getRowById($id);
    }

    /**
     * 获取所有数据
     * @return array
     */
    public function getsAll()
    {
        return $this->getRows('*', []);
    }
}
