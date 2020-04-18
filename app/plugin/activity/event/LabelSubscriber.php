<?php

namespace main\app\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectLabelModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收版本管理的事件
 * Class IssueSubscriber
 */
class LabelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onLabelCreate => 'onLabelCreate',
            Events::onLabelUpdate => 'onLabelUpdate',
            Events::onLabelDelete => 'onLabelDelete',

        ];
    }

    public function onLabelCreate(CommonPlacedEvent $event)
    {
        $label = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了标签';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $label['id'];
        $activityInfo['title'] = $label['title'];
        $activityModel->insertItem(UserAuth::getId(), $label['project_id'], $activityInfo);
    }

    public function onLabelUpdate(CommonPlacedEvent $event)
    {
        $id = $event->pluginDataArr['id'];
        $label = (new ProjectLabelModel())->getById($id);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了标签';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $label['id'];
        $activityInfo['title'] = $label['title'];
        $activityModel->insertItem(UserAuth::getId(), $label['project_id'], $activityInfo);
    }

    public function onLabelDelete(CommonPlacedEvent $event)
    {
        $id = $event->pluginDataArr['id'];
        $label = (new ProjectLabelModel())->getById($id);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了标签';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $label['id'];
        $activityInfo['title'] = $label['title'];
        $activityModel->insertItem(UserAuth::getId(), $label['project_id'], $activityInfo);

    }

}