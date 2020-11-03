<?php


namespace main\app\api;


use main\app\classes\JWTLogic;
use main\app\classes\UserAuth;
use main\app\model\user\UserModel;

class Auth extends BaseApi
{
    public function index()
    {
        if ($this->requestMethod != 'get') {
            return self::returnHandler('请求失败', [], Constants::HTTP_BAD_REQUEST);
        }
        $account = $_GET['account'];
        $password = $_GET['password'];
        $accountId = 0;

        if ($account != 'master') {
            return self::returnHandler('只允许master账号登录', [], Constants::HTTP_BAD_REQUEST);
        }

        $userAuth = UserAuth::getInstance();
        list($ret, $user) = $userAuth->checkLoginByUsername($account, $password);
        if ($ret != UserModel::LOGIN_CODE_OK) {
            return self::returnHandler('授权失败. 账号&密码错误', [], Constants::HTTP_BAD_REQUEST);
        }

        $accountId = $user['uid'];

        $jwt = JWTLogic::getInstance();
        $accessToken = $jwt->publish($accountId, $account);
        $accessToken = strval($accessToken);
        $accessRefreshToken = $jwt->publishRefreshToken($accountId, $account);
        $accessRefreshToken = strval($accessRefreshToken);
        // var_dump($accessToken);
        return self::returnHandler('授权成功', [
            'account' => $account,
            'api_access_token' => $accessToken,
            'api_access_refresh_token' => $accessRefreshToken,
        ]);
    }

    public function refreshToken()
    {
        if ($this->requestMethod != 'get') {
            return self::returnHandler('请求失败', [], Constants::HTTP_BAD_REQUEST);
        }
        $accessRefreshToken = trim($_GET['access_refresh_token']);

        $jwt = JWTLogic::getInstance();
        $parserTokenArr = $jwt->parser($accessRefreshToken);

        if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_INVALID
            || $parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXCEPTION) {
            self::echoJson($parserTokenArr['msg'], [], Constants::HTTP_AUTH_FAIL);
        }

        if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXPIRED) {
            // 前端识别到EXPIRED，调用refresh_token
            self::echoJson(JWTLogic::PARSER_STATUS_EXPIRED, [], Constants::HTTP_AUTH_FAIL);
        }

        $accountId = $parserTokenArr['uid'];
        $account = $parserTokenArr['account'];
        $accessToken = $jwt->publish($accountId, $account);
        $accessToken = strval($accessToken);
        $accessRefreshToken = $jwt->publishRefreshToken($accountId, $account);
        $accessRefreshToken = strval($accessRefreshToken);
        return self::returnHandler('token刷新成功', [
            'account' => $account,
            'api_access_token' => $accessToken,
            'api_access_refresh_token' => $accessRefreshToken,
        ]);
    }
}
