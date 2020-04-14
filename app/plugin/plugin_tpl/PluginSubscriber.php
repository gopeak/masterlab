<?php

namespace main\app\plugin\plugin_tpl;

use main\app\plugin\BasePluginSubscriber;
use main\app\event\PluginPlacedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * 活动日志插件
 * Class ActivityPlugin
 */
class PluginSubscriber extends BasePluginSubscriber implements EventSubscriberInterface
{

    public $subscribersArr = [];

    /**
     * ActivityPlugin constructor.
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        parent::__construct();
        // 载入事件订阅类和函数
        parent::getEventSubscriberFile(realpath(dirname(__FILE__)));
        parent::loadEventSubscriber($dispatcher);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            basename (__CLASS__).'@'.\main\app\event\Events::onPluginInstall =>'onInstallEvent',
            basename (__CLASS__).'@'.\main\app\event\Events::onPluginUnInstall =>'onUnInstallEvent'
        ];
    }

    /**
     * 插件安装后的操作
     * @param $pluginPlacedEvent
     */
    public function onInstallEvent(PluginPlacedEvent $pluginPlacedEvent)
    {
        // var_dump($pluginPlacedEvent);

    }

    /**
     * 插件卸载后的操作
     * @param $pluginPlacedEvent
     */
    public function onUnInstallEvent(PluginPlacedEvent $pluginPlacedEvent)
    {
        // var_dump($pluginPlacedEvent);
    }


}