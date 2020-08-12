<?php

namespace main\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\ctrl\admin\Project;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\user\UserModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目成员管理的事件
 * Class IssueSubscriber
 */
class ProjectUserSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectUserAdd => 'onProjectUserAdd',
            Events::onProjectUserUpdateRoles => 'onProjectUserUpdateRoles',
            Events::onProjectUserRemove => 'onProjectUserRemove',

        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectUserAdd(CommonPlacedEvent $event)
    {
        $rolesArr = (new ProjectRoleModel())->getRowsByIdArr("*", 'id',$event->pluginDataArr['role_id_arr']);
        $roleNames = '';
        foreach ($rolesArr as $role) {
            $roleNames .= $role['name'] . ' ';
        }

        $user = (new UserModel())->getByUid($event->pluginDataArr['user_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '项目添加用户';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $user['uid'];
        $activityInfo['title'] = $user['display_name'] . ':' . $roleNames;
       // print_r($activityInfo);
        $activityModel->insertItem(UserAuth::getId(), $event->pluginDataArr['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onProjectUserUpdateRoles(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectUserRemove(CommonPlacedEvent $event)
    {
        $user = (new UserModel())->getByUid($event->pluginDataArr['user_id']);
        $project = (new ProjectModel())->getById($event->pluginDataArr['project_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '项目移除了用户';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $user['uid'];
        $activityInfo['title'] = $project['name'] . ':' . $user['display_name'];
        $activityModel->insertItem(UserAuth::getId(), $event->pluginDataArr['project_id'], $activityInfo);
    }

}