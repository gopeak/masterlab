<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;

/**
 * 用户组管理
 */
class Group extends BaseAdminCtrl
{

    static public $pageSizes = [20, 50, 100];


    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'group';
        $this->render('gitlab/admin/groups.php', $data);
    }

    public function pageEditUsers()
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
            $this->ajaxFailed('参数错误', '用户组不能为空');
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

        $userMainModel = new UserModel();
        $user_main_talbe = $userMainModel->getTable();
        $sql = "SELECT count(distinct u.uid ) as cc FROM {$user_group_table} ug left join {$user_main_talbe} u ON ug.uid=u.uid Where ug.group_id=:group_id";
        $data['count'] =  $userModel->db->getOne($sql, ['group_id' => $group_id]);

        if (!empty($users)) {
            foreach ($users as &$user) {
                $user['avatar'] = UserLogic::formatAvatar($user['avatar'], $user['email']);
                $user['create_time_text'] = format_unix_time($user['create_time']);
            }
        }
        $data['users'] = $users;
        $this->ajaxSuccess('', $data);
    }

    /**
     * @param array $params
     * @throws \Exception
     */
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
     * 添加组
     * @param array $params
     */
    public function add($params = null)
    {
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '参数错误';
        }

        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = 'name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        $info['name'] = $params['name'];
        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        $model = new GroupModel();
        if (isset($model->getByName($info['name'])['id'])) {
            $this->ajaxFailed('提示', '该名称已经被使用', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }

        list($ret, $msg) = $model->add($info['name'], $info['description'], 1);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误', '插入数据失败,详情:' . $msg);
        }
    }

    /**
     * @param $id
     * @param $params
     * @throws \Exception
     */
    public function update($id, $params)
    {
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        if (isset($params['name']) && empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
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
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误,请重试', [], 500);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        if (empty($id)) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = (int)$id;
        $model = new GroupModel();
        $ret = $model->deleteById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }

    /**
     * @param null $group_id
     * @param null $user_ids
     * @throws \Exception
     */
    public function addUser($group_id = null, $user_ids = null)
    {
        if (empty($group_id)) {
            $this->ajaxFailed('参数错误', '用户组不能为空');
        }

        if (empty($user_ids)) {
            $this->ajaxFailed('参数错误', '用户id不能为空');
        }
        if (is_string($user_ids)) {
            $user_ids = explode(',', $user_ids);
        }
        $group_id = (int)$group_id;

        $userModel = new UserGroupModel();
        foreach ($user_ids as $uid) {
            $userModel->add($uid, $group_id);
        }
        $this->ajaxSuccess('操作成功');
    }

    /**
     * @param null $group_id
     * @param null $uid
     * @throws \Exception
     */
    public function removeUser($group_id = null, $uid = null)
    {
        if (empty($uid)) {
            $this->ajaxFailed('参数错误', '用户id不能为空');
        }
        if (empty($group_id)) {
            $this->ajaxFailed('参数错误', '用户组id不能为空');
        }

        $userModel = new UserGroupModel();
        $group_id = (int)$group_id;
        $uid = (int)$uid;
        $ret = $userModel->deleteByGroupIdUid($group_id, $uid);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除失败');
        } else {
            $this->ajaxSuccess('操作成功');
        }
    }
}
