<?php

namespace main\app\model\user;

/**
 *
 */
class UserWidgetModel extends BaseUserItemsModel
{
    public $prefix = 'user_';

    public $table = 'widget';

    const   DATA_KEY = 'user_widget/';

    /**
     * UserWidgetModel constructor.
     * @param string $userId
     * @param bool $persistent
     * @throws \Exception
     */
    public function __construct($userId = '', $persistent = false)
    {
        parent::__construct($userId, $persistent);

        $this->uid = $userId;
    }

    public function getsByUid($userId)
    {
        return $this->getRows('*', ['user_id' => $userId], null, 'order_weight', 'asc');
    }

    /**
     * @param $userId
     * @param $widgetId
     * @return array
     */
    public function getItemByWidgetId($userId ,$widgetId)
    {
        return $this->getRow('*', ['user_id' => $userId, 'widget_id'=>$widgetId]);
    }
}
