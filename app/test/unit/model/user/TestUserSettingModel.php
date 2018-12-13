<?php

namespace main\app\test\unit\model\user;
use PHPUnit\Framework\TestCase;
use main\app\test\BaseDataProvider;
use main\app\model\user\UserSettingModel;
use main\app\model\user\UserModel;

/**
 * UserSettingModel 测试类
 * User: sven
 */
class TestUserSettingModel extends TestCase
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

    /**
     *
     */
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
    }

    /**
     * 测试获取当前用户设置
     */
    public function testMain()
    {
        $model = new UserSettingModel();
        list($ret, $insertId) = $model->insertSetting(self::$user['uid'], 'test_key', 'test_value');
        $this->assertTrue($ret);
        $this->assertTrue(intval($insertId) > 0);

        // 获取所有的设置
        $userSettings = $model->getSetting(self::$user['uid']);
        $this->assertCount(1, $userSettings);

        // 测试获取单个值
        $value = $model->getSettingByKey(self::$user['uid'], 'test_key');
        $this->assertEquals('test_value', $value);

        // 更新设置
        list($ret, $updatedCount) = $model->updateSetting(self::$user['uid'], 'test_key', 'test_value2');
        $this->assertTrue($ret);
        $this->assertEquals(1, $updatedCount);

        // 清除数据
        $deletedCount = (int)$model->deleteSettingByKey(self::$user['uid'], 'test_key');
        $this->assertEquals(1, $deletedCount);
        $model->deleteById($insertId);

        $model->insertSetting(self::$user['uid'], 'test_key2', 'test_value2');
        $deletedCount = $model->deleteByUid(self::$user['uid']);
        $this->assertNotEmpty($deletedCount);
        $this->assertEmpty($model->getSetting(self::$user['uid']));
    }
}
