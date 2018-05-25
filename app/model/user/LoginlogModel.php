<?php

namespace main\app\model\user;

use main\app\model\DbModel;

/**
 *
 * @author Sven
 */
class LoginlogModel extends DbModel
{
    public $prefix = 'user_';
    public $table  = 'login_log';
    public $fields = ' * ';
    public $primaryKey = 'id';

    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    public function getLoginLog($uid)
    {
        $conditions['uid'] = $uid;
        return $this->getRows('id,session_id', $conditions, null, 'id', 'desc');
    }

    /**
     * 记录登录日志,用于只允许单个用户登录
     * @param $userId
     * @return array
     */
    public function loginLogInsert($userId)
    {
        $info = [];
        $info['session_id'] = session_id();
        $info['uid'] = $userId;
        $info['time'] = time();
        $info['ip'] = getIp();
        return parent::insert($info);
    }

    public function deleteByUid($userId)
    {
        $conditions['uid'] = $userId;
        return $this->delete($conditions);
    }
}
