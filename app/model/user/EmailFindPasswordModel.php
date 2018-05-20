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
     * @param $verify_code
     * @return array
     */
    public function getByEmailVerifyCode($email, $verify_code)
    {
        //使用缓存机制
        $fields = '*';
        $where = ['email' => $email, 'verify_code' => $verify_code];
        $key = self::DATA_KEY . $email;
        $table = $this->getTable();
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }


    /**
     * 插入一条邮箱验证码记录
     * @param $email
     * @param $verify_code
     * @return bool
     * @throws \Exception
     */
    public function insertVerifyCode($email, $verify_code)
    {
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $table = $this->getTable();
        $time = time();
        $email = $this->db->pdo->quote($email);
        $verify_code = $this->db->pdo->quote($verify_code);
        $sql = "INSERT IGNORE INTO {$table} SET email={$email},   verify_code={$verify_code}, time='$time' ";
        $sql .= " ON DUPLICATE KEY UPDATE verify_code=$verify_code,time='$time'; ";
        $ret = $this->exec($sql);
        return $ret;
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
        $table = $this->getTable();
        $condition = ['email' => $email];
        $flag = parent::deleteBykey($table, $condition, $key);
        return $flag;
    }
}
