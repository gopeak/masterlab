<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 用户组所用户有的全局权限
 */
class PermissionGlobalGroupModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'global_group';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }


    /**
     * 新增
     * @param $permGlobalId
     * @param $groupId
     * @return array
     * @throws \Exception
     */
    public function add($permGlobalId, $groupId)
    {
        $info = [];
        $info['perm_global_id'] = $permGlobalId;
        $info['group_id'] = $groupId;
        //$info['is_system'] = '0';
        return $this->insert($info);
    }

    /**
     * 获取某个用户组的权限
     * @param $permGlobalId
     * @return array
     * @throws \Exception
     */
    public function getsByParentId($permGlobalId)
    {
        $conditions = [];
        $conditions['perm_global_id'] = $permGlobalId;
        return $this->getRows("*", $conditions, null, 'id', 'asc');
    }

    /**
     * 获取某个用户组拥有的权限记录
     * @param $permGlobalId
     * @param $groupId
     * @return array
     */
    public function getByParentIdAndGroupId($permGlobalId, $groupId)
    {
        $conditions = [];
        $conditions['perm_global_id'] = $permGlobalId;
        $conditions['group_id'] = $groupId;
        return $this->getRow("*", $conditions);
    }

    /**
     * 获取某个用户组拥有的权限记录
     * @param $permGlobalId
     * @param $groupId
     * @return array
     */
    public function getPermIdsByUserGroups($userGroups)
    {
        if (empty($userGroups) || !is_array($userGroups)) {
            return [];
        }
        $params = [];
        $table = $this->getTable();
        $sql = "select perm_global_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $userGroups);
        $sql .= " AND  group_id IN ({$roleIds_str}) GROUP BY perm_global_id";
        $rows = $this->db->getRows($sql, $params, true);

        if (empty($rows)) {
            return [];
        }

        return array_keys($rows);
    }
}
