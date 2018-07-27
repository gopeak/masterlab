<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;
/**
 * 用户角色所有权限
 */
class PermissionDefaultRoleModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'default_role';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getsAll()
    {
        return $this->getRows('*', ['project_id' => 0]);
    }
}
