<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 * 邀请email模型
 * Class InviteEmailModel
 * @package main\app\model\user
 */
class InviteEmailModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'invite';

    public $primaryKey = 'id';

    const   DATA_KEY = 'user_invite/';

    /**
     * InviteEmailModel constructor.
     * @param string $uid
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }


    /**
     * 通过token获取数据
     * @param $token
     * @return array
     * @throws \Exception
     */
    public function getByToken($token)
    {
        //使用缓存机制
        $fields = '*';
        $where = ['token' => $token];
        $key = self::DATA_KEY . $token;
        $final = parent::getRowByKey($fields, $where, $key);
        return $final;
    }


    /**
     * 插入一条邮箱验证码记录
     * @param $email
     * @param $token
     * @return array
     * @throws \Exception
     */
    public function add($email, $token, $projectId, $projectRoles)
    {
        //执行SQL语句，返回影响行数，如果有错误，则会被捕获并跳转到出错页面
        $table = $this->getTable();
        $params = [];
        $params['email'] = $email;
        $params['token'] = $token;
        $params['expire_time'] = time()+30*86400;
        $params['project_id'] = $projectId;
        if(is_array($projectRoles)){
            $params['project_roles'] = implode(',',$projectRoles);
        }else{
            $params['project_roles'] = strval($projectRoles);
        }
        $rets = $this->replace($params);
        // 更新缓存
        $this->cache->delete(self::DATA_KEY . $email);
        return $rets;
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

    /**
     * 通过token删除记录
     * @param $token
     * @return int
     * @throws \Exception
     */
    public function deleteByToken($token)
    {
        $key = self::DATA_KEY . $token;
        $condition = ['token' => $token];
        $flag = parent::deleteBykey($condition, $key);
        return $flag;
    }
}
