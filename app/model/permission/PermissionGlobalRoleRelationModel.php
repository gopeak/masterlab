<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 全局角色拥有的权限
 */
class PermissionGlobalRoleRelationModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'global_role_relation';

    /**
     * PermissionGlobalRoleRelationModel constructor.
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
        $list = $this->getRows('perm_global_id', ['role_id' => $roleId]);

        if (empty($list)) {
            return [];
        }
        $data = [];
        foreach ($list as $item) {
            $data[] = $item['perm_global_id'];
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
        $info['perm_global_id'] = $permId;
        $info['is_system'] = 1;
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
        $sql = "select perm_global_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  role_id IN ({$roleIds_str}) GROUP BY perm_global_id";

        $rows = $this->db->getRows($sql, $params, true);

        if (empty($rows)) {
            return [];
        }

        return array_keys($rows);
    }

    /**
     * @param $roleId
     * @return int
     */
    public function deleteByRoleId($roleId)
    {
        $where = ['role_id' => $roleId];
        $row = $this->delete($where);
        return $row;
    }

    /**
     * 获取某个用户组拥有的权限记录
     * @param $permGlobalId
     * @param $groupId
     * @return array
     */
    public function getPermIdsByUserRoles($idArr)
    {
        if (empty($idArr) || !is_array($idArr)) {
            return [];
        }
        $params = [];
        $table = $this->getTable();
        $sql = "select perm_global_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $idArr);
        $sql .= " AND  role_id IN ({$roleIds_str}) GROUP BY perm_global_id";
        $rows = $this->db->getRows($sql, $params, true);

        if (empty($rows)) {
            return [];
        }

        return array_keys($rows);
    }
}
