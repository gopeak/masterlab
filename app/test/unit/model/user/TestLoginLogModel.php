<?php

namespace main\app\test\unit\model\user;

use main\app\model\user\LoginlogModel;
use PHPUnit\Framework\TestCase;
use main\app\model\user\UserModel;
use main\app\test\BaseDataProvider;

/**
 * LoginLogModel 测试类
 * User: sven
 */
class TestLoginLogModel extends TestCase
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

        $model = new LoginlogModel();
        $model->deleteById(self::$user['uid']);
    }
    /**
     * 测试一整套流程
     * @throws \Exception
     */
    public function testMain()
    {
        $userId = self::$user['uid'];

        $model = new LoginlogModel();
        list($ret, $insertId) = $model->loginLogInsert($userId);
        $this->assertTrue($ret);
        $this->assertTrue(intval($insertId) > 0);

        // 获取所有的设置
        $loginLogs = $model->getLoginLog($userId);
        $this->assertNotEmpty($loginLogs);
        $this->assertCount(1, $loginLogs);

        // 清除数据
        $deletedCount = (int)$model->deleteByUid($userId);
        $this->assertEquals(1, $deletedCount);
        $model->deleteById($insertId);
    }
}
