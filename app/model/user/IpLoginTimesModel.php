<?php

namespace main\app\model\user;

use main\app\model\DbModel;

/**
 * @todo进行sql参数化绑定
 *
 * @author Sven
 */
class IpLoginTimesModel extends DbModel
{
    public $prefix = 'user_';
    public $table = 'ip_login_times';
    public $fields = ' * ';
    public $primaryKey = 'id';

    /**
     * 用于实现单例模式
     * @var self
     */
    protected static $instance;

    /**
     * 创建一个自身的单例对象
     * @param array $dbConfig
     * @param bool $persistent
     * @throws \PDOException
     * @return self
     */
    public static function getInstance($persistent = false)
    {
        $index = intval($persistent);
        if (!isset(self::$instance[$index]) || !is_object(self::$instance[$index])) {
            self::$instance[$index] = new self($persistent);
        }
        return self::$instance[$index];
    }

    public function __construct($persistent = false)
    {
        parent::__construct($persistent);
    }

    /**
     *  获取ip的尝试登录次数
     * @param $ip
     * @return array 一条查询数据
     */
    public function getIpLoginTimes($ip)
    {
        return $this->getRow('*', ['ip' => $ip]);
    }

    /**
     * 插入ip的登录次数
     * @param $ip
     * @param $times
     * @return array
     * @throws \Exception
     */
    public function insertIp($ip, $times)
    {
        $info = [];
        $info['ip'] = $ip;
        $info['times'] = $times;
        $info['up_time'] = time();
        $ret = $this->insert($info);
        return $ret;
    }

    /**
     * 初始化插入ip的登录次数
     * @param $ip
     * @return array
     * @throws \Exception
     */
    public function resetInsertIp($ip)
    {
        $updateInfo['times'] = 0;
        $updateInfo['up_time'] = time();
        $ret = $this->update($updateInfo, ['ip' => $ip]);
        return $ret;
    }

    /**
     * 更新ip的尝试登录次数
     * @param $ip
     * @param $times
     * @return array
     *  * @throws \Exception
     */
    public function updateIpTime($ip, $times)
    {
        $updateInfo = [];
        $updateInfo['times'] = $times;
        $updateInfo['up_time'] = time();
        $ret = $this->update($updateInfo, ['ip' => $ip]);
        return $ret;
    }

    /**
     * @param $ip
     * @return int
     */
    public function deleteByIp($ip)
    {
        $conditions['ip'] = $ip;
        $ret = $this->delete($conditions);
        return $ret;
    }
}
