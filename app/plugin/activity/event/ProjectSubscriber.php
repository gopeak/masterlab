<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\Events;

/**
 * 接收项目的事件
 * Class IssueSubscriber
 */
class ProjectSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectCreate => 'onProjectCreate',
            Events::onProjectUpdate => 'onProjectUpdate',
            Events::onProjectDelete => 'onProjectDelete',
            Events::onProjectArchive => 'onProjectArchive',
        ];
    }

    public function onProjectCreate(CommonPlacedEvent $event)
    {

    }

    public function onProjectUpdate(CommonPlacedEvent $event)
    {

    }

    public function onProjectDelete(CommonPlacedEvent $event)
    {

    }

    public function onProjectArchive(CommonPlacedEvent $event)
    {

    }

}