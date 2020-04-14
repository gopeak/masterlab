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
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
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


    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueCreateBefore(CommonPlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateBefore');
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueCreateAfter(CommonPlacedEvent $event)
    {
        // ...
        var_dump($event);
        var_dump('onIssueCreateAfter');
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueUpdateBefore(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueUpdateAfter(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueDelete(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueClose(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueFollow(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueUnFollow(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueConvertChild(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueBatchDelete(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueBatchUpdate(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueImportByExcel(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueRemoveChild(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueJoinSprint(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueJoinClose(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueJoinBacklog(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueAddAdvFilter(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueAddFilter(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueAddComment(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueDeleteComment(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueUpdateComment(CommonPlacedEvent $event)
    {

    }

}