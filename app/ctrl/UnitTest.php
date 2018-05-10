<?php
/**
 * Created by PhpStorm.
 * User: sven
 * Date: 2017/7/7 0007
 * Time: 下午 3:01
 */

namespace main\app\ctrl;

use \main\app\model\unit_test\FrameworkUserModel;
use \main\app\classes\UserAuth;

/**
 * 配合单元测试的控制器类
 * Class unitTest
 * @package main\app\ctrl
 */
class UnitTest extends BaseCtrl
{
    public function auth()
    {
        if (!isset($_REQUEST['uid'])) {
            die('param error');
        }
        $uid = $_REQUEST['uid'];

        $userModel = new FrameworkUserModel();
        $conditions['id'] = $uid;
        $user = $userModel->getRow('*', $conditions);

        if (!isset($user['id'])) {
            die('user is empty');
        }

        $auth = UserAuth::getInstance();
        $auth->login($user) ;
        echo 'ok';
    }
}
