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
            return self::returnHandler('授权失败.');
        }
        $account = $_GET['account'];
        $password = $_GET['password'];
        $accountId = 0;

        if ($account != 'api_master' || $password != 'testtest') {
            return self::returnHandler('授权失败. 账号&密码错误');
        }

        $jwt = JWTLogic::getInstance();
        $accessToken = $jwt->publish($accountId, $account);
        $accessToken = strval($accessToken);
        // var_dump($accessToken);
        return self::returnHandler('授权成功' .$accessToken, [
            'account' => $account,
            'api_access_token' => $accessToken,
        ]);
    }

    public function index2()
    {
        if ($this->requestMethod != 'get') {
            return self::returnHandler('授权失败.');
        }
        $account = $_GET['account'];
        $password = $_GET['password'];
        $userAuth = UserAuth::getInstance();
        list($ret, $user) = $userAuth->checkLoginByUsername($account, $password);
        if ($ret != UserModel::LOGIN_CODE_OK) {
            return self::returnHandler('授权失败. 账号&密码错误');
        }

        // $accessToken = base64_encode($account) . '@' . md5($account . $key);

        $jwt = JWTLogic::getInstance();
        $accessToken = $jwt->publish($user['uid'], $account);
        $accessToken = strval($accessToken);
        // var_dump($accessToken);
        return self::returnHandler('授权成功' .$accessToken, [
            'account' => $account,
            'api_access_token' => $accessToken,
        ]);
    }

}