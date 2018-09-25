<?php

namespace main\app\test\unit\model\user;

use PHPUnit\Framework\TestCase;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;

/**
 *  UserGroupModel 测试类
 * User: sven
 */
class TestBaseUserModel extends TestCase
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

    public static function setUpBeforeClass()
    {
    }

    public static function tearDownAfterClass()
    {
    }

    /**
     * 初始化用户
     */
    public static function initUser($info)
    {
        $user = BaseDataProvider::createUser($info);
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

    public function testMain()
    {
        $abc = true;
        $this->assertTrue($abc);
    }
}
