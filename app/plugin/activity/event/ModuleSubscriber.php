<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收模块管理的事件
 * Class IssueSubscriber
 */
class ModuleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onModuleCreate => 'onModuleCreate',
            Events::onModuleUpdate => 'onModuleUpdate',
            Events::onModuleDelete => 'onModuleDelete',
        ];
    }

    public function onModuleCreate(CommonPlacedEvent $event)
    {

    }

    public function onModuleUpdate(CommonPlacedEvent $event)
    {

    }

    public function onModuleDelete(CommonPlacedEvent $event)
    {

    }

}