<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目的事件
 * Class IssueSubscriber
 */
class OrgSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onOrgCreate => 'onOrgCreate',
            Events::onOrgUpdate => 'onOrgUpdate',
            Events::onOrgDelete => 'onOrgDelete',
        ];
    }

    public function onOrgCreate(CommonPlacedEvent $event)
    {

    }

    public function onOrgUpdate(CommonPlacedEvent $event)
    {

    }

    public function onOrgDelete(CommonPlacedEvent $event)
    {

    }

}