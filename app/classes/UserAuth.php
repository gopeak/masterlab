<?php

namespace main\app\classes;

use main\app\model\user\UserModel;
use main\app\model\user\IpLoginTimesModel;

/**
 * 用户业务逻辑
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
     *
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     *
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

        $this->user = isset($_SESSION[self::SESSION_USER_INFO_KEY]) ? $_SESSION[self::SESSION_USER_INFO_KEY] : '';;
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
    public function getId()
    {
        return isset($_SESSION[self::SESSION_UID_KEY]) ? $_SESSION[self::SESSION_UID_KEY] : false;
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
    public static function createPassword($origin_password)
    {
        return password_hash($origin_password, PASSWORD_DEFAULT);
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
     * 用户登录操作
     *
     * @param array $user 用户信息
     * @param number $duration 登录会话有效期
     * @param string $absolute 有效期是否是绝对的，
     * 如果是false，用户如果在有效期内有活动，有效期会重新计算。
     * 如果设置为true，那么不管是否活动，到期后都会退出登录。
     */
    public function login($user, $duration = 0, $absolute = true)
    {
        $_SESSION[self::SESSION_UID_KEY] = $user['uid'];
        $_SESSION[self::SESSION_USER_INFO_KEY] = $user;
        $_SESSION[self::SESSION_EXPIRE_KEY] = $duration;
        $_SESSION[self::SESSION_ABS_KEY] = $absolute;
        $timeout = $duration ? time() + $duration : 0;
        $_SESSION[SELF::SESSION_TIMEOUT_KEY] = $timeout;
        $this->renewSessionCookie($timeout);
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
            $set_token = UserAuth::createToken($user['password']);
            setcookie(UserAuth::SESSION_UID_KEY, $user['uid'], time() + 3600 * 7 * 24, '/', getCookieHost());
            setcookie(UserAuth::SESSION_TOKEN_KEY, $set_token, time() + 3600 * 7 * 24, '/', getCookieHost());
        } else {
            setcookie(UserAuth::SESSION_UID_KEY, '', time() + 3600 * 4, '/', getCookieHost());
            setcookie(UserAuth::SESSION_TOKEN_KEY, '', time() + 3600 * 4, '/', getCookieHost());
        }
    }

    /**
     * 获取权限列表
     * @param $role_id 角色id
     * @return array
     */
    public function getUserPermissionList($role_id)
    {
        if (!$role_id) {
            return [];
        }

        $roleModel = new RoleModel();
        $role = $roleModel->getRow($roleModel->table, '*', ['role_id' => $role_id]);
        $rights = $role['role_rights'];
        if (empty($rights)) {
            return [];
        }

        $permModel = new PermissionModel();
        $permits = $permModel->getRows($permModel->getTable(), '*', ["pms_id IN ($rights)"]);
        $rights = [];
        foreach ($permits as $permit) {
            $rights[] = $permit['pms_key'];
        }

        $_SESSION['_user_acl'] = $rights;
    }

    /**
     * 检查当前用户是否有有个权限
     * @param string $pms_key 权限键名
     * @return bool
     */
    public function checkPermission($pms_key)
    {
        $isMaster = $this->getIsMaster();
        if (!$isMaster == -1) {
            $permits = isset($_SESSION['_user_acl']) ? $_SESSION['_user_acl'] : [];
            return in_array($pms_key, $permits);
        } else {
            return true;
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
        setcookie(self::SESSION_UID_KEY, '', time() + 3600 * 4, '/', getCookieHost());
        setcookie(self::SESSION_TOKEN_KEY, '', time() + 3600 * 4, '/', getCookieHost());
    }

    /**
     * 检查登录错误次数,一个ip的登录错误次数限制
     * @param $times
     * @param $login_much_error_times_vcode
     * @return array
     */
    public function checkIpErrorTimes(&$times, $login_much_error_times_vcode)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        //v($login_much_error_times_vcode);
        $final = [];
        if ($login_much_error_times_vcode > 0) {
            $ip_row = $ipLoginTimesModel->getIpLoginTimes(getIp());
            if (isset($ip_row['times'])) {
                $up_time = (int)$ip_row['up_time'];
                if (time() - $up_time < 600) {
                    $times = (int)$ip_row['times'];
                }
            }
            //v($times);
            // 如果密码输入4次错误，则要求输入验证码
            if ($times > 3) {
                if (!isset($_REQUEST['vcode'])) {
                    $final['msg'] = '请输入验证码';
                    $final['code'] = UserModel::LOGIN_REQUIRE_VERIFY_CODE;
                    return $final;
                }
                $vcode = strtolower($_REQUEST['vcode']);
                $srv_vode = isset($_SESSION['login_captcha']) ? strtolower($_SESSION['login_captcha']) : '';
                if ($vcode == $srv_vode && (time() - $_SESSION['login_captcha_time']) < 300) {
                } else {
                    $final['code'] = UserModel::LOGIN_VERIFY_CODE_ERROR;
                    $final['msg'] = '验证码错误!';
                    return $final;
                }
            }
        }
        return $final;
    }

    /**
     * 检查登录是否需要验证码
     * @param $times
     * @param $login_much_error_times_vcode
     * @return array
     */
    public function checkRequireLoginVcode(&$times, $login_much_error_times_vcode)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        $final = [];
        if ($login_much_error_times_vcode > 0) {
            // 判断登录次数
            if (isset($ip_row['times'])) {
                $times++;
            } else {
                $times = 1;
                $ipLoginTimesModel->insertIp(getIp(), $times);
            }

            // 如果密码输入4次错误，则要求输入验证码
            if ($times > 3) {
                $final['code'] = UserModel::LOGIN_REQUIRE_VERIFY_CODE;
                $final['msg'] = '密码输入多次错误,需要显示验证码';
                $_SESSION['need_code'] = true;
            }
            $ipLoginTimesModel->updateIpTime(getIp(), $times);
        }
        return $final;
    }

    /**
     * 更新登录次数
     * @param $times
     * @param $login_much_error_times_vcode
     */
    public function updateIpLoginTime(&$times, $login_much_error_times_vcode)
    {
        $ipLoginTimesModel = IpLoginTimesModel::getInstance();
        if ($login_much_error_times_vcode > 0) {
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
        return isset($_SESSION[SELF::SESSION_TIMEOUT_KEY]) ? $_SESSION[SELF::SESSION_TIMEOUT_KEY] : 0;
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
            $_SESSION[SELF::SESSION_TIMEOUT_KEY] = time() + $expires;
            $this->renewSessionCookie($expires);
        }
    }

    /**
     * 设置session
     * @param int $lifetime
     */
    protected function renewSessionCookie($lifetime = 0)
    {
        $params = session_get_cookie_params();
        $params['lifetime'] = $lifetime;
        if (session_status() == PHP_SESSION_ACTIVE) {
            $sessionId = session_id();
            $sessionName = session_name();
            setcookie(
                $sessionName,
                $sessionId,
                $params['lifetime'],
                $params['path'],
                $params['domain'],
                $params['secure']
            );
        } else {
            session_set_cookie_params(
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
            return array(UserModel::LOGIN_CODE_EXIST, $user);
        }

        if (!password_verify($password, $user['password'])) {
            return array(UserModel::LOGIN_CODE_ERROR, $user);
        }

        return array(UserModel::LOGIN_CODE_OK, $user);
    }
}
