<?php
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
/**
 * 接收迭代管理的事件
 * Class IssueSubscriber
 */
class SprintSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onSprintCreate=>'onSprintCreate',
            Events::onSprintUpdate=>'onSprintUpdate',
            Events::onSprintSetActive=>'onSprintSetActive',
            Events::onSprintDelete=>'onSprintDelete',
        ];
    }

    public function onSprintCreate(CommonPlacedEvent $event)
    {

    }

    public function onSprintUpdate(CommonPlacedEvent $event)
    {

    }
    public function onSprintSetActive(CommonPlacedEvent $event)
    {

    }
    public function onSprintDelete(CommonPlacedEvent $event)
    {

    }

}