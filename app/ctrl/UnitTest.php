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
use \main\app\classes\SystemLogic;

/**
 * 配合单元测试的控制器类
 * Class unitTest
 * @package main\app\ctrl
 */
class UnitTest extends BaseCtrl
{
    /**
     * 获取当前用户的会话数据
     * @throws \Exception
     */
    public function getSession()
    {
        $this->ajaxSuccess('session', $_SESSION);
    }
	
	public function asyncMail()
    {
        $logic = new SystemLogic();
		$ret = $logic->asyncMail('121642038@qq.com', "发送测试xxxxxxxxxx", "发送内容xxxxxxxxxxxxxxxxx<h2>wwwwwwwwwwwwww</h2>", "","html", "D:/timg.jpg"); 
		 
		$this->ajaxSuccess('mail', $ret);
    }
}
