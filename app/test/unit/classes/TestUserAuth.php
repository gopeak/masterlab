<?php

namespace main\app\test\unit\classes;

use PHPUnit\Framework\TestCase;

use main\app\model\user\IpLoginTimesModel;
use main\app\model\user\UserModel;
use main\app\classes\UserAuth;

/**
 *  UserAuth 测试类
 * @package main\app\test\unit\classes
 */
class TestUserAuth extends TestCase
{
    public static $user = [];

    public static $password = '123456';

    public static $ipAddress1 = '111.111.111.111';

    public static $ipAddress2 = '222.222.222.222';

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
        unset($_SESSION['login_captcha']);
        unset($_SESSION['login_captcha_time']);
        unset($_SESSION[UserAuth::SESSION_UID_KEY]);
        unset($_SESSION[UserAuth::SESSION_USER_INFO_KEY]);
        unset($_SESSION[UserAuth::SESSION_EXPIRE_KEY]);
        unset($_SESSION[UserAuth::SESSION_ABS_KEY]);
        unset($_SESSION[UserAuth::SESSION_TIMEOUT_KEY]);
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $ipLoginTimesModel->deleteByIp(self::$ipAddress1);
        $ipLoginTimesModel->deleteByIp(self::$ipAddress2);
    }

    /**
     * @throws \Exception
     */
    public function testMain()
    {
        $logic = new UserAuth();

        // 未登录时返回false
        $logic->logout();
        $ret = (bool)$logic->getId();
        $this->assertFalse($ret);

        // 未登录时获取用户信息返回false
        $ret = $logic->getUser();
        $this->assertEmpty($ret);

        $ret = $logic->isGuest();
        $this->assertTrue($ret);

        $ret = $logic->login(self::$user);
        $this->assertTrue($ret);

        // 登录后返回 true
        $ret = $logic->getId();
        $this->assertNotEmpty($ret);

        // 登录后获取用户信息
        $ret = $logic->getUser();
        $this->assertNotEmpty($ret);
        $ret = $logic->isGuest();
        $this->assertFalse($ret);

        // 正确的用户名和密码登录
        list($ret, $msg) = $logic->checkLoginByUsername(self::$user['username'], self::$password);
        $this->assertEquals($ret, UserModel::LOGIN_CODE_OK);
        $this->assertNotEmpty($msg);

        // 错误的用户名
        $errorUsername = 'error-username-' . mt_rand(1000, 9999);
        list($ret, $msg) = $logic->checkLoginByUsername($errorUsername, self::$password);
        $this->assertEquals($ret, UserModel::LOGIN_CODE_ERROR);
        $this->assertEmpty($msg);

        // 错误的密码
        $errorPassword = 'error-password-' . mt_rand(1000, 9999);
        list($ret, $msg) = $logic->checkLoginByUsername(self::$user['username'], $errorPassword);
        $this->assertEquals($ret, UserModel::LOGIN_CODE_ERROR);

        // 登录
        $logic->login(self::$user);
        $this->assertTrue(isset($_SESSION[UserAuth::SESSION_UID_KEY]));
        $this->assertTrue(isset($_SESSION[UserAuth::SESSION_USER_INFO_KEY]));
        $this->assertTrue(isset($_SESSION[UserAuth::SESSION_EXPIRE_KEY]));
        $this->assertTrue(isset($_SESSION[UserAuth::SESSION_ABS_KEY]));
        $this->assertTrue(isset($_SESSION[UserAuth::SESSION_TIMEOUT_KEY]));
        // 登录设置参数
        $duration = 100;
        $absolute = false;
        $logic->login(self::$user, $duration, $absolute);
        $this->assertEquals($_SESSION[UserAuth::SESSION_UID_KEY], self::$user['uid']);
        $this->assertEquals($_SESSION[UserAuth::SESSION_EXPIRE_KEY], $duration);
        $this->assertEquals($_SESSION[UserAuth::SESSION_ABS_KEY], $absolute);
        $this->assertTrue($_SESSION[UserAuth::SESSION_TIMEOUT_KEY] <= (time() + $duration));

        // 注销
        $logic->logout();
        $this->assertFalse(isset($_SESSION[UserAuth::SESSION_UID_KEY]));
        $this->assertFalse(isset($_SESSION[UserAuth::SESSION_USER_INFO_KEY]));
        $this->assertFalse(isset($_SESSION[UserAuth::SESSION_EXPIRE_KEY]));
        $this->assertFalse(isset($_SESSION[UserAuth::SESSION_ABS_KEY]));
        $this->assertFalse(isset($_SESSION[UserAuth::SESSION_TIMEOUT_KEY]));
    }

    /**
     * @throws \Exception
     */
    public function testCheckIpErrorTimes()
    {
        $logic = new UserAuth();
        // 准备数据
        $reqVerifyCode = 'req_code';
        $ipAddress = self::$ipAddress1;
        $times = 0;
        $muchErrorTimesVCode = 3;
        $_SESSION['login_captcha'] = $reqVerifyCode;
        $_SESSION['login_captcha_time'] = time() - 10;

        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $ipLoginTimesModel->insertIp($ipAddress, 1);
        // 只有一次错误的情况
        $arr = $logic->checkIpErrorTimes($reqVerifyCode, $ipAddress, $times, $muchErrorTimesVCode);
        list($ret, $retCode, $tip) = $arr;
        $this->assertTrue($ret);
        $this->assertEquals(0, $retCode);
        $this->assertEquals('', $tip);

        // 已经有10次错误的情况
        $_SESSION['login_captcha_time'] = 0;
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $ipLoginTimesModel->updateIpTime($ipAddress, 10);
        $arr = $logic->checkIpErrorTimes($reqVerifyCode, $ipAddress, $times, $muchErrorTimesVCode);
        list($ret, $retCode, $tip) = $arr;
        $this->assertFalse((bool)$ret, $tip);
        $this->assertEquals(UserModel::LOGIN_TOO_MUCH_ERROR, $retCode);
        $reqVerifyCode = false;
        $arr = $logic->checkIpErrorTimes($reqVerifyCode, $ipAddress, $times, $muchErrorTimesVCode);
        list($ret, $retCode, $tip) = $arr;
        $this->assertFalse($ret, $tip);
        $this->assertEquals(UserModel::LOGIN_REQUIRE_VERIFY_CODE, $retCode);
    }

    /**
     * @throws \Exception
     */
    public function testCheckRequireLoginVCode()
    {
        $logic = new UserAuth();
        // 准备数据
        $reqVerifyCode = 'req_code';
        $ipAddress = self::$ipAddress2;
        $times = 0;
        $muchErrorTimesVCode = 3;
        $_SESSION['login_captcha'] = $reqVerifyCode;
        $_SESSION['login_captcha_time'] = time() - 10;

        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $ipLoginTimesModel->insertIp($ipAddress, 1);
        // 只有一次错误的情况
        $arr = $logic->checkRequireLoginVCode($ipAddress, $times, $muchErrorTimesVCode);
        list($ret, $retCode, $tip) = $arr;
        $this->assertTrue($ret);
        $this->assertEquals(0, $retCode);
        $this->assertEquals('', $tip);

        // 已经有10次错误的情况
        $times = 10;
        list($ret, $msg) = $ipLoginTimesModel->updateIpTime($ipAddress, $times);
        $this->assertTrue($ret, strval($msg));
        $arr = $logic->checkRequireLoginVCode($ipAddress, $times, $muchErrorTimesVCode);
        list($ret, $retCode, $tip) = $arr;
        $this->assertTrue($ret, $tip);
        $this->assertEquals(UserModel::LOGIN_REQUIRE_VERIFY_CODE, (int)$retCode);
    }
}
