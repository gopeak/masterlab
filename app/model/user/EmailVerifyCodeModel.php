<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *
 * 邮箱验证码模块
 *
 */
class EmailVerifyCodeModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'email_active';

    const   DATA_KEY = 'email_active/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     *  获取邮箱验证码的记录信息
     * @param $email
     * @return array
     */
    public function getByEmail($email)
    {
        //使用缓存机制
        $fields = '*';
        $conditions = ['email' => $email];
        $key = self::DATA_KEY . $email;
        $final = parent::getRowByKey($fields, $conditions, $key);
        return $final;
    }

    /**
     * @param $email
     * @param $verifyCode
     * @return array
     */
    public function getByEmailVerify($email, $verifyCode)
    {
        //使用缓存机制
        $fields = '*';
        $where = ['email' => $email, 'verify_code' => $verifyCode];
        $key = '';//self::DATA_KEY . $email.'/'.$verifyCode;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }

    /**
     * 邮箱激活记录
     * @param array $uid
     * @param $email
     * @param $verifyCode
     * @return bool
     */
    public function add($uid, $email, $username, $verifyCode)
    {
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $table = $this->getTable();
        $params = [];
        $params['email'] = $email;
        $params['uid'] = $uid;
        $params['username'] = $username;
        $params['verify_code'] = $verifyCode;
        $params['time'] = time();

        $sql = "INSERT IGNORE INTO {$table} SET email=:email, uid=:uid, username=:username,verify_code=:verify_code, `time`=:time ";
        $sql .= " ON DUPLICATE KEY UPDATE verify_code=:verify_code";
        $ret = $this->db->exec($sql, $params);
        $insertId = $this->db->getLastInsId();
        return [$ret, $insertId];
    }

    /**
     * 删除邮箱验证码记录
     */
    public function deleteByEmail($email)
    {
        $key = self::DATA_KEY . $email;
        $where = ['email' => $email];
        $flag = parent::deleteBykey($where, $key);
        return $flag;
    }
}
