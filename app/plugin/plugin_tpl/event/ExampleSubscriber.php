<?php
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\IssuePlacedEvent;

/**
 * 接收事项的事件
 * Class IssueSubscriber
 */
class ExampleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.response'=> [
                ['onKernelResponsePre', 10],
                ['onKernelResponsePost', -10],
            ],
            IssuePlacedEvent::NAME => [
                ['onIssueCreateBefore', 1],
                ['onIssueCreateAfter', 2],
            ]
        ];
    }

    public function onKernelResponsePre(Event $event)
    {
        // ...
        var_dump('onKernelResponsePre');
    }

    public function onKernelResponsePost(Event $event)
    {
        // ...
        var_dump('onKernelResponsePost');
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