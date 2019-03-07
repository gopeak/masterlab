<?php

namespace main\app\model\system;

use main\app\model\BaseDictionaryModel;

/**
 *  系统自带的字段
 *
 */
class NotifySchemeDataModel extends BaseDictionaryModel
{
    public $prefix = 'main_';

    public $table = 'notify_scheme_data';

    public $fields = '*';

    /**
     * 根据通知方案ID获取通知方案
     * @throws \Exception
     */
    public function getSchemeData($notifySchemeId)
    {
        $conditions = ['scheme_id' => $notifySchemeId];
        $fields = "*,{$this->primaryKey} as k";
        $table = $this->getTable();
        return $this->getRows($fields, $conditions, null, null, null, null, true);
    }

}
