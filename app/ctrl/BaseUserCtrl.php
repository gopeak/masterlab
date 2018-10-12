<?php

namespace main\app\ctrl;

use main\app\classes\SettingsLogic;
use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\model\UserModel;
use main\app\model\SettingModel;


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

    public function __construct()
    {
        parent::__construct();
        // 设置用户时区
        date_default_timezone_set((new SettingsLogic())->dateTimezone());
        $this->auth = UserAuth::getInstance();
        if (!UserAuth::getId()) {
            //print_r($_SERVER);
            if ($this->isAjax()) {
                $this->ajaxFailed('提示', '您尚未登录,或登录状态已经失效!');
            } else {
                $this->error('提示', '您尚未登录,或登录状态已经失效!', ['type' => 'link', 'link' => ROOT_URL . 'passport/login', 'title' => '跳转至登录页面']);
                die;
            }
            //
        }
        $assigneeCount = IssueFilterLogic::getCountByAssignee(UserAuth::getId());
        if ($assigneeCount <= 0) {
            $assigneeCount = '';
        }
        $this->addGVar('assignee_count', $assigneeCount);
        // $token = isset($_GET['token']) ? $_GET['token'] : '';
        // $this->settings = $this->getSysSetting();
    }


    /**
     * 是否是ajax请求
     * @return bool
     */
    public function isAjax()
    {
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
