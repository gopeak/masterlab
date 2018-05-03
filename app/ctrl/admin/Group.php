<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;

/**
 * 组织管理
 */
class Group extends BaseAdminCtrl
{

    static public $pageSizes = [20, 50, 100];


    public function index()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'group';
        $this->render('gitlab/admin/groups.php', $data);
    }

    public function editUsers()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'group';
        $data['group_id'] = null;
        if (isset($_GET['_target'][3])) {
            $data['group_id'] = (int)$_GET['_target'][3];
        }
        if (isset($_GET['group_id'])) {
            $data['group_id'] = (int)$_GET['group_id'];
        }
        if (empty($data['group_id'])) {
            $this->error('参数错误', '用户组id为空');
            die;
        }
        $this->render('gitlab/admin/group_edit_users.php', $data);
    }

    public function fetchUsers($group_id = null)
    {
        $group_id = intval($group_id);

        if (empty($group_id)) {
            $this->ajaxFailed('param_is_empty');
        }
        $groupModel = new GroupModel();
        $data['group'] = $groupModel->getRowById($group_id);

        $userModel = new UserModel();
        $user_table = $userModel->getTable();
        $userGroupModel = new UserGroupModel();

        $user_group_table = $userGroupModel->getTable();
        $table = "{$user_table} U  LEFT JOIN {$user_group_table} G on U.uid=G.uid ";

        $sql = "   WHERE 1 ";
        $params = [];
        $params['status'] = UserModel::STATUS_NORMAL;
        $sql .= " AND status=:status";

        $params['group_id'] = $group_id;
        $sql .= " AND  G.group_id=:group_id   ";

        $fields = "U.uid as uid,username,display_name,email,avatar,create_time ";
        $sql = "SELECT {$fields} FROM  {$table} " . $sql;
        $users = $userModel->db->getRows($sql, $params);

        $sql = "SELECT count(*) as cc FROM  {$user_group_table}  Where group_id=:group_id";
        $data['count'] = $userModel->db->getOne($sql, ['group_id' => $group_id]);

        if (!empty($users)) {
            foreach ($users as &$user) {
                $user['avatar'] = UserLogic::format_avatar($user['avatar'], $user['email']);
                $user['create_time_text'] = format_unix_time($user['create_time']);
            }
        }
        $data['users'] = $users;
        $this->ajaxSuccess('', $data);
    }

    public function filter($params = [])
    {
        $page_size = intval($params['page_size']);
        if (!in_array($page_size, self::$pageSizes)) {
            $page_size = self::$pageSizes[0];
        }
        $name = trimStr($params['name']);
        $page = max(1, (int)$params['page']);

        $userLogic = new UserLogic();
        //  select g.* ,count(u.id) as cc from
        // main_group g left join user_group u on g.id=u.group_id
        //  group by u.group_id;
        list($rows, $total) = $userLogic->groupFilter($name, $page, $page_size);

        $data['groups'] = $rows;
        $data['total'] = (int)$total;
        $data['pages'] = max(1, ceil($total / $page_size));
        $data['page_size'] = (int)$page_size;
        $data['page'] = (int)$page;
        $this->ajaxSuccess('', $data);
    }

    public function get($id)
    {
        $id = (int)$id;
        $model = new GroupModel();
        $group = $model->getById($id);

        $this->ajaxSuccess('ok', (object)$group);
    }


    /**
     * 添加组织
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $errorMsg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = 'param_is_empty';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['field']['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new GroupModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        list($ret, $msg) = $model->insert($info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error:' . $msg, [], 500);
        }
    }

    /**
     * 更新组织
     * @param $id
     * @param $params
     */
    public function update($id, $params)
    {
        $errorMsg = [];
        if (empty($params)) {
            $errorMsg['tip'] = 'param_is_empty';
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['field']['name'] = 'param_is_empty';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['field']['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $id = (int)$id;

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new GroupModel();
        $group = $model->getByName($info['name']);
        //var_dump($group);
        if (isset($group['id']) && ($group['id'] != $id)) {
            $this->ajaxFailed('name_exists', [], 600);
        }

        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error', [], 500);
        }
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('param_is_empty');
        }
        $id = (int)$id;
        $model = new GroupModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }

    /**
     * @param null $group_id
     * @param null $user_ids
     */
    public function addUser($group_id = null, $user_ids = null)
    {
        if (empty($group_id)) {
            $this->ajaxFailed('param_is_empty', [], 600);
        }

        if (empty($user_ids)) {
            $this->ajaxFailed('param_is_empty', [], 600);
        }
        if (is_string($user_ids)) {
            $user_ids = explode(',', $user_ids);
        }
        $group_id = (int)$group_id;

        $userModel = new UserGroupModel();
        foreach ($user_ids as $uid) {
            $userModel->add($uid, $group_id);
        }
        $this->ajaxSuccess('ok');
    }

    public function removeUser($group_id = null, $uid = null)
    {
        if (empty($uid)) {
            $this->ajaxFailed('no_uid');
        }
        if (empty($group_id)) {
            $this->ajaxFailed('no_group_id');
        }

        $userModel = new UserGroupModel();
        $group_id = (int)$group_id;
        $uid = (int)$uid;
        $ret = $userModel->deleteByGroupIdUid($group_id, $uid);
        if (!$ret) {
            $this->ajaxFailed('delete_failed');
        } else {
            $this->ajaxSuccess('success');
        }
    }
}
