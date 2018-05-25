<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl;

use main\app\classes\UserAuth;
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
class Passport extends BaseUserCtrl
{
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
    public function outputCaptcha()
    {
        $builder = new CaptchaBuilder;
        $builder->build(300, 80);
        $_SESSION['captcha'] = $builder->getPhrase();
        header('Content-type: image/jpeg');
        $builder->output();
    }

    public function logout()
    {
        UserAuth::getInstance()->logout();

        $data = [];
        $data['title'] = 'Sign in';
        $this->render('gitlab/passport/login.php', $data);
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
            $password = cryptoJsAesDecrypt('gohome@#fine', $_POST["aes_json"]);
            //$final['$password'] = $password;
        }

        // 检查登录错误次数,一个ip的登录错误次数限制
        $times = 0;
        $settingModel = SettingModel::getInstance();
        $login_much_error_times_captcha = $settingModel->getSetting('login_much_error_times_captcha');
        $tip = $this->auth->checkIpErrorTimes($times, $login_much_error_times_captcha);
        if (!empty($tip)) {
            $this->ajaxFailed($tip['msg'], [], $tip['code']);
        }
        // 检车登录账号和密码
        list($ret, $user) = $this->auth->checkLoginByUsername($username, $password);

        if ($ret != UserModel::LOGIN_CODE_OK) {
            $code = intval($ret);
            $tip = 'password_error';
            $arr = $this->auth->checkRequireLoginVcode($times, $login_much_error_times_captcha);
            if (!empty($arr)) {
                $code = $arr['code'];
                $tip = 'password_too_much_error_require_captcha';//$arr['msg'];
            }
            $this->ajaxFailed($tip, [], $code);
        }
        unset($_SESSION['login_captcha'], $_SESSION['login_captcha_time']);

        // 更新登录次数
        $this->auth->updateIpLoginTime($times, $login_much_error_times_captcha);

        if ($user['status'] != UserModel::STATUS_NORMAL) {
            $this->ajaxFailed('user_baned');
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
        $loginLogModel->kickCurrentUserOtherLogin($user['uid']);
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
            $this->ajaxFailed('refresh_token');
        }

        $final['token'] = $token;
        $final['refresh_token'] = $refresh_token;
        $token_cfg = getConfigVar('data');
        $final['token_expire'] = intval($token_cfg['token']['expire_time']);

        if (isset($user['password'])) {
            unset($user['password']);
        }
        // $_SESSION[UserAuth::SESSION_UID_KEY] = $user['uid'];
        $this->auth->login($user);
        $_SESSION['user_info'] = $user;
        $userCtrl = new User();
        $userCtrl->uid = $user['uid'];
        $final['user'] = $userCtrl->get();

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
     */
    public function doLogout()
    {
        //清除会话
        UserAuth::getInstance()->logout();
        $this->ajaxSuccess('ok');
    }


    public function register($email = '', $username = '', $password = '', $display_name = '', $avatar = '')
    {
        //参数检查
        $settingModel = new SettingModel();
        // 是否需要图形验证码
        if ($settingModel->getSetting('reg_require_pic_code')) {
            $captcha_code = $_POST['captcha_code'];
            if (empty($captcha_code)) {
                $this->ajaxFailed('图形验证码为空!');
                return;
            }
            if (isset($_SESSION['reg_captcha'])
                && $captcha_code !== $_SESSION['reg_captcha']
                && (time() - $_SESSION['reg_captcha_time']) > 300) {
                $this->ajaxFailed('图形验证码错误!');
                return;
            }
            if (isset($_SESSION['reg_captcha'])) {
                unset($_SESSION['reg_captcha']);
            }
            if (isset($_SESSION['reg_captcha_time'])) {
                unset($_SESSION['reg_captcha_time']);
            }
        }

        $userModel = UserModel::getInstance('');

        $email = trimStr($email);
        if (empty($email)) {
            $this->ajaxFailed('email不能为空');
        }

        $user = $userModel->getByEmail($email);
        if (isset($user['uid']) && $user['status'] != UserModel::STATUS_PENDING_APPROVAL) {
            $this->ajaxFailed('email已经被使用了!');
        }
        unset($user);

        $user = $userModel->getByUsername($username);
        if (isset($user['uid'])) {
            $this->ajaxFailed('用户名已经被使用了!');
        }
        unset($user);

        if (strlen($password) > 20) {
            $this->ajaxFailed('密码长度太长了!');
        }

        $userInfo = [];
        $userInfo['password'] = UserAuth::createPassword($password);
        $userInfo['display_name'] = $display_name;
        $userInfo['status'] = UserModel::STATUS_PENDING_APPROVAL;
        $userInfo['create_time'] = time();
        $userInfo['avatar'] = !empty($avatar) ? $avatar : "";

        $userModel = new  UserModel();
        $ret = $userModel->addUser($userInfo);
        if ($ret[1]['uid']) {
            $this->sendActiveEmail($ret[1]['uid'], $email, $username);
            $this->ajaxSuccess('注册成功');
        } else {
            $this->ajaxFailed('注册失败');
        }
    }

    /**
     * 发送邮箱待激活的emaiil
     * @param $uid
     * @param string $email
     * @return array
     */
    private function sendActiveEmail($uid, $email = '', $username = '')
    {
        $userModel = UserModel::getInstance();

        $verify_code = randString(32);
        $emailVerifyCodeModel = new EmailVerifyCodeModel();

        $row = $emailVerifyCodeModel->getByEmail($email);
        if (isset($row['email'])) {
            if (time() - intval($row['time']) < 59) {
                $this->ajaxFailed('请稍后再点击发送验证码');
            }
        }

        $flag = $emailVerifyCodeModel->insertVerifyCode($uid, $email, $username, $verify_code);
        if ($flag) {
            $user = $userModel->getByUid($uid);
            $args = [];
            $args['{{site_name}}'] = (new SettingsLogic())->showSysTitle();
            $args['{{name}}'] = $user['display_name'];
            $args['{{email}}'] = $email;
            $args['{{url}}'] = ROOT_URL . 'passport/active_email?email=' . $email . '&verify_code=' . $verify_code;
            $mail_config = getConfigVar('mail');
            $body = str_replace(array_keys($args), array_values($args), $mail_config['tpl']['active_email']);
            echo $body;
            //@TODO 异步发送
            list($ret, $err_msg) = send_mail($email, '激活用户邮箱通知', $body);
            if (!$ret) {
                return [false, 'send_email_failed:' . $err_msg];
            }
        } else {
            //'很抱歉,服务器繁忙，请重试!!';
            return [false, 'server_error_insert_failed'];
        }
        return [true, 'ok'];
    }

    public function findPassword()
    {
        $this->render('gitlab/passport/find_password.php');
    }

    /**
     * 发送找回密码
     * @param string $email
     * @return array
     */
    public function sendFindPasswordEmail($email = '')
    {
        $userModel = UserModel::getInstance();

        $verify_code = randString(32);
        $emailFindPasswordModel = new EmailFindPasswordModel();

        $row = $emailFindPasswordModel->getByEmail($email);
        if (isset($row['email'])) {
            if (time() - intval($row['time']) < 59) {
                //$this->ajax_failed( '请稍后再发送');
            }
        }
        $flag = $emailFindPasswordModel->insertVerifyCode($email, $verify_code);
        if ($flag) {
            $user = $userModel->getByEmail($email);
            $args = [];
            $args['{{site_name}}'] = (new SettingsLogic())->showSysTitle();
            $args['{{name}}'] = $user['display_name'];
            $args['{{email}}'] = $email;
            $args['{{verify_code}}'] = $verify_code;
            $url = ROOT_URL . 'passport/display_reset_password?email=' . $email . '&verify_code=' . $verify_code;
            $args['{{url}}'] = $url;
            $mail_config = getConfigVar('mail');
            $body = str_replace(array_keys($args), array_values($args), $mail_config['tpl']['reset_password']);
            //echo $body;
            //@TODO 异步发送
            list($ret, $err_msg) = send_mail($email, '找回密码邮箱通知', $body);
            if (!$ret) {
                $this->ajaxFailed('send_email_failed:' . $err_msg);
            }
        } else {
            //'很抱歉,服务器繁忙，请重试!!';
            $this->ajaxFailed('server_error_insert_failed:');
        }
        $this->ajaxSuccess('send_find_password_email_success');
    }


    /**
     * 绑定email
     * @param $email
     * @param $verify_code
     */
    public function activeEmail($email, $verify_code)
    {

        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (isset($user['email'])) {
            $this->error('错误信息', 'email_exist');
            die;
        }
        unset($user);

        // 校验验证码
        $emailVerifyCodeModel = new EmailVerifyCodeModel();
        $find = $emailVerifyCodeModel->getByEmailVerify($email, $verify_code);

        if (!isset($find['email']) || $verify_code != $find['verify_code']) {
            $this->error('错误信息', '亲,激活链接已经失效');
            die;
        }

        if ((time() - (int)$find['time']) > 3600) {
            $this->error('错误信息', '亲,激活链接时间已经失效');
            die;
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

    public function displayResetPassword($email, $verify_code)
    {
        // 校验验证码
        $emailFindPasswordModel = new EmailFindPasswordModel();
        $find = $emailFindPasswordModel->getByEmailVerifyCode($email, $verify_code);

        if (!isset($find['email']) || $verify_code != $find['verify_code']) {
            $this->error('错误信息', '亲,激活链接已经失效,请重试');
            die;
        }

        if ((time() - (int)$find['time']) > 36000) {
            $this->error('错误信息', '亲,激活链接时间已经失效');
            die;
        }


        $data = ['email' => $email, 'verify_code' => $verify_code];

        $this->render('gitlab/passport/reset_password.php', $data);
    }

    public function resetPassword($email, $verify_code, $password, $password_confirmation)
    {
        $userModel = UserModel::getInstance('');
        $user = $userModel->getByEmail($email);
        if (!isset($user['email'])) {
            $this->error('错误信息', 'email_not_exist');
            die;
        }
        // 校验验证码
        $emailFindPasswordModel = new EmailFindPasswordModel();
        $find = $emailFindPasswordModel->getByEmailVerifyCode($email, $verify_code);

        if (!isset($find['email']) || $verify_code != $find['verify_code']) {
            $this->error('错误信息', '亲,此链接已经失效');
            die;
        }

        if ((time() - (int)$find['time']) > (3600 * 24)) {
            $this->error('错误信息', '亲,此链接时间已经失效');
            die;
        }
        if ($password != $password_confirmation) {
            $this->error('错误信息', '两次密码输入不一致');
            die;
        }

        $userInfo = [];
        $userInfo['password'] = UserAuth::createPassword($password);
        $userModel->uid = $user['uid'];
        list($ret, $msg)  = $userModel->updateUser($userInfo);
        if ($ret) {
            $emailFindPasswordModel->deleteByEmail($email);
            $this->info('信息提示', '重置密码成功!');
        } else {
            $this->info('信息提示', '很抱歉,重置密码失败,请重试.'.$msg);
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
