<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *
 * 用户所在组 模型
 */
class UserGroupModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'group';

    const   DATA_KEY = 'user_group/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function getGroupsByUid($uid)
    {
        $ret = [];
        $rows = $this->getRows('id,group_id', ['uid' => $uid]);
        foreach ($rows as $row) {
            $ret[] = $row['group_id'];
        }
        return $ret;
    }

    public function getUserIdsByGroups($groups)
    {
        if (empty($groups)) {
            return [];
        }
        $groups_ids_str = implode(',', $groups);
        $params = [];
        $params['group_ids'] = $groups_ids_str;
        $table = $this->getTable();
        $sql = "select uid from {$table}   where  group_id in(:group_ids) ";

        $rows = $this->db->getRows($sql, $params, false);
        $ret = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $ret[] = $row['uid'];
            }
        }
        return $ret;
    }

    public function getsByUserIds($userIds)
    {
        if (empty($userIds)) {
            return [];
        }
        $userIds_str = implode(',', $userIds);
        $params = [];
        $table = $this->getTable();
        $sql = "select * from {$table}   where  uid in( {$userIds_str} ) ";
        $rows = $this->db->getRows($sql, $params, false);
        $ret = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $ret[$row['uid']][] = $row['group_id'];
            }
        }
        return $ret;
    }

    /**
     * @param $uid
     * @param $groupId
     * @return array
     * @throws \Exception
     */
    public function add($uid, $groupId)
    {
        $info = [];
        $info['uid'] = $uid;
        $info['group_id'] = $groupId;
        return $this->insertIgnore($info);
    }

    public function adds($uid, $groupIds)
    {
        $rows = [];
        foreach ($groupIds as $gid) {
            $info = [];
            $info['uid'] = $uid;
            $info['group_id'] = $gid;
            $rows [] = $info;
        }
        return $this->insertRows($rows);
    }

    public function deleteByUid($uid)
    {
        $conditions['uid'] = $uid;
        return $this->delete($conditions);
    }

    public function deleteByGroupIdUid($groupId, $uid)
    {
        $conditions['uid'] = $uid;
        $conditions['group_id'] = $groupId;
        return $this->delete($conditions);
    }
}
