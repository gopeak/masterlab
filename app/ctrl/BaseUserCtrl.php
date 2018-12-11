<?php

namespace main\app\ctrl;

use main\app\classes\SettingsLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\classes\PermissionGlobal;

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
        $haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        $this->addGVar('is_admin', $haveAdminPerm);

        $assigneeCount = IssueFilterLogic::getCountByAssignee(UserAuth::getId());
        if ($assigneeCount <= 0) {
            $assigneeCount = '';
        }
        $this->addGVar('assignee_count', $assigneeCount);
        // $token = isset($_GET['token']) ? $_GET['token'] : '';
        // $this->settings = $this->getSysSetting();

        $this->addGVar('G_uid', UserAuth::getId());
        $this->addGVar('G_show_announcement', $this->getAnnouncement());
    }


    /**
     * 是否是ajax请求
     * @return bool
     */
    public function isAjax()
    {
        if (isset($_GET['data_type']) && $_GET['data_type'] == 'json') {
            return true;
        }
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
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
