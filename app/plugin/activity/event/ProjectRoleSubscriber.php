<?php

namespace main\app\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\user\UserModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收项目角色管理的事件
 * Class IssueSubscriber
 */
class ProjectRoleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onProjectRoleAdd => 'onProjectRoleAdd',
            Events::onProjectRoleUpdate => 'onProjectRoleUpdate',
            Events::onProjectRoleRemove => 'onProjectRoleRemove',
            Events::onProjectRolePermUpdate => 'onProjectRolePermUpdate',
            Events::onProjectRoleAddUser => 'onProjectRoleAddUser',
            Events::onProjectRoleRemoveUser => 'onProjectRoleRemoveUser',
        ];
    }

    public function onProjectRoleAdd(CommonPlacedEvent $event)
    {
        $role = (new ProjectRoleModel())->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了项目角色';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $role['name'];
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectRoleUpdate(CommonPlacedEvent $event)
    {
        $preData = $event->pluginDataArr['pre_data'];
        $currentData = $event->pluginDataArr['cur_data'];
        $updatedMsg = '';
        foreach ($currentData as $key => $item) {
            if ($item != $preData[$key]) {
                $updatedMsg .= $preData[$key] . '-->' . $item . ' ';
            }
        }
        $role = (new ProjectRoleModel())->getById($event->pluginDataArr['id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了项目角色';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $updatedMsg;
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectRoleRemove(CommonPlacedEvent $event)
    {
        $role = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了项目角色';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $role['name'];
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectRolePermUpdate(CommonPlacedEvent $event)
    {
        $role = (new ProjectRoleModel())->getById($event->pluginDataArr['role_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了项目角色的权限';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $role['name'];
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectRoleAddUser(CommonPlacedEvent $event)
    {
        $role = (new ProjectRoleModel())->getById($event->pluginDataArr['role_id']);
        $user = (new UserModel())->getByUid($event->pluginDataArr['user_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '项目角色添加用户';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $role['name'].':'.$user['display_name'];
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectRoleRemoveUser(CommonPlacedEvent $event)
    {
        $role = (new ProjectRoleModel())->getById($event->pluginDataArr['role_id']);
        $user = (new UserModel())->getByUid($event->pluginDataArr['user_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '项目角色移除用户';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $role['id'];
        $activityInfo['title'] = $role['name'].':'.$user['display_name'];
        $activityModel->insertItem(UserAuth::getId(), $role['project_id'], $activityInfo);
    }

}