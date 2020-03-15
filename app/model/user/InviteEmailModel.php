<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

class InviteEmailModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'invite';

    public $primaryKey = 'id';

    const   DATA_KEY = 'user_invite/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    /**
     *  获取邮箱验证码的记录信息,通过Phone
     * @param $email
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

    public function deleteByToken($token)
    {
        $key = self::DATA_KEY . $token;
        $condition = ['email' => $token];
        $flag = parent::deleteBykey($condition, $key);
        return $flag;
    }
}
