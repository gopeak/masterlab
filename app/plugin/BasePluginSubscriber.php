<?php

namespace main\app\plugin;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *  插件基类
 * Class ActivityPlugin
 */
class BasePluginSubscriber implements EventSubscriberInterface
{

    public $subscribersArr = [];

    public function __construct()
    {

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
    protected function loadEventSubscriber(EventDispatcher $dispatcher)
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


}