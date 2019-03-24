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

use main\app\classes\PermissionGlobal;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectUserRoleModel;
use \main\app\model\user\UserModel;
use \main\app\model\user\UserGroupModel;
use \main\app\classes\UserAuth;
use \main\app\classes\ProjectLogic;
use Katzgrau\KLogger\Logger;

/**
 * 进行单元测试的应用基类,提供一些公共的便捷的资源和数据
 * Class BaseAppTestCase
 * @package main\app\test
 */
class BaseAppTestCase extends BaseTestCase
{

    public static $logger = null;

    /**
     * 用户curl资源
     * @var \Curl\Curl
     */
    public static $userCurl = null;

    /**
     * 非登录curl资源
     * @var \Curl\Curl
     */
    public static $noLoginCurl = null;

    /**
     * 超级管理员curl资源
     * @var \Curl\Curl
     */
    public static $adminCurl = null;

    public static $userPassword = '123456';

    public static $user = [];

    public static $org = [];

    public static $project = [];

    public static $scheme = [];

    public static $typeScheme = [];

    public static $userProjectRoles = [];

    public static $userGroup = [];

    /**
     * @var \main\app\model\user\UserModel
     */
    public static $userModel = null;

    /**
     * 初始化自动化测试的数据和资源
     * @throws \Exception
     */
    public static function setUpBeforeClass()
    {
        self::$noLoginCurl = new \Curl\Curl();

        self::$userCurl = new \Curl\Curl();
        self::$userCurl->setCookieFile('./data/cookie/user.txt');
        self::$userCurl->setHeader('MLTEST-CSRFTOKEN', ENCRYPT_KEY);

        self::$userModel = UserModel::getInstance();

        self::$logger = new Logger(TEST_LOG);
        self::$user = self::initLoginUser();
        self::initAppData();
    }

    public static function initAppData()
    {
        // 创建组织
        self::$org = BaseDataProvider::createOrg();

        // 创建一个项目,并指定权限方案为默认
        $info['permission_scheme_id'] = 0;
        $info['org_id'] = self::$org['id'];
        self::$project = BaseDataProvider::createProject($info);

        // 初始化项目角色与用户绑定
        list($flag, $roleInfo) = ProjectLogic::initRole(self::$project['id']);
        if ($flag) {
            foreach ($roleInfo as $role) {
                $model = new ProjectUserRoleModel();
                $model->insertRole(self::$user['uid'], self::$project['id'], $role['id']);
            }
        }
    }

    /**
     * 初始化一个独立的登录用户
     * @throws \Exception
     */
    public static function initLoginUser()
    {
        $username = '190' . mt_rand(12345678, 92345678);
        $originPassword = '123456';

        $info['username'] = $username;
        $info['password'] = UserAuth::createPassword($originPassword);
        $user = BaseDataProvider::createUser($info);
        // 加入管理组
        $model = new UserGroupModel();
        $model->add($user['uid'], 1);

        // 登录成为授权用户
        $loginData = [];
        $loginData['username'] = $username;
        $loginData['password'] = $originPassword;

        self::$userCurl->post(ROOT_URL . 'passport/do_login?data_type=json', $loginData);
        $respData = json_decode(self::$userCurl->rawResponse, true);
        // var_dump(self::$userCurl->requestHeaders);
        if (!$respData) {
            var_dump(__CLASS__ . '/' . __FUNCTION__ . '  failed,' . self::$userCurl->rawResponse);
            return [];
        }
        return $user;
    }

    /**
     * @param \Curl\Curl $curl
     */
    public static function checkPageError($curl)
    {
        list($ret, $error) = self::validPageError($curl);
        if (!$ret) {
            var_dump($error);
            $file = TEST_LOG . '/request_error_' . date('Y-m-d') . '.log';
            file_put_contents($file, $curl->rawResponse, FILE_APPEND);
            parent::fail('Response have error');
        }
    }

    /**
     * 判断http请求是否正常
     * @param \Curl\Curl $curl
     * @return array
     */
    public static function validPageError($curl)
    {
        $rawResponse = $curl->rawResponse;
        $statusCode = $curl->httpStatusCode;
        if ((int)$statusCode != 200) {
            return [false, 'httpStatusCode!=200'];
        }
        if (isset($curl->responseHeaders['Content-Type']) &&
            preg_match('/^(?:application|text)\/(?:[a-z]+(?:[\.-][0-9a-z]+){0,}[\+\.]|x-)?json(?:-[a-z]+)?/i', $curl->responseHeaders['Content-Type'])) {
            $tmp = json_decode($rawResponse);
            if (empty($tmp)) {
                return [false, 'json parse error'];
            }
        }

        if (!empty($msg = checkXdebugError($rawResponse))) {
            return [false, $msg];
        }
        /*
                if (!empty($msg = checkXdebugTriggerError($rawResponse))) {
                    return [false, $msg];
                }

                if (!empty($msg = checkTriggerError($rawResponse))) {
                    return [false, $msg];
                }
                if (!empty($msg = checkXdebugFatalError($rawResponse))) {
                    return [false, $msg];
                }

                if (!empty($msg = checkXdebugUnDefine($rawResponse))) {
                    return [false, $msg];
                }
                */
        if (!empty($msg = checkUserError($rawResponse))) {
            return [false, $msg];
        }

        if (!empty($msg = checkUnDefine($rawResponse))) {
            return [false, $msg];
        }
        if (!empty($msg = checkExceptionError($rawResponse))) {
            return [false, $msg];
        }

        return [true, []];
    }

    /**
     * 删除用户
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public static function deleteUser($id)
    {
        $conditions['uid'] = $id;
        $model = new UserModel();
        return $model->delete($conditions);
    }

    /**
     * @throws \Exception
     */
    public static function tearDownAfterClass()
    {
        if (!empty(self::$user['uid'])) {
            self::deleteUser(self::$user['uid']);
            $model = new ProjectUserRoleModel();
            $model->deleteByUid(self::$user['uid']);

            $model = new UserGroupModel();
            $model->deleteByUid(self::$user['uid']);
        }
        if (!empty(self::$project['id'])) {
            $model = new ProjectModel();
            $model->deleteById(self::$project['id']);
        }
        if (!empty(self::$org['id'])) {
            $model = new OrgModel();
            $model->deleteById(self::$org['id']);
        }

    }
}
