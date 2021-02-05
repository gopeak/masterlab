<?php


namespace main\app\api;


use main\app\classes\JWTLogic;
use main\app\classes\UserAuth;
use main\app\model\SettingModel;
use main\app\model\user\UserModel;

class Auth extends BaseApi
{

    /**
     * @return array
     * @throws \Exception
     */
    public function index()
    {
        if ($this->requestMethod != 'get') {
            return self::returnHandler('请求失败', [], Constants::HTTP_BAD_REQUEST);
        }
        if (!isset($_GET['app_key']) || !isset($_GET['app_secret'])) {
            return self::returnHandler('请求失败,请提供app_key和app_secret参数', [], Constants::HTTP_BAD_REQUEST);
        }
        $reqAppKey = $_GET['app_key'];
        $reqAppSecret = $_GET['app_secret'];
        $settingModel = new SettingModel();
        $enable_api = $settingModel->getSettingValue('enable_api');
        if (empty($enable_api)) {
            return self::returnHandler('请求失败,API功能未启用，请在后台管理页面启用', [], Constants::HTTP_BAD_REQUEST);
        }
        $appKey = $settingModel->getSettingValue('app_key');
        $appSecret = $settingModel->getSettingValue('app_secret');
        if (empty($appKey) || empty($appSecret)) {
            return self::returnHandler('请求失败,请在后台的API页面设置app_key和app_secret参数', [], Constants::HTTP_BAD_REQUEST);
        }
        if ($appKey != $reqAppKey || $appSecret != $reqAppSecret) {
            return self::returnHandler('请求失败,app_key和app_secret参数错误', [], Constants::HTTP_BAD_REQUEST);
        }
        $account = 'master';
        $userModel = new UserModel();
        $user = $userModel->getByUsername($account);
        if (empty($user)) {
            return self::returnHandler('授权失败,管理员账号master缺失请联系管理员', [], Constants::HTTP_BAD_REQUEST);
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
            //self::echoJson($parserTokenArr['msg'], [], Constants::HTTP_AUTH_FAIL);
            throw new \Exception($parserTokenArr['msg'], Constants::HTTP_AUTH_FAIL);
        }

        if ($parserTokenArr['code'] == JWTLogic::PARSER_STATUS_EXPIRED) {
            // 前端识别到EXPIRED，调用refresh_token
            throw new \Exception(JWTLogic::PARSER_STATUS_EXPIRED, Constants::HTTP_AUTH_FAIL);
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
