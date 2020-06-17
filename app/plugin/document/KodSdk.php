<?php

namespace main\app\plugin\document;

use main\app\plugin\BasePluginSubscriber;
use main\app\event\PluginPlacedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * 插件事件类
 * Class ActivityPlugin
 */
class KodSdk
{

    public $subscribersArr = [];

    /**
     * KodSdk constructor.
     */
    public function __construct()
    {
        require_once realpath(__DIR__) . '/kod/config/setting_user.php';
    }

    /**
     * @param $user
     * @return string
     */
    public function getAutoLoginUrl($user)
    {
        $loginToken = base64_encode($user) . '|' . md5($user . $GLOBALS['config']['settings']['apiLoginTonken']);
        $url = sprintf(ROOT_URL . "kod_index.php?user/loginSubmit&login_token=%s", $loginToken);
        return $url;
    }

    /**
     * 通过用户名获取AccessToke
     * @param $user
     * @return array
     */
    public function getAccessToken($user)
    {
        $loginToken = base64_encode($user) . '|' . md5($user . $GLOBALS['config']['settings']['apiLoginTonken']);
        $url = sprintf(ROOT_URL . "kod_index.php?user/loginSubmit&isAjax=1&getToken=1&login_token=%s", $loginToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode(); // 200
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "获取kod access token 失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }

    /**
    name:demo1                  //用户账号
    password:123456             //用户密码
    sizeMax:2                   //用户空间大小设置
    role:2                      //用户角色id
    groupInfo:{"1":"write"}     //用户所在部门及在部门对应的权限
    ----
    homePath:"D:/"              //可选；自定义指定用户的根目录;
     * @return array
     */
    public function createUser($dataArr, $accessToken)
    {
        $url = sprintf(ROOT_URL . "systemMember/add?accessToken=".$accessToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url,['form_params' => $dataArr]);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "获取kod access token 失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }



}