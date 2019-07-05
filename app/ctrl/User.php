<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ConfigLogic;
use main\app\classes\UploadLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\WidgetLogic;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\IssueModel;
use main\app\model\user\UserModel;
use main\app\model\user\UserTokenModel;
use main\app\model\user\UserSettingModel;
use main\app\model\user\UserIssueDisplayFieldsModel;
use main\app\model\ActivityModel;
use main\app\model\issue\IssueFollowModel;

/**
 * Class Passport
 * 用户账号相关功能
 */
class User extends BaseUserCtrl
{

    public $allowSettingFields = ['scheme_style' => 'left', 'layout' => 'fixed', 'project_view' => 'issues', 'issue_view' => 'list'];

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'user');
    }

    /**
     * @throws \Exception
     */
    public function pageProfile()
    {
        $data = [];
        $data['title'] = '个人资料';
        $data['nav'] = 'profile';
        $userId = '';
        if (isset($_GET['_target'][2])) {
            $userId = $_GET['_target'][2];
        }
        $data['other_user'] = [];

        if ($userId != '' && $userId != UserAuth::getInstance()->getId()) {
            $user = UserModel::getInstance($userId)->getUser();
            if (isset($user['create_time'])) {
                $user['create_time_text'] = format_unix_time($user['create_time']);
            }
            if (isset($user['password'])) {
                unset($user['password']);
            }
            $user = UserLogic::format($user);
            $data['other_user'] = $user;
        }
        if (empty($userId)) {
            $userId = UserAuth::getInstance()->getId();
        }
        $data['user_id'] = $userId;
        $this->render('gitlab/user/profile.php', $data);
    }

    public function pageLogOperation()
    {
        $data = [];
        $data['title'] = '操作日志';
        $data['nav'] = 'log_operation';
        $userId = '';
        if (isset($_GET['_target'][2])) {
            $userId = $_GET['_target'][2];
        }

        $data['other_user'] = [];
        $data['user_id'] = $userId;
        if ($userId != '' && $userId != UserAuth::getInstance()->getId()) {
            $user = UserModel::getInstance($userId)->getUser();
            if (isset($user['create_time'])) {
                $user['create_time_text'] = format_unix_time($user['create_time']);
            }
            if (isset($user['password'])) {
                unset($user['password']);
            }
            $user = UserLogic::format($user);
            $data['other_user'] = $user;
        }
        $data['user_id'] = $userId;
        $this->render('gitlab/user/log_operation.php', $data);
    }

    public function pageHaveJoinProjects()
    {
        $data = [];
        $data['title'] = '参与的项目';
        $data['nav'] = 'profile';
        $userId = '';
        if (isset($_GET['_target'][2])) {
            $userId = $_GET['_target'][2];
        }
        $data['other_user'] = [];
        if ($userId != '' && $userId != UserAuth::getInstance()->getId()) {
            $user = UserModel::getInstance($userId)->getUser();
            if (isset($user['create_time'])) {
                $user['create_time_text'] = format_unix_time($user['create_time']);
            }
            if (isset($user['password'])) {
                unset($user['password']);
            }
            $user = UserLogic::format($user);
            $data['other_user'] = $user;
        }
        $data['user_id'] = $userId;
        $this->render('gitlab/user/have_join_projects.php', $data);
    }

    public function pagePreferences()
    {
        $data = [];
        $data['title'] = '界面设置';
        $data['nav'] = 'profile';
        $this->render('gitlab/user/preferences.php', $data);
    }

    public function pageFilters()
    {
        $data = [];
        $data['title'] = '用户实现过滤器';
        $data['nav'] = 'profile';
        $data['projects'] = ConfigLogic::getAllProjects();
        $this->render('gitlab/user/user_filters.php', $data);
    }

    public function fetchFollowIssues()
    {
        $userId = UserAuth::getInstance()->getId();
        $model = new IssueFollowModel();

        $rows = $model->getItemsByUserId($userId);
        $issueIdArr = [];
        foreach ($rows as $row) {
            $issueIdArr[] = $row['issue_id'];
        }
        $issueIdArr = array_unique($issueIdArr);

        $issueModel = new IssueModel();
        $data['issues'] = $issueModel->getsByIds($issueIdArr);
        $this->ajaxSuccess('ok', $data);
    }


    public function fetchFilters()
    {
        $userId = UserAuth::getInstance()->getId();
        $model = new IssueFilterModel();

        $data['filters'] = $model->getCurUserFilter($userId);
        $this->ajaxSuccess('ok', $data);
    }


    /**
     * 修改自定义过滤器
     * @param array $params
     * @throws \Exception
     */
    public function updateFilter($params = [])
    {
        $id = null;
        $uid = $this->getCurrentUid();
        if (isset($_GET['_target'][3])) {
            $id = (int)$_GET['_target'][3];
        }
        if (isset($_REQUEST['id'])) {
            $id = (int)$_REQUEST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $errorMsg = [];
        if (empty($params)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }

        if (!isset($params['name']) || empty($params['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        $model = new IssueFilterModel();
        $currentRow = $model->getItemById($id);
        if (!isset($currentRow['id'])) {
            $this->ajaxFailed('错误', 'id错误,找不到对应的数据');
        }
        if ($currentRow['author'] != $uid) {
            $this->ajaxFailed('提示', '非当前用户数据，不能更新');
        }
        $id = (int)$id;
        $info = [];
        $info['name'] = $params['name'];

        $ret = $model->updateById($id, $info);
        if ($ret) {
            $this->ajaxSuccess('ok');
        } else {
            $this->ajaxFailed('服务器错误', '更新数据失败');
        }
    }

    /**
     * @param array $params
     * @throws \Exception
     */
    public function deleteFilter()
    {
        $id = null;
        if (isset($_GET['_target'][2])) {
            $id = (int)$_GET['_target'][2];
        }
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }

        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }

        $id = (int)$id;
        $model = new IssueFilterModel();
        $row = $model->getItemById($id);
        if ($row['author'] != UserAuth::getId()) {
            $this->ajaxFailed('参数错误', '该过滤器不属于当前用户或登录状态已失效');
        }
        $ret = $model->deleteItemById($id);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '删除数据失败');
        } else {
            $this->ajaxSuccess('success');
        }
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

        $widgetLogic = new WidgetLogic();
        $data['projects'] = $widgetLogic->getUserHaveJoinProjects($limit);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * 获取单个用户信息
     * @param string $token
     * @param string $openid
     * @throws \Exception
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
        if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
            $this->uid = (int)$_REQUEST['user_id'];
            $userModel->uid = $this->uid;
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
        $userId = UserAuth::getInstance()->getId();

        $userInfo = [];
        $userModel = UserModel::getInstance($userId);
        if (isset($params['display_name'])) {
            $userInfo['display_name'] = $params['display_name'];
        }
        if (isset($params['sex'])) {
            $userInfo['sex'] = (int)$params['sex'];
        }
        if (isset($params['description'])) {
            $userInfo['sign'] = $params['description'];
        }

        if (isset($params['birthday'])) {
            $userInfo['birthday'] = $params['birthday'];
        }
        if (isset($_POST['image'])) {
            $base64_string = $_POST['image'];
            $saveRet = $this->base64ImageContent($base64_string, STORAGE_PATH . 'attachment/avatar/', $userId);
            if ($saveRet !== false) {
                $userInfo['avatar'] = 'avatar/' . $saveRet . '?t=' . time();
            }
        }
        // print_r($userInfo);
        $ret = false;
        if (!empty($userInfo)) {
            list($ret) = $userModel->updateUser($userInfo);
            if ($ret) {
                $currentUid = $this->getCurrentUid();
                $activityModel = new ActivityModel();
                $activityInfo = [];
                $activityInfo['action'] = '更新了资料';
                $activityInfo['type'] = ActivityModel::TYPE_USER;
                $activityInfo['obj_id'] = $userId;
                $activityInfo['title'] = $userInfo['display_name'];
                $activityModel->insertItem($currentUid, 0, $activityInfo);

                //写入操作日志
                $logData = [];
                $logData['user_name'] = $this->auth->getUser()['username'];
                $logData['real_name'] = $this->auth->getUser()['display_name'];
                $logData['obj_id'] = $userId;
                $logData['module'] = LogOperatingLogic::MODULE_NAME_USER;
                $logData['page'] = $_SERVER['REQUEST_URI'];
                $logData['action'] = LogOperatingLogic::ACT_EDIT;
                $logData['remark'] = '用户修改个人资料';
                $logData['pre_data'] = $userModel->getRowById($currentUid);
                $logData['cur_data'] = $userInfo;
                LogOperatingLogic::add($currentUid, 0, $logData);
            }
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

        if (!UserAuth::getId()) {
            $this->ajaxFailed('提示', '你尚未登录', BaseCtrl::AJAX_FAILED_TYPE_WARN);
        }
        if (!isset($params['origin_pass']) || !isset($params['new_password'])) {
            $this->ajaxFailed('错误', '参数不能为空');
        }

        $originPassword = $params['origin_pass'];
        $newPassword = $params['new_password'];
        if (empty($originPassword) || empty($newPassword)) {
            $this->ajaxFailed('错误', '密码不能为空');
        }

        $uid = $_SESSION[UserAuth::SESSION_UID_KEY];
        $userModel = new UserModel($uid);
        $user = $userModel->getUser();
        if (!password_verify($originPassword, $user['password'])) {
            $this->ajaxFailed('错误', '原密码输入错误');
        }
        $updateInfo = [];
        $updateInfo['password'] = UserAuth::createPassword($newPassword);
        $userModel->updateUser($updateInfo);

        $this->ajaxSuccess('修改密码完成，您可以重新登录了');
    }

    /**
     * @throws \Exception
     */
    public function widgets()
    {
        $data = [];
        $data['title'] = '自定义面板';
        $data['nav'] = 'notifications';

        $userId = UserAuth::getId();
        $widgetLogic = new WidgetLogic();
        $data['widgets'] = $widgetLogic->getAvailableWidget();
        $data['user_widgets'] = $widgetLogic->getUserWidgets($userId);
        $data['user_in_projects'] = $widgetLogic->getUserHaveJoinProjects(500);
        $data['user_in_sprints'] = $widgetLogic->getUserHaveSprints($data['user_in_projects']);

        $data['user_layout'] = 'aa';
        $userSettingModel = new UserSettingModel();
        $layout = $userSettingModel->getSettingByKey($userId, 'user_layout');
        if (!empty($layout)) {
            $data['user_layout'] = $layout;
        }

        ConfigLogic::getAllConfigs($data);

        $this->render('gitlab/user/widget_setting.php', $data);
    }

    /**
     * 获取用户界面设置信息
     * @throws \Exception
     */
    public function getPreferences()
    {
        $userId = UserAuth::getInstance()->getId();
        $userModel = new UserSettingModel($userId);
        $dbUserSettings = $userModel->getSetting($userId);
        $userSettings = [];
        foreach ($dbUserSettings as $item) {
            $userSettings[$item['_key']] = $item;
        }
        foreach ($this->allowSettingFields as $settingField => $default) {
            if (!isset($userSettings[$settingField])) {
                $item = ['id' => null, 'user_id' => $userId, '_key' => $settingField, '_value' => $default];
                $dbUserSettings[] = $item;
            }
        }
        $this->ajaxSuccess('ok', ['user' => $dbUserSettings]);
    }


    /**
     * 保存用户设置
     * @throws \Exception
     */
    public function setPreferences()
    {
        $allowSettingFields = $this->allowSettingFields;

        $postSettings = $_POST['params'];

        $userId = UserAuth::getInstance()->getId();
        $userModel = new UserSettingModel($userId);
        $dbUserSettings = $userModel->getSetting($userId);
        $userSettings = [];
        foreach ($dbUserSettings as $item) {
            $userSettings[$item['_key']] = $item['_value'];
        }
        // print_r($postSettings);
        foreach ($allowSettingFields as $settingField => $default) {
            unset($default);
            // 没提交的字段忽略
            if (!isset($postSettings[$settingField])) {
                continue;
            }
            // 如果表中不存在,则插入数据
            if (!isset($userSettings[$settingField])) {
                $userModel->insertSetting($userId, $settingField, $postSettings[$settingField]);
            } else {
                // 否则更新有变化的数据
                if ($userSettings[$settingField] != $postSettings[$settingField]) {
                    $userModel->updateSetting($userId, $settingField, $postSettings[$settingField]);
                }
            }
        }
        $this->ajaxSuccess('ok', ['params' => $postSettings]);
    }

    /**
     * 保存用户某一项目的显示列设置
     * @throws \Exception
     */
    public function saveIssueDisplayFields()
    {
        $userId = UserAuth::getId();

        // 校验参数
        if (!isset($_POST['display_fields']) || !isset($_POST['project_id'])) {
            $this->ajaxFailed('参数错误');
        }

        // 获取数据
        $fields = '';
        if (!empty($_POST['display_fields'])) {
            $fields = implode(',', $_POST['display_fields']);
        }

        $projectId = (int)$_POST['project_id'];
        // 保存到数据库中
        $model = new UserIssueDisplayFieldsModel();
        list($ret, $errMsg) = $model->replaceFields($userId, $projectId, $fields);
        if (!$ret) {
            $this->ajaxFailed($errMsg);
        }
        $this->ajaxSuccess('保存成功');
    }

    /**
     * 更新用户事项列表的视图的设置
     * @throws \Exception
     */
    public function updateIssueView()
    {
        // 校验参数
        if (!isset($_POST['issue_view']) || !isset($_POST['issue_view'])) {
            $this->ajaxFailed('参数错误');
        }

        // 获取数据
        $issueView = 'list';
        if (!empty($_POST['issue_view'])) {
            $issueView = $_POST['issue_view'];
        }

        // 保存到数据库中
        $userId = UserAuth::getInstance()->getId();
        $userModel = new UserSettingModel($userId);
        $dbIssueView = $userModel->getSettingByKey($userId, 'issue_view');

        // 如果表中不存在,则插入数据
        if (empty($dbIssueView)) {
            $userModel->insertSetting($userId, 'issue_view', $issueView);
        } else {
            // 否则更新有变化的数据
            if ($dbIssueView != $issueView) {
                $userModel->updateSetting($userId, 'issue_view', $issueView);
            }
        }
        $this->ajaxSuccess('保存成功');
    }
}
