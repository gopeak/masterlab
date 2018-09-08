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

    public $uid = '';

    const   DATA_KEY = '';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);
        $this->uid = $uid;
    }

    public function getItemByUid($uid)
    {
        return $this->getRow('*', ['uid' => $uid]);
    }

    public function insertItem($uid, $info)
    {
        $info['uid'] = $uid;
        return $this->insert($info);
    }

    public function updateItemByUid($uid, $info)
    {
        $conditions['uid'] = $uid;
        return $this->update($info, $conditions);
    }

    public function deleteByUid($uid)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        return $this->delete($conditions);
    }

}
