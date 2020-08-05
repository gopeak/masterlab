<?php

namespace main\plugin\activity;

use main\plugin\BasePluginSubscriber;
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

    public $pluginName = '';


    /**
     * ActivityPlugin constructor.
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher, $pluginName)
    {
        parent::__construct($pluginName);
        $this->pluginName = $pluginName;
        // 载入事件订阅类和函数
        parent::getEventSubscriberFile(realpath(dirname(__FILE__)).DS.'event');
        parent::loadEventSubscriber($dispatcher, basename (__DIR__));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            basename (__DIR__).'@'.\main\app\event\Events::onPluginInstall =>'onInstallEvent',
            basename (__DIR__).'@'.\main\app\event\Events::onPluginUnInstall =>'onUnInstallEvent'
        ];
    }

    /**
     * 插件安装后的操作
     * @param $pluginPlacedEvent
     */
    public function onInstallEvent(PluginPlacedEvent $pluginPlacedEvent)
    {
        var_dump($pluginPlacedEvent);

    }

    /**
     * 插件卸载后的操作
     * @param $pluginPlacedEvent
     */
    public function onUnInstallEvent(PluginPlacedEvent $pluginPlacedEvent)
    {
        var_dump($pluginPlacedEvent);
    }


}