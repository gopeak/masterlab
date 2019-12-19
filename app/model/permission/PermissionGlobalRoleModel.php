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

    /**
     * 通过角色名来获取数据
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        $conditions = [];
        $conditions['name'] = $name;
        return $this->getRow("*", $conditions);
    }

    /**
     * 新增
     * @param $name
     * @param string $description
     * @return array
     * @throws \Exception
     */
    public function add($name, $description = "")
    {
        $row = [];
        $row['name'] = $name;
        $row['description'] = $description;
        $row['is_system'] = '0';
        return $this->insert($row);
    }
}
