<?php

namespace main\app\model\user;

use main\app\model\user\BaseUserItemsModel;

/**
 * 用户设置模型
 */
class UserSettingModel extends BaseUserItemsModel
{
    public $prefix = 'user_';

    public $table = 'setting';

    const   DATA_KEY = 'user_setting/';

    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);

        $this->uid = $userId;
    }

    public function getSettingByKey($userId, $key)
    {
        return $this->getOne('_value', ['user_id' => $userId, '_key' => $key]);
    }

    public function getSetting($userId)
    {
        return parent::getItemsByUid($userId);
    }

    /**
     * 新增
     * @param $userId
     * @param $key
     * @param $value
     * @return array
     * @throws \Exception
     */
    public function insertSetting($userId, $key, $value)
    {
        $info = [];
        $info['user_id'] = $userId;
        $info['_key'] = $key;
        $info['_value'] = $value;
        return $this->insertItem($userId, $info);
    }

    public function updateSetting($userId, $key, $value)
    {
        $info = [];
        $info['_value'] = $value;
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['_key'] = $key;
        return $this->update($info, $conditions);
    }

    public function deleteSettingById($id)
    {
        return $this->deleteById($id);
    }

    public function deleteSettingByKey($userId, $key)
    {
        $conditions = [];
        $conditions['user_id'] = $userId;
        $conditions['_key'] = $key;
        return $this->delete($conditions);
    }
}
