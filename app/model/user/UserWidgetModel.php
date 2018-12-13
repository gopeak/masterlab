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
}
