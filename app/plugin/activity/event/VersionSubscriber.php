<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收版本管理的事件
 * Class IssueSubscriber
 */
class VersionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onVersionCreate => 'onVersionCreate',
            Events::onVersionUpdate => 'onVersionUpdate',
            Events::onVersionDelete => 'onVersionDelete',
            Events::onVersionRelease => 'onVersionRelease',

        ];
    }

    public function onVersionCreate(CommonPlacedEvent $event)
    {

    }

    public function onVersionUpdate(CommonPlacedEvent $event)
    {

    }

    public function onVersionDelete(CommonPlacedEvent $event)
    {

    }

    public function onVersionRelease(CommonPlacedEvent $event)
    {

    }

}