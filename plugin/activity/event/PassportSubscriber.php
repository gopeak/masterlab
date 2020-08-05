<?php

namespace main\plugin\activity\event;

use main\app\classes\UserAuth;
use main\app\model\ActivityModel;
use main\app\model\OrgModel;
use main\app\model\user\UserModel;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;

/**
 * 接收登录等的事件
 * Class IssueSubscriber
 */
class PassportSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            Events::onUserRegister => 'onUserRegister',
            Events::onUserLogin => 'onUserLogin',
            Events::onUserlogout => 'onUserlogout',
            Events::onUserUpdateProfile => 'onUserUpdateProfile',
        ];
    }

    public function onUserRegister(CommonPlacedEvent $event)
    {

    }

    public function onUserLogin(CommonPlacedEvent $event)
    {

    }

    public function onUserlogout(CommonPlacedEvent $event)
    {

    }

    public function onUserUpdateProfile(CommonPlacedEvent $event)
    {
        $preData = $event->pluginDataArr['pre_data'];
        $currentUser = $event->pluginDataArr['cur_data'];
        $updatedMsg = '';
        foreach ($currentUser as $key => $item) {
            if ($item != $preData[$key]) {
                $updatedMsg .= $preData[$key] . '-->' . $item . ' ';
            }
        }
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了资料';
        $activityInfo['type'] = ActivityModel::TYPE_USER;
        $activityInfo['obj_id'] = UserAuth::getId();
        $activityInfo['title'] = $updatedMsg;
        $activityModel->insertItem(UserAuth::getId(), 0, $activityInfo);
    }
}