<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 默认角色模型
 */
class PermissionModel extends BaseDictionaryModel
{
    public $prefix = '';

    public $table = 'permission';

    /**
     * PermissionModel constructor.
     * @param bool $persistent
     */
    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }


    public function add($info)
    {
        if ( empty($info) )
        {
            return [false, 'params_is_empty'];
        }
        return $this->insert($info);
    }


    public function getParent()
    {
        return $this->getRows('*', ['parent_id' => 0]);
    }

    public function getChildren()
    {
        $params = [];
        $table = $this->getTable();
        $sql = " select `id` , `name` , `parent_id` , `description` , `_key` from {$table}   where  1 ";
        $sql .= " AND  parent_id > 0 ";

        $rows = $this->db->getRows($sql, $params, true);

        return $rows;
    }

    public function getKeysById($permIds)
    {

        if ( empty($permIds) || !is_array($permIds) )
        {
            return [];
        }
        $params = [];
        $table = $this->getTable();
        $sql = "select _key from {$table}   where  1 ";

        $ids_str = implode(',', $permIds);
        $sql .= " AND  id IN ({$ids_str}) ";

        $rows = $this->db->getRows($sql, $params, true);

        if ( empty($rows) )
        {
            return [];
        }

        return array_keys($rows);
    }

}
