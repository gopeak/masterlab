<?php

namespace main\app\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收版本管理的事件
 * Class IssueSubscriber
 */
class VersionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onVersionCreate => 'onVersionCreate',
            Events::onVersionUpdate => 'onVersionUpdate',
            Events::onVersionDelete => 'onVersionDelete',
            Events::onVersionRelease => 'onVersionRelease',

        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onVersionCreate(CommonPlacedEvent $event)
    {
        $version = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了版本';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $version['id'];
        $activityInfo['title'] = $version['name'];
        $activityModel->insertItem(UserAuth::getId(), $version['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onVersionUpdate(CommonPlacedEvent $event)
    {
        $preData = $event->pluginDataArr['pre_data'];
        $currentData = $event->pluginDataArr['cur_data'];
        $updatedMsg = '';
        $displayKeyArr = ['name'];
        foreach ($currentData as $key => $item) {
            if ($item != $preData[$key] && in_array($key,$displayKeyArr)) {
                $updatedMsg .= $preData[$key] . '-->' . $item . ' ';
            }
        }
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了版本';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $preData['id'];
        $activityInfo['title'] = $updatedMsg;
        $activityModel->insertItem(UserAuth::getId(), $preData['project_id'], $activityInfo);
    }

    public function onVersionDelete(CommonPlacedEvent $event)
    {
        $version = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了版本';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $version['id'];
        $activityInfo['title'] = $version['name'];
        $activityModel->insertItem(UserAuth::getId(), $version['project_id'], $activityInfo);
    }

    public function onVersionRelease(CommonPlacedEvent $event)
    {

    }

}