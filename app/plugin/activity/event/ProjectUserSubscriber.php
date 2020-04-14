<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目成员管理的事件
 * Class IssueSubscriber
 */
class ProjectUserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectUserAdd => 'onProjectUserAdd',
            Events::onProjectUserUpdateRoles => 'onProjectUserUpdateRoles',
            Events::onProjectUserRemove => 'onProjectUserRemove',

        ];
    }

    public function onProjectUserAdd(CommonPlacedEvent $event)
    {

    }

    public function onProjectUserUpdateRoles(CommonPlacedEvent $event)
    {

    }

    public function onProjectUserRemove(CommonPlacedEvent $event)
    {

    }

}