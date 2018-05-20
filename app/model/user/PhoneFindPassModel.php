<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *
 * 找回密码存放表
 *
 * @author
 *
 */
class PhoneFindPassModel extends CacheModel
{
    /**
     * 表前缀
     * @var string
     */
    public $prefix = 'user_';

    /*
     * 数据库表名
     */
    public $table = 'phone_find_password';

    const   DATA_KEY = 'user_phone_find_password/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     *  获取找回密码的记录信息
     * @param $phone
     * @return array
     */
    public function getByPhone($phone)
    {
        //使用缓存机制
        $fields = '*,id as k';
        $where = " Where `phone`='$phone'  limit 1 ";
        $key = self::DATA_KEY . $phone;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }


    /**
     *
     * 插入一条找回密码记录
     * @param bool
     */
    public function insert($insertInfo)
    {

        $key = self::DATA_KEY . $insertInfo['phone'];
        $re = parent::insertByKey($this->getTable(), $insertInfo, $key);
        return $re;
    }


    /**
     * 删除找回密码记录
     * Enter description here ...
     */
    public function deleteByPhone($phone)
    {
        $key = self::DATA_KEY . $phone;
        $table = $this->getTable();
        $where = " Where phone = '$phone'";
        $flag = parent::deleteBykey($table, $where, $key);
        return $flag;
    }
}




