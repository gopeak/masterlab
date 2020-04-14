<?php

namespace main\app\plugin\activity\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收分类管理的事件
 * Class IssueSubscriber
 */
class CatalogSubscriber implements EventSubscriberInterface
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
            Events::onCataloglCreate => 'onCataloglCreate',
            Events::onCatalogUpdate => 'onCatalogUpdate',
            Events::onCatalogDelete => 'onCatalogDelete',

        ];
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onCataloglCreate(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onCatalogUpdate(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onCatalogDelete(CommonPlacedEvent $event)
    {

    }

}