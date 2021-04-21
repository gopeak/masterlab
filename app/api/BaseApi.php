<?php

namespace main\app\api;

use framework\protocol\Api;
use main\app\classes\B2bcrypt;
use main\app\classes\Sign;
use main\app\model\SettingModel;
use main\app\model\user\UserModel;
use main\app\protocol\OpenApi;
use main\lib\phpcurl\Curl;

/**
 * api 基类， 提供对外接口的接入操作
 *
 * @author jesen
 *
 */
class BaseApi
{

    /**
     * 允许的请求方式
     * */
    protected static $method_type = array('get', 'post', 'put', 'patch', 'delete');

    protected $requestMethod = null;
    protected $masterUid = 0;
    protected $masterAccount = 'api_master';

    /**
     * BaseApi constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $settingModel = new SettingModel();
        $enableApi = $settingModel->getSettingValue('enable_api');
        if(!$enableApi){
            throw new \Exception('请求失败,Api调用已经禁用', Constants::HTTP_BAD_REQUEST);
        }
        $apiIpAddr = $settingModel->getSettingValue('api_ip_addr');
        if(!empty($apiIpAddr) && trimStr($apiIpAddr)!=''){
            $apiIpAddrArr = explode(';', $apiIpAddr);
            $remoteIp = getIp();
            if(!in_array($remoteIp, $apiIpAddrArr)){
                throw new \Exception('请求失败,IP地址受限', Constants::HTTP_BAD_REQUEST);
            }
        }
        $this->requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $userModel = new UserModel();
        $user = $userModel->getByUsername('master');
        $this->masterUid = $user['uid'];
    }

    /**
     * @param string $msg
     * @param array $body
     * @param int $code
     * @return array
     */
    protected static function returnHandler($msg = '', $body = [], $code = Constants::HTTP_OK)
    {
        $ret = [];
        $ret['msg'] = $msg;
        $ret['code'] = $code;
        $ret['body'] = $body;

        return $ret;
    }

    /**
     * 直接输出restful结果
     * @param string $msg
     * @param array $data
     * @param int $code
     */
    protected static function echoJson($msg = '', $data = [], $code = Constants::HTTP_OK)
    {
        $data = self::returnHandler($msg, $data, $code);
        $apiProtocol = new OpenApi();
        $apiProtocol->builder('200', $data);
        $jsonStr = $apiProtocol->getResponse();
        echo $jsonStr;
        exit;
    }


    /**
     * 模拟PATCH请求方法
     * @return array
     */
    protected static function _PATCH()
    {
        $reqDataArr = [];
        $reqData = file_get_contents('php://input');
        parse_str($reqData, $reqDataArr);
        return $reqDataArr;
    }

    /**
     * @throws \Exception
     */
    protected function validateRestfulHandler()
    {
        foreach (self::$method_type as $method) {
            if (!method_exists($this, $method . 'Handler')) {
                throw new \Exception('Restful '. $method . 'Handler not exists', 500);
            }
        }
    }

}

