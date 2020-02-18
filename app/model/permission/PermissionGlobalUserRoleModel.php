<?php

namespace main\app\model\permission;

use main\app\model\BaseDictionaryModel;

/**
 * 用户所拥有的全局角色
 */
class PermissionGlobalUserRoleModel extends BaseDictionaryModel
{
    public $prefix = 'permission_';

    public $table = 'global_user_role';

    /**
     * ProjectUserRoleModel constructor.
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * 获取全部数据
     * @param bool $primaryKey
     * @param string $fields
     * @return array
     */
    public function getAllItems($primaryKey = true, $fields = '*')
    {
        if ($fields == '*') {
            $table = $this->getTable();
            $fields = " id as k,{$table}.*";
        }
        $rows = $this->getRows($fields, [], null, $this->primaryKey, 'asc', null, $primaryKey);
        return $rows;
    }


    /**
     * 用户拥有哪些角色
     * @param $userId
     * @param $projectId
     * @return array
     */
    public function getUserRolesByProject($userId, $projectId)
    {
        $ret = [];
        $rows = $this->getRows('*', ['user_id' => $userId, 'project_id' => $projectId]);
        foreach ($rows as $row) {
            $ret[] = $row['role_id'];
        }

        return $ret;
    }




    /**
     * 新增
     * @param $roleId
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function add($projectId, $userId, $roleId)
    {
        $info = [];
        $info['role_id'] = $roleId;
        $info['project_id'] = $projectId;
        $info['user_id'] = $userId;
        return $this->insert($info);
    }

    /**
     * 删除
     * @param $roleId
     * @param $userId
     * @return int
     * @throws \Exception
     */
    public function del($userId, $roleId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }


    /**
     * 删除项目用户
     * @param $projectId
     * @param $userId
     * @return int
     */
    public function deleteByUser($userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        return $this->delete($conditions);
    }

    /**
     * @param $id
     * @param $userId
     * @param $roleId
     * @return int
     */
    public function deleteUniqueItem($id, $userId, $roleId)
    {
        $conditions = [];
        $conditions['id'] = $id;
        $conditions['user_id'] = $userId;
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * 删除一个用户的所有
     * @param $userId
     * @return int
     */
    public function deleteByUid($userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        return $this->delete($conditions);
    }


    /**
     * @param $userId
     * @return array
     */
    public function getUserRoles($userId)
    {
        return $this->getRows('*', ['user_id' => $userId]);
    }

    /**
     * @param $roleId
     * @return array
     */
    public function getsRoleId($roleId)
    {
        return $this->getRows('*', ['role_id' => $roleId]);
    }


    /**
     * 获取某个用户的角色列表
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function getsByUid($userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $result = $this->getRows("role_id", $conditions, null, 'id', 'asc');

        if (empty($result)) {
            return [];
        }
        $data = [];
        foreach ($result as $item) {
            $data[] = $item['role_id'];
        }
        return array_values($data);
    }

    /**
     * @param $userId
     * @param $roleId
     * @return array
     * @throws \Exception
     */
    public function insertRole($userId, $roleId)
    {
        $info = [];
        $info['user_id'] = $userId;
        $info['role_id'] = $roleId;
        return $this->insert($info);
    }

    /**
     * 批量插入
     * @param $rows
     * @return bool
     */
    public function insertRoles($rows)
    {
        return $this->insertRows($rows);
    }

    /**
     * @param $userId
     * @param $projectId
     * @param $roleId
     * @return int
     */
    public function deleteByRole($userId, $roleId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * 按角色ID删除
     * @param $roleId
     * @return int
     */
    public function deleteByRoleId($roleId)
    {
        $conditions = [];
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * @param $projectIds
     * @param $roleIds
     * @return array
     */
    public function getUidsByRole($projectIds, $roleIds)
    {
        if (empty($projectIds) || !is_array($projectIds)) {
            return [];
        }
        if (empty($roleIds) || !is_array($roleIds)) {
            return [];
        }
        $projectIds_str = implode(',', $projectIds);
        $params = [];
        $table = $this->getTable();
        $sql = "select user_id from {$table}   where  1 ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  role_id in ({$roleIds_str})";

        $rows = $this->db->getRows($sql, $params, true);

        if (!empty($rows)) {
            return array_keys($rows);
        }
        return [];
    }


    /**
     * @param $userId
     * @param $projectId
     * @param $roleId
     * @return bool
     */
    public function checkUniqueItemExist($userId, $roleId)
    {
        $table = $this->getTable();
        $conditions['user_id'] = $userId;
        $conditions['role_id'] = $roleId;
        $sql = "SELECT count(*) as cc  FROM {$table} Where user_id=:user_id AND role_id=:role_id  ";
        $count = $this->db->getOne($sql, $conditions);
        return $count > 0;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getProjectIdArrByUid($userId)
    {
        $table = $this->getTable();
        $sql = "SELECT DISTINCT project_id FROM {$table} WHERE user_id={$userId}";
        $rows = $this->db->getRows($sql);
        return $rows;
    }
}
