<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目角色管理的事件
 * Class IssueSubscriber
 */
class ProjectRoleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectRoleAdd => 'onProjectRoleAdd',
            Events::onProjectRoleUpdate => 'onProjectRoleUpdate',
            Events::onProjectRoleRemove => 'onProjectRoleRemove',
            Events::onProjectRolePermUpdate => 'onProjectRolePermUpdate',
            Events::onProjectRoleAddUser => 'onProjectRoleAddUser',
            Events::onProjectRoleRemoveUser => 'onProjectRoleRemoveUser',
        ];
    }

    public function onProjectRoleAdd(CommonPlacedEvent $event)
    {

    }

    public function onProjectRoleUpdate(CommonPlacedEvent $event)
    {

    }

    public function onProjectRoleRemove(CommonPlacedEvent $event)
    {

    }

    public function onProjectRolePermUpdate(CommonPlacedEvent $event)
    {

    }

    public function onProjectRoleAddUser(CommonPlacedEvent $event)
    {

    }

    public function onProjectRoleRemoveUser(CommonPlacedEvent $event)
    {

    }

}