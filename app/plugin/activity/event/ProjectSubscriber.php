<?php

namespace main\app\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\event\CommonPlacedEvent;
use main\app\model\ActivityModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\Events;

/**
 * 接收项目的事件
 * Class IssueSubscriber
 */
class ProjectSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectCreate => 'onProjectCreate',
            Events::onProjectUpdate => 'onProjectUpdate',
            Events::onProjectDelete => 'onProjectDelete',
            Events::onProjectArchive => 'onProjectArchive',
        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectCreate(CommonPlacedEvent $event)
    {
        $project = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了项目';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $project['id'];
        $activityInfo['title'] = $project['name'];
        $activityModel->insertItem(UserAuth::getId(), $project['id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectUpdate(CommonPlacedEvent $event)
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
        $activityInfo['action'] = '更新了项目';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $currentData['id'];
        $activityInfo['title'] = $updatedMsg;
        $activityModel->insertItem(UserAuth::getId(), $currentData['id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onProjectDelete(CommonPlacedEvent $event)
    {
        $project = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了项目';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $project['id'];
        $activityInfo['title'] = $project['name'];
        $activityModel->insertItem(UserAuth::getId(), $project['id'], $activityInfo);
    }

    public function onProjectArchive(CommonPlacedEvent $event)
    {
        $project = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '归档了项目';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $project['id'];
        $activityInfo['title'] = $project['name'];
        $activityModel->insertItem(UserAuth::getId(), $project['id'], $activityInfo);
    }

}