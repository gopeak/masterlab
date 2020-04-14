<?php

namespace main\app\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectModuleModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收模块管理的事件
 * Class IssueSubscriber
 */
class ModuleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onModuleCreate => 'onModuleCreate',
            Events::onModuleUpdate => 'onModuleUpdate',
            Events::onModuleDelete => 'onModuleDelete',
        ];
    }

    public function onModuleCreate(CommonPlacedEvent $event)
    {
        $module = (new ProjectModuleModel)->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了模块';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $module['id'];
        $activityInfo['title'] = $module['name'];
        $activityModel->insertItem(UserAuth::getId(), $module['project_id'], $activityInfo);
    }

    public function onModuleUpdate(CommonPlacedEvent $event)
    {
        $module = (new ProjectModuleModel)->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了模块';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $module['id'];
        $activityInfo['title'] = $module['name'];
        $activityModel->insertItem(UserAuth::getId(), $module['project_id'], $activityInfo);
    }

    public function onModuleDelete(CommonPlacedEvent $event)
    {
        $module =  $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了模块';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $module['id'];
        $activityInfo['title'] = $module['name'];
        $activityModel->insertItem(UserAuth::getId(), $module['project_id'], $activityInfo);
    }

}