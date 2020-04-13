<?php
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
/**
 * 接收版本管理的事件
 * Class IssueSubscriber
 */
class LabelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onLabelCreate=>'onLabelCreate',
            Events::onLabelUpdate=>'onLabelUpdate',
            Events::onLabelDelete=>'onLabelDelete',

        ];
    }

    public function onLabelCreate(CommonPlacedEvent $event)
    {

    }

    public function onLabelUpdate(CommonPlacedEvent $event)
    {

    }
    public function onLabelDelete(CommonPlacedEvent $event)
    {

    }

}