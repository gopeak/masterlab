<?php

namespace main\app\model\user;

use main\app\classes\UserAuth;
use main\app\model\DbModel;


/**
 *
 * User model
 * @author Sven
 */
class UserModel extends DbModel
{
    public $prefix = 'user_';

    public $table = 'main';

    public $fields = ' * ';

    public $primaryKey = 'uid';


    const  DATA_KEY = 'user/';

    const  REG_RETURN_CODE_OK = 1;
    const  REG_RETURN_CODE_EXIST = 2;
    const  REG_RETURN_CODE_ERROR = 3;

    /**
     * 登录成功
     */
    const  LOGIN_CODE_OK = 1;

    /**
     * 已经登录过了
     */
    const  LOGIN_CODE_EXIST = 2;

    /**
     * 登录失败
     */
    const  LOGIN_CODE_ERROR = 3;

    /**
     * 登录需要验证码
     */
    const  LOGIN_REQUIRE_VERIFY_CODE = 4;

    /**
     * 验证码错误
     */
    const  LOGIN_VERIFY_CODE_ERROR = 5;

    /**
     * 错误次数太多
     */
    const  LOGIN_TOO_MUCH_ERROR = 5;

    const  STATUS_PENDING_APPROVAL = 0;
    const  STATUS_NORMAL = 1;
    const  STATUS_DISABLED = 2;
    public static $status = [
        self::STATUS_PENDING_APPROVAL => '审核中',
        self::STATUS_NORMAL => '正常',
        self::STATUS_DISABLED => '禁用'
    ];

    public $uid = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;


    /**
     * 创建单例对象
     * @param string $uid
     * @param bool $persistent
     * @return mixed
     * @throws \Exception
     */
    public static function getInstance($uid = '', $persistent = false)
    {
        $index = $uid . strval(intval($persistent));
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($uid, $persistent);
        }
        return self::$instance[$index];
    }

    /**
     * UserModel constructor.
     * @param string $uid
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($persistent);
        $this->uid = $uid;
    }

    /**
     * 获取正常状态的用户数
     * @return int
     */
    public function getNormalCount()
    {
        return (int)$this->getCount(['status' => self::STATUS_NORMAL]);
    }

    public function getAll($primaryKey = true)
    {
        $table = $this->getTable();
        $fields = " uid as k,{$table}.*";
        return $this->getRows($fields, [], null, 'uid', 'desc', null, $primaryKey);
    }

    /**
     * 取得一个用户的基本信息
     * @return array
     */
    public function getUser()
    {
        $fields = '*';
        $conditions = array('uid' => $this->uid);
        $finally = $this->getRow($fields, $conditions);
        return $finally;
    }

    /**
     * @param $uid
     * @return array
     */
    public function getByUid($uid)
    {
        $fields = '*';
        $where = array('uid' => $uid);
        $finally = $this->getRow($fields, $where);
        return $finally;
    }

    public function getByOpenid($openid)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['openid' => trim($openid)];
        $user = $this->getRow($fields, $where);
        return $user;
    }

    public function getByPhone($phone)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['phone' => trim($phone)];
        $user = $this->getRow($fields, $where);
        return $user;
    }

    public function getByEmail($email)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['email' => trim($email)];
        $user = $this->getRow($fields, $where);
        return $user;
    }

    public function getUsersByIds($uids)
    {
        if (empty($uids)) {
            return [];
        }
        $uids = implode(',', $uids);
        $sql = "select * from " . $this->getTable() . " where uid in({$uids})";
        $rows = $this->db->getRows($sql);
        return $rows;
    }

    public function getFieldByIds($field, $userIds)
    {
        if (empty($userIds)) {
            return [];
        }

        $params['user_ids'] = $userIds = implode(',', $userIds);
        $sql = "select uid as k,{$field}  from " . $this->getTable() . " where uid in({$userIds})";
        $rows = $this->db->getRows($sql, $params);

        $ret = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $ret[] = $row[$field];
            }
        }
        return $ret;
    }

    public function getByUsername($username)
    {
        $fields = "*,{$this->primaryKey} as k";
        $where = ['username' => trim($username)];
        $user = $this->getRow($fields, $where);
        return $user;
    }


    /**
     * 添加用户
     * @param array $userInfo 提交的用户信息
     * @return array
     */
    public function addUser($userInfo)
    {
        if (empty($userInfo)) {
            return array(self::REG_RETURN_CODE_ERROR, []);
        }
        if (!isset($userInfo['openid'])) {
            $userInfo['openid'] = UserAuth::createOpenid($userInfo['email'].time());
        }
        list($flag, $insertId) = $this->insert($userInfo);
        if ($flag) {
            $this->uid = $insertId;
            $user = $this->getUser(true);
            return array(self::REG_RETURN_CODE_OK, $user);
        } else {
            return array(self::REG_RETURN_CODE_ERROR, $insertId);
        }
    }

    /**
     * 更新用户的信息
     * @param $updateInfo
     * @param $uid
     * @return array
     * @throws \Exception
     */
    public function updateUserById($updateInfo, $uid)
    {
        if (empty($updateInfo)) {
            return [false, __CLASS__ . __METHOD__ . '参数$update_info不能为空'];
        }
        if (!is_array($updateInfo)) {
            return [false, __CLASS__ . __METHOD__ . '参数$update_info必须是数组'];
        }
        if (!$uid) {
            return [false, __CLASS__ . __METHOD__ . '参数$uid不能为空'];
        }
        // $key = self::DATA_KEY . 'uid/' . $uid;
        $where = ['uid' => $uid];
        $ret = $this->update($updateInfo, $where);
        return $ret;
    }

    /**
     * 更新一个用户的信息
     * @param $updateInfo
     * @return array
     * @throws \Exception
     */
    public function updateUser($updateInfo)
    {
        if (empty($updateInfo)) {
            return [false, 'update info is empty'];
        }
        if (!is_array($updateInfo)) {
            return [false, 'update info is not array'];
        }
        $uid = $this->uid;
        // $key = self::DATA_KEY . 'uid/' . $uid;
        $where = ['uid' => $uid];//"  where `uid`='$uid'";
        $ret = $this->update($updateInfo, $where);
        return $ret;
    }
}
