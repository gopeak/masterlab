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

    public function __construct($persistentt = false)
    {
        parent::__construct($persistentt);
    }

    /**
     * 创建一个自身的单例对象
     * @param bool $persistentt
     * @return self
     */
    public static function getInstance($persistentt = false)
    {
        $index = intval($persistentt);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistentt);
        }
        return self::$instance[$index];
    }


    public function getByUid($uid, $fields = '*')
    {
        $row = $this->getRowById($uid, $fields);
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
     * 添加日志,需要传入一个对象，取出其public属性作为数据
     * @param  array $password_hash
     * @return  array [$ret,$msg]
     */
    public function insert($password_hash)
    {
        $row = [];
        $row['hash'] = $password_hash;
        return parent::insert($row);
    }
}
