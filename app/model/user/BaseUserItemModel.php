<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *  与用户 1:1 关系的模型基类
 */
class BaseUserItemModel extends CacheModel
{
    public $prefix = '';

    public $table = '';

    public $fields = '*';

    public $userId = '';

    const   DATA_KEY = '';

    /**
     * BaseUserItemModel constructor.
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
     * @param $userId
     * @return array
     */
    public function getItemByUid($userId)
    {
        return $this->getRow('*', ['user_id' => $userId]);
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
    public function replaceItem($userId, $info)
    {
        $info['user_id'] = $userId;
        return $this->replace($info);
    }

    /**
     * @param $userId
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemByUid($userId, $info)
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
