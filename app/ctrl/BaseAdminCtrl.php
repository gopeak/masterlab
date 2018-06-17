<?php

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\model\UserModel;
use main\lib\phpcurl\Curl;


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

    public function __construct()
    {
        parent::__construct();
        $this->auth = UserAuth::getInstance();
        // $token = isset($_GET['token']) ? $_GET['token'] : '';
    }
}
