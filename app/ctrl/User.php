<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;
use main\app\model\user\UserTokenModel;

/**
 * Class Passport
 * 用户账号相关功能
 */
class User extends BaseUserCtrl
{

    public function profile()
    {
        $data = [];
        $data['title'] = 'Profile';
        $data['nav'] = 'profile';
        $this->render('gitlab/user/profile.php', $data);
    }

    public function profileEdit()
    {
        $data = [];
        $data['title'] = 'Profile edit';
        $data['nav'] = 'profile_edit';
        $this->render('gitlab/user/profile_edit.php', $data);
    }

    public function password()
    {
        $data = [];
        $data['title'] = 'Edit Password';
        $data['nav'] = 'password';
        $this->render('gitlab/user/password.php', $data);
    }

    public function notifications()
    {
        $data = [];
        $data['title'] = 'Notifications';
        $data['nav'] = 'notifications';
        $this->render('gitlab/user/notifications.php', $data);
    }


    /**
     * 获取单个用户信息
     * @param string $token
     * @param string $openid
     * @return object|\stdClass
     * @throws \main\app\model\user\PDOException
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
        if (isset($user['create_time'])) {
            $user['create_time_text'] = format_unix_time($user['create_time']);
        }
        $user['avatar'] = UserLogic::formatAvatar($user['avatar']);
        $this->ajaxSuccess('ok', ['user' => (object)$user]);
        return (object)$user;
    }

    /**
     * 用户查询
     * @param null $search
     * @param null $per_page
     * @param bool $active
     * @param null $project_id
     * @param null $group_id
     * @param bool $current_user
     * @param null $skip_users
     * @return array
     * @throws \main\app\model\user\PDOException
     */
    public function selectFilter(
        $search = null,
        $per_page = null,
        $active = true,
        $project_id = null,
        $group_id = null,
        $current_user = false,
        $skip_users = null
    ) {

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
        $uid = UserAuth::getInstance()->getId();

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
            if (!empty($user) && $user['uid'] != UserAuth::getInstance()->getId()) {
                $this->ajaxFailed('email_exists');
            }
            $userinfo['email'] = $email;
        }
        if (isset($params['birthday'])) {
            $userinfo['birthday'] = es($params['birthday']);
        }
        if (isset($_POST['image'])) {
            $base64_string = $_POST['image'];
            $saveRet = $this->base64ImageContent($base64_string, STORAGE_PATH . 'attachment/avatar/', $uid);
            if ($saveRet !== false) {
                $userinfo['avatar'] = 'avatar/' . $saveRet;
            }
        }
        if (!empty($userinfo)) {
            $ret = $userModel->updateUser($userinfo);
        }
        $this->ajaxSuccess('保存成功', $ret);
    }

    /**
     * save avatar
     * @param $base64ImageContent
     * @param $path
     * @param $uid
     * @return bool|string
     */
    private function base64ImageContent($base64ImageContent, $path, $uid)
    {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64ImageContent, $result)) {
            $type = $result[2];
            $newFile = $path . $uid . ".{$type}";
            if (file_put_contents($newFile, base64_decode(str_replace($result[1], '', $base64ImageContent)))) {
                return $uid . ".{$type}";
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 修改密码
     * @param array $params
     */
    public function setNewPassword($params = [])
    {
        $final = [];
        $final['code'] = 2;
        $final['msg'] = '';
        if (!isset($_SESSION[UserAuth::SESSION_UID_KEY])) {
            $this->ajaxFailed('nologin');
        }
        $originPassword = $params['origin_pass'];
        $newPassword = $params['new_password'];
        if (empty($originPassword) || empty($newPassword)) {
            $this->ajaxFailed('param_err');
        }

        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = new UserModel($uid);
        $user = $userModel->getUser();

        if (md5($originPassword) != $user['password']) {
            $this->ajaxFailed('origin_password_error');
        }
        $updateInfo = [];
        $updateInfo['password'] = md5($newPassword);
        $userModel->updateUser($updateInfo);

        $this->ajaxSuccess('修改密码完成，您可以重新登录了');
    }
}
