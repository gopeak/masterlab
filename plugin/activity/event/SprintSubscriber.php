<?php

namespace main\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收迭代管理的事件
 * Class IssueSubscriber
 */
class SprintSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onSprintCreate => 'onSprintCreate',
            Events::onSprintUpdate => 'onSprintUpdate',
            Events::onSprintSetActive => 'onSprintSetActive',
            Events::onSprintDelete => 'onSprintDelete',
        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onSprintCreate(CommonPlacedEvent $event)
    {
        $sprint = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了迭代';
        $activityInfo['type'] = ActivityModel::TYPE_AGILE;
        $activityInfo['obj_id'] = $sprint['id'];
        $activityInfo['title'] = $sprint['name'];
        $activityModel->insertItem(UserAuth::getId(), $sprint['project_id'], $activityInfo);

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onSprintUpdate(CommonPlacedEvent $event)
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
        $activityInfo['action'] = '更新了迭代';
        $activityInfo['type'] = ActivityModel::TYPE_AGILE;
        $activityInfo['obj_id'] = $currentData['id'];
        $activityInfo['title'] = $updatedMsg;
        $activityModel->insertItem(UserAuth::getId(), $preData['project_id'], $activityInfo);

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onSprintSetActive(CommonPlacedEvent $event)
    {
        $sprint = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '设置迭代状态为进行中';
        $activityInfo['type'] = ActivityModel::TYPE_AGILE;
        $activityInfo['obj_id'] = $sprint['id'];
        $activityInfo['title'] = $sprint['name'];
        $activityModel->insertItem(UserAuth::getId(), $sprint['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onSprintDelete(CommonPlacedEvent $event)
    {
        $sprint = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了迭代';
        $activityInfo['type'] = ActivityModel::TYPE_AGILE;
        $activityInfo['obj_id'] = $sprint['id'];
        $activityInfo['title'] = $sprint['name'];
        $activityModel->insertItem(UserAuth::getId(), $sprint['project_id'], $activityInfo);

    }

}