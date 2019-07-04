<?php

namespace main\app\ctrl;

use main\app\classes\SettingsLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\model\project\ProjectModel;
use main\app\classes\ProjectLogic;
use main\app\model\user\UserSettingModel;

/**
 *  网站前端的控制器基类
 *
 * @author user
 *
 */
class BaseUserCtrl extends BaseCtrl
{

    /**
     * 登录状态保持对象
     * @var \main\app\classes\UserAuth;
     */
    protected $auth;

    /**
     * 用户id
     * @var
     */
    protected $uid;

    /**
     * 是否为系统管理员
     * @var bool
     */
    public $isAdmin = false;

    /**
     * 用户在当前项目所拥有的权限列表
     * @var array
     */
    public $projectPermArr = [];

    /**
     * BaseUserCtrl constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        // 设置用户时区
        date_default_timezone_set((new SettingsLogic())->dateTimezone());
        $this->auth = UserAuth::getInstance();

        $noAuth = false;
        if (isset($_GET['_target'][0]) && isset($_GET['_target'][1])) {
            $fnc = $_GET['_target'][0] . '.' . $_GET['_target'][1];
            if (isset($_GET['_target'][2])) {
                $fnc .= '.' . $_GET['_target'][2];
            }
            $noAuthFncArr = getCommonConfigVar('common')['noAuthFnc'];
            if (in_array($fnc, $noAuthFncArr)) {
                $noAuth = true;
            }
        }
        if (!UserAuth::getId() && !$noAuth) {
            //print_r($_SERVER);
            if ($this->isAjax()) {
                $this->ajaxFailed('提示', '您尚未登录,或登录状态已经失效!', 401);
            } else {
                if (!isset($_GET['_target']) || empty($_GET['_target'])) {
                    header('location:' . ROOT_URL . 'passport/login');
                    die;
                }
                $this->error('提示',
                    '您尚未登录,或登录状态已经失效!',
                    ['type' => 'link', 'link' => ROOT_URL . 'passport/login', 'title' => '跳转至登录页面']
                );
                die;
            }
        }
        // 是否也有系统管理员权限
        $this->isAdmin = $haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        $this->addGVar('is_admin', $haveAdminPerm);

        $projectId = null;
        if (isset($_GET['project'])) {
            $projectId = intval($_GET['project']);
        }
        if (isset($_POST['params']['project_id'])) {
            $projectId = intval($_POST['params']['project_id']);
        }
        if (isset($_GET['project_id'])) {
            $projectId = intval($_GET['project_id']);
        }

        if (!empty($projectId)) {
            $this->projectPermArr = PermissionLogic::getUserHaveProjectPermissions(UserAuth::getId(), $projectId, $haveAdminPerm);
        }
        $project = [];
        if ($projectId) {
            $projModel = new ProjectModel();
            $project = $projModel->getById($projectId);
            list($project['avatar'], $project['avatar_exist']) = ProjectLogic::formatAvatar($project['avatar']);
            $project['first_word'] = mb_substr(ucfirst($project['name']), 0, 1, 'utf-8');
        }
        $this->addGVar('G_project', $project);

        $userSettings = [];
        $userSettingModel = new UserSettingModel(UserAuth::getId());
        $dbUserSettings = $userSettingModel->getSetting(UserAuth::getId());
        foreach ($dbUserSettings as $item) {
            $userSettings[$item['_key']] = $item['_value'];
        }
        $this->addGVar('G_Preferences', $userSettings);

        $assigneeCount = IssueFilterLogic::getCountByAssignee(UserAuth::getId());
        if ($assigneeCount <= 0) {
            $assigneeCount = '';
        }
        $this->addGVar('assignee_count', $assigneeCount);
        // $token = isset($_GET['token']) ? $_GET['token'] : '';
        // $this->settings = $this->getSysSetting();

        $this->addGVar('projectPermArr', $this->projectPermArr);
        $this->addGVar('G_uid', UserAuth::getId());
        $this->addGVar('G_show_announcement', $this->getAnnouncement());
    }


    /**
     * 获取当前用户uid
     * @return bool
     */
    public function getCurrentUid()
    {
        return $this->auth->getId();
    }

}
