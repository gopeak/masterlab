<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 全局权限
 */
class PermissionGlobalModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'global';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }
}
