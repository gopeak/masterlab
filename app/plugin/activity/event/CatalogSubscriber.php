<?php
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
/**
 * 接收分类管理的事件
 * Class IssueSubscriber
 */
class CatalogSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onCataloglCreate=>'onCataloglCreate',
            Events::onCatalogUpdate=>'onCatalogUpdate',
            Events::onCatalogDelete=>'onCatalogDelete',

        ];
    }

    public function onCataloglCreate(CommonPlacedEvent $event)
    {

    }

    public function onCatalogUpdate(CommonPlacedEvent $event)
    {

    }
    public function onCatalogDelete(CommonPlacedEvent $event)
    {

    }

}