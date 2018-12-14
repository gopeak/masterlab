<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *  与用户 1:M 关系的模型基类
 */
class BaseUserItemsModel extends CacheModel
{
    public $prefix = '';

    public $table = '';

    public $fields = '*';

    public $uid = '';

    const   DATA_KEY = '';

    /**
     * BaseUserItemsModel constructor.
     * @param string $userId
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);
        $this->uid = $userId;
    }

    /**
     * @param $uid
     * @return array
     */
    public function getItemsByUid($userId)
    {
        return $this->getRows('*', ['user_id' => $userId]);
    }

    /**
     * @param $userId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($userId, $info)
    {
        $info['user_id'] = $userId;
        return $this->insert($info);
    }

    /**
     * @param $userId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemByUidAndKey($userId, $info)
    {
        $conditions['user_id'] = $userId;
        return $this->update($info, $conditions);
    }

    /**
     * @param $userId
     * @return int
     */
    public function deleteByUid($userId)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        return $this->delete($conditions);
    }

}