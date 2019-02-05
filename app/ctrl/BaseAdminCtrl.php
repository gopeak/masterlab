<?php

namespace main\app\ctrl;

use main\app\classes\IssueFilterLogic;
use main\app\classes\UserAuth;
use main\app\model\UserModel;
use main\app\classes\PermissionGlobal;
use main\app\model\user\UserSettingModel;

/**
 *  网站前端的控制器基类
 *
 * @author user
 *
 */
class BaseAdminCtrl extends BaseCtrl
{
    /**
     * 登录状态保持对象
     * @var UserAuth;
     */
    protected $auth;

    /**
     * 用户id
     * @var
     */
    protected $uid;

    /**
     * BaseAdminCtrl constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::addGVar('top_menu_active', 'system');
        parent::__construct();
        // todo 判断管理员
        //$this->auth = UserAuth::getInstance();
        // $token = isset($_GET['token']) ? $_GET['token'] : '';
        $uid = UserAuth::getId();
        if (!$uid) {
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

        $check = PermissionGlobal::check($uid, PermissionGlobal::ADMINISTRATOR);

        if (!$check || !$uid) {
            if (parent::isAjax()) {
                $this->ajaxFailed('您还未获取此模块的权限', [], 401);
            } else {
                $this->error('权限错误', '您还未获取此模块的权限！');
                exit;
            }
        }
        $assigneeCount = IssueFilterLogic::getCountByAssignee(UserAuth::getId());
        if ($assigneeCount <= 0) {
            $assigneeCount = '';
        }

        // 是否也有系统管理员权限
        $haveAdminPerm = PermissionGlobal::check(UserAuth::getId(), PermissionGlobal::ADMINISTRATOR);
        $this->addGVar('is_admin', $haveAdminPerm);

        $this->addGVar('assignee_count', $assigneeCount);

        $this->addGVar('G_uid', UserAuth::getId());
        $this->addGVar('G_show_announcement', $this->getAnnouncement());

        $userSettings = [];
        $userSettingModel = new UserSettingModel(UserAuth::getId());
        $dbUserSettings = $userSettingModel->getSetting(UserAuth::getId());
        foreach ($dbUserSettings as $item) {
            $userSettings[$item['_key']] = $item['_value'];
        }
        $this->addGVar('G_Preferences', $userSettings);
    }
}
