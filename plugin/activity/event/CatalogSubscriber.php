<?php

namespace main\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectCatalogLabelModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收分类管理的事件
 * Class IssueSubscriber
 */
class CatalogSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::onCataloglCreate => 'onCataloglCreate',
            Events::onCatalogUpdate => 'onCatalogUpdate',
            Events::onCatalogDelete => 'onCatalogDelete',

        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onCataloglCreate(CommonPlacedEvent $event)
    {
        $catalog = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了分类';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $catalog['id'];
        $activityInfo['title'] = $catalog['name'];
        $activityModel->insertItem(UserAuth::getId(), $catalog['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onCatalogUpdate(CommonPlacedEvent $event)
    {
        $model = new ProjectCatalogLabelModel();
        $catalog = $model->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了分类';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $catalog['id'];
        $activityInfo['title'] = $catalog['name'];
        $activityModel->insertItem(UserAuth::getId(), $catalog['project_id'], $activityInfo);
    }
    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onCatalogDelete(CommonPlacedEvent $event)
    {
        $catalog = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了分类';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $catalog['id'];
        $activityInfo['title'] = $catalog['name'];
        $activityModel->insertItem(UserAuth::getId(), $catalog['project_id'], $activityInfo);
    }

}