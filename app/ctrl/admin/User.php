<?php

namespace main\app\ctrl\admin;

use main\app\classes\UserAuth;
use main\app\classes\PermissionLogic;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
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
     *
     * @return int|null
     */
    private function getParamUserId()
    {
        $userId = null;
        if (isset($_GET['_target'][3])) {
            $userId = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['uid'])) {
            $userId = (int)$_REQUEST['uid'];
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
            $this->ajaxFailed('参数错误', '提交的数据为空');
        }
        if (!isset($params['password']) || empty($params['password'])) {
            $errorMsg['password'] = 'password_is_empty';
        }
        if (!isset($params['email']) || empty($params['email'])) {
            $errorMsg['email'] = 'email_is_empty';
        }
        if (!isset($params['display_name']) || empty($params['display_name'])) {
            $errorMsg['display_name'] = 'display_name_is_empty';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
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

        list($ret, $user) = $userModel->addUser($userInfo);
        if ($ret == UserModel::REG_RETURN_CODE_OK) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', "插入数据错误:" . $user);
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
