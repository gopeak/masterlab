<?php

namespace main\app\plugin\plugin_tpl;

use main\app\event\PluginPlacedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * 插件入口类
 * Class ActivityPlugin
 */
class TplPlugin implements EventSubscriberInterface
{

    public $subscribersArr = [];

    public function __construct(EventDispatcher $dispatcher)
    {
        // 载入事件订阅类和函数
        $this->getEventSubscriberFile(realpath(dirname(__FILE__)));
        $this->loadEventSubscriber($dispatcher);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            \main\app\event\Events::onPluginInstall =>'onInstallEvent',
            \main\app\event\Events::onPluginUnInstall =>'onUnInstallEvent'
        ];
    }

    /**
     * 递归获取事件订阅类
     * @param $subscriberDir
     */
    public function getEventSubscriberFile($subscriberDir)
    {
        $currentDir = dir($subscriberDir);
        while ($file = $currentDir->read()) {
            if ((is_dir($subscriberDir . $file)) and ($file != ".") and ($file != "..")) {
                $this->getEventSubscriberFile($subscriberDir . $file . '/');
            } else {
                $subClassPath = str_replace(PLUGIN_PATH, '', $subscriberDir);
                $subClassPath = str_replace('/', "\\", $subClassPath);
                $file = pathinfo($file);
                if ($file['extension'] = 'php'
                    && strpos($file['basename'], 'Model') !== false
                    && !in_array($file['basename'], ['BaseModel', 'DbModel'])
                ) {
                    $this->subscribersArr[] = $subClassPath . $file['basename'];
                }
            }
        }
        $currentDir->close();

    }


    /**
     * 注册事件订阅
     * @param EventDispatcher $dispatcher
     */
    public function loadEventSubscriber(EventDispatcher $dispatcher)
    {
        foreach ($this->subscribersArr as $subscriberName) {
            $subscriberClass = str_replace('.php', '', $subscriberName);
            // require_once MODEL_PATH.$modelName.'.php';
            $subscriberClass = sprintf("main\\%s\\plugin\\event\\%s", APP_NAME, $subscriberClass);
            //var_dump($model_class);
            if (!class_exists($subscriberClass)) {
                // @todo 通用的使用日志写入
                echo sprintf("plugin %s event/%s no found ", __CLASS__, $subscriberClass)."\n";
            }
            $subscriberObj = new $subscriberClass();
            // @todo 通过反射是否实现 EventSubscriberInterface 接口
            if ($subscriberObj && method_exists($subscriberObj, 'getSubscribedEvents')) {
                $dispatcher->addSubscriber($subscriberObj);
            }
        }
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