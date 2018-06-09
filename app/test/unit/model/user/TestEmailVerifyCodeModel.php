<?php

namespace main\app\test\unit\model\user;

use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;
use main\app\model\user\EmailVerifyCodeModel;

/**
 *  GroupModel 测试类
 * User: sven
 */
class TestEmailVerifyCodeModel extends TestBaseUserModel
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

    public static function setUpBeforeClass()
    {
        self::$user = self::initUser();
    }

    public static function tearDownAfterClass()
    {
        self::clearData();
    }
    /**
     * 初始化用户
     */
    public static function initUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);

        // 表单数据 $post_data
        $postData = [];
        $postData['username'] = $username;
        $postData['phone'] = $username;
        $postData['email'] = $username . '@masterlab.org';
        $postData['display_name'] = $username;
        $postData['status'] = UserModel::STATUS_NORMAL;
        $postData['openid'] = md5($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            //var_dump('TestBaseUserModel initUser  failed,' . $msg);
            parent::fail('TestBaseUserModel initUser  failed,' . $msg);
            return;
        }
        $user = $userModel->getRowById($msg);
        return $user;
    }

    /**
     * 清除数据
     */
    public static function clearData()
    {
        $userModel = new UserModel();
        $userModel->deleteById(self::$user['uid']);
    }

    /**
     * 主流程
     */
    public function testMain()
    {
        $model = new EmailVerifyCodeModel();
        // 1. 新增测试需要的数据
        $userId = self::$user['uid'];
        $email = self::$user['email'];
        $username= self::$user['username'];
        $verifyCode = '123456';
        list($ret, $insertId) = $model->add($userId, $email, $username, $verifyCode);
        $this->assertTrue($ret, $insertId);

        // 2.测试 getByEmail
        $row = $model->getByEmail($email);
        $this->assertEquals($email, $row['email']);
        $this->assertEquals($username, $row['username']);
        $this->assertEquals($verifyCode, $row['verify_code']);

        // 3.测试 getByName
        $row = $model->getByEmailVerify($email, $verifyCode);
        $this->assertEquals($email, $row['email']);
        $this->assertEquals($username, $row['username']);
        $this->assertEquals($verifyCode, $row['verify_code']);

        // 4.删除
        $ret = (bool)$model->deleteByEmail($email);
        $this->assertTrue($ret);
        $model->deleteById($insertId);
    }
}
