<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

class EmailFindPasswordModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'email_find_password';

    public $primaryKey = 'email';

    const   DATA_KEY = 'email_find_password/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     *  获取邮箱验证码的记录信息,通过Phone
     * @param user_
     * @return array
     */
    public function getByEmail($email)
    {
        //使用缓存机制
        $fields = '*';
        $where = ['email' => $email];
        $key = self::DATA_KEY . $email;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }

    /**
     * @param $email
     * @param $verifyCode
     * @return array
     */
    public function getByEmailVerifyCode($email, $verifyCode)
    {
        //使用缓存机制
        $fields = '*';
        $where = ['email' => $email, 'verify_code' => $verifyCode];
        $key = self::DATA_KEY . $email;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }

    /**
     * 插入一条邮箱验证码记录
     * @param $email
     * @param $verifyCode
     * @return array
     * @throws \Exception
     */
    public function add($email, $verifyCode)
    {
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $table = $this->getTable();
        $params = [];
        $params['email'] = $email;
        $params['verify_code'] = $verifyCode;
        $params['time'] = time();

        $sql = "INSERT IGNORE INTO {$table} SET email=:email,verify_code=:verify_code, `time`=:time ";
        $sql .= " ON DUPLICATE KEY UPDATE verify_code=:verify_code";
        $ret = $this->db->exec($sql, $params);
        $insertId = $this->db->getLastInsId();
        return [$ret, $insertId];
    }


    /**
     * 删除邮箱验证码记录
     * @param $email
     * @return int
     * @throws \Exception
     */
    public function deleteByEmail($email)
    {
        $key = self::DATA_KEY . $email;
        $condition = ['email' => $email];
        $flag = parent::deleteBykey($condition, $key);
        return $flag;
    }
}
