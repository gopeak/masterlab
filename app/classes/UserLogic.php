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
use main\app\model\user\UserProjectRoleModel;

class UserLogic
{

    const STATUS_OK = 1;
    const STATUS_DELETE = 2;
    static public $STATUS = [
        self::STATUS_OK => '正常',
        self::STATUS_DELETE => '已删除'
    ];

    public function getAllNormalUser($limit = 1000)
    {
        $userModel = new UserModel();
        $conditions['status'] = self::STATUS_OK;
        $orderBy = 'uid';
        $sort = "desc ";
        $append_sql = "";
        $field = "uid,phone,username,display_name,avatar";
        $users = $userModel->getRows($field, $conditions, $append_sql, $orderBy, $sort, $limit, true);
        foreach ($users as &$user) {
            if (strpos($user['avatar'], 'http://') === false) {
                if (empty($user['avatar'])) {
                    $user['avatar'] = PUBLIC_URL . 'img/default_avatar.png';
                    if (!empty($user['email'])) {
                        $user['avatar'] = getGravatar($user['email']);
                    }
                } else {
                    $user['avatar'] = ROOT_URL . $user['avatar'];
                }

            }
        }
        return $users;
    }

    public function getUserLimit($limit = 100)
    {
        $userModel = new UserModel();
        $conditions['status'] = self::STATUS_OK;
        $orderBy = 'id';
        $sort = "desc ";
        $append_sql = "";
        $users = $userModel->getRows("*", $conditions, $append_sql, $orderBy, $sort, $limit);
        return $users;
    }

    public function filter($field, $uid = 0, $username = '', $group_id = 0, $status = '',$order_by = 'uid', $sort = 'desc', $page = 1, $page_size = 50)
    {
        $start = $page_size * ($page - 1);
        $limit = " limit $start, " . $page_size;
        $order = empty($order_by) ? '' : " Order By  $order_by  $sort";

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
                $sql .= " AND ( locate( ':username',username) > 0  || locate( ':display_name',display_name) > 0 )   ";
            }
        }
        $table = $userModel->getTable() . ' U  ';
        if (!empty($group_id)) {
            $params['group_id'] = $group_id;
            $user_group_table = $userGroupModel->getTable();
            $table .= " LEFT JOIN " . $user_group_table . " G on U.uid=G.uid ";
            $sql .= " AND  G.group_id=:group_id   ";
        }
        // 获取总数
        $sqlCount = "SELECT count(U.uid) as cc FROM  {$table} " . $sql;
        $count = $userModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$table} " . $sql;
        $sql .= ' ' . $order . $limit;

        $rows = $userModel->db->getRows($sql, $params, true);
        $user_ids = array_keys($rows);

        $user_groups = $userGroupModel->getsByUserIds($user_ids);
        $groups = $groupModel->getAll();

        unset($userModel, $userGroupModel, $groupModel);

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row_uid = $row['uid'];
                $row['group'] = [];
                if (isset($user_groups[$row_uid]) && !empty($user_groups[$row_uid])) {
                    foreach ($user_groups[$row_uid] as $gid) {
                        $row['group'][] = $groups[$gid];
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

    public static function formatAvatarUser(&$user)
    {
        if (!isset($user['avatar'])) {
            return $user;
        }

        if (strpos($user['avatar'], 'http://') === false) {
            if (empty($avatar)) {
                $user['avatar'] = ROOT_URL . 'gitlab/images/default_user.png';
                if (!empty($user['email'])) {
                    $user['avatar'] = getGravatar($user['email']);
                }
            } else {
                $user['avatar'] = ROOT_URL . $avatar;
            }
        }
        return $user;
    }

    public static function formatAvatar($avatar, $email = '')
    {
        if (strpos($avatar, 'http://') === false) {
            if (empty($avatar)) {
                $avatar = ROOT_URL . 'gitlab/images/default_user.png';
                if (!empty($email)) {
                    $avatar = getGravatar($email);
                }
            } else {
                $avatar = ROOT_URL . $avatar;
            }
        }
        return $avatar;
    }

    public function selectUserFilter(
        $search = null,
        $limit = null,
        $active = true,
        $project_id = null,
        $group_id = null,
        $skip_user_ids = null
    ){
        //  @todo 应该使用连表的方式避免子查询
        $userGroupModel = new UserGroupModel();
        $user_group_table = $userGroupModel->getTable();

        $userProjectRoleModel = new UserProjectRoleModel();
        $user_project_role_table = $userProjectRoleModel->getTable();

        $userModel = new UserModel();
        $userTable = $userModel->getTable();

        $fields = " uid  as id,username,display_name as name,avatar ";

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
        if (!empty($project_id)) {
            $params['project_id'] = $project_id;
            if ($project_id < 0) {
                $sql .= " AND   uid In ( Select uid From {$user_project_role_table} Where project_id!=:project_id ) ";
            } else {
                $sql .= " AND   uid  In ( Select uid From {$user_project_role_table} Where project_id=:project_id ) ";
            }
        }
        if (!empty($group_id)) {
            $group_id = intval($group_id);
            $params['group_id'] = abs($group_id);
            if ($group_id < 0) {
                $sql .= " AND   uid NOT In ( Select uid From {$user_group_table} Where group_id=:group_id ) ";
            } else {
                $sql .= " AND   uid In ( Select uid From {$user_group_table} Where group_id=:group_id ) ";
            }
        }
        if (!empty($skip_user_ids)) {
            if (is_array($skip_user_ids)) {
                $skip_user_ids_str = implode(',', $skip_user_ids);
            } else {
                $skip_user_ids_str = $skip_user_ids;
            }
            $params['skip_user_ids'] = $skip_user_ids_str;
            $sql .= " AND   uid NOT IN (:skip_user_ids) ";
        }
        if (!empty($limit)) {
            $limit = intval($limit);
            $sql .= " limit $limit ";
        }
        //echo $sql;
        $rows = $userModel->db->getRows($sql, $params);
        unset($userModel, $userGroupModel, $userProjectRoleModel);

        return $rows;
    }


    public function groupFilter($name = '', $page = 1, $page_size = 50)
    {
        $userGroupModel = new UserGroupModel();
        $user_group_table = $userGroupModel->getTable();
        $start = $page_size * ($page - 1);
        $limit = " limit $start, " . $page_size;
        $order = " Order by id Asc";
        $field = "G.* ,count(UG.id) as cc ";

        $groupModel = new GroupModel();
        $groupTable = $groupModel->getTable();
        $join_table = " {$groupTable} G left join {$user_group_table} UG on G.id=UG.group_id   ";

        $sql = "   WHERE 1 ";
        $params = [];
        if (!empty($name)) {
            $params['name'] = $name;
            $sql .= " AND  locate( :name,G.name) > 0  ";
        }
        $sql .= " group by UG.group_id ";

        // 获取总数
        $sqlCount = "SELECT count(G.id) as cc FROM  {$join_table} " . $sql;
        $count = $groupModel->db->getOne($sqlCount, $params);

        $sql = "SELECT {$field} FROM  {$join_table} " . $sql;
        $sql .= ' ' . $order . $limit;
        //echo $sql;
        $rows = $groupModel->db->getRows($sql, $params);
        unset($userGroupModel, $groupModel);

        return [$rows, $count];
    }

    public function getUsersByProjectRole($project_ids, $role_ids)
    {
        if (empty($project_ids)) {
            return [];
        }
        $userProjectRoleModel = new UserProjectRoleModel();
        $uids = $userProjectRoleModel->getUidsByProjectRole($project_ids, $role_ids);

        $userModel = new UserModel();
        $users = $userModel->getUsersByIds($uids);
        return $users;
    }

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
}
