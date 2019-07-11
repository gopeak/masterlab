<?php

/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:56
 */

namespace main\app\classes;

use main\app\model\project\ProjectRoleModel;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;
use main\app\model\project\ProjectUserRoleModel;

/**
 * Class UserLogic
 * @package main\app\classes
 */
class UserLogic
{
    const STATUS_OK = 1;

    const STATUS_DELETE = 3;

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

    /**
     * @param int $limit
     * @param bool $primaryKey
     * @return array
     * @throws \Exception
     */
    public function getAllNormalUser($limit = 10000, $primaryKey = true)
    {
        $userModel = new UserModel();
        $conditions['status'] = self::STATUS_NORMAL;
        $orderBy = 'uid';
        $sort = "desc ";
        $append_sql = "";
        $field = "uid as k,uid,phone,username,display_name,avatar,email,status";
        $users = $userModel->getRows($field, $conditions, $append_sql, $orderBy, $sort, $limit, $primaryKey);
        foreach ($users as &$user) {
            self::formatAvatarUser($user);
        }
        unset($user);
        return $users;
    }

    /**
     * @param int $limit
     * @return array
     * @throws \Exception
     */
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

    /**
     * @param int $uid
     * @param string $username
     * @param int $groupId
     * @param string $status
     * @param string $orderBy
     * @param string $sort
     * @param int $page
     * @param int $pageSize
     * @return array
     * @throws \Exception
     */
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
            $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
            if (preg_match($pattern, $username)) {
                $params['email'] = $username;
                $sql .= " AND  locate(:email,email) > 0  ";
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

                $row['avatar'] = self::formatAvatar($row['avatar'], trimStr($row['email']));

                $row['create_time_text'] = format_unix_time($row['create_time']);
                $row['last_login_time_text'] = format_unix_time($row['last_login_time']);
                $row['user_status_text'] = '';
                $rowStatus = intval($row['status']);
                if (isset(UserModel::$status[$rowStatus])) {
                    $row['user_status_text'] = UserModel::$status[$rowStatus];
                }

                $row['status_bg'] = 'background-color: #69D100; color: #FFFFFF';
                if ($row['status'] == UserModel::STATUS_PENDING_APPROVAL) {
                    $row['status_bg'] = 'background-color: #fc9403; color: #FFFFFF';
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
            if (!empty($userIdStr) && $userIdStr != 'null') {
                if ($groupId < 0) {
                    $sql .= " AND   uid NOT In ( $userIdStr ) ";
                } else {
                    $sql .= " AND   uid In ( $userIdStr ) ";
                }
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
        //echo $sql;
        $rows = $userModel->db->getRows($sql, $params);
        unset($userModel);
        return $rows;
    }

    /**
     * @param $projectId
     * @return string
     * @throws \Exception
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
     * @throws \Exception
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
        $field = "G.* ";

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
        $sql .= " group by G.id ";

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
     * 获取加入项目的用户id列表
     * @param $projectId
     * @return array
     * @throws \Exception
     *
     */
    public function getUserIdArrByProject($projectId)
    {
        if (empty($projectId)) {
            return [];
        }

        $projectRoleModel = new ProjectRoleModel();
        $projectRoles = $projectRoleModel->getsByProject($projectId);
        $projectRoleIdsArr = array_column($projectRoles, 'id');
        unset($projectRoles);

        $userProjectRoleModel = new ProjectUserRoleModel();
        $rows = $userProjectRoleModel->getByProjectId($projectId);
        $userHaveRolesArr = [];
        foreach ($rows as $row) {
            if (in_array($row['role_id'], $projectRoleIdsArr)) {
                $userId = $row['user_id'];
                $userHaveRolesArr[$userId][] = $row['role_id'];
            }
        }
        return $userHaveRolesArr;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllProjectUserIdArr()
    {
        $userProjectRoleModel = new ProjectUserRoleModel();
        $rows = $userProjectRoleModel->getAllItems(false);
        $projectUserIdArr = [];
        foreach ($rows as $row) {
            $userId = $row['user_id'];
            $projectId = $row['project_id'];
            $projectUserIdArr[$projectId][] = $userId;
        }
        return $projectUserIdArr;
    }

    /**
     * 获取用户通过项目和角色
     * @param $projectIds
     * @param $roleIds
     * @return array
     * @throws \Exception
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
     * 获取项目的所有用户及用户所拥有的项目角色
     * @param $projectId
     * @return array
     * @throws \Exception
     */
    public function getUsersAndRoleByProjectId($projectId)
    {
        $model = new ProjectRoleModel();
        $data['roles'] = $model->getsByProject($projectId);
        $roleObj = [];
        foreach ($data['roles'] as $role) {
            $roleObj[$role['id']] = $role;
        }

        $userHaveRolesArr = $this->getUserIdArrByProject($projectId);

        $userIdArr = array_keys($userHaveRolesArr);
        $userModel = new UserModel();
        $users = $userModel->getUsersByIds($userIdArr);
        foreach ($users as &$user) {
            $user['have_roles'] = [];
            $user['have_roles_str'] = '';
            $userId = $user['uid'];
            if (!empty($userHaveRolesArr[$userId])) {
                foreach ($userHaveRolesArr[$userId] as $roleId) {
                    $user['have_roles'][] = $roleObj[$roleId];
                }
                $user['have_roles_str'] = implode(",", array_column($user['have_roles'], 'name'));
                $user['have_roles_ids'] = implode(",", array_column($user['have_roles'], 'id'));
            }
        }
        unset($user);
        return $users;
    }


    /**
     * 更新用户所属的组
     * @param $uid
     * @param $groups
     * @return array
     * @throws \Exception
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
            $item['create_time_origin'] = date('y-m-d H:i:s', intval($item['create_time']));
        }

        $item['update_time_text'] = format_unix_time($item['update_time'], time());
        $item['update_time_origin'] = '';
        if (intval($item['update_time']) > 100000) {
            $item['update_time_origin'] = date('y-m-d H:i:s', intval($item['update_time']));
        }
        $item['first_word'] = mb_substr(ucfirst($item['display_name']), 0, 2, 'utf-8');
        $item['avatar'] = self::formatAvatar($item['avatar'], $item['email']);
        return $item;
    }

    /**
     * 获取所有用户的ID和name的map，ID为indexKey
     * @return array
     * @throws \Exception
     */
    public static function getAllUserNameAndId()
    {
        $userModel = new UserModel();
        $originalRes = $userModel->getAll(false);
        $usernameMap = array_column($originalRes, 'username', 'uid');
        $displayNameMap = array_column($originalRes, 'display_name', 'uid');
        $avatarMap = array_column($originalRes, 'avatar', 'uid');
        return [$usernameMap, $displayNameMap, $avatarMap];
    }
}
