<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *   权限方案模型
 */
class PermissionSchemeItemModel extends CacheModel
{
    public $prefix = 'permission_';

    public $table = 'scheme_item';

    const   DATA_KEY = 'permission_scheme_item/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);

        $this->uid = $uid;
    }

    public function getItemsByIdPermissionKey($schemeId, $permissionKey)
    {
        return $this->getRows('*', ['scheme' => $schemeId, 'permission_key' => $permissionKey]);
    }

    public function getItemsById($schemeId)
    {
        return $this->getRows('*', ['scheme' => $schemeId]);
    }
}
