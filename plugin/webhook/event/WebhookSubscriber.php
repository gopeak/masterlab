<?php

namespace main\plugin\webhook\event;

use main\app\classes\MasterlabSocketClient;
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

        $postData = [];
        $postData['current_user_id'] = $currentUserId;
        $postData['current_user_info'] = json_encode($currentUserInfo);
        $postData['json'] = is_array($event->pluginDataArr) ? json_encode($event->pluginDataArr) :strval($event->pluginDataArr);
        $postData['event_name'] = $this->currentFuc;
        $model = new WebHookModel();
        $webhooks = $model->getEnableItems();

        //$resArr = $this->multipleThreadsRequest($webhooks, $postData);
        //print_r($resArr);
        foreach ($webhooks as $i => $webhook) {
            $url = $webhook['url'];
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
            $postData['secret_token'] = $webhook['secret_token'];
            $this->requestByMasterlabSocket($webhook, $postData);
            //$this->fsockopenPost($url, $postData, (int)$webhook['timeout']);
        }
    }


    /**
     * 通过fsockopenPost方式请求
     * @param $url
     * @param $data
     * @param $timeout
     * @return string
     */
    private function fsockopenPost($url, $data, $timeout)
    {
        $urlInfo = parse_url($url);
        if (!isset($urlInfo["port"])) {
            $urlInfo["port"] = 80;
        }
        $fp = fsockopen($urlInfo["host"], $urlInfo["port"], $errno, $errStr, $timeout);
        $content = http_build_query($data);
        fwrite($fp, "POST " . $urlInfo["path"] . " HTTP/1.1\r\n");
        fwrite($fp, "Host: " . $urlInfo["host"] . "\r\n");
        fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
        fwrite($fp, "Content-Length: " . strlen($content) . "\r\n");
        fwrite($fp, "Connection: close\r\n");
        fwrite($fp, "\r\n");
        fwrite($fp, $content);
        $result = "";
        //while (!feof($fp)) {
        //$result .= fgets($fp, 1024);
        //}
        fclose($fp);
        return $result;
    }


    /**
     * 通过curl
     */
    private function multipleThreadsRequest($webhooks, $postData)
    {
        // print_r($webhooks);
        $mh = curl_multi_init();
        $curl_array = array();
        foreach ($webhooks as $i => $webhook) {
            $url = $webhook['url'];
            $hookEventsArr = json_decode($webhook['hook_event_json'], true);
            if (empty($hookEventsArr)) {
                $hookEventsArr = [];
            }
            if (!in_array($this->currentFuc, $hookEventsArr)) {
                continue;
            }
            $postData['secret_token'] = $webhook['secret_token'];
            $curl_array[$i] = curl_init($url);
            curl_setopt($curl_array[$i], CURLOPT_POST, 1);
            curl_setopt($curl_array[$i], CURLOPT_POSTFIELDS, $postData);
            curl_setopt($curl_array[$i], CURLOPT_TIMEOUT, (int)$webhook['timeout']);
            curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh, $curl_array[$i]);
        }
        $running = NULL;
        do {
            usleep(10000);
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = array();
        foreach ($webhooks as $i => $webhook) {
            $url = $webhook['url'];
            $res[$url] = curl_multi_getcontent($curl_array[$i]);
        }

        foreach ($webhooks as $i => $webhook) {
            curl_multi_remove_handle($mh, $curl_array[$i]);
        }
        curl_multi_close($mh);
        return $res;
    }

    /**
     * @param $url
     * @param $data
     * @param $timeout
     * @throws \Exception
     */
    private function requestByRedis($url, $data, $timeout)
    {
        $issueModel = new IssueModel();
        $issueModel->cache->connect();
        if (!$issueModel->cache) {
            return;
        }
        $pushArr = [];
        $pushArr['url'] = $url;
        $pushArr['data'] = $data;
        $pushArr['timeout'] = $timeout;
        $key = 'webhook';
        $ret = $issueModel->cache->redis->rPush($key, $pushArr);
        //var_dump($ret);

    }

    /**
     * 通过masterlab异步发送webhook请求
     * @param array $webhook
     * @param array $dataArr
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    private function requestByMasterlabSocket($webhook, $dataArr)
    {
        $dataStr = http_build_query($dataArr);
        $pushArr = [];
        $pushArr['project_id'] = $webhook['project_id'];
        $pushArr['webhook_id'] = $webhook['id'];
        $pushArr['event_name'] = $dataArr['event_name'];
        $pushArr['url'] = $webhook['url'];
        $pushArr['data'] = $dataStr;
        $pushArr['status'] = WebHookLogModel::STATUS_READY;
        $pushArr['time'] = time();
        $pushArr['user_id'] = UserAuth::getId();
        $pushArr['err_msg'] = '';

        // 0准备;1执行成功;2队列中;3出队列后执行失败
        $webhooklogModel = new WebHookLogModel();
        list($logRet, $logId) = $webhooklogModel->insert($pushArr);
        if ($logRet) {
            $pushArr['log_id'] = (int)$logId;
        } else {
            $pushArr['log_id'] = 0;
        }

        list($ret, $msg) = MasterlabSocketClient::send("WebhookPost", $pushArr);
        if (!$ret && $logRet) {
            $webhooklogModel->updateById($logId, ['err_msg' => $msg, 'status' => WebHookLogModel::STATUS_ASYNC_FAILED]);
        }
        return [$ret, $msg];
    }

    /**
     * @param $webhook
     * @param $dataArr
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    private function requestByGuzzleHttp($webhook, $dataArr)
    {
        $dataStr = http_build_query($dataArr);
        $pushArr = [];
        $pushArr['project_id'] = $webhook['project_id'];
        $pushArr['webhook_id'] = $webhook['id'];
        $pushArr['event_name'] = $dataArr['event_name'];
        $pushArr['url'] = $webhook['url'];
        $pushArr['data'] = $dataStr;
        $pushArr['status'] = WebHookLogModel::STATUS_READY;
        $pushArr['time'] = time();
        $pushArr['user_id'] = UserAuth::getId();
        $pushArr['err_msg'] = '';

        // 0准备;1执行成功;2队列中;3出队列后执行失败
        $webhooklogModel = new WebHookLogModel();
        list($logRet, $logId) = $webhooklogModel->insert($pushArr);
        if ($logRet) {
            $pushArr['log_id'] = (int)$logId;
        } else {
            $pushArr['log_id'] = 0;
        }

        $client = new \GuzzleHttp\Client();
        // Send an asynchronous request.
        $response = $client->post($pushArr['url'], ['form_params' => $dataArr]);
        $statusCode = $response->getStatusCode(); // 200
        $webhooklogModel = new WebHookLogModel();
        if ($statusCode == 200) {
            $webhooklogModel->updateById($logId, ['err_msg' => '', 'status' => WebHookLogModel::STATUS_SUCCESS]);
        }else{
            $body = $response->getBody();
            $webhooklogModel->updateById($logId, ['err_msg' => 'Response status code:'.$statusCode." \r\n".$body, 'status' => WebHookLogModel::STATUS_FAILED]);
        }

        return [true, '异步执行'];
    }

}