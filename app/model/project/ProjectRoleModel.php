<?php

namespace main\app\model\project;

use main\app\model\CacheModel;

/**
 * 项目拥有的角色 模型
 */
class ProjectRoleModel extends CacheModel
{
    public $prefix = 'project_';

    public $table = 'role';

    const   DATA_KEY = 'project_role/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }
}