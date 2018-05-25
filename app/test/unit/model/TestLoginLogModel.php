<?php

namespace main\app\test\unit\model;

use main\app\model\user\LoginlogModel;
use PHPUnit\Framework\TestCase;

use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\UserModel;

/**
 * LoginLogModel 测试类
 * User: sven
 */
class TestLoginLogModel extends TestCase
{

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
        $postData['status'] = UserLogic::STATUS_OK;
        $postData['openid'] = UserAuth::createOpenid($username);

        $userModel = new UserModel();
        list($ret, $msg) = $userModel->insert($postData);
        if (!$ret) {
            var_dump('initUser  failed,' . $msg);
            parent::fail('initUser  failed,' . $msg);
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

        $model = new LoginlogModel();
        $model->deleteById(self::$user['uid']);
    }
    /**
     * 测试一整套流程
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
