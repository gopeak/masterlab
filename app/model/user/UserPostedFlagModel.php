<?php

namespace main\app\model\user;


/**
 *
 */
class UserPostedFlagModel extends BaseUserItemModel
{
    public $prefix = 'user_';

    public $table = 'posted_flag';

    const   DATA_KEY = 'user_posted_flag/';

    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);

        $this->uid = $userId;
    }

    /**
     * @param $userId
     * @param $date
     * @param $ip
     * @return array
     */
    public function getByDateIp($userId, $date, $ip)
    {
        return $this->getRow('*', ['user_id' => $userId, '_date' => $date, 'ip'=>$ip]);
    }

    /**
     * @param $userId
     * @param $date
     * @param $ip
     * @return array
     * @throws \Exception
     */
    public function insertDateIp($userId, $date, $ip)
    {
        $info = [];
        $info['user_id'] = $userId;
        $info['_date'] = $date;
        $info['ip'] = $ip;
        return $this->insertItem($userId, $info);
    }

    /**
     * @param $userId
     * @param $date
     * @return int
     */
    public function deleteSettingByDate($userId, $date)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['_date'] = $date;
        return $this->delete($conditions);
    }
}
