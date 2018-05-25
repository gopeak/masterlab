<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *   权限方案模型
 */
class PermissionSchemeModel extends CacheModel
{
    public $prefix = 'permission_';

    public $table = 'scheme';

    const   DATA_KEY = 'permission_scheme/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);

        $this->uid = $uid;
    }
}
