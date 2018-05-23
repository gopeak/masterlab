<?php

namespace main\app\model\user;

use main\app\model\CacheModel;

/**
 *
 */
class UserSettingModel extends CacheModel
{
    public $prefix = 'user_';

    public $table = 'setting';

    const   DATA_KEY = 'user_setting/';

    public function __construct($uid = '', $persistent = false)
    {
        parent::__construct($uid, $persistent);

        $this->uid = $uid;
    }

    public function getSetting($uid)
    {
        return $this->getRows('*', ['uid' => $uid]);
    }

    public function insertSetting($uid, $key, $value)
    {
        $info = [];
        $info['uid'] = $uid;
        $info['_key'] = $key;
        $info['_value'] = $value;
        // INSERT INTO {$table} (`uid`,`project_id`,`role_id`) VALUES('$uid',$project_id,$role_id)
        // ON DUPLICATE UPDATE project_id=$project_id,role_id=$role_id;
        return $this->insert($info);
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

    public function deleteByProjectRole($uid, $project_id, $role_id)
    {
        $conditions = [];
        $conditions['uid'] = $uid;
        $conditions['project_id'] = $project_id;
        $conditions['role_id'] = $role_id;
        return $this->delete($conditions);
    }
}
