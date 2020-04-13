<?php
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\IssuePlacedEvent;

/**
 * 接收项目的事件
 * Class IssueSubscriber
 */
class ProjectSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [

            IssuePlacedEvent::NAME => [
                ['onIssueCreateBefore', 1],
                ['onIssueCreateAfter', 2],
            ]
        ];
    }

    public function onIssueCreateBefore(IssuePlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateBefore');
    }

    public function onIssueCreateAfter(IssuePlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateAfter');
    }
}