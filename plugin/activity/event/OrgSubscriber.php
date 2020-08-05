<?php

namespace main\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\OrgModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目的事件
 * Class IssueSubscriber
 */
class OrgSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onOrgCreate => 'onOrgCreate',
            Events::onOrgUpdate => 'onOrgUpdate',
            Events::onOrgDelete => 'onOrgDelete',
        ];
    }

    public function onOrgCreate(CommonPlacedEvent $event)
    {
        $org = (new OrgModel())->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $org['id'];
        $activityInfo['title'] = $org['name'];
        $activityModel->insertItem(UserAuth::getId(), 0, $activityInfo);
    }

    public function onOrgUpdate(CommonPlacedEvent $event)
    {
        $org = (new OrgModel())->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $org['id'];
        $activityInfo['title'] = $org['name'];
        $activityModel->insertItem(UserAuth::getId(), 0, $activityInfo);
    }

    public function onOrgDelete(CommonPlacedEvent $event)
    {
        $org =  $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了组织';
        $activityInfo['type'] = ActivityModel::TYPE_ORG;
        $activityInfo['obj_id'] = $org['id'];
        $activityInfo['title'] = $org['name'];
        $activityModel->insertItem(UserAuth::getId(), 0, $activityInfo);
    }

}