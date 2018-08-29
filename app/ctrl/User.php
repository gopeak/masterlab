<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\IssueFilterLogic;
use main\app\model\user\UserModel;
use main\app\model\user\UserTokenModel;
use main\app\model\project\ProjectModel;
use main\app\model\OrgModel;

/**
 * Class Passport
 * 用户账号相关功能
 */
class User extends BaseUserCtrl
{
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'user');
    }

    public function pageProfile()
    {
        $data = [];
        $data['title'] = 'Profile';
        $data['nav'] = 'profile';
        $this->render('gitlab/user/profile.php', $data);
    }

    public function pageHaveJoinProjects()
    {
        $data = [];
        $data['title'] = '参与的项目';
        $data['nav'] = 'profile';
        $this->render('gitlab/user/have_join_projects.php', $data);
    }

    public function pagePreferences()
    {
        $data = [];
        $data['title'] = '界面设置';
        $data['nav'] = 'profile';
        $this->render('gitlab/user/preferences.php', $data);
    }


    public function pageProfileEdit()
    {
        $data = [];
        $data['title'] = 'Profile edit';
        $data['nav'] = 'profile_edit';
        $this->render('gitlab/user/profile_edit.php', $data);
    }

    public function pagePassword()
    {
        $data = [];
        $data['title'] = 'Edit Password';
        $data['nav'] = 'password';
        $this->render('gitlab/user/password.php', $data);
    }

    public function pageNotifications()
    {
        $data = [];
        $data['title'] = 'Notifications';
        $data['nav'] = 'notifications';
        $this->render('gitlab/user/notifications.php', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchUserHaveJoinProjects()
    {
        $limit = 6;
        if (isset($_REQUEST['limit'])) {
            $limit = (int)$_REQUEST['limit'];
        }
        $userId = UserAuth::getId();
        if (PermissionGlobal::check($userId, PermissionGlobal::ADMINISTRATOR)) {
            $projectModel = new ProjectModel();
            $all = $projectModel->getAll(false);
            $model = new OrgModel();
            $originsMap = $model->getMapIdAndPath();
            $i = 0;
            $projects = [];
            foreach ($all as &$item) {
                $i++;
                if ($i > $limit) {
                    break;
                }
                $projects[] = ProjectLogic::formatProject($item, $originsMap);
            }
            $data['projects'] = $projects;
        } else {
            $data['projects'] = PermissionLogic::getUserRelationProjects($userId, $limit);
        }

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取单个用户信息
     * @param string $token
     * @param string $openid
     * @throws \ReflectionException
     */
    public function get($token = '', $openid = '')
    {
        $userModel = UserModel::getInstance('');
        $userModel->uid = UserAuth::getInstance()->getId();
        if (!empty($openid)) {
            $user = $userModel->getByOpenid($openid);
            $this->uid = $uid = $user['uid'];
        }
        if (!empty($token)) {
            $userUoken = UserTokenModel::getInstance()->getUserTokenByToken($token);
            if (!isset($userUoken['uid'])) {
                $this->ajaxFailed('错误', '提交的token无效');
            }
            $this->uid = $uid = $userUoken['uid'];
        }
        $user = $userModel->getUser();
        $user = UserLogic::formatUserInfo($user);
        $this->ajaxSuccess('ok', ['user' => $user]);
    }

    /**
     * 用户查询
     * @param null $search
     * @param null $perPage
     * @param bool $active
     * @param null $project_id
     * @param null $group_id
     * @param bool $current_user
     * @param null $skip_users
     * @return array
     * @throws \Exception
     */
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
        $perPage = abs(intval($per_page));
        $field_type = isset($_GET['field_type']) ? $_GET['field_type'] : null;
        $users = [];

        if (empty($field_type) || $field_type == 'user') {
            $userLogic = new UserLogic();
            $users = $userLogic->selectUserFilter($search, $perPage, $active, $project_id, $group_id, $skip_users);
            foreach ($users as $k => &$row) {
                $row['avatar_url'] = UserLogic::formatAvatar($row['avatar']);
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
                $tmp['avatar_url'] = UserLogic::formatAvatar($user['avatar'], $user['email']);
                array_unshift($users, $tmp);
            }
            sort($users);
        }
        if ($field_type == 'project') {
            $logic = new ProjectLogic();
            $users = $logic->selectFilter($search, $perPage);
            foreach ($users as &$row) {
                list($row['avatar'], $row['avatar_exist']) = ProjectLogic::formatAvatar($row['avatar']);
                // $row['avatar_url'] = $row['avatar'];
                //$row['first_word'] = mb_substr(ucfirst($row['name']), 0, 1, 'utf-8');
            }
        }

        if ($field_type == 'issue') {
            $logic = new IssueFilterLogic();
            $issueId = isset($_GET['issue_id']) ? intval($_GET['issue_id']) : null;
            $users = $logic->selectFilter($issueId, $search, $perPage);
            foreach ($users as &$row) {
                $row['avatar'] = null;
            }
        }
        return $users;
    }

    /**
     * 处理用户资料的修改
     * @param array $params
     * @throws \Exception
     */
    public function setProfile($params = [])
    {
        //参数检查
        $uid = UserAuth::getInstance()->getId();

        $userInfo = [];
        $userModel = UserModel::getInstance($uid);
        if (isset($params['display_name'])) {
            $userInfo['display_name'] = es($params['display_name']);
        }
        if (isset($params['sex'])) {
            $userInfo['sex'] = (int)$params['sex'];
        }
        if (isset($params['birthday'])) {
            $userInfo['birthday'] = es($params['birthday']);
        }
        if (isset($_POST['image'])) {
            $base64_string = $_POST['image'];
            $saveRet = $this->base64ImageContent($base64_string, STORAGE_PATH . 'attachment/avatar/', $uid);
            if ($saveRet !== false) {
                $userInfo['avatar'] = 'avatar/' . $saveRet;
            }
        }
        $ret = false;
        if (!empty($userInfo)) {
            $ret = $userModel->updateUser($userInfo);
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
     * @throws \Exception
     */
    public function setNewPassword($params = [])
    {
        $final = [];
        $final['code'] = 2;
        $final['msg'] = '';
        if (!isset($_SESSION[UserAuth::SESSION_UID_KEY])) {
            $this->ajaxFailed('提示', '你尚未登录', BaseCtrl::AJAX_FAILED_TYPE_WARN);
        }
        $originPassword = $params['origin_pass'];
        $newPassword = $params['new_password'];
        if (empty($originPassword) || empty($newPassword)) {
            $this->ajaxFailed('错误', '密码为空');
        }

        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = new UserModel($uid);
        $user = $userModel->getUser();

        if (md5($originPassword) != $user['password']) {
            $this->ajaxFailed('错误', '原密码输入错误');
        }
        $updateInfo = [];
        $updateInfo['password'] = UserAuth::createPassword($newPassword);
        $userModel->updateUser($updateInfo);

        $this->ajaxSuccess('修改密码完成，您可以重新登录了');
    }
}
