<?php

namespace main\app\classes;

use main\app\model\user\UserModel;
use main\app\model\user\IpLoginTimesModel;
use main\app\model\user\LoginlogModel;

/**
 * 用户登录相关的业务逻辑
 *
 */
class UserAuth
{

    /**
     * 未登录跳转页面
     * @var string
     */
    public $loginUrl = '/login';

    /**
     * 当前用户数据
     * @var []
     */
    protected $user = [];

    /**
     * 一账通用户会话uid下标
     * @var string
     */
    const SESSION_UID_KEY = 'hornet_uid';


    /**
     * 用户会话信息
     * @var string
     */
    const SESSION_USER_INFO_KEY = 'user_info';


    /**
     * 一账通用户会话token下标
     * @var string
     */
    const SESSION_TOKEN_KEY = 'user_token';

    /**
     * session过期时间下标
     */
    const SESSION_EXPIRE_KEY = '_expires';

    /**
     * session绝对值下标
     */
    const SESSION_ABS_KEY = '_absolute';

    /**
     * session过期时间下标
     */
    const SESSION_TIMEOUT_KEY = '_timeout';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @throws \PDOException
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance) || !is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * 返回用户信息
     * @param bool $refresh
     * @return array|string
     */
    public function getUser($refresh = false)
    {
        if ($this->isGuest()) {
            return [];
        }

        if ($this->user && !$refresh) {
            return $this->user;
        }

        $this->user = isset($_SESSION[self::SESSION_USER_INFO_KEY]) ? $_SESSION[self::SESSION_USER_INFO_KEY] : '';
        return $this->user;
    }

    /**
     * 检查登录状态
     */
    public function checkLogin()
    {
        if ($this->isGuest()) {
            ob_end_clean();
            header('Location:' . $this->loginUrl);
            exit;
        }
        return;
    }

    /**
     * 当前用户是否是游客
     * @return boolean
     */
    public function isGuest()
    {
        $userId = $this->getId();
        if (!$userId) {
            return true;
        }
        return false;
    }

    /**
     * 返回用户id
     */
    public static function getId()
    {
        return isset($_SESSION[self::SESSION_UID_KEY]) ? $_SESSION[self::SESSION_UID_KEY] : 0;
    }

    /**
     * 返回一个随机手机号码
     * @return string
     */
    public static function createRandPhone()
    {
        return '170' . mt_rand(12345678, 92345678);
    }


    /**
     * 生成加密后的密码
     * @return string
     */
    public static function createPassword($originPassword)
    {
        return password_hash($originPassword, PASSWORD_DEFAULT);
    }

    /**
     * 生成加密后的密码
     * @return string
     */
    public static function createToken($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 生成加密后的密码
     * @return string
     */
    public static function createOpenid($source)
    {
        return md5($source);
    }

    /**
     * 用户登录操作
     *
     * @param array $user 用户信息
     * @param int $duration 登录会话有效期
     * @param bool $absolute 有效期是否是绝对的, 如果是false，用户如果在有效期内有活动，有效期会重新计算。如果设置为true，那么不管是否活动，到期后都会退出登录。
     * @return bool
     */
    public function login($user, $duration = 0, $absolute = true)
    {
        $_SESSION[self::SESSION_UID_KEY] = $user['uid'];
        $_SESSION[self::SESSION_USER_INFO_KEY] = $user;
        $_SESSION[self::SESSION_EXPIRE_KEY] = $duration;
        $_SESSION[self::SESSION_ABS_KEY] = $absolute;
        $timeout = $duration ? time() + $duration : 0;
        $_SESSION[self::SESSION_TIMEOUT_KEY] = $timeout;
        $this->setSessionCookie($timeout);
        return true;
    }

    /**
     * 字段登录操作
     * @param $user
     */
    public function autoLogin($user)
    {
        // 自动登录处理
        if (isset($_POST['auto_login']) && $_POST['auto_login'] == "true") {
            $setToken = UserAuth::createToken($user['password']);
            setcookie(UserAuth::SESSION_UID_KEY, $user['uid'], time() + 3600 * 7 * 24, '/', getCookieHost());
            setcookie(UserAuth::SESSION_TOKEN_KEY, $setToken, time() + 3600 * 7 * 24, '/', getCookieHost());
        } else {
            setcookie(UserAuth::SESSION_UID_KEY, '', time() + 3600 * 4, '/', getCookieHost());
            setcookie(UserAuth::SESSION_TOKEN_KEY, '', time() + 3600 * 4, '/', getCookieHost());
        }
    }

    /**
     * 注销操作
     * @return  void
     */
    public function logout()
    {
        // 获取跟登录用户相关的会话然后清除会话
        $curRefClass = new \ReflectionClass(__CLASS__);
        $consts = $curRefClass->getConstants();
        foreach ($consts as $v) {
            if (isset($_SESSION[$v])) {
                unset($_SESSION[$v]);
            }
        }
        @setcookie(self::SESSION_UID_KEY, '', time() + 3600 * 4, '/', getCookieHost());
        @setcookie(self::SESSION_TOKEN_KEY, '', time() + 3600 * 4, '/', getCookieHost());
    }

    /**
     * 检查登录错误次数,一个ip的登录错误次数限制
     * @param string $reqVerifyCode
     * @param string $ipAddress
     * @param int $times
     * @param int $muchErrorTimesVCode
     * @return array
     * @throws \PDOException
     */
    public function checkIpErrorTimes($reqVerifyCode, $ipAddress, &$times, $muchErrorTimesVCode = 3)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $muchErrorTimesVCode = (int)$muchErrorTimesVCode;
        if ($muchErrorTimesVCode > 0) {
            $ipRow = $ipLoginTimesModel->getIpLoginTimes($ipAddress);
            if (isset($ipRow['times'])) {
                $upTime = (int)$ipRow['up_time'];
                if ((time() - $upTime) < 600) {
                    $times = (int)$ipRow['times'];
                }
            }

            // 如果密码输入4次错误，则要求输入验证码
            if ((int)$times > $muchErrorTimesVCode) {
                if (!$reqVerifyCode) {
                    return [false, UserModel::LOGIN_REQUIRE_VERIFY_CODE, '请输入验证码!'];
                }
                $verifyCode = strtolower($reqVerifyCode);
                $sessionCaptchaCode = isset($_SESSION['login_captcha']) ? strtolower($_SESSION['login_captcha']) : '';
                if ($verifyCode == $sessionCaptchaCode && (time() - $_SESSION['login_captcha_time']) < 300) {
                    // nothing to do
                } else {
                    return [false, UserModel::LOGIN_VERIFY_CODE_ERROR, '验证码错误!'];
                }
            }
        }
        return [true, 0, ''];
    }

    /**
     * 检查登录是否需要验证码
     * @param $times
     * @param $muchErrorTimesVCode
     * @return array
     * @throws \Exception
     */
    public function checkRequireLoginVCode($ipAddress, &$times, $muchErrorTimesVCode)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $ret = true;
        $code = 0;
        $msg = '';
        if ($muchErrorTimesVCode > 0) {
            $ipRow = $ipLoginTimesModel->getIpLoginTimes($ipAddress);
            // 判断登录次数
            if (isset($ipRow['times'])) {
                $times++;
            } else {
                $times = 1;
                $ipLoginTimesModel->insertIp($ipAddress, $times);
            }
            // 如果密码输入4次错误，则要求输入验证码
            if ($times > 3) {
                $_SESSION['need_code'] = true;
                $ret = true;
                $code = UserModel::LOGIN_REQUIRE_VERIFY_CODE;
                $msg = '密码输入多次错误,需要显示验证码';
            } else {
                unset($_SESSION['need_code']);
            }
            $ipLoginTimesModel->updateIpTime($ipAddress, $times);
        }
        return [$ret, $code, $msg];
    }

    /**
     * 更新登录次数
     * @param $times
     * @param $muchErrorTimesVcode
     * @throws \PDOException
     */
    public function updateIpLoginTime(&$times, $muchErrorTimesVcode)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        if ($muchErrorTimesVcode > 0) {
            $ipLoginTimesModel->updateIpTime(getIp(), $times);
        }
    }

    /**
     * 返回有效时间
     * @return int
     */
    protected function expires()
    {
        return isset($_SESSION[self::SESSION_EXPIRE_KEY]) ? $_SESSION[self::SESSION_EXPIRE_KEY] : 0;
    }

    /**
     * 返回超时时间
     * @return int
     */
    protected function timeout()
    {
        return isset($_SESSION[self::SESSION_TIMEOUT_KEY]) ? $_SESSION[self::SESSION_TIMEOUT_KEY] : 0;
    }

    /**
     * 返回区间值
     * @return bool
     */
    protected function isAbsolute()
    {
        return isset($_SESSION[self::SESSION_ABS_KEY]) ? $_SESSION[self::SESSION_ABS_KEY] : false;
    }

    /**
     * 刷新session
     */
    protected function update()
    {
        if (($expires = $this->expires()) <= 0) {
            return;
        }
        if (($timeout = $this->timeout()) && $timeout <= time()) {
            $this->logout();
        } elseif (!$this->isAbsolute()) {
            $_SESSION[self::SESSION_TIMEOUT_KEY] = time() + $expires;
            $this->setSessionCookie($expires);
        }
    }

    /**
     * 设置session
     * @param int $lifetime
     */
    protected function setSessionCookie($lifetime = 0)
    {
        $params = @session_get_cookie_params();
        $params['lifetime'] = $lifetime;
        if (session_status() == PHP_SESSION_ACTIVE) {
            $sessionId = session_id();
            $sessionName = session_name();
            @setcookie(
                $sessionName,
                $sessionId,
                $params['lifetime'],
                $params['path'],
                $params['domain'],
                $params['secure']
            );
        } else {
            @session_set_cookie_params(
                $params['lifetime'],
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
    }

    public function checkLoginByUsername($account, $password)
    {
        $userModel = UserModel::getInstance('');
        $user = $userModel->getByUsername($account);
        if (!$user) {
            $user = $userModel->getByPhone($account);
        }
        if (!$user) {
            $user = $userModel->getByEmail($account);
        }
        if (!isset($user['password'])) {
            return array(UserModel::LOGIN_CODE_ERROR, $user);
        }

        if (!password_verify($password, $user['password'])) {
            return array(UserModel::LOGIN_CODE_ERROR, $user);
        }

        return array(UserModel::LOGIN_CODE_OK, $user);
    }

    /**
     * 只允许用户在一个地方登录,踢掉当前用户的其他登录状态，直接删除session文件
     * @param $uid
     * @throws \Exception
     */
    public function kickCurrentUserOtherLogin($uid)
    {
        $userModel = UserModel::getInstance($uid);
        $loginlogModel = new LoginlogModel();
        $logs = $loginlogModel->getLoginLog($uid);
        if (!empty($logs)) {
            $deleteLogs = [];
            $lastId = 0;
            $lastSessionId = '';
            foreach ($logs as $k => $log) {
                $lastId = $log['id'];
                $lastSessionId = $log['session_id'];
                unset($k);
                break;
            }
            if (!empty($logs)) {
                foreach ($logs as $k => $log) {
                    if ($lastSessionId != $log['session_id']) {
                        $deleteLogs[] = $log['session_id'];
                    }
                }
                $newLogs = array_unique($deleteLogs);
                // v($new_logs);
                if (ini_get('session.save_handler') == 'files') {
                    $sessionSavePath = ini_get('session.save_path');
                    $deleteRet = false;
                    foreach ($newLogs as $file) {
                        if (@unlink($sessionSavePath . '/sess_' . $file)) {
                            $deleteRet = true;
                        }
                    }
                    if ($deleteRet) {
                        $sql = "delete from {$loginlogModel->getTable()} where id !=$lastId AND uid=$uid limit 100 ";
                        //echo $sql;
                        $userModel->db->query($sql);
                    }
                }
                // @todo session为redis情况
            }
        }
    }
}
