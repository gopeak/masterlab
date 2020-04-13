<?php

use main\app\event\CommonPlacedEvent;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\IssuePlacedEvent;
use main\app\event\Events;
/**
 * 接收事项的事件
 * Class IssueSubscriber
 */
class IssueSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onIssueCreateBefore=>'onIssueCreateBefore',
            Events::onIssueCreateAfter=>'onIssueCreateAfter',
            Events::onIssueUpdateBefore=>'onIssueUpdateBefore',
            Events::onIssueUpdateAfter=>'onIssueUpdateAfter',
            Events::onIssueDelete=>'onIssueDelete',
            Events::onIssueClose=>'onIssueClose',
            Events::onIssueFollow=>'onIssueFollow',
            Events::onIssueUnFollow=>'onIssueUnFollow',
            Events::onIssueConvertChild=>'onIssueConvertChild',
            Events::onIssueBatchDelete=>'onIssueBatchDelete',
            Events::onIssueBatchUpdate=>'onIssueBatchUpdate',
            Events::onIssueImportByExcel=>'onIssueImportByExcel',
            Events::onIssueRemoveChild=>'onIssueRemoveChild',
            Events::onIssueJoinSprint=>'onIssueJoinSprint',
            Events::onIssueJoinClose=>'onIssueJoinClose',
            Events::onIssueJoinBacklog=>'onIssueJoinBacklog',
            Events::onIssueAddAdvFilter=>'onIssueAddAdvFilter',
            Events::onIssueAddFilter=>'onIssueAddFilter',
            Events::onIssueAddComment=>'onIssueAddComment',
            Events::onIssueDeleteComment=>'onIssueDeleteComment',
            Events::onIssueUpdateComment=>'onIssueUpdateComment',
        ];
    }


    public function onIssueCreateBefore(CommonPlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateBefore');
    }

    public function onIssueCreateAfter(CommonPlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateAfter');
    }

    public function onIssueUpdateBefore(CommonPlacedEvent $event)
    {

    }

    public function onIssueUpdateAfter(CommonPlacedEvent $event)
    {

    }
    public function onIssueDelete(CommonPlacedEvent $event)
    {

    }
    public function onIssueClose(CommonPlacedEvent $event)
    {

    }
    public function onIssueFollow(CommonPlacedEvent $event)
    {

    }
    public function onIssueUnFollow(CommonPlacedEvent $event)
    {

    }
    public function onIssueConvertChild(CommonPlacedEvent $event)
    {

    }
    public function onIssueBatchDelete(CommonPlacedEvent $event)
    {

    }
    public function onIssueBatchUpdate(CommonPlacedEvent $event)
    {

    }
    public function onIssueImportByExcel(CommonPlacedEvent $event)
    {

    }
    public function onIssueRemoveChild(CommonPlacedEvent $event)
    {

    }
    public function onIssueJoinSprint(CommonPlacedEvent $event)
    {

    }

    public function onIssueJoinClose(CommonPlacedEvent $event)
    {

    }
    public function onIssueJoinBacklog(CommonPlacedEvent $event)
    {

    }
    public function onIssueAddAdvFilter(CommonPlacedEvent $event)
    {

    }
    public function onIssueAddFilter(CommonPlacedEvent $event)
    {

    }
    public function onIssueAddComment(CommonPlacedEvent $event)
    {

    }
    public function onIssueDeleteComment(CommonPlacedEvent $event)
    {

    }

    public function onIssueUpdateComment(CommonPlacedEvent $event)
    {

    }

}