<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 默认角色拥有的权限
 */
class DefaultRoleRelationModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'default_role_relation';

    /**
     * DefaultRoleRelationModel constructor.
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * @param $roleId
     * @return array
     */
    public function getPermIdsByRoleId($roleId)
    {
        $list = $this->getRows('perm_id', ['role_id' => $roleId]);

        if (empty($list)) {
            return [];
        }
        $data = [];
        foreach ($list as $item) {
            $data[] = $item['perm_id'];
        }
        return array_unique($data);
    }

    /**
     * 新增
     * @param $roleId
     * @param $permId
     * @return array
     * @throws \Exception
     */
    public function add($roleId, $permId)
    {
        $info = [];
        $info['role_id'] = $roleId;
        $info['perm_id'] = $permId;
        return $this->insert($info);
    }


    /**
     * @param $roleIds
     * @return array
     */
    public function getPermIdsByRoleIds($roleIds)
    {
        if (empty($roleIds) || !is_array($roleIds)) {
            return [];
        }
        $params = [];
        $table = $this->getTable();
        $sql = "select perm_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  role_id IN ({$roleIds_str}) GROUP BY perm_id";

        $rows = $this->db->fetchAll($sql, $params);

        if (empty($rows)) {
            return [];
        }

        return array_keys($rows);
    }

    /**
     * @param $roleId
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteByRoleId($roleId)
    {
        $where = ['role_id' => $roleId];
        $row = $this->delete($where);
        return $row;
    }
}
