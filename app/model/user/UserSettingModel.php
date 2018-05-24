<?php

namespace main\app\model\user;

use main\app\model\user\BaseUserItemsModel;

/**
 *
 */
class UserSettingModel extends BaseUserItemsModel
{
    public $prefix = 'user_';

    public $table = 'setting';

    const   DATA_KEY = 'user_setting/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);

        $this->uid = $uid;
    }

    public function getSettingByKey($uid, $key)
    {
        return $this->getOne('_value', ['uid' => $uid, '_key' => $key]);
    }

    public function getSetting($uid)
    {
        return parent::getItemsByUid($uid);
    }

    public function insertSetting($uid, $key, $value)
    {
        $info = [];
        $info['uid'] = $uid;
        $info['_key'] = $key;
        $info['_value'] = $value;
        return $this->insertItem($uid, $info);
    }

    public function updateSetting($uid, $key, $value)
    {
        $info = [];
        $info['_value'] = $value;
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['_key'] = $key;
        return $this->update($info, $conditions);
    }

    public function deleteSettingById($id)
    {
        return $this->deleteById($id);
    }

    public function deleteSettingByKey($uid, $key)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['_key'] = $key;
        return $this->delete($conditions);
    }
}
