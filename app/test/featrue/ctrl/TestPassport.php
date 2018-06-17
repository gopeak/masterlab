<?php

namespace main\app\test\featrue;

use main\app\model\user\UserModel;
use main\app\model\user\EmailVerifyCodeModel;
use main\app\model\user\EmailFindPasswordModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use main\app\classes\UserAuth;

/**
 *
 * @version
 * @link
 */
class TestPassport extends BaseAppTestCase
{
    public static $clean = [];


    public static $logoutUser = [];

    public static $findPassUser = [];

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     *  测试完毕后执行此方法
     */
    public static function tearDownAfterClass()
    {
        BaseDataProvider::deleteUser(self::$logoutUser ['uid']);
        BaseDataProvider::deleteUser(self::$findPassUser ['uid']);
        parent::tearDownAfterClass();
    }

    /**
     * 测试页面
     */
    public function testLoginPage()
    {
        $curl = BaseAppTestCase::$noLoginCurl;
        $curl->get(ROOT_URL . '/passport/login');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="username"/', $resp);
        $this->assertRegExp('/name="password"/', $resp);
    }


    public function testLogoutPage()
    {
        // 构建一个登录的curl
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';
        $info['email'] = $username . '@masterlab.org';
        $info['password'] = UserAuth::createPassword($originPassword);
        self::$logoutUser = BaseDataProvider::createUser($info);
        // 登录成为授权用户
        $loginData = [];
        $loginData['username'] = $username;
        $loginData['password'] = $originPassword;
        $curl = new \Curl\Curl();
        $curl->post(ROOT_URL . 'passport/do_login', $loginData);
        $respData = json_decode(self::$userCurl->rawResponse, true);
        if (!$respData) {
            $this->fail('login failed');
            return;
        }

        $curl->get(ROOT_URL . '/passport/logout');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="user[username]"/', $resp);
        $curl->get(ROOT_URL . '/unit_test/get_session');
        $session = json_decode($curl->rawResponse);
        $this->assertEmpty($session);
    }

    public function testOutputCaptcha()
    {
        $curl = BaseAppTestCase::$noLoginCurl;
        $curl->get('/passport/outputCaptcha');
        parent::checkPageError($curl);
        $curl->get(ROOT_URL . '/unit_test/get_session');
        $session = json_decode($curl->rawResponse);
        $this->assertNotEmpty($session['captcha']);
    }

    public function testFindPasswordPage()
    {
        $curl = BaseAppTestCase::$noLoginCurl;
        $curl->get('/passport/findPassword');
        parent::checkPageError($curl);
        $this->assertEquals(200, $curl->httpStatusCode);
    }

    /**
     * 测试注册登录功能
     * @throws \Exception
     */
    public function testRegisterLogin()
    {
        // 1.注册
        $curl = new \Curl\Curl();
        $curl->get('/passport/findPassword');
        parent::checkPageError($curl);
        $displayName = '190' . mt_rand(12345678, 92345678);
        $email = $displayName . '@masterlab.org';
        $password = '123456';
        $regInfo['email'] = $email;
        $regInfo['password'] = $password;
        $regInfo['display_name'] = $displayName;
        $curl->post(ROOT_URL . 'passport/register', $regInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertEquals('200', $respArr['ret']);
        $userModel = new UserModel();
        $user = $userModel->getByEmail($email);
        $this->assertEquals(UserModel::STATUS_PENDING_APPROVAL, $user['status']);

        // 2.激活用户
        $emailVerifyCodeModel = new EmailVerifyCodeModel();
        $find = $emailVerifyCodeModel->getByEmail($email);
        $this->assertNotEmpty($find);
        $aciveData = ['email' => $email, 'verify_code' => $find['verify_code']];
        $curl->get(ROOT_URL . 'passport/active_email', $aciveData);
        parent::checkPageError($curl);

        // 3.登录
        $loginInfo = [];
        $loginInfo['email'] = $email;
        $loginInfo['password'] = $password;
        $curl->post(ROOT_URL . 'passport/do_login', $loginInfo);
        parent::checkPageError($curl);
        $respArr = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respArr, 'passport login failed');
        $this->assertEquals('200', $respArr['ret']);
        $respData = $respArr['data'];
        $this->assertEquals(UserModel::LOGIN_CODE_OK, $respData['code']);
        $this->assertNotEmpty($respData['user']);
        $this->assertEquals($email, $respData['user']['email']);
        $this->assertEquals($displayName, $respData['user']['display_name']);
        $this->assertArrayNotHasKey('password', $respData['user']);
    }

    public function testFindPasswordByEmail()
    {
        $email = '190' . mt_rand(12345678, 92345678) . '@masterlab.org';
        $originPassword = '123456';
        $info['email'] = $email;
        $info['password'] = UserAuth::createPassword($originPassword);
        self::$findPassUser = BaseDataProvider::createUser($info);

        // 1.发送找回密码
        $curl = new \Curl\Curl();
        $reqData = [];
        $reqData['email'] = $email;
        $curl->get(ROOT_URL . 'passport/sendFindPasswordEmail', $reqData);
        parent::checkPageError($curl);

        // 2.显示重置密码页面
        $model = new EmailFindPasswordModel();
        $find = $model->getByEmail($email);
        $this->assertNotEmpty($find);
        $reqData = [];
        $reqData['email'] = $email;
        $reqData['verify_code'] = $find['verify_code'];
        $curl->get(ROOT_URL . 'passport/sendFindPasswordEmail', $reqData);
        parent::checkPageError($curl);

        $reqData = [];
        $reqData['email'] = $email;
        $reqData['verify_code'] = $find['verify_code'];
        $reqData['password'] = $originPassword;
        $reqData['password_confirmation'] = $originPassword;
        $curl->post(ROOT_URL . 'passport/resetPassword', $reqData);
        parent::checkPageError($curl);
    }

    public function testEmailExist()
    {
        $existEmail = BaseAppTestCase::$user['email'];
        $curl = new \Curl\Curl();
        $reqData = [];
        $reqData['email'] = $existEmail;
        $curl->get(ROOT_URL . 'passport/emailExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('true', $curl->rawResponse);


        $notExistEmail = 'no_exists' . mt_rand(12345678, 92345678) . '@masterlab.org';
        $curl = new \Curl\Curl();
        $reqData = [];
        $reqData['email'] = $notExistEmail;
        $curl->get(ROOT_URL . 'passport/emailExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('false', $curl->rawResponse);
    }

    public function testUsernameExist()
    {
        $existUserName = BaseAppTestCase::$user['username'];
        $curl = new \Curl\Curl();
        $reqData = [];
        $reqData['username'] = $existUserName;
        $curl->get(ROOT_URL . 'passport/usernameExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('true', $curl->rawResponse);


        $notExistUserName = 'no_exists' . mt_rand(12345678, 92345678) ;
        $curl = new \Curl\Curl();
        $reqData = [];
        $reqData['username'] = $notExistUserName;
        $curl->get(ROOT_URL . 'passport/usernameExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('false', $curl->rawResponse);
    }

}
