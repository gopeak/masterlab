<?php

namespace main\app\event;

use main\app\ctrl\BaseUserCtrl;
use Symfony\Contracts\EventDispatcher\Event;
use main\app\model\issue\IssueModel;

/**
 * 系统全局设置的各种配置属性
 *
 */
class IssuePlacedEvent   extends Event
{
    const NAME = 'issue.placed';

    /**
     * @var BaseUserCtrl|null
     */
    protected $ctrl = null;

    /**
     * @var IssueModel
     */
    protected $issueModel;

    public function __construct(BaseUserCtrl $ctrl, IssueModel $issueModel)
    {
        $this->ctrl = $ctrl;
        $this->issueModel = $issueModel;
    }

    /**
     * @return IssueModel
     */
    public function getIssueModel()
    {
        return $this->issueModel;
    }

    /**
     * @return BaseUserCtrl|null
     */
    public function getCtrl()
    {
        return $this->ctrl;
    }
}
