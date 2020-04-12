<?php

namespace main\app\event;

use main\app\ctrl\BaseCtrl;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * 用于传递事件的用户数据
 *
 */
class UserPlacedEvent   extends Event
{
    /**
     * @var mixed
     */
    public $ctrl = null;

    /**
     * @var array
     */
    public $pluginDataArr = [];


    public function __construct($ctrl, $pluginDataArr)
    {
        $this->ctrl = $ctrl;
        $this->pluginDataArr = $pluginDataArr;
    }


}
