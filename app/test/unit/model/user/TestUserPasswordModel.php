<?php

namespace main\app\test\unit\model\user;


use PHPUnit\Framework\TestCase;
use main\app\model\user\UserPasswordModel;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
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
