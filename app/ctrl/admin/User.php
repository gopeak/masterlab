<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\user\UserGroupModel;
use main\app\model\user\UserModel;
use main\app\model\user\GroupModel;


/**
 * 系统模块的用户控制器
 */
class User extends BaseAdminCtrl
{

    static public $pageSizes = [10, 20, 50, 100];

    public function pageIndex()
    {
        $data = [];
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'user';
        $this->render('gitlab/admin/users.php', $data);
    }

    /**
     * 项目角色
     * @param $uid
     */
    public function pageUserProjectRole($uid)
    {
        $uid = (int)$uid;
        $data = [];
        $data['uid'] = $uid;
        $data['title'] = 'Users';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'user';
        $data['title'] = 'Edit user project role';
        $this->render('gitlab/admin/user_project_role.php', $data);
    }

    /**
     *
     * @return int|null
     */
    private function getParamUserId()
    {
        $userId = null;
        if (isset($_GET['_target'][2])) {
            $userId = (int)$_GET['_target'][2];
        }
        if (isset($_GET['uid'])) {
            $userId = (int)$_GET['uid'];
        }
        if (!$userId) {
            $this->ajaxFailed('uid_is_null');
        }
        return $userId;
    }

    /**
     * 用户查询
     * @param int $uid
     * @param string $username
     * @param int $group_id
     * @param string $status
     * @param string $order_by
     * @param string $sort
     * @param int $page
     * @param int $page_size
     * @throws \Exception
     */
    public function filter(
        $uid = 0,
        $username = '',
        $group_id = 0,
        $status = '',
        $order_by = 'uid',
        $sort = 'desc',
        $page = 1,
        $page_size = 20
    )
    {
        $groupId = intval($group_id);
        $orderBy = $order_by;
        $pageSize = intval($page_size);
        if (!in_array($pageSize, self::$pageSizes)) {
            $pageSize = self::$pageSizes[1];
        }
        $uid = intval($uid);
        $groupId = intval($groupId);
        $username = trimStr($username);
        $status = intval($status);

        $userLogic = new UserLogic();
        $ret = $userLogic->filter($uid, $username, $groupId, $status, $orderBy, $sort, $page, $pageSize);
        list($users, $total, $groups) = $ret;
        $data['groups'] = array_values($groups);
        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['users'] = array_values($users);
        $this->ajaxSuccess('', $data);
    }

    /**
     *
     * @throws \Exception
     */
    public function userProjectRoleFetch()
    {
        $uid = $this->getParamUserId();
        $userProjectRoleModel = new ProjectUserRoleModel($uid);
        $userProjectRoles = $userProjectRoleModel->getUserRoles($uid);

        $userProjectRolesIds = [];
        foreach ($userProjectRoles as $v) {
            $userProjectRolesIds[$v['project_id'] . '@' . $v['project_role_id']] = $v;
        }
        $projectModel = new ProjectModel();
        $projects = $projectModel->getAll();
        $projectRoleModel = new ProjectRoleModel();
        $roles = $projectRoleModel->getsAll();
        $ps = [];
        foreach ($projects as $p) {
            $tmp = [];
            $tmp['id'] = $p['id'];
            $tmp['name'] = $p['name'];
            foreach ($roles as $role) {
                $index = $p['id'] . '@' . $role['id'];
                $tmp[$index] = isset($userProjectRolesIds[$index]);
            }
            $ps [] = $tmp;
        }
        unset($projects);

        $data['userProjectRolesIds'] = $userProjectRolesIds;
        $data['projects'] = $ps;
        $data['roles'] = $roles;

        $this->ajaxSuccess('ok', $data);
    }


    /**
     * @param $uid
     * @param $project_id
     * @throws \Exception
     */
    public function permission($uid, $project_id)
    {
        $permissionLogic = new PermissionLogic();
        $ret = $permissionLogic->getUserHaveProjectPermissions($uid, $project_id);
        $data['permissions'] = $ret;
        $this->ajaxSuccess('ok', $data);
    }


    /**
     * 某一用户的项目角色
     * @param $uid
     * @throws \Exception
     */
    public function projectRoles($uid)
    {
        $permissionLogic = new PermissionLogic();
        $ret = $permissionLogic->getUserProjectRoles($uid);
        $data['project_roles'] = $ret;
        $this->ajaxSuccess('ok', $data);
    }


    /**
     * @param $uid
     * @param $params
     * @throws \Exception
     */
    public function updateUserProjectRole($uid, $params)
    {
        $uid = intval($uid);
        $userProjectRoleModel = new ProjectUserRoleModel($uid);
        if (empty($params)) {
            $this->ajaxFailed('参数错误');
        }
        $userProjectRoleModel->deleteByUid($uid);
        foreach ($params as $key => $param) {
            list($project_id, $role_id) = explode('@', $key);
            $project_id = (int)$project_id;
            $role_id = (int)$role_id;
            if (!empty($project_id) && !empty($role_id)) {
                try {
                    $userProjectRoleModel->insertRole($uid, $project_id, $role_id);
                } catch (\Exception $e) {
                    $this->ajaxFailed('failed', $e->getMessage());
                }
            }
        }
        $this->ajaxSuccess('ok');
    }

    /**
     * 禁用用户
     * @throws \Exception
     */
    public function disable()
    {
        $userId = $this->getParamUserId();
        $userInfo = [];
        $userModel = UserModel::getInstance();
        $userInfo['status'] = UserModel::STATUS_DISABLED;
        $userModel->uid = $userId;
        $userModel->updateUser($userInfo);
        $this->ajaxSuccess('success');
    }

    /**
     * 获取单个用户信息
     * @throws \Exception
     */
    public function get()
    {
        $userId = $this->getParamUserId();
        $userModel = UserModel::getInstance($userId);

        $userModel->uid = $userId;
        $user = $userModel->getUser();
        if (isset($user['password'])) {
            unset($user['password']);
        }
        if (!isset($user['uid'])) {
            $this->ajaxFailed('参数错误');
        }
        UserLogic::formatAvatarUser($user);
        $this->ajaxSuccess('ok', (object)$user);
    }

    /**
     * 用户
     * @throws \Exception
     */
    public function gets()
    {
        $userLogic = new UserLogic();
        $users = $userLogic->getAllNormalUser();
        $this->ajaxSuccess('ok', $users);
    }

    /**
     * @throws \Exception
     */
    public function userGroup()
    {
        $userId = $this->getParamUserId();
        $data = [];
        $userGroupModel = new UserGroupModel();
        $data['user_groups'] = $userGroupModel->getGroupsByUid($userId);
        $groupModel = new GroupModel();
        $data['groups'] = $groupModel->getAll(false);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     *
     * @param $params
     * @throws \Exception
     */
    public function updateUserGroup($params)
    {
        $userId = $this->getParamUserId();
        $groups = $params['groups'];
        if (!is_array($groups)) {
            $this->ajaxFailed('param_is_error');
        }
        $userLogic = new UserLogic();
        list($ret, $msg) = $userLogic->updateUserGroup($userId, $groups);
        if ($ret) {
            $this->ajaxSuccess($msg);
        }
        $this->ajaxFailed($msg);
    }

    /**
     * 添加用户
     * @param $params
     * @throws
     */
    public function add($params)
    {
        $errorMsg = [];
        if (empty($params)) {
            $errorMsg['tip'] = '参数错误';
        }
        if (!isset($params['password']) || empty($params['password'])) {
            $errorMsg['field']['password'] = 'password_is_empty';
        }
        if (!isset($params['email']) || empty($params['email'])) {
            $errorMsg['field']['email'] = 'email_is_empty';
        }
        if (!isset($params['display_name']) || empty($params['display_name'])) {
            $errorMsg['field']['display_name'] = 'display_name_is_empty';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $display_name = $params['display_name'];
        $password = $params['password'];
        $email = $params['email'];
        $disabled = isset($params['disable']) ? true : false;
        $userInfo = [];
        $userInfo['email'] = str_replace(' ', '', $email);
        $userInfo['username'] = $email;
        $userInfo['display_name'] = $display_name;
        $userInfo['password'] = UserAuth::createPassword($password);
        $userInfo['create_time'] = time();
        if ($disabled) {
            $userInfo['status'] = UserModel::STATUS_DISABLED;
        } else {
            $userInfo['status'] = UserModel::STATUS_NORMAL;
        }

        $userModel = UserModel::getInstance();
        $user = $userModel->getByEmail($userInfo['email']);
        if (isset($user['email'])) {
            $this->ajaxFailed('email_exists');
        }

        $ret = $userModel->addUser($userInfo);
        if ($ret && !empty($userModel->db->getLastInsId())) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('server_error_add_failed');
        }
    }

    /**
     * @param $params
     * @throws \Exception
     */
    public function update($params)
    {
        $userId = $this->getParamUserId();
        $errorMsg = [];
        if (empty($params)) {
            $errorMsg['tip'] = '参数错误';
        }
        if (isset($params['password']) && empty($params['password'])) {
            $errorMsg['field']['password'] = 'password_is_empty';
        }

        if (isset($params['display_name']) && empty($params['display_name'])) {
            $errorMsg['field']['display_name'] = 'display_name_is_empty';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed($errorMsg, [], 600);
        }

        $info = [];
        if (isset($params['display_name'])) {
            $info['display_name'] = $params['display_name'];
        }
        if (isset($params['disable'])) {
            $info['status'] = UserModel::STATUS_DISABLED;
        } else {
            $info['status'] = UserModel::STATUS_NORMAL;
        }

        $userModel = UserModel::getInstance($userId);
        $userModel->uid = $userId;
        $userModel->updateUser($info);

        $this->ajaxSuccess('ok');
    }

    /**
     * 删除用户
     */
    public function delete($uid)
    {
        $userId = $this->getParamUserId();
        if (empty($uid)) {
            $this->ajaxFailed('no_uid');
        }
        // @todo 判断有关联事项，或者管理员不能删除
        $userModel = UserModel::getInstance();
        $ret = $userModel->deleteById($userId);
        if (!$ret) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        } else {
            $this->ajaxSuccess('success');
        }
    }

    /**
     * 批量删除帐户
     * @throws \Exception
     */
    public function batchDisable()
    {
        if (empty($_REQUEST['checkbox_id']) || !isset($_REQUEST['checkbox_id'])) {
            $this->ajaxFailed('no_request_uid');
        }

        $userModel = UserModel::getInstance();
        foreach ($_REQUEST['checkbox_id'] as $uid) {
            $userModel->uid = intval($uid);
            $userInfo = [];
            $userInfo['status'] = UserModel::STATUS_DISABLED;
            list($ret, $msg) = $userModel->updateUser($userInfo);
            if (!$ret) {
                $this->ajaxFailed('server_error_update_failed:' . $msg);
            }
        }
        $this->ajaxSuccess('success');
    }

    /**
     * 批量恢复帐户
     * @throws \Exception
     */
    public function batchRecovery()
    {
        if (empty($_REQUEST['checkbox_id']) || !isset($_REQUEST['checkbox_id'])) {
            $this->ajaxFailed('no_request_id');
        }

        $userModel = UserModel::getInstance();

        foreach ($_REQUEST['checkbox_id'] as $id) {
            $userModel->uid = intval($id);
            $userInfo = [];
            $userInfo['status'] = UserModel::STATUS_NORMAL;
            $userModel->updateUser($userInfo);
        }
        $this->ajaxSuccess('success');
    }
}
