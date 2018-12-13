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
     * @param $uid
     * @return array
     */
    public function getItemsByUid($uid)
    {
        return $this->getRows('*', ['user_id' => $uid]);
    }

    /**
     * @param $uid
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function insertItem($uid, $info)
    {
        $info['user_id'] = $uid;
        return $this->insert($info);
    }

    /**
     * @param $uid
     * @param $info
     * @return array
     * @throws \Exception
     */
    public function updateItemByUidAndKey($uid, $info)
    {
        $conditions['user_id'] = $uid;
        return $this->update($info, $conditions);
    }

    /**
     * @param $uid
     * @return int
     */
    public function deleteByUid($uid)
    {
        $conditions = [];
        $conditions['user_id'] = $uid;
        return $this->delete($conditions);
    }

}