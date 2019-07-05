<?php

namespace main\app\ctrl\admin;

use main\app\classes\SystemLogic;
use main\app\classes\UserAuth;
use main\app\classes\ConfigLogic;
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

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '用户管理';
        $data['nav_links_active'] = 'user';
        $data['left_nav_active'] = 'user';
        ConfigLogic::getAllConfigs($data);

        $data['group_id'] = 0;
        if (isset($_GET['group_id'])) {
            $data['group_id'] = (int)$_GET['group_id'];
        }
        $data['status_approval'] = UserModel::STATUS_PENDING_APPROVAL;
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
        $this->ajaxSuccess('ok', $data);
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
        $this->ajaxSuccess('操作成功');
    }

    /**
     * 激活用户
     * @throws \Exception
     */
    public function active()
    {
        $userId = $this->getParamUserId();
        $userInfo = [];
        $userModel = UserModel::getInstance();
        $userInfo['status'] = UserModel::STATUS_NORMAL;
        $userModel->uid = $userId;
        $userModel->updateUser($userInfo);
        $this->ajaxSuccess('操作成功');
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

        $user['is_cur'] = "0";
        if ($user['uid'] == UserAuth::getId()) {
            $user['is_cur'] = "1";
        }
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
            $this->ajaxSuccess("操作成功", $msg);
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
            $errorMsg['password'] = '请输入密码';
        }
        if (!isset($params['email']) || empty($params['email'])) {
            $errorMsg['email'] = '请输入email地址';
        }
        if (!isset($params['username']) || empty($params['username'])) {
            $errorMsg['username'] = '请输入用户名';
        }
        if (!isset($params['display_name']) || empty($params['display_name'])) {
            $errorMsg['display_name'] = '请输入显示名称';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $display_name = $params['display_name'];
        $password = trimStr($params['password']);
        $username = trimStr($params['username']);
        $email = trimStr($params['email']);
        $disabled = isset($params['disable']) ? true : false;
        $userInfo = [];
        $userInfo['email'] = str_replace(' ', '', $email);
        $userInfo['username'] = $username;
        $userInfo['display_name'] = $display_name;
        $userInfo['password'] = UserAuth::createPassword($password);
        $userInfo['create_time'] = time();
        $userInfo['title'] = isset($params['title']) ? $params['title'] : '';
        if ($disabled) {
            $userInfo['status'] = UserModel::STATUS_DISABLED;
        } else {
            $userInfo['status'] = UserModel::STATUS_NORMAL;
        }

        $userModel = UserModel::getInstance();
        $user = $userModel->getByEmail($email);
        if (isset($user['email'])) {
            $this->ajaxFailed('邮箱地址已经被使用了');
        }
        $user2 = $userModel->getByUsername($username);
        if (isset($user2['email'])) {
            $this->ajaxFailed('用户名已经被使用了');
        }
        unset($user, $user2);

        list($ret, $user) = $userModel->addUser($userInfo);
        if ($ret == UserModel::REG_RETURN_CODE_OK) {
            if (isset($params['notify_email']) && $params['notify_email'] == '1') {
                $sysLogic = new SystemLogic();
                $content = "管理用户为您创建了Masterlab账号。<br>用户名：{$username}<br>密码：{$password}<br><br>请访问 " . ROOT_URL . " 进行登录<br>";
                $sysLogic->mail([$email], "Masterlab创建账号通知", $content);
            }
            $this->ajaxSuccess('提示', '操作成功');
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
            $this->ajaxFailed('参数错误');
        }
        if (isset($params['display_name']) && empty($params['display_name'])) {
            $errorMsg['display_name'] = '请输入显示名称';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $info = [];
        if (isset($params['password']) && !empty($params['password'])) {
            $info['password'] = UserAuth::createPassword($params['password']);
        }
        if (isset($params['display_name'])) {
            $info['display_name'] = $params['display_name'];
        }
        if (isset($params['title'])) {
            $info['title'] = $params['title'];
        }
        if (isset($params['disable']) && (UserAuth::getId() != $userId)) {
            $info['status'] = UserModel::STATUS_DISABLED;
        } else {
            $info['status'] = UserModel::STATUS_NORMAL;
        }

        $userModel = UserModel::getInstance($userId);
        $userModel->uid = $userId;
        $userModel->updateUser($info);

        $this->ajaxSuccess('提示', '操作成功');
    }

    /**
     * 删除用户
     * @throws \Exception
     */
    public function delete($uid)
    {
        $userId = $this->getParamUserId();
        if (empty($uid)) {
            $this->ajaxFailed('no_uid');
        }
        if ($userId == UserAuth::getId()) {
            $this->ajaxFailed('逻辑错误', '不能自己');
        }

        // @todo 要处理删除后该用户关联的事项
        $userModel = new UserModel();
        $user = $userModel->getByUid($userId);
        if (empty($user)) {
            $this->ajaxFailed('参数错误', '用户不存在');
        }
        if ($user['is_system'] == '1') {
            $this->ajaxFailed('逻辑错误', '不能删除系统自带的用户');
        }

        $ret = $userModel->deleteById($userId);
        if (!$ret) {
            $this->ajaxFailed('系统错误', '删除用户失败,原因是数据库执行错误');
        } else {
            $userModel = new UserGroupModel();
            $userModel->deleteByUid($userId);
            $this->ajaxSuccess('提示', '操作成功');
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
        $this->ajaxSuccess('提示', '操作成功');
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
        $this->ajaxSuccess('提示', '操作成功');
    }
}
