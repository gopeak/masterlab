<?php

namespace main\app\plugin\activity\event;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收登录等的事件
 * Class IssueSubscriber
 */
class PassportSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onUserRegister => 'onUserRegister',
            Events::onUserLogin => 'onUserLogin',
            Events::onUserlogout => 'onUserlogout',
            Events::onUserUpdateProfile => 'onUserUpdateProfile',
        ];
    }

    public function onUserRegister(CommonPlacedEvent $event)
    {

    }

    public function onUserLogin(CommonPlacedEvent $event)
    {

    }

    public function onUserlogout(CommonPlacedEvent $event)
    {

    }

    public function onUserUpdateProfile(CommonPlacedEvent $event)
    {

    }
}