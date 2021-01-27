<?php

namespace main\plugin\document;

use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\model\PluginModel;
use main\app\model\user\UserModel;
use main\plugin\BasePluginCtrl;
use main\lib\FileUtil;

/**
 *
 *   插件的入口类
 * @package main\app\ctrl\project
 */
class Index extends BasePluginCtrl
{

    public $pluginInfo = [];

    public $dirName = '';

    public $pluginMethod = 'pageIndex';

    public function __construct()
    {
        parent::__construct();

        // 当前插件目录名
        $this->dirName = basename(pathinfo(__FILE__)['dirname']);

        // 当前插件的配置信息
        $pluginModel = new PluginModel();
        $this->pluginInfo = $pluginModel->getByName($this->dirName);

        $pluginMethod = isset($_GET['_target'][3])? $_GET['_target'][3] :'';
        if($pluginMethod=="/" || $pluginMethod=="\\" || $pluginMethod==''){
            $pluginMethod = "pageIndex";
        }
        if(method_exists($this,$pluginMethod)){
            $this->pluginMethod = $pluginMethod;
            $this->$pluginMethod();
        }
    }

    /**
     * 插件首页方法
     * @throws \Exception
     */
    public function pageIndex()
    {
        $data = [];
        $data['title'] = '文档管理';
        $data['nav_links_active'] = 'plugin';
        $data['sub_nav_active'] = 'plugin';
        $data['plugin_name'] = $this->dirName;
        $data['nav_links_active'] = 'document';
        $data = RewriteUrl::setProjectData($data);
        $data['current_user'] = $user  = UserModel::getInstance()->getByUid(UserAuth::getId());

        if(!$data['project_id']){
            echo '获取项目id失败';
            return;
        }

        $docAdmin = 'admin';
        $docPassword = 'admin';
        $kodSdk = new KodSdk();
        list($ret, $accessToken) =  $kodSdk->getAccessToken($docAdmin);
        if(!$ret){
            echo '文档模块集成失败, 请尝试给 plugin/document/kod 目录及子目录赋予读写权限';
            return;
        }
        list($ret, $kodUsers) = $kodSdk->getUsers($accessToken);
        if(!$ret){
            echo '文档模块获取用户信息失败,请联系管理员';
            return;
        }
        list($ret, $kodRoles) = $kodSdk->getRoles($accessToken);
        if(!$ret){
            echo '文档模块获取角色信息失败,请联系管理员';
            return;
        }
        $expectProjectDocUsername = 'project'.$data['project_id'];
        $actUserArr = null;
        foreach ($kodUsers as $kodUser) {
            if($kodUser['name']== $expectProjectDocUsername){
                $actUserArr = $kodUser;
            }
        }
        if(empty($actUserArr) ){
            if(count($kodUsers)>15){
                echo '文档模块获取用户信息失败,请联系管理员';
                return;
            }
            $dataArr = [];
            $dataArr['name'] = $expectProjectDocUsername;
            $dataArr['password'] = md5($expectProjectDocUsername);
            $dataArr['sizeMax'] = 5;
            $dataArr['role'] = 2;
            $dataArr['groupInfo'] = json_encode(['1'=>'write']);
            //$homePath = STORAGE_PATH.'document/'.$expectProjectDocUsername;
            //@mkdir($homePath);
            //$dataArr['homePath'] = $homePath;
            list($ret, $msg) = $kodSdk->createUser($dataArr, $accessToken);
            if(!$ret){
                echo '文档模块创建用户信息失败,请联系管理员';
                return;
            }
            list($ret, $userArr) = $kodSdk->getUser($expectProjectDocUsername, $accessToken);
            $userPath = $expectProjectDocUsername;
            if($ret && isset($userArr['path']) && !empty($userArr['path'])){
                $userPath = $userArr['path'];
            }
            $originPath = PRE_APP_PATH.'plugin/document/kod/data/User/'.$expectProjectDocUsername;
            $projectPath = PRE_APP_PATH.'plugin/document/kod/data/User/'.$userPath;
            if(!file_exists($projectPath) && !file_exists($projectPath.'/data') ){
                if(!file_exists($originPath)){
                    FileUtil::copyDir(PRE_APP_PATH.'plugin/document/kod/data/User/project0',  $projectPath);
                }
            }
            if(file_exists($originPath)){
                FileUtil::copyDir($originPath,  $projectPath);
            }

        }
        //base64Encode('admin')+'|'+md5('admin'+'aabbcckod')
        require_once realpath(__DIR__) . '/kod/config/setting_user.php';
        $loginToken = base64_encode($expectProjectDocUsername).'|'.md5($expectProjectDocUsername.$GLOBALS['config']['settings']['apiLoginTonken']);
        $iframeUrl = sprintf(ROOT_URL."kod_index.php?user/loginSubmit&login_token=%s", $loginToken);
        $data['iframe_url'] = $iframeUrl;
        $this->twigRender('index.twig', $data);
        //header("location:/kod_index.php?user/login&kod=1");
        //require_once realpath(__DIR__).'/kod/index.php';
        //$this->phpRender('index.php', $data);
        // create database mastererp  character set ‘utf8’ collate ‘utf8_general_ci’;
    }


}
