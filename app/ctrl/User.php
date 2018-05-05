<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;
use main\app\model\user\RegVerifyCodeModel;
use main\app\model\user\UserTokenModel;
use main\app\model\user\LoginlogModel;
use main\app\model\user\EmailVerifyCodeModel;

/**
 * Class Passport
 * 用户账号相关功能
 */
class User extends BaseUserCtrl
{

    public function profile()
    {
        $data = [];
        $data['title'] = 'Sign in';
        $this->render('gitlab/user/profile.php', $data);
    }

    public function profile_edit()
    {
        $data = [];
        $data['title'] = 'Sign in';
        $this->render('gitlab/user/profile_edit.php', $data);
    }

    /**
     * 获取单个用户信息
     * @param string $token
     * @param string $openid
     * @return object
     */
    public function get($token = '', $openid = '')
    {
        $userModel = UserModel::getInstance('');

        if (!empty($openid)) {
            $user = $userModel->getByOpenid($openid);
            $this->uid = $uid = $user['uid'];
        }
        if (!empty($token)) {
            $user_token = UserTokenModel::getInstance()->getUserTokenByToken($token);
            if (!isset($user_token['uid'])) {
                $this->ajaxFailed('token无效!');
            }
            $this->uid = $uid = $user_token['uid'];
        }
        $userModel->uid = UserAuth::getInstance()->getId();
        $user = $userModel->getUser();
        if (isset($user['password'])) {
            unset($user['password']);
        }
        if (!isset($user['uid'])) {
            return new \stdClass();
        }
        $user['avatar'] = UserLogic::formatAvatar($user['avatar']);
        $this->ajaxSuccess('ok', ['user' => (object)$user]);
        return (object)$user;
    }

    public function selectFilter(
        $search = null,
        $per_page = null,
        $active = true,
        $project_id = null,
        $group_id = null,
        $current_user = false,
        $skip_users = null
    )
    {

        header('Content-Type:application/json');
        $current_uid = UserAuth::getInstance()->getId();
        $userModel = UserModel::getInstance($current_uid);
        $per_page = abs(intval($per_page));
        $field_type = isset($_GET['field_type']) ? $_GET['field_type'] : null;
        $users = [];

        if (empty($field_type) || $field_type == 'user') {
            $userLogic = new UserLogic();
            $users = $userLogic->selectUserFilter($search, $per_page, $active, $project_id, $group_id, $skip_users);
            foreach ($users as $k => &$row) {
                $row['avatar_url'] = UserLogic::format_avatar($row['avatar']);
                if ($current_user && $row['id'] == $current_uid) {
                    unset($users[$k]);
                }
            }
            if ($current_user) {
                $user = $userModel->getUser();
                $tmp = [];
                $tmp['id'] = $user['uid'];
                $tmp['name'] = $user['display_name'];
                $tmp['username'] = $user['username'];
                $tmp['avatar_url'] = UserLogic::format_avatar($user['avatar'], $user['email']);
                array_unshift($users, $tmp);
            }
            sort($users);
        }
        if ($field_type == 'project') {
            $logic = new ProjectLogic();
            $users = $logic->selectFilter($search, $per_page);
            foreach ($users as &$row) {
                $row['avatar_url'] = UserLogic::format_avatar($row['avatar']);
            }
        }
        return $users;
    }

    /**
     * 处理用户资料的修改
     * @param array $params
     * @throws \main\app\model\user\PDOException
     */
    public function setProfile($params = [])
    {
        //参数检查
        $uid = $this->uid;

        $userinfo = [];
        $userModel = UserModel::getInstance($uid);
        if (isset($params['display_name'])) {
            $userinfo['display_name'] = es($params['display_name']);
        }
        if (isset($params['sex'])) {
            $userinfo['sex'] = (int)$params['sex'];
        }
        if (isset($params['email'])) {
            $email = $params['email'];
            $user = $userModel->getByEmail($email);
            if (!empty($user) && $user['uid']!=UserAuth::getInstance()->getId()) {
                $this->ajaxFailed('email_exists');
            }
            $userinfo['email'] = $email;
        }
        if (isset($params['birthday'])) {
            $userinfo['birthday'] = es($params['birthday']);
        }
        if (isset($params['avatar'])) {
            if (strpos($params['avatar'], 'http://') !== false) {
                $params['avatar'] = str_replace(ATTACHMENT_URL, '', $params['avatar']);
            }
            $userinfo['avatar'] = es($params['avatar']);
        }
        if (!empty($userinfo)) {
            $userModel->updateUser($userinfo);
        }
        $this->ajaxSuccess('保存成功', $userinfo);
    }

    /**
     * 直接修改修改密码
     * @param string $origin_pass
     * @param string $new_pass
     */
    public function setNewPassword($origin_pass, $new_pass)
    {
        $final = [];
        $final['code'] = 2;
        $final['msg'] = '';
        if (!isset($_SESSION[UserAuth::SESSION_UID_KEY])) {
            $this->ajaxFailed('nologin');
        }
        if (empty($old_pass) || empty($new_pass)) {
            $this->ajaxFailed('param_err');
        }

        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = new UserModel($uid);
        $user = $userModel->getUser();

        if (md5($origin_pass) != $user['password']) {
            $this->ajaxFailed('origin_password_error');
        }
        $update_info = [];
        $update_info['password'] = md5($new_pass);
        $userModel->updateUser($update_info);

        $this->ajaxSuccess('修改密码完成，您可以重新登录了');
    }

    /**
     * 本地裁剪后提交服务器
     * @param null $file
     * @throws \main\app\model\user\PDOException
     */
    public function crop($file = null)
    {
        unset($file);
        $user_info = [];

        if (!isset($_SESSION[UserAuth::SESSION_UID_KEY]) || empty($_SESSION[UserAuth::SESSION_UID_KEY])) {
            $this->ajaxFailed('nologin');
        }
        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = UserModel::getInstance($uid);
        if (isset($_REQUEST['direct_pic']) && !empty($_REQUEST['direct_pic'])) {
            $user_info['avatar'] = es($_REQUEST['direct_pic']);
            $userModel->updateUser($user_info);
            $this->ajaxSuccess('操作成功');
        }
        if (!isset($_FILES['avatar'])) {
            $this->ajaxFailed('param_file_null', [], 500);
        }

        $dir = (strlen($uid) > 1) ? substr($uid, 0, 2) : $uid;
        $relate_path = 'attached/avatar/' . $dir;
        $abs_path = PUBLIC_PATH . 'assets/' . $relate_path;
        if (!file_exists($abs_path)) {
            mkdir($abs_path, 0755);
        }
        $ext = get_image_ext($_FILES['avatar']['tmp_name']);
        $origin_filename = $uid . '_origin.' . $ext;
        list($re) = uploadFile($_FILES['avatar'], $abs_path, $origin_filename);
        if (!$re) {
            $this->ajaxFailed('upload_file_failed', [], 500);
        }
        $user_info['avatar'] = $relate_path . '/' . $uid . '_origin.' . $ext . '?t=' . time();

        $userModel->updateUser($user_info);
        $this->ajaxSuccess('操作成功');
    }
}
