<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;
use main\app\model\project\ProjectUserRoleModel;

class UserLogic
{
    const STATUS_OK = 1;

    const STATUS_DELETE = 2;

    const  STATUS_PENDING_APPROVAL = 0;

    const  STATUS_NORMAL = 1;

    const  STATUS_DISABLED = 2;

    static public $STATUS = [
        self::STATUS_PENDING_APPROVAL => '审核中',
        self::STATUS_NORMAL => '正常',
        self::STATUS_DISABLED => '禁用'
    ];

    /**
     * @param $user
     * @return object|\stdClass
     */
    public static function formatUserInfo($user)
    {
        if (isset($user['password'])) {
            unset($user['password']);
        }
        if (!isset($user['uid'])) {
            return new \stdClass();
        }
        if (isset($user['create_time'])) {
            $user['create_time_text'] = format_unix_time($user['create_time']);
        }
        $user['avatar'] = self::formatAvatar($user['avatar']);
        return (object)$user;
    }

    public function getAllNormalUser($limit = 10000)
    {
        $userModel = new UserModel();
        $conditions['status'] = self::STATUS_NORMAL;
        $orderBy = 'uid';
        $sort = "desc ";
        $append_sql = "";
        $field = "uid as k,uid,phone,username,display_name,avatar,email,status";
        $users = $userModel->getRows($field, $conditions, $append_sql, $orderBy, $sort, $limit, true);
        foreach ($users as &$user) {
            self::formatAvatarUser($user);
        }
        unset($user);
        return $users;
    }

    public function getUserLimit($limit = 100)
    {
        $userModel = new UserModel();
        $conditions['status'] = self::STATUS_NORMAL;
        $orderBy = 'uid';
        $sort = "desc ";
        $appendSql = "";
        $users = $userModel->getRows("*", $conditions, $appendSql, $orderBy, $sort, $limit);
        return $users;
    }

    public function filter(
        $uid = 0,
        $username = '',
        $groupId = 0,
        $status = '',
        $orderBy = 'uid',
        $sort = 'desc',
        $page = 1,
        $pageSize = 50
    )
    {
        $field = "U.uid as k,U.uid as uid,username,display_name,email,avatar,
        create_time,last_login_time,status,is_system,login_counter";
        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = empty($orderBy) ? '' : " Order By  $orderBy  $sort";

        $userModel = new UserModel();
        $userGroupModel = new UserGroupModel();
        $groupModel = new GroupModel();

        $sql = "   WHERE 1 ";
        $params = [];
        if (!empty($uid)) {
            $params['uid'] = $uid;
            $sql .= " AND uid=:uid";
        }
        if (!empty($status) && isset(UserModel::$status[$status])) {
            $params['status'] = $status;
            $sql .= " AND status=:status";
        }

        if (!empty($username)) {
            if (filter_var($username, FILTER_VALIDATE_EMAIL) !== false) {
                //$params['email'] = $username;
                $sql .= " AND  locate( ':email',email) > 0  ";
            } else {
                $params['username'] = $username;
                $params['display_name'] = $username;
                $sql .= " AND ( locate( :username,username) > 0  || locate( :display_name,display_name) > 0 )   ";
            }
        }
        $table = $userModel->getTable() . ' U  ';
        if (!empty($groupId)) {
            $params['group_id'] = $groupId;
            $userGroupTable = $userGroupModel->getTable();
            $table .= " LEFT JOIN " . $userGroupTable . " G on U.uid=G.uid ";
            $sql .= " AND  G.group_id=:group_id   ";
        }
        // 获取总数
        $sqlCount = "SELECT count(U.uid) as cc FROM  {$table} " . $sql;
        //var_dump($sqlCount,$params);
        $count = $userModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$table} " . $sql;
        $sql .= ' ' . $order . $limit;
        //var_dump($sql);
        $rows = $userModel->db->getRows($sql, $params, true);
        $userIds = array_keys($rows);

        $userGroups = $userGroupModel->getsByUserIds($userIds);
        $groups = $groupModel->getAll();

        unset($userModel, $userGroupModel, $groupModel);

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $rowUid = $row['uid'];
                $row['group'] = [];
                if (isset($userGroups[$rowUid]) && !empty($userGroups[$rowUid])) {
                    //var_dump($userGroups[$rowUid] );
                    foreach ($userGroups[$rowUid] as $gid) {
                        if (isset($groups[$gid])) {
                            $row['group'][] = $groups[$gid];
                        }
                    }
                }
                if (isset($row['password'])) {
                    unset($row['password']);
                }
                if (empty($row['avatar'])) {
                    $row['avatar'] = getGravatar(trimStr($row['email']));
                }
                $row['create_time_text'] = format_unix_time($row['create_time']);
                $row['last_login_time_text'] = format_unix_time($row['last_login_time']);
                $row['status_text'] = '';
                if (isset(UserModel::$status[$row['status']])) {
                    $row['status_text'] = UserModel::$status[$row['status']];
                }

                $row['status_bg'] = '';
                if ($row['status'] == UserModel::STATUS_NORMAL) {
                    $row['status_bg'] = 'background-color: #69D100; color: #FFFFFF"';
                }
                if ($row['status'] == UserModel::STATUS_DISABLED) {
                    $row['status_bg'] = 'background-color: #FF0000; color: #FFFFFF';
                }

                $row['myself'] = '0';
                if (isset($_SESSION[UserAuth::SESSION_UID_KEY])
                    && $row['uid'] == $_SESSION[UserAuth::SESSION_UID_KEY]
                ) {
                    $row['myself'] = '1';
                }
            }
        }
        return [$rows, $count, $groups];
    }

    /**
     * 传入用户信息，格式化头像地址
     * @param $user
     * @return mixed
     */
    public static function formatAvatarUser(&$user)
    {
        if (!isset($user['avatar'])) {
            return $user;
        }
        $user['avatar'] = self::formatAvatar($user['avatar'], $user['email']);
        return $user;
    }

    /**
     * 返回绝对路径的头像地址
     * @param string $avatar 用户表中的avatar字段值
     * @param string $email 用户email,如果该值不为空,则访问 gravatar.com 服务获得地址
     * @return string
     */
    public static function formatAvatar($avatar, $email = '')
    {
        if (strpos($avatar, 'http') === false) {
            if (empty($avatar)) {
                $avatar = ROOT_URL . 'gitlab/images/default_user.png';
                if (!empty($email)) {
                    $avatar = getGravatar($email);
                }
            } else {
                $avatar = ATTACHMENT_URL . $avatar;
            }
        }
        return $avatar;
    }

    /**
     * 用户下拉菜单的数据筛选
     * @param null $search
     * @param null $limit
     * @param bool $active
     * @param null $project_id
     * @param null $group_id
     * @param null $skip_user_ids
     * @return array
     * @throws \Exception
     */
    public function selectUserFilter(
        $search = null,
        $limit = null,
        $active = true,
        $project_id = null,
        $group_id = null,
        $skip_user_ids = null
    )
    {
        $projectId = $project_id;
        $groupId = $group_id;
        $skipUserIds = $skip_user_ids;

        $userModel = new UserModel();
        $userTable = $userModel->getTable();

        $fields = " uid  as id,username,display_name as name,avatar,status ";

        $sql = "Select {$fields} From {$userTable} Where 1 ";
        $params = [];
        if (!empty($search)) {
            $params['search'] = $search;
            $sql .= " AND  ( 
                locate(:search,username)>0 OR locate(:search,display_name)>0 OR locate(:search,email)>0 
             )";
        }
        if ($active) {
            $params['status'] = UserModel::STATUS_NORMAL;
            $sql .= " AND  status=:status ";
        }
        if (!empty($projectId)) {
            $projectRoleUserIdStr = $this->fetchProjectRoleUserIds($projectId);
            if ($projectId < 0) {
                $sql .= " AND   uid NOT In ( {$projectRoleUserIdStr} ) ";
            } else {
                $sql .= " AND   uid  In ({$projectRoleUserIdStr}) ";
            }
        }
        if (!empty($groupId)) {
            $groupId = intval($groupId);
            $userIdStr = $this->fetchUserGroupUserIds($groupId);
            if ($groupId < 0) {
                $sql .= " AND   uid NOT In ( $userIdStr ) ";
            } else {
                $sql .= " AND   uid In ( $userIdStr ) ";
            }
        }
        if (!empty($skipUserIds)) {
            if (is_array($skipUserIds)) {
                $skipUserIdsStr = implode(',', $skipUserIds);
            } else {
                $skipUserIdsStr = $skipUserIds;
            }
            $params['skip_user_ids'] = $skipUserIdsStr;
            $sql .= " AND   uid NOT IN (:skip_user_ids) ";
        }
        if (!empty($limit)) {
            $limit = intval($limit);
            $sql .= " limit $limit ";
        }
        $rows = $userModel->db->getRows($sql, $params);
        unset($userModel);
        return $rows;
    }

    /**
     * @param $projectId
     * @return string
     */
    private function fetchProjectRoleUserIds($projectId)
    {
        $userProjectRoleModel = new ProjectUserRoleModel();
        $userIdArr = [];
        $rows = $userProjectRoleModel->getRows('user_id', ['project_id' => $projectId]);
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $userIdArr[] = $row['user_id'];
            }
        }
        $userIdArrStr = 'null';
        if (!empty($userIdArr)) {
            $userIdArrStr = implode(',', $userIdArr);
        }
        return $userIdArrStr;
    }

    /**
     * @param $groupId
     * @return string
     */
    private function fetchUserGroupUserIds($groupId)
    {
        $userGroupModel = new UserGroupModel();
        $userIdArr = [];
        $rows = $userGroupModel->getRows('uid', ['group_id' => $groupId]);
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $userIdArr[] = $row['uid'];
            }
        }
        $userIdArrStr = 'null';
        if (!empty($userIdArr)) {
            $userIdArrStr = implode(',', $userIdArr);
        }
        return $userIdArrStr;
    }

    /**
     * 通过组名称过滤
     * @param string $name
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
    public function groupFilter($name = '', $page = 1, $pageSize = 50)
    {
        $userGroupModel = new UserGroupModel();
        $userGroupTable = $userGroupModel->getTable();
        $start = $pageSize * ($page - 1);
        $limit = " limit $start, " . $pageSize;
        $order = " Order by id Asc";
        $field = "G.* ,count(UG.id) as cc ";

        $groupModel = new GroupModel();
        $groupTable = $groupModel->getTable();
        $joinTable = " {$groupTable} G left join {$userGroupTable} UG on G.id=UG.group_id   ";

        $sqlCount = "SELECT count(id) as cc FROM {$groupTable} ";
        $sql = "   WHERE 1 ";
        $params = [];
        if (!empty($name)) {
            $params['name'] = $name;
            $sql .= " AND  locate( :name,G.name) > 0  ";
            $sqlCount .= " WHERE locate( :name,name) > 0";
        }
        $sql .= " group by UG.group_id ";

        // 获取总数
        $count = $groupModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$joinTable} " . $sql;
        $sql .= ' ' . $order . $limit;
        //echo $sql;
        $rows = $groupModel->db->getRows($sql, $params);
        unset($userGroupModel, $groupModel);

        return [$rows, $count];
    }

    /**
     * 获取用户通过项目和角色
     * @param $projectIds
     * @param $roleIds
     * @return array
     */
    public function getUsersByProjectRole($projectIds, $roleIds)
    {
        if (empty($projectIds)) {
            return [];
        }
        $userProjectRoleModel = new ProjectUserRoleModel();
        $userIdArr = $userProjectRoleModel->getUidsByProjectRole($projectIds, $roleIds);

        $userModel = new UserModel();
        $users = $userModel->getUsersByIds($userIdArr);
        return $users;
    }

    /**
     * 更新用户所属的组
     * @param $uid
     * @param $groups
     * @return array
     */
    public function updateUserGroup($uid, $groups)
    {
        if (empty($groups)) {
            return [false, 'data_is_empty'];
        }
        $userGroupModel = new UserGroupModel();
        try {
            $userGroupModel->db->beginTransaction();
            $userGroupModel->deleteByUid($uid);
            if (!empty($groups)) {
                $userGroupModel->adds($uid, $groups);
            }
            $userGroupModel->db->commit();
        } catch (\PDOException $e) {
            $userGroupModel->db->rollBack();
            return [false, $e->getMessage()];
        }
        return [true, 'ok'];
    }

    public static function format($item)
    {
        if (isset($item['password'])) {
            unset($item['password']);
        }
        $item['create_time_text'] = format_unix_time($item['create_time'], time());
        $item['create_time_origin'] = '';
        if (intval($item['create_time']) > 100000) {
            $item['create_time_origin'] = date('y-m-d H:i:s', intval($item['create_time']) );
        }

        $item['update_time_text'] = format_unix_time($item['update_time'], time());
        $item['update_time_origin'] = '';
        if (intval($item['update_time']) > 100000) {
            $item['update_time_origin'] = date('y-m-d H:i:s', intval($item['update_time']) );
        }
        $item['first_word'] = mb_substr(ucfirst($item['display_name']), 0, 2, 'utf-8');
        $item['avatar'] = self::formatAvatar($item['avatar'], $item['email']);
        return $item;
    }
}
