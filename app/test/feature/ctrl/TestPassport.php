<?php

namespace main\app\test\featrue;

use main\app\model\user\UserModel;
use main\app\model\user\EmailVerifyCodeModel;
use main\app\model\user\EmailFindPasswordModel;
use main\app\test\BaseAppTestCase;
use main\app\test\BaseDataProvider;
use main\app\classes\UserAuth;
use \Curl\Curl;

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

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     *  测试完毕后执行此方法
     */
    public static function tearDownAfterClass()
    {
        if (isset(self::$logoutUser ['uid'])) {
            BaseDataProvider::deleteUser(self::$logoutUser ['uid']);
        }
        if (isset(self::$findPassUser ['uid'])) {
            BaseDataProvider::deleteUser(self::$findPassUser ['uid']);
        }

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
        $this->assertRegExp('/<title>.+<\/title>/is', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="username"/', $resp);
        $this->assertRegExp('/name="password"/', $resp);
    }


    /**
     * 测试注销页面
     * @throws \Exception
     */
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
        $curl = new Curl();
        $curl->post(ROOT_URL . 'passport/do_login?data_type=json', $loginData);
        $respData = json_decode(self::$userCurl->rawResponse, true);
        if (!$respData) {
            $this->fail('login failed');
            return;
        }

        $curl->get(ROOT_URL . '/passport/logout');
        $resp = $curl->rawResponse;
        parent::checkPageError($curl);
        $this->assertRegExp('/<title>.+<\/title>/is', $resp, 'expect <title> tag, but not match');
        $this->assertRegExp('/name="username"/is', $resp);
        $curl->get(ROOT_URL . 'unit_test/get_session');
        $respJson = json_decode($curl->rawResponse, true);
        $this->assertEmpty($respJson['data']);
    }

    /**
     * 测试验证码
     */
    public function testOutputCaptcha()
    {
        $curl = new Curl(ROOT_URL);
        $curl->setCookieFile(TEST_LOG . '/testOutputCaptcha.txt');
        $curl->get(ROOT_URL . '/passport/outputCaptcha');
        $respHeader = $curl->getInfo();
        $this->assertEquals('image/jpeg', $respHeader['content_type']);
        $curl->get(ROOT_URL . '/unit_test/get_session?data_type=json&mode=login');
        $respJson = json_decode($curl->rawResponse, true);
        $this->assertNotEmpty($respJson['data']['captcha_login']);
    }

    /**
     * 测试找回密码页面
     */
    public function testFindPasswordPage()
    {
        $curl = BaseAppTestCase::$noLoginCurl;
        $curl->get(ROOT_URL . '/passport/findPassword');
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
        $curl = new Curl();
        $curl->get(ROOT_URL . '/passport/login');

        parent::checkPageError($curl);
        $displayName = '190' . mt_rand(12345678, 92345678);
        $email = $displayName . '@masterlab.org';
        $password = '123456';
        $regInfo['email'] = $email;
        $regInfo['email_confirmation'] = $email;
        $regInfo['username'] = $displayName;
        $regInfo['password'] = $password;
        $regInfo['display_name'] = $displayName;
        $curl->post(ROOT_URL . 'passport/register?data_type=json', $regInfo);
        // echo $curl->rawResponse;
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
        $activeData = ['email' => $email, 'verify_code' => $find['verify_code']];
        $curl->get(ROOT_URL . 'passport/active_email', $activeData);
        parent::checkPageError($curl);

        // 3.登录
        $loginInfo = [];
        $loginInfo['username'] = $email;
        $loginInfo['password'] = $password;
        $curl->post(ROOT_URL . 'passport/do_login?data_type=json', $loginInfo);
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

    /**
     * @throws \Exception
     */
    public function testFindPasswordByEmail()
    {
        $email = '190' . mt_rand(12345678, 92345678) . '@masterlab.org';
        $originPassword = '123456';
        $info['username'] = $email;
        $info['email'] = $email;
        $info['password'] = UserAuth::createPassword($originPassword);
        self::$findPassUser = BaseDataProvider::createUser($info);
        // 1.发送找回密码
        $curl = new Curl();
        $reqData = [];
        $reqData['email'] = $email;
        $reqData['data_type'] = 'json';
        $curl->get(ROOT_URL . 'passport/sendFindPasswordEmail', $reqData);
        //echo $curl->rawResponse;
        parent::checkPageError($curl);

        // 2.显示重置密码页面
        $model = new EmailFindPasswordModel();
        $find = $model->getByEmail($email);
        $this->assertNotEmpty($find);
        $reqData = [];
        $reqData['email'] = $email;
        $reqData['verify_code'] = $find['verify_code'];
        $curl->get(ROOT_URL . 'passport/displayResetPassword', $reqData);
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
        $curl = new Curl();
        $reqData = [];
        $reqData['email'] = $existEmail;
        $reqData['data_type'] = 'text';
        $curl->get(ROOT_URL . 'passport/emailExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('true', $curl->rawResponse);


        $notExistEmail = 'no_exists' . mt_rand(12345678, 92345678) . '@masterlab.org';
        $curl = new Curl();
        $reqData = [];
        $reqData['email'] = $notExistEmail;
        $reqData['data_type'] = 'text';
        $curl->get(ROOT_URL . 'passport/emailExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('false', $curl->rawResponse);
    }

    public function testUsernameExist()
    {
        $existUserName = BaseAppTestCase::$user['username'];
        $curl = new Curl();
        $reqData = [];
        $reqData['username'] = $existUserName;
        $reqData['data_type'] = 'text';
        $curl->get(ROOT_URL . 'passport/usernameExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('true', $curl->rawResponse);


        $notExistUserName = 'no_exists' . mt_rand(12345678, 92345678);
        $curl = new Curl();
        $reqData = [];
        $reqData['username'] = $notExistUserName;
        $reqData['data_type'] = 'text';
        $curl->get(ROOT_URL . 'passport/usernameExist', $reqData);
        parent::checkPageError($curl);
        $this->assertEquals('false', $curl->rawResponse);
    }
}
