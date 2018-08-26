<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\model\user\EmailFindPasswordModel;
use main\app\model\user\UserModel;
use main\app\model\SettingModel;
use main\app\model\user\UserTokenModel;
use main\app\model\user\LoginlogModel;
use main\app\model\user\EmailVerifyCodeModel;
use \main\lib\CaptchaBuilder;
use main\app\classes\SettingsLogic;

/**
 * 用户账号相关功能
 */
class Passport extends BaseCtrl
{

    /**
     * 登录状态保持对象
     * @var \main\app\classes\UserAuth;
     */
    protected $auth;

    /**
     * Passport constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = UserAuth::getInstance();
    }

    /**
     * 登录页面
     */
    public function login()
    {
        $data = [];
        $data['title'] = '登录';
        $data['captcha_login_switch'] = (new SettingsLogic())->loginRequireCaptcha();
        $data['captcha_reg_switch'] = (new SettingsLogic())->regRequireCaptcha();
        $this->render('gitlab/passport/login.php', $data);
    }

    /**
     * 输出验证码
     */
    public function outputCaptcha($mode)
    {
        if (in_array($mode, array('login', 'reg'))) {
            $builder = new CaptchaBuilder;
            $builder->build(150, 40);
            if ($mode == 'login') {
                $_SESSION['captcha_login'] = $builder->getPhrase();
            }
            if ($mode == 'reg') {
                $_SESSION['captcha_reg'] = $builder->getPhrase();
            }
            header('Content-type: image/jpeg');
            $builder->output();
            $builder->output();
        }
    }

    /**
     * 注销
     */
    public function logout()
    {
        UserAuth::getInstance()->logout();
        $this->login();
    }

    /**
     * 登录
     * @param string $username
     * @param string $password
     * @param string $ios_token
     * @param string $android_token
     * @param string $version
     * @param string $openid
     * @param string $display_name
     * @param string $headimgurl
     * @param int $source
     * @throws \Exception
     */
    public function doLogin(
        $username = '',
        $password = '',
        $ios_token = '',
        $android_token = '',
        $version = '',
        $openid = '',
        $display_name = '',
        $headimgurl = '',
        $source = 0
    )
    {
        $userModel = UserModel::getInstance('');
        $final = [];
        $final['user'] = new \stdClass();
        $final['msg'] = '';
        $final['code'] = 0;
        // sleep( 5 );
        // 使用对称aes加密解密
        if (isset($_POST["aes_json"]) && isset($_POST["passphrase"])) {
            $passPhrase = getConfigVar('data')['login']['pass_phrase'];
            $password = cryptoJsAesDecrypt($passPhrase, $_POST["aes_json"]);
            //$final['$password'] = $password;
        }
        // $err = [];
        // 检查登录错误次数,一个ip的登录错误次数限制
        $times = 0;
        $settingModel = SettingModel::getInstance();
        $muchErrTimesCaptcha = $settingModel->getSetting('muchErrorTimesCaptcha');
        $ipAddress = getIp();
        $reqVerifyCode = isset($_REQUEST['vcode']) ? $_REQUEST['vcode'] : false;
        $arr = $this->auth->checkIpErrorTimes($reqVerifyCode, $ipAddress, $times, $muchErrTimesCaptcha);
        list($ret, $retCode, $tip) = $arr;
        if (!$ret) {
            $this->ajaxFailed('参数错误', $tip, $retCode);
        }
        // 检车登录账号和密码
        list($ret, $user) = $this->auth->checkLoginByUsername($username, $password);

        if ($ret != UserModel::LOGIN_CODE_OK) {
            $code = intval($ret);
            $tip = '密码错误';
            $arr = $this->auth->checkRequireLoginVCode($ipAddress, $times, $muchErrTimesCaptcha);
            list($ret2, $code2) = $arr;
            if (!$ret2) {
                $code = $code2;
                $tip = '错误太多,需要输入验证码';//$arr['msg'];
            }
            $this->ajaxFailed('参数错误', $tip, $code);
        }
        unset($_SESSION['login_captcha'], $_SESSION['login_captcha_time']);

        // 更新登录次数
        $this->auth->updateIpLoginTime($times, $muchErrTimesCaptcha);

        if ($user['status'] != UserModel::STATUS_NORMAL) {
            $this->ajaxFailed('错误', '该用户已经被禁用');
        }

        if ($openid) {
            $info['weixin_openid'] = $openid;
            if (!$user['avatar']) {
                $info['avatar'] = $headimgurl;
            }
            $info['weixin_openid'] = $openid;
            $userModel->updateUserById($info, $user['uid']);
        }
        if ($ios_token) {
            $info['ios_token'] = $ios_token;
        }
        if ($android_token) {
            $info['android_token'] = $android_token;
        }
        if ($version) {
            $info['version'] = $version;
        }
        if ($display_name) {
            $info['display_name'] = $display_name;
        }
        if ($source) {
            $info['source'] = $source;
        }

        $this->auth->autoLogin($user);

        // 更新登录信息
        $userModel->uid = $user['uid'];
        $this->updateLoginInfo($userModel->uid);
        // 处理登录返回值
        $this->processLoginReturn($final, $user);
        // 记录登录日志,用于只允许单个用户登录
        $loginLogModel = new LoginlogModel();
        $loginLogModel->loginLogInsert($user['uid']);
        $this->auth->kickCurrentUserOtherLogin($user['uid']);
        $this->ajaxSuccess($final['msg'], $final);
    }

    /**
     * 处理登录返回值
     * @param $final
     * @param $user
     */
    private function processLoginReturn(&$final, $user)
    {
        // 生成和刷新token
        $userTokenModel = new UserTokenModel($user['uid']);
        list($ret, $token, $refresh_token) = $userTokenModel->makeToken($user);
        if (!$ret) {
            $this->ajaxFailed('服务器错误', '刷新token失败');
        }

        $final['token'] = $token;
        $final['refresh_token'] = $refresh_token;
        $tokenCfg = getConfigVar('data');
        $final['token_expire'] = intval($tokenCfg['token']['expire_time']);

        if (isset($user['password'])) {
            unset($user['password']);
        }
        // $_SESSION[UserAuth::SESSION_UID_KEY] = $user['uid'];
        $this->auth->login($user);
        $_SESSION['user_info'] = $user;

        $userLogic = new UserLogic();
        $final['user'] = $userLogic->formatUserInfo($user);

        $final['code'] = UserModel::LOGIN_CODE_OK;
        $final['msg'] = '亲,登录成功';
    }

    /**
     * 更新登录信息
     * @param $uid
     */
    private function updateLoginInfo($uid)
    {
        $updateInfo = array();
        if (isset($_REQUEST['ios_token']) && !empty($_REQUEST['ios_token'])) {
            $updateInfo['ios_token'] = str_replace(array(" ", '<', '>'), array('', '', ''), $_REQUEST['ios_token']);
        }

        if (isset($_REQUEST['android_token']) && !empty($_REQUEST['android_token'])) {
            $updateInfo['android_token'] = str_replace(
                array(" ", '<', '>'),
                array('', '', ''),
                $_REQUEST['android_token']
            );
        }
        $updateInfo['last_login_time'] = time();
        if (!empty($updateInfo)) {
            $userModel = UserModel::getInstance($uid);
            $userModel->updateUser($updateInfo);
            unset($updateInfo);
        }
    }

    /**
     * 注销接口
     * @throws \Exception
     */
    public function doLogout()
    {
        //清除会话
        UserAuth::getInstance()->logout();
        $this->ajaxSuccess('ok');
    }


    /**
     * 邮箱注册注册
     * @throws \Exception
     */
    public function register()
    {
        //参数检查
        $settingModel = new SettingModel();

        $err = [];
        // 是否需要图形验证码
        if ($settingModel->getSetting('reg_require_pic_code')) {
            $captchaCode = $_POST['captcha_code'];
            if (empty($captchaCode)) {
                $err['captcha_code'] = '图形验证码为空';
            }
            if (isset($_SESSION['reg_captcha'])
                && $captchaCode !== $_SESSION['reg_captcha']
                && (time() - $_SESSION['reg_captcha_time']) > 300) {
                $this->ajaxFailed('错误', '图形验证码不正确');
                $err['captcha_code'] = '图形验证码不正确';
            }
            if (isset($_SESSION['reg_captcha'])) {
                unset($_SESSION['reg_captcha']);
            }
            if (isset($_SESSION['reg_captcha_time'])) {
                unset($_SESSION['reg_captcha_time']);
            }
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $err['email'] = 'email不能为空';
        }
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $err['password'] = 'password不能为空';
        }
        if (!isset($_POST['display_name']) || empty($_POST['display_name'])) {
            $err['display_name'] = '显示名称不能为空';
        }
        $email = trimStr($_POST['email']);
        $password = trimStr($_POST['password']);
        if (strlen($password) > 20) {
            $err['password'] = '密码长度太长了';
        }
        if (!empty($err)) {
            $this->ajaxFailed('参数错误', $err, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $displayName = trimStr(safeStr($_POST['display_name']));
        $avatar = isset($_POST['avatar']) ? safeStr($_POST['avatar']) : "";

        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (isset($user['uid']) && $user['status'] != UserModel::STATUS_PENDING_APPROVAL) {
            $this->ajaxFailed('提示', 'email已经被使用了!', BaseCtrl::AJAX_FAILED_TYPE_TIP);
        }
        unset($user);

        $userInfo = [];
        $userInfo['password'] = UserAuth::createPassword($password);
        $userInfo['email'] = safeStr($email);
        $userInfo['display_name'] = safeStr($displayName);
        $userInfo['status'] = UserModel::STATUS_PENDING_APPROVAL;
        $userInfo['create_time'] = time();
        $userInfo['avatar'] = $avatar;

        $userModel = new UserModel();
        list($ret, $user) = $userModel->addUser($userInfo);
        if ($ret == UserModel::REG_RETURN_CODE_OK) {
            $this->sendActiveEmail($user['uid'], $email, $displayName);
            $this->ajaxSuccess('注册成功');
        } else {
            $this->ajaxFailed('服务器错误', '注册失败,详情:' . $user);
        }
    }

    /**
     * 发送邮箱待激活的emaiil
     * @param array $user
     * @param string $email
     * @return array
     */
    private function sendActiveEmail($user, $email = '', $username = '')
    {
        $verifyCode = randString(32);
        $emailVerifyCodeModel = new EmailVerifyCodeModel();
        $row = $emailVerifyCodeModel->getByEmail($email);
        if (isset($row['email'])) {
            if (time() - intval($row['time']) < 59) {
                return [false, '请稍后再点击发送验证码'];
            }
        }

        list($flag, $insertId) = $emailVerifyCodeModel->add($user['uid'], $email, $username, $verifyCode);
        if ($flag) {
            $args = [];
            $args['{{site_name}}'] = (new SettingsLogic())->showSysTitle();
            $args['{{name}}'] = $user['display_name'];
            $args['{{email}}'] = $email;
            $args['{{url}}'] = ROOT_URL . 'passport/active_email?email=' . $email . '&verifyCode=' . $verifyCode;
            $mailConfig = getConfigVar('mail');
            $body = str_replace(array_keys($args), array_values($args), $mailConfig['tpl']['active_email']);
            echo $body;
            //@TODO 异步发送
            list($ret, $errMsg) = send_mail($email, '激活用户邮箱通知', $body);
            if (!$ret) {
                return [false, 'send_email_failed:' . $errMsg];
            }
        } else {
            //'很抱歉,服务器繁忙，请重试!!';
            return [false, 'server_error_insert_failed:' . $insertId];
        }
        return [true, 'ok'];
    }


    /**
     * 打开邮箱,激活用户
     */
    public function activeEmail()
    {
        if (isset($_GET['email'])) {
            $this->error('参数错误', 'email_param_error');
            return;
        }
        if (isset($_GET['verify_code'])) {
            $this->error('参数错误', 'verify_code_param_error');
            return;
        }
        $email = trimStr($_GET['email']);
        $verifyCode = trimStr($_GET['verify_code']);

        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (isset($user['email'])) {
            $this->error('错误信息', 'email_exist');
            return;
        }
        unset($user);

        // 校验验证码
        $emailVerifyCodeModel = new EmailVerifyCodeModel();
        $find = $emailVerifyCodeModel->getByEmailVerify($email, $verifyCode);

        if (!isset($find['email']) || $verifyCode != $find['verify_code']) {
            $this->error('错误信息', '亲,激活链接已经失效');
            return;
        }

        if ((time() - (int)$find['time']) > 3600) {
            $this->error('错误信息', '亲,激活链接时间已经失效');
            return;
        }

        //参数检查
        $userInfo = [];
        $userInfo['status'] = UserModel::STATUS_NORMAL;
        $userInfo['email'] = $find['email'];
        $userInfo['username'] = $find['username'];
        $userModel->uid = $find['uid'];
        list($ret, $msg) = $userModel->updateUser($userInfo);
        if ($ret) {
            $emailVerifyCodeModel->deleteByEmail($email);
            $this->info('信息提示', '激活账号成功!');
        } else {
            $this->info('信息提示', '激活账号失败:' . $msg);
        }
    }

    public function findPassword()
    {
        $this->render('gitlab/passport/find_password.php');
    }

    /**
     * 发送找回密码
     * @param string $email
     * @throws \Exception
     */
    public function sendFindPasswordEmail($email = '')
    {
        $userModel = UserModel::getInstance();

        $verifyCode = randString(32);
        $emailFindPwdModel = new EmailFindPasswordModel();

        $row = $emailFindPwdModel->getByEmail($email);
        if (isset($row['email'])) {
            if (time() - intval($row['time']) < 59) {
                $this->ajaxFailed('提示', '操作过于频繁请稍后再发送', BaseCtrl::AJAX_FAILED_TYPE_TIP);
            }
        }
        list($flag, $insertId) = $emailFindPwdModel->add($email, $verifyCode);
        if ($flag) {
            $user = $userModel->getByEmail($email);
            $args = [];
            $args['{{site_name}}'] = (new SettingsLogic())->showSysTitle();
            $args['{{name}}'] = $user['display_name'];
            $args['{{email}}'] = $email;
            $args['{{verifyCode}}'] = $verifyCode;
            $url = ROOT_URL . 'passport/display_reset_password?email=' . $email . '&verifyCode=' . $verifyCode;
            $args['{{url}}'] = $url;
            $mailConfig = getConfigVar('mail');
            $body = str_replace(array_keys($args), array_values($args), $mailConfig['tpl']['reset_password']);
            //echo $body;
            //@TODO 异步发送
            list($ret, $errMsg) = send_mail($email, '找回密码邮箱通知', $body);
            if (!$ret) {
                $this->ajaxFailed('服务器错误', '发送邮件失败,请求:' . $errMsg);
            }
        } else {
            //'很抱歉,服务器繁忙，请重试!!';
            $this->ajaxFailed('服务器错误', '插入失败,详情:' . $insertId);
        }
        $this->ajaxSuccess('ok');
    }


    public function displayResetPassword()
    {
        if (isset($_GET['email'])) {
            $this->error('参数错误', '邮件地址为空');
            return;
        }
        if (isset($_GET['verify_code'])) {
            $this->error('参数错误', '验证码为空');
            return;
        }
        $email = trimStr($_GET['email']);
        $verifyCode = trimStr($_GET['verify_code']);

        // 校验验证码
        $emailFindPwdModel = new EmailFindPasswordModel();
        $find = $emailFindPwdModel->getByEmailVerifyCode($email, $verifyCode);

        if (!isset($find['email']) || $verifyCode != $find['verify_code']) {
            $this->error('错误信息', '亲,激活链接已经失效,请重试');
            return;
        }
        if ((time() - (int)$find['time']) > 36000) {
            $this->error('错误信息', '亲,激活链接时间已经失效');
            return;
        }
        $data = ['email' => $email, 'verify_code' => $verifyCode];
        $this->render('gitlab/passport/reset_password.php', $data);
    }

    /**
     * 处理重置密码
     * @throws \Exception
     */
    public function resetPassword()
    {
        if (isset($_POST['email'])) {
            $this->error('参数错误', '邮件地址为空');
            return;
        }
        if (isset($_POST['verify_code'])) {
            $this->error('参数错误', '验证码为空');
            return;
        }
        if (isset($_POST['password'])) {
            $this->error('参数错误', '密码为空');
            return;
        }
        if (isset($_POST['password_confirmation'])) {
            $this->error('参数错误', '确认密码为空');
            return;
        }
        $email = trimStr($_POST['email']);
        $verifyCode = trimStr($_POST['verify_code']);
        $password = trimStr($_POST['password']);
        $passwordConfirmation = trimStr($_POST['password_confirmation']);

        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (!isset($user['email'])) {
            $this->error('参数错误', '邮件不存在');
            return;
        }
        // 校验验证码
        $emailFindPwdModel = new EmailFindPasswordModel();
        $find = $emailFindPwdModel->getByEmailVerifyCode($email, $verifyCode);

        if (!isset($find['email']) || $verifyCode != $find['verify_code']) {
            $this->error('信息提示', '亲,此链接已经失效');
            return;
        }

        if ((time() - (int)$find['time']) > (3600 * 24)) {
            $this->error('信息提示', '亲,此链接时间已经失效');
            return;
        }
        if ($password != $passwordConfirmation) {
            $this->error('信息提示', '两次密码输入不一致');
            return;
        }

        $userInfo = [];
        $userInfo['password'] = UserAuth::createPassword($password);
        $userModel->uid = $user['uid'];
        list($ret, $msg) = $userModel->updateUser($userInfo);
        if ($ret) {
            $emailFindPwdModel->deleteByEmail($email);
            $this->info('信息提示', '重置密码成功!');
        } else {
            $this->info('信息提示', '很抱歉,重置密码失败,请重试.' . $msg);
        }
    }

    /**
     * 检查邮箱是否
     * @param string $email
     */
    public function emailExist($email)
    {
        if (empty($email)) {
            echo 'true';
            die;
        }
        $userModel = UserModel::getInstance();
        $user = $userModel->getByEmail($email);
        if (!isset($user['uid'])) {
            echo 'false';
            die;
        }
        echo 'true';
        die;
    }

    /**
     * 检查用户名你是否存在
     * @param string $username
     */
    public function usernameExist($username = '')
    {
        if (empty($username)) {
            echo 'true';
            die;
        }
        $userModel = UserModel::getInstance();
        $user = $userModel->getByUsername($username);
        if (!isset($user['uid'])) {
            echo 'false';
            die;
        }
        echo 'true';
        die;
    }
}
