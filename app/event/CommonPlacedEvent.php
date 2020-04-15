<?php

namespace main\app\event;

use main\app\ctrl\BaseCtrl;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * 用于传递事件数据类
 *
 */
class CommonPlacedEvent   extends Event
{
    /**
     * 控制器对象
     * @var mixed
     */
    public $ctrl = null;

    /**
     * @var mixed|null
     */
    public $pluginDataArr = null;

    /**
     * CommonPlacedEvent constructor.
     * @param $ctrl
     * @param $pluginDataArr
     */
    public function __construct($ctrl, $pluginDataArr)
    {
        $this->ctrl = $ctrl;
        $this->pluginDataArr = $pluginDataArr;
    }

}
