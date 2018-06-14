<?php
/**
 *
 * B2B系统测试基类，基类主要确保各项资源配置正确。维持一个稳定干净的测试环境。
 *
 * @version    php v7.1.1
 * @see        PHPUnit_Framework_TestCase
 * @link
 */

namespace main\app\test;

use \main\app\model\project\ProjectModel;
use \main\app\model\user\UserModel;
use \main\app\classes\UserLogic;
use \main\app\classes\UserAuth;
use Katzgrau\KLogger\Logger;

class BaseAppTestCase extends BaseTestCase
{

    public static $logger = null;

    /**
     *  跟平台交互curl资源
     * @var \Curl\Curl
     */
    public static $app_curl = null;

    /**
     * 用户curl资源
     * @var \Curl\Curl
     */
    public static $user_curl = null;


    /**
     * 用户数据
     * @var array
     */
    public static $user = [];


    /**
     * @var \main\app\model\user\UserModel
     */
    public static $userModel = null;


    public static function setUpBeforeClass()
    {

        self::$app_curl = new \Curl\Curl();
        self::$app_curl->setCookieFile('./data/cookie/app.txt');

        self::$user_curl = new \Curl\Curl();
        self::$user_curl->setCookieFile('./data/cookie/user.txt');

        self::$userModel = UserModel::getInstance();

        self::$logger = new Logger(TEST_LOG);

        self::$user = self::initLoginUser();
    }


    /**
     * 初始化一个独立的登录用户
     */
    public static function initLoginUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';

        $info['username'] = $username;
        $info['password'] = UserAuth::createPassword($originPassword);
        $user = BaseDataProvider::createUser($info);

        // 登录成为授权用户
        $loginData = [];
        $loginData['username'] = $username;
        $loginData['password'] = $originPassword;

        self::$user_curl->post(ROOT_URL . 'passport/do_login', $loginData);
        $respData = json_decode(self::$user_curl->rawResponse, true);
        if (!$respData) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . self::$user_curl->rawResponse);
            return [];
        }
        return $user;
    }

    public static function checkPageError($rawResponse)
    {
        $ret = true;
        $msg = '';
    }

    /**
     * 删除用户
     * @param int $id
     * @return bool
     */
    public static function deleteUser($id)
    {
        $conditions['uid'] = $id;
        $model = new UserModel();
        return $model->delete($conditions);
    }


    public static function tearDownAfterClass()
    {
        self::deleteUser(self::$user['uid']);
    }
}
