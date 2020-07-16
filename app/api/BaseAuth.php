<?php


namespace main\app\api;


use main\app\classes\JWTLogic;

class BaseAuth extends BaseApi
{
    protected $authUserId = null;
    protected $authAccount = null;

    public function __construct()
    {
        parent::__construct();

        if (!isset($_GET['access_token']) || empty($_GET['access_token'])) {
            return self::returnHandler('缺少参数.');
        }
        $accessToken = $_GET['access_token'];
        $jwt = JWTLogic::getInstance();
        $parserTokenArr = $jwt->parser($accessToken);

        if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_INVALID || $parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXCEPTION) {
            return self::returnHandler($parserTokenArr['msg']);
        }

        if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXPIRED) {
            // 前端识别到EXPIRED，调用refresh_token
            return self::returnHandler(JWTLogic::PARSER_STATUS_EXPIRED);
        }

        $this->authUserId = $parserTokenArr['uid'];
        $this->authAccount = $parserTokenArr['account'];
    }
}