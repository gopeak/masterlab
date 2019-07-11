<?php

namespace main\app\model\project;

use main\app\model\BaseDictionaryModel;

/**
 * 项目的中的用户所拥有的角色
 */
class ProjectUserRoleModel extends BaseDictionaryModel
{
    public $prefix = 'project_';

    public $table = 'user_role';

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
     * 项目中用户拥有哪些角色
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
     * 用户所在项目总数
     * @param $userId
     * @param $projectId
     * @return int
     */
    public function getCountUserRolesByProject($userId, $projectId)
    {
        $count = $this->getOne('count(*) as cc', ['user_id' => $userId, 'project_id' => $projectId]);
        return intval($count);
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
     * 删除项目角色下的所有用户
     * @param $roleId
     * @return int
     * @throws \Exception
     */
    public function delProjectRole($roleId)
    {
        $conditions = [];
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * 删除项目用户
     * @param $projectId
     * @param $userId
     * @return int
     */
    public function delProjectUser($projectId, $userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['project_id'] = $projectId;
        return $this->delete($conditions);
    }

    /**
     * @param $id
     * @param $userId
     * @param $projectId
     * @param $roleId
     * @return int
     */
    public function deleteUniqueItem($id, $userId, $projectId, $roleId)
    {
        $conditions = [];
        $conditions['id'] = $id;
        $conditions['user_id'] = $userId;
        $conditions['project_id'] = $projectId;
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
     * @param $projectId
     * @return array
     */
    public function getByProjectId($projectId)
    {
        return $this->getRows('*', ['project_id' => $projectId]);
    }

    /**
     * @param $projectId
     * @return array
     */
    public function getUserIdByProjectId($projectId)
    {
        $rows = $this->getRows('user_id', ['project_id' => $projectId]);
        $userIdArr = [];
        foreach ($rows as $row) {
            $userIdArr[] = $row['user_id'];
        }
        return $userIdArr;
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
     * @param $projectId
     * @param $roleId
     * @return array
     * @throws \Exception
     */
    public function insertRole($userId, $projectId, $roleId)
    {
        $info = [];
        $info['user_id'] = $userId;
        $info['project_id'] = $projectId;
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
    public function deleteByProjectRole($userId, $projectId, $roleId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['project_id'] = $projectId;
        $conditions['role_id'] = $roleId;
        return $this->delete($conditions);
    }

    /**
     * @param $projectIds
     * @param $roleIds
     * @return array
     */
    public function getUidsByProjectRole($projectIds, $roleIds)
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
        $sql = "select user_id from {$table}   where  project_id in({$projectIds_str}) ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  role_id in ({$roleIds_str})";

        $rows = $this->db->getRows($sql, $params, true);

        if (!empty($rows)) {
            return array_keys($rows);
        }
        return [];
    }

    /**
     * @param $projectIds
     * @return array
     */
    public function getUidsByProjectIds($projectIds)
    {
        if (empty($projectIds) || !is_array($projectIds)) {
            return [];
        }
        $projectIds_str = implode(',', $projectIds);
        $params = [];
        $table = $this->getTable();
        $sql = "select user_id from {$table}   where  project_id in({$projectIds_str}) ";

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
    public function checkUniqueItemExist($userId, $projectId, $roleId)
    {
        $table = $this->getTable();
        $conditions['user_id'] = $userId;
        $conditions['project_id'] = $projectId;
        $conditions['role_id'] = $roleId;
        $sql = "SELECT count(*) as cc  FROM {$table} Where user_id=:user_id AND project_id=:project_id AND role_id=:role_id  ";
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
