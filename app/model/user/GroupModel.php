<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 * 用户组定义表
 */
class GroupModel extends CacheModel
{
    public $prefix = 'main_';

    public $table = 'group';

    const   DATA_KEY = 'main_group/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function add($name, $description, $active)
    {
        $info = [];
        $info['name'] = $name;
        $info['description'] = $description;
        $info['active'] = $active ? 1 : 0;
        $ret = $this->insert($info);
        return $ret;
    }

    public function getById($id)
    {
        return $this->getRowById($id);
    }

    public function getAll($primaryKey = true)
    {
        $fields = "id as k," . $this->getTable() . '.* ';
        return $this->getRows($fields, [], null, 'id', 'asc', null, $primaryKey);
    }

    public function getIds()
    {
        $fields = "id as k,name";
        $rows = $this->getRows($fields, [], null, 'id', 'asc', null, true);
        return array_keys($rows);
    }

    public function getByName($name)
    {
        $conditions = ['name' => trim($name)];
        $row = $this->getRow("*", $conditions);
        return $row;
    }
}
