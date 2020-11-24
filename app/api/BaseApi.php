<?php

namespace main\app\api;

use framework\protocol\Api;
use main\app\classes\B2bcrypt;
use main\app\classes\Sign;
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
     * 参数处理
     */
    public function __construct()
    {
        $this->requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $userModel = new UserModel();
        $user = $userModel->getByUsername('master');
        $this->masterUid = $user['uid'];
    }

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

    protected function validateRestfulHandler()
    {
        foreach (self::$method_type as $method) {
            if (!method_exists($this, $method . 'Handler')) {
                throw new \Exception('Restful '. $method . 'Handler not exists', 500);
            }
        }
    }

}

