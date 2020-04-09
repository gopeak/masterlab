<?php

/**
 * 活动日志插件
 * Class ActivityPlugin
 */
class ActivityPlugin
{

    public $subscribersArr = [];

    public function __construct($ctrlObj, $pluginManager)
    {
        // 载入事件订阅类和函数
        $this->getEventSubscriberFile(realpath(dirname(__FILE__)));
        $this->loadEventSubscriber($pluginManager);
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
     * 添加事件订阅
     * @param $pluginManager
     */
    public function loadEventSubscriber($pluginManager)
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
                $pluginManager->dispatcher->addSubscriber($subscriberObj);
            }
        }
    }

    /**
     * 插件安装时执行动作
     * @param $pluginManager
     */
    public function beforeInstallEvent($pluginManager)
    {

    }

    /**
     * 安装完毕后
     * @param $pluginManager
     */
    public function afterInstallEvent($pluginManager)
    {

    }


    /**
     * 卸载插件时的操作
     * @param $pluginManager
     */
    public function unstallEvent($pluginManager)
    {

    }
}