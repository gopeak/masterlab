<?php

namespace main\app\plugin\webhook\event;

use main\app\event\CommonPlacedEvent;
use main\app\plugin\webhook\model\WebHookModel;
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

    public function __call($method, $args) {
        $this->currentFuc = $method;
        return call_user_func_array([$this, 'post'], $args);
    }


    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function post(CommonPlacedEvent $event)
    {
        $postData = [];
        $postData['json'] = json_encode($event->pluginDataArr);
        $postData['event_name'] = $this->currentFuc;
        $model = new WebHookModel();
        $webhooks = $model->getEnableItems();

        //$resArr = $this->multipleThreadsRequest($webhooks, $postData);
        //print_r($resArr);
        foreach ($webhooks as $i => $webhook) {
            $url = $webhook['url'];
            $postData['secret_token'] = $webhook['secret_token'];
            $this->fsockopenPost($url, $postData,(int)$webhook['timeout']);
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
        if(!isset($urlInfo["port"])){
            $urlInfo["port"] = 80;
        }
        $fp = fsockopen($urlInfo["host"], $urlInfo["port"], $errno, $errStr, $timeout);
        $content = http_build_query($data);
        fwrite($fp, "POST ".$urlInfo["path"]." HTTP/1.1\r\n");
        fwrite($fp, "Host: ".$urlInfo["host"]."\r\n");
        fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
        fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
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


}