<?php

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\model\UserModel;
use main\lib\phpcurl\Curl;
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
        $this->auth = UserAuth::getInstance();
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

    /**
     * 获取全局的系统配置
     * @return array
     */
    protected function getSysSetting()
    {
        return SettingModel::getInstance()->getAllSetting(true);
    }
}
