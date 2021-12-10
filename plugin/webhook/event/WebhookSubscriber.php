<?php

namespace main\plugin\webhook\event;

use main\app\classes\MasterlabSocketClient;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\event\CommonPlacedEvent;
use main\app\model\CacheModel;
use main\app\model\issue\IssueModel;
use main\app\model\project\ProjectModel;
use main\app\model\user\UserModel;
use main\plugin\webhook\model\WebHookLogModel;
use main\plugin\webhook\model\WebHookModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\Events;

/**
 * webhook接收事件并提交请求
 * Class IssueSubscriber
 */
class WebhookSubscriber implements EventSubscriberInterface
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
     * @throws \ReflectionException
     */
    public static function getSubscribedEvents()
    {
        $events = new Events();
        $constantsArr = (new \ReflectionClass($events))->getConstants();
        $arr = [];
        foreach ($constantsArr as $constant) {
            $arr[$constant] = $constant;
        }
        // print_r($constantsArr);
        return $arr;

    }

    public $currentFuc = '';

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $this->currentFuc = $method;
        return call_user_func_array([$this, 'post'], $args);
    }


    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function post(CommonPlacedEvent $event)
    {
        if(is_array($event->pluginDataArr)){
            $event->pluginDataArr['project_info'] = null;
        }

        if (isset($event->pluginDataArr['project_id'])) {
            $project = (new ProjectModel())->getById($event->pluginDataArr['project_id']);
            if (!empty($project)) {
                $event->pluginDataArr['project_info'] = $project;
            }
        }
        $currentUserId = UserAuth::getId();
        $currentUserInfo = (new UserModel($currentUserId))->getByUid($currentUserId);
        if (empty($currentUserInfo)) {
            $currentUserInfo = new \stdClass();
        } else {
            $currentUserInfo = UserLogic::format($currentUserInfo);
        }
        $projectInfo = null;
        if(isset($event->pluginDataArr['project_info']) && !empty($event->pluginDataArr['project_info'])){
            $projectArr =  $event->pluginDataArr['project_info'];
            $projectInfo = [];
            $projectInfo['id'] = $projectArr['id'];
            $projectInfo['name'] = $projectArr['name'];
            $projectInfo['description'] = $projectArr['description'];
            list($projectInfo['avatar'], $exist) = ProjectLogic::formatAvatar($projectArr['avatar']);
            $projectInfo['avatar-thum'] = $projectInfo['avatar'];
            if($exist){
                $thumPic = PUBLIC_PATH. 'attachment/project/avatar/'.$projectArr['id'].'-wechat-thum.png';
                $ret =  self::waterZoom(PUBLIC_PATH. 'attachment/' . $projectArr['avatar'],800,455,300,180 ,$thumPic);
                if($ret){
                    $projectInfo['avatar-thum'] = ROOT_URL . 'attachment/project/avatar/'.$projectArr['id'].'-wechat-thum.png'.'?t='.time();
                }
            }
            unset($projectArr, $event->pluginDataArr['project_info']);
        }
        $postData = [];
        $postData['current_user_id'] = $currentUserId;
        $postData['current_user_info'] = $currentUserInfo;
        $postData['project_id'] = $event->pluginDataArr['project_id'] ?? null;
        $postData['project_info'] = $projectInfo;
        $postData['json'] = $event->pluginDataArr;
        $postData['event_name'] = $this->currentFuc;
        $postData['root_url'] = ROOT_URL;
        $model = new WebHookModel();
        $webhooks = $model->getEnableItems();

        //$resArr = $this->multipleThreadsRequest($webhooks, $postData);
        //print_r($resArr);
        foreach ($webhooks as $i => $webhook) {
            $webhook['project_id'] = 0;
            if (isset($event->pluginDataArr['project_id'])) {
                $webhook['project_id'] = (int)$event->pluginDataArr['project_id'];
            }
            $hookEventsArr = json_decode($webhook['hook_event_json'], true);
            if (empty($hookEventsArr)) {
                $hookEventsArr = [];
            }
            if (!in_array($this->currentFuc, $hookEventsArr)) {
                continue;
            }
            $filterProjectArr = json_decode($webhook['filter_project_json'], true);
            if(!in_array('',$filterProjectArr)){
                if($webhook['project_id'] && $filterProjectArr){
                    if(!in_array($webhook['project_id'], $filterProjectArr)){
                        //return [false, '此webhook忽略当前项目的事件'];
                        continue;
                    }
                }
            }
            $postData['secret_token'] = $webhook['secret_token'];
            $postData['timeout'] = $webhook['timeout'];
            $postData['url'] = $webhook['url'];
            $postDataStr = http_build_query($postData);
            $logArr = [];
            $logArr['project_id'] = @$webhook['project_id'];
            $logArr['webhook_id'] = $webhook['id'];
            $logArr['event_name'] = $postData['event_name'];
            $logArr['url'] = $webhook['url'];
            $logArr['data'] = $postDataStr;
            $logArr['status'] = WebHookLogModel::STATUS_READY;
            $logArr['time'] = time();
            $logArr['user_id'] = UserAuth::getId();
            $logArr['err_msg'] = '';
            $webhooklogModel = new WebHookLogModel();
            list($logRet, $logId) = $webhooklogModel->insert($logArr);
            if ($logRet) {
                $postData['log_id'] = (int)$logId;
            } else {
                $postData['log_id'] = 0;
            }
            list($ret, $msg) = $this->requestByMasterlabSocket($webhook, $postData);
            if (!$ret && $logRet) {
                $webhooklogModel->updateById($logId, ['err_msg' => $msg, 'status' => WebHookLogModel::STATUS_ASYNC_FAILED]);
            }
        }
    }


    /**
     * 通过masterlab异步发送webhook请求
     * @param array $webhook
     * @param array $postDataArr
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    private function requestByMasterlabSocket($webhook, $postDataArr)
    {
        $command = 'WebhookHelper.post';
        // 如果是钉钉机器人
        if($webhook['type']=='dingding'){
            $command = 'DingdingMessageHelper.push';
        }
        // 如果是企业微信机器人
        if($webhook['type']=='wechat'){
            $command = 'WechatWorkMessageHelper.push';
        }
        //print_r($pushArr);
        return  MasterlabSocketClient::send($command, $postDataArr);
    }

    /**
     * 更改图片画布大小
     * @static public
     * @param string $source 原文件名
     * @param string $width $height 要生成的图片宽，高
     * @param string $posX $posX 图片添加到画布位置
     * @param string $$savename  修改后的图片名
     * @return bool
     */
    static function waterZoom($source, $width, $height,$posX,$posY, $savename=null) {
        //检查文件是否存在
        if (!file_exists($source)){
            return false;
        }

        $dst_im = @imagecreatefrompng($source);
        $dst_info = @getimagesize($source);

        $im = @imagecreatetruecolor($width, $height);
        $cc = @imagecolorallocate($im,255,255,255);
        imagefill($im, 0, 0, $cc);
        @imagecopy($im, $dst_im, $posX, $posY, 0, 0, $dst_info[0],$dst_info[1]);
        header("Content-type:image/png");
        if (!$savename) {
            $savename = $source;
            @unlink($source);
        }
        imagejpeg($im, $savename);
        imagedestroy($im);
        return true;
    }

}