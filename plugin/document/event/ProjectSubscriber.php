<?php

namespace main\plugin\document\event;

use main\app\classes\UserAuth;
use main\app\event\CommonPlacedEvent;
use main\app\model\ActivityModel;
use main\app\model\user\UserMessageModel;
use main\plugin\document\KodSdk;
use main\lib\FileUtil;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\Events;

/**
 * 文档模块接收项目的事件
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
            Events::onProjectRecover => 'onProjectRecover',
        ];
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectCreate(CommonPlacedEvent $event)
    {
        $pluginDataArr = $event->pluginDataArr;
        $docAdmin = 'admin';
        $kodSdk = new KodSdk();
        $model = new UserMessageModel();
        list($ret, $accessToken) =  $kodSdk->getAccessToken($docAdmin);
        if(!$ret){
            $title =  '项目创建提示';
            $content =  '文档模块认证接口错误,请联系管理员';
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        list($ret, $kodUsers) = $kodSdk->getUsers($accessToken);
        if(!$ret){
            $title =  '项目创建提示';
            $content =  '文档模块用户接口错误,请联系管理员';
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        if(count($kodUsers)>15){
            $title =  '项目创建提示';
            $content =  '文档模块数量限制，该项目不能使用了,请联系管理员';
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        $expectProjectDocUsername = 'project'.$pluginDataArr['id'];;
        $dataArr = [];
        $dataArr['name'] = $expectProjectDocUsername;
        $dataArr['password'] = md5($expectProjectDocUsername);
        $dataArr['sizeMax'] = 5;
        $dataArr['role'] = 2;
        $dataArr['groupInfo'] = json_encode(['1'=>'write']);
        //$homePath = STORAGE_PATH.'document/'.$expectProjectDocUsername;
        //@mkdir($homePath);
        //$dataArr['homePath'] = $homePath;
        list($ret) = $kodSdk->createUser($dataArr, $accessToken);
        if(!$ret){
            $title =  '项目创建异常';
            $content =  '文档模块创建失败,请联系管理员';
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        // @todo 判断是否存在
        $projectPath = APP_PATH.'plugin/document/kod/data/User/'.$expectProjectDocUsername;
        if(!file_exists($projectPath) || !file_exists($projectPath.'/data') || !file_exists($projectPath.'/home')){
            FileUtil::copyDir(APP_PATH.'plugin/document/kod/data/User/project0', APP_PATH.'plugin/document/kod/data/User/'.$expectProjectDocUsername);
        }

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onProjectUpdate(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onProjectDelete(CommonPlacedEvent $event)
    {
        $pluginDataArr = $event->pluginDataArr;
        $projectUserName = 'project'.$pluginDataArr['id'];
        $projectPath = APP_PATH.'plugin/document/kod/data/User/'.$projectUserName;
        FileUtil::unlinkDir($projectPath);
        $this->deleteKodUser($pluginDataArr);
    }

    public function onProjectArchive(CommonPlacedEvent $event)
    {
        $pluginDataArr = $event->pluginDataArr;
        $projectUserName = 'project'.$pluginDataArr['id'];
        $projectPath = APP_PATH.'plugin/document/kod/data/User/'.$projectUserName;
        FileUtil::moveDir($projectPath, $projectPath.'_archive');
        $this->deleteKodUser($pluginDataArr);

    }

    public function onProjectRecover(CommonPlacedEvent $event)
    {
        $pluginDataArr = $event->pluginDataArr;
        $projectUserName = 'project'.$pluginDataArr['id'];
        $projectPath = APP_PATH.'plugin/document/kod/data/User/'.$projectUserName;
        FileUtil::moveDir($projectPath.'_archive', $projectPath, true );
        $this->deleteKodUser($pluginDataArr);

    }

    public function deleteKodUser($pluginDataArr)
    {
        $docAdmin = 'admin';
        $kodSdk = new KodSdk();
        $model = new UserMessageModel();
        list($ret, $accessToken) =  $kodSdk->getAccessToken($docAdmin);
        if(!$ret){
            $title =  '项目删除提示';
            $content =  '文档模块认证接口错误:'.$accessToken;
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        $projectUserName = 'project'.$pluginDataArr['id'];
        list($ret, $projectUser) = $kodSdk->getUser($projectUserName, $accessToken);
        if(!$ret){
            $title =  '项目删除提示';
            $content =  '文档模块用户接口错误:'.$projectUser;
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }
        list($ret, $msg) =  $kodSdk->deleteUser($projectUser['userID'], $accessToken);
        if(!$ret){
            $title =  '项目删除提示';
            $content =  '文档模块认证接口错误:'.$msg;
            $model->setMsg2User(UserAuth::getId(), UserMessageModel::TYPE_SYSTEM, $title, $content);
            return;
        }

    }



}