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
        $where = ['phone'=>$phone];
        $key = self::DATA_KEY . $phone;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }


    /**
     * 新增数据
     * @param array $insertInfo
     * @return array|mixed
     * @throws \Exception
     */
    public function insertPhone($insertInfo)
    {
        $key = self::DATA_KEY . $insertInfo['phone'];
        $ret = parent::insertByKey($insertInfo, $key);
        return $ret;
    }


    /**
     * 删除找回密码记录
     * Enter description here ...
     */
    public function deleteByPhone($phone)
    {
        $key = self::DATA_KEY . $phone;
        $where = " Where phone = '$phone'";
        $flag = parent::deleteBykey($where, $key);
        return $flag;
    }
}
