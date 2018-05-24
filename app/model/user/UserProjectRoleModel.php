<?php

namespace main\app\model\user;

/**
 *
 */
class UserProjectRoleModel extends BaseUserItemsModel
{
    public $prefix = 'user_';

    public $table = 'project_role';

    const   DATA_KEY = 'user_project_role/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function getUserRolesByProject($uid, $projectId)
    {
        $ret = [];
        $rows = $this->getRows('*', ['uid' => $uid, 'project_id' => $projectId]);
        foreach ($rows as $row) {
            $ret[] = $row['project_role_id'];
        }

        return $ret;
    }

    public function getUserRoles($uid)
    {
        return $this->getRows('*', ['uid' => $uid]);
    }

    public function insertRole($uid, $projectId, $roleId)
    {
        $info = [];
        $info['uid'] = $uid;
        $info['project_id'] = $projectId;
        $info['project_role_id'] = $roleId;
        return $this->insert($info);
    }

    public function deleteByUid($uid)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        return $this->delete($conditions);
    }

    public function deleteByProjectRole($uid, $projectId, $roleId)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['project_id'] = $projectId;
        $conditions['project_role_id'] = $roleId;
        return $this->delete($conditions);
    }

    public function getUidsByProjectRole($projectIds, $roleIds)
    {
        if (empty($projectIds)|| !is_array($projectIds)) {
            return [];
        }
        if (empty($roleIds) || !is_array($roleIds)) {
            return [];
        }
        $projectIds_str = implode(',', $projectIds);
        $params = [];
        $table = $this->getTable();
        $sql = "select uid from {$table}   where  project_id in({$projectIds_str}) ";

        $roleIds_str = implode(',', $roleIds);
        $sql .= " AND  project_role_id in ({$roleIds_str})";

        $rows = $this->db->getRows($sql, $params, true);

        if (!empty($rows)) {
            return array_keys($rows);
        }
        return [];
    }
}
