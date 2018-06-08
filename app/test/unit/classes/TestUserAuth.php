<?php

namespace main\app\test\unit\classes;

use PHPUnit\Framework\TestCase;

use main\app\model\system\MailQueueModel;
use main\app\classes\UserAuth;
use main\app\test\data\LogDataProvider;

/**
 *  UserAuth 测试类
 * @package main\app\test\unit\classes
 */
class TestUserAuth extends TestCase
{
    public static $user = [];

    public static $password = '123456';

    public static function setUpBeforeClass()
    {
        $info = [];
        $info['password'] = UserAuth::createPassword(self::$password);
        if (!$info['password']) {
            parent::fail('UserAuth::createPassword failed');
        }
        self::$user = UserAuthDataProvider::initUser($info);
    }

    public static function tearDownAfterClass()
    {
        UserAuthDataProvider::clear();
    }

    /**
     * 测试构造函数
     */
    public function testConstruct()
    {
    }

    public function testMain()
    {
        $logic = new UserAuth();

        // 未登录时返回false
        $ret = $logic->getId();
        $this->assertFalse($ret);

        // 未登录时获取用户信息返回false
        $ret = $logic->getUser();
        $this->assertFalse($ret);

        $ret = $logic->isGuest();
        $this->assertTrue($ret);

        $ret = $logic->login(self::$user);
        $this->assertTrue($ret);

        

    }
}
