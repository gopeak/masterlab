<?php

namespace main\app\event;

use main\app\ctrl\BaseAdminCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\DbModel;
use Symfony\Contracts\EventDispatcher\Event;
use main\app\model\issue\IssueModel;

/**
 * 用于传递事件的插件安装和卸载数据
 *
 */
class PluginPlacedEvent   extends Event
{
    /**
     * @var BaseAdminCtrl|null
     */
    public $ctrl = null;

    /**
     * @var array
     */
    public $pluginDataArr = [];


    public function __construct(BaseAdminCtrl $ctrl, $pluginDataArr)
    {
        $this->ctrl = $ctrl;
        $this->pluginDataArr = $pluginDataArr;
    }


}
