<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收用户管理的事件
 * Class IssueSubscriber
 */
class UserAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onUserAddByAdmin => 'onUserAddByAdmin',
            Events::onUserUpdateByAdmin => 'onUserUpdateByAdmin',
            Events::onUserActiveByAdmin => 'onUserActiveByAdmin',
            Events::onUserDeleteByAdmin => 'onUserDeleteByAdmin',
            Events::onUserDisableByAdmin => 'onUserDisableByAdmin',
            Events::onUserBatchDisableByAdmin => 'onUserBatchDisableByAdmin',
            Events::onUserBatchRecoveryByAdmin => 'onUserBatchRecoveryByAdmin',
        ];
    }

    public function onUserAddByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserUpdateByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserActiveByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserDeleteByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserDisableByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserBatchDisableByAdmin(CommonPlacedEvent $event)
    {

    }

    public function onUserBatchRecoveryByAdmin(CommonPlacedEvent $event)
    {

    }

}