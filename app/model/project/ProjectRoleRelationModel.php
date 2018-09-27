<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 * 项目的用户角色所拥有的权限
 */
class ProjectRoleRelationModel extends BaseDictionaryModel
{
    public $prefix = 'project_';

    public $table = 'role_relation';

    /**
     * ProjectRoleRelationModel constructor.
     * @param bool $persistent
     */
    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * 获取某个角色权限id列表
     * @param $roleId
     * @return array
     */
    public function getPermIdsByRoleId($roleId)
    {
        $list = $this->getRows('perm_id', ['role_id' => $roleId], true);

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
    public function add($projectId, $roleId, $permId)
    {
        $info = [];
        $info['project_id'] = $projectId;
        $info['role_id'] = $roleId;
        $info['perm_id'] = $permId;
        return $this->insert($info);
    }

    /**
     * 获取多个角色的权限
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

        $rows = $this->db->getRows($sql, $params, true);

        if (empty($rows)) {
            return [];
        }

        return array_keys($rows);
    }

    /**
     * 删除某个角色的关联数据
     * @param $roleId
     * @return int
     */
    public function deleteByRoleId($roleId)
    {
        $where = ['role_id' => $roleId];
        $row = $this->delete($where);
        return $row;
    }
}
