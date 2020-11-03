<?php

namespace main\plugin;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *  插件事件基类
 * Class ActivityPlugin
 */
class BasePluginSubscriber implements EventSubscriberInterface
{

    public $subscribersArr = [];

    public $pluginName = '';

    /**
     * BasePluginSubscriber constructor.
     * @param $pluginName
     */
    public function __construct($pluginName)
    {
        $this->pluginName = $pluginName;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [];
    }

    /**
     * 递归获取事件订阅类
     * @param $subscriberDir
     */
    protected function getEventSubscriberFile($subscriberDir)
    {
        $currentDir = dir($subscriberDir);
        while ($file = $currentDir->read()) {
            if ((is_dir($subscriberDir . $file)) and ($file != ".") and ($file != "..")) {
                 $this->getEventSubscriberFile($subscriberDir . $file . DS);
            } else {
                $subClassPath = str_replace(PLUGIN_PATH, '', $subscriberDir);
                $subClassPath = str_replace('/', "\\", $subClassPath);
                //var_dump($subClassPath);
                $file = pathinfo($file);
                if ($file['extension'] == 'php'
                    && !in_array($file['basename'], ['BaseModel', 'DbModel'])
                    && $file['basename']!='.'
                    && $file['basename']!='..'
                    && $file['basename']!='.gitignore'
                ) {
                    $this->subscribersArr[] = $subscriberDir .DS. $file['basename'];
                }
            }
        }
        $currentDir->close();
    }

    /**
     * 注册事件订阅
     * @param EventDispatcher $dispatcher
     * @param $pluginName
     */
    protected function loadEventSubscriber(EventDispatcher $dispatcher, $pluginName)
    {
        // print_r($this->subscribersArr);
        foreach ($this->subscribersArr as $subscriberFile) {
            require_once  $subscriberFile;
            $subscriberName = basename($subscriberFile);
            $subscriberClass = str_replace('.php', '', $subscriberName);
            $subscriberClass = sprintf("main\\plugin\\%s\\event\\%s", $pluginName, $subscriberClass);
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


}