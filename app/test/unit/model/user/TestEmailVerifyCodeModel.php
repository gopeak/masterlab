<?php

namespace main\app\test\unit\model\user;

use main\app\model\user\UserModel;
use main\app\model\user\EmailVerifyCodeModel;
use main\app\test\BaseDataProvider;

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
     * @param array $info
     * @return array
     * @throws \Exception
     */
    public static function initUser($info=[])
    {
        $user = BaseDataProvider::createUser($info);
        return $user;
    }

    /**
     * 清除数据
     * @throws \Exception
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
