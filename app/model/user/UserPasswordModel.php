<?php

namespace main\app\model\user;

use main\app\model\DbModel;

/**
 *
 * 用户密码model
 * @author Sven
 */
class UserPasswordModel extends DbModel
{
    public $prefix = 'user_';

    public $table = 'password';

    public $fields = ' * ';

    public $primaryKey = 'uid';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function getByUid($uid)
    {
        $row = $this->getRowById($uid);
        return $row;
    }

    public function valid($uid, $password)
    {
        $row = $this->getByUid($uid);
        if (!isset($row['hash'])) {
            return false;
        }
        return password_verify($password, $row['hash']);
    }

    /**
     * 用户新增密码
     * @param array $uid
     * @param $passwordHash
     * @return array
     */
    public function insert($uid, $passwordHash)
    {
        $row = [];
        $row['uid'] = $uid;
        $row['hash'] = $passwordHash;
        return parent::insert($row);
    }
}
