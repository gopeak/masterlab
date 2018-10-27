<?php

namespace main\app\model\unit_test;

use main\app\model\DbModel;

/**
 *  框架用户表模型
 *
 */
class FrameworkUserModel extends DbModel
{
    public $prefix = 'hornet_';

    public $table = 'user';

    public $fields = ' * ';

    public $primaryKey = 'id';


    const  DATA_KEY = 'user/';


    public $uid = '';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index]  = new self($persistent);
        }
        return self::$instance[$index] ;
    }

    /**
     * 通过名称获取用户信息
     * @param $name
     * @return array
     */
    public function getByName($name)
    {
        $where = ['name' => trim($name)];
        $row = $this->getRow("*", $where);
        return $row;
    }


    /**
     * 获取所有数据
     * @param bool $primaryKey 是否把主键作为索引
     * @return array
     * @throws \Exception
     */
    public function getAll($primaryKey = true)
    {
        $table = $this->getTable();
        return $this->getRows(" id as k,{$table}.*", array(), null, 'id', 'desc', null, $primaryKey);
    }


    /**
     * 取得一个用户的基本信息
     * @return array
     */
    public function get()
    {
        $uid = $this->uid;
        $fileds = '*';
        $where = array('id' => $uid);
        $finally = $this->getRow($fileds, $where);
        return $finally;
    }

    /**
     * @param $uid
     * @return array
     */
    public function getUserByUid($master_uid)
    {
        $fileds = '*';
        $where = array('id' => $master_uid);
        $finally = $this->getRow($fileds, $where);
        return $finally;
    }


    /**
     * 添加用户
     * @param $userinfo   提交的用户信息
     * @return bool
     */
    public function addUser($userinfo)
    {
        if (empty($userinfo)) {
            return array(false, array());
        }
        $flag = $this->insert($userinfo);

        if ($flag) {
            $uid = $this->lastInsertId();
            $this->uid = $uid;
            $user = $this->get(true);
            return array(true, $user);
        } else {
            return array(false, []);
        }
    }

    /**
     * 根据用户名获取用户
     * @param $username
     * @return  一条查询数据
     */
    public function getByUsername($username)
    {
        $fields = '*';
        $conditions = ['username' => $username];

        return parent::getRow($fields, $conditions);
    }

    /**
     * 根据手机号获取用户
     * @param $mobile
     * @return 一条查询数据
     */
    public function getByPhone($phone)
    {
        $fields = '*';
        $conditions = ['phone' => $phone];
        return parent::getRow($fields, $conditions);
    }
}
