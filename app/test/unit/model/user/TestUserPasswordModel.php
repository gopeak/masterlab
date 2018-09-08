<?php

namespace main\app\test\unit\model\user;


use PHPUnit\Framework\TestCase;
use main\app\model\user\UserPasswordModel;
use main\app\classes\UserAuth;
use main\app\test\BaseDataProvider;
use main\app\model\user\UserModel;

/**
 *  UserPasswordModel 测试类
 * User: sven
 */
class TestUserPasswordModel extends TestCase
{
    /**
     * 用户数据
     * @var array
     */
    public static $user = [];

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        self::$user = self::initUser();
    }

    /**
     * @throws \Exception
     */
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

        $model = new UserPasswordModel();
        $model->deleteById(self::$user['uid']);
    }

    /**
     * 测试获取当前用户设置
     */
    public function testMain()
    {
        $uid = self::$user['uid'];
        $model = new UserPasswordModel();
        $originPassword = '123456';
        $password = UserAuth::createPassword($originPassword);
        list($ret) = $model->add($uid, $password);
        $this->assertTrue($ret);

        // 获取记录
        $row = $model->getByUid($uid);
        $this->assertTrue(isset($row['hash']));

        // 测试校验
        $this->assertTrue($model->valid($uid, $originPassword));
        $this->assertFalse($model->valid($uid, 'error_password'));
        $this->assertFalse($model->valid($uid, ''));
        $model->deleteById(self::$user['uid']);
    }
}
