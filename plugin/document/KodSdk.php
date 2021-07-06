<?php

namespace main\plugin\document;

use main\plugin\BasePluginSubscriber;
use main\app\event\PluginPlacedEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * 插件事件类
 * Class ActivityPlugin
 */
class KodSdk
{

    public $rootUrl = ROOT_URL . "kod_index.php";

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
        $url = sprintf($this->rootUrl . "?user/loginSubmit&login_token=%s", $loginToken);
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
        $url = sprintf($this->rootUrl  . "?user/loginSubmit&isAjax=1&getToken=1&login_token=%s", $loginToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        //echo $response->getBody();
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
        $url = sprintf($this->rootUrl . "?systemMember/add&accessToken=".$accessToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url,['form_params' => $dataArr]);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (is_null($bodyArr) || !$bodyArr['code']) {
            return [false, "创建用户失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }

    /**
     * @param $userName
     * @param $accessToken
     * @return array
     */
    public function getUser($userName, $accessToken)
    {
        $url = sprintf($this->rootUrl . "?systemMember/getByName&name={$userName}&accessToken=".$accessToken);
        $client = new \GuzzleHttp\Client();
        $dataArr['name'] = $userName;
        $response = $client->request('POST', $url,['form_params' => $dataArr]);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "获取用户{$userName}信息失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }

    /**
     * @param $userId
     * @param $accessToken
     * @return array
     */
    public function deleteUser($userId, $accessToken)
    {
        $url = sprintf($this->rootUrl . '?systemMember/doAction&accessToken='.$accessToken);
        $client = new \GuzzleHttp\Client();
        $dataArr['action'] = 'del';
        $dataArr['userID'] = json_encode([$userId]);
        $response = $client->request('POST', $url,['form_params' => $dataArr]);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "删除用户失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }


    /**
     * @param $accessToken
     * @return array
     */
    public function getUsers($accessToken)
    {
        $url = sprintf($this->rootUrl . "?systemMember/get&accessToken=".$accessToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "获取用户列表失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }

    public function getRoles($accessToken)
    {
        $url = sprintf($this->rootUrl . "?systemRole/get&accessToken=".$accessToken);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            return [false, 'response status:' . $statusCode];
        }
        $bodyArr = json_decode($response->getBody(), true);
        if (!$bodyArr['code']) {
            return [false, "获取角色列表失败\r\n" . $response->getBody()];
        }
        return [true, $bodyArr['data']];
    }


}