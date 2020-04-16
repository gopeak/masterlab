<?php

namespace main\app\plugin;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\DbModel;
use main\app\model\PluginModel;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\ActivityModel;
use main\app\model\user\UserModel;

/**
 *
 *  插件的控制器基类
 * @package main\app\ctrl\project
 */
class BasePluginCtrl extends BaseUserCtrl
{

    public $pluginInfo = [];

    public $dirName = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $tpl
     * @param array $dataArr
     * @param bool $partial
     * @throws \Exception
     */
    public function phpRender($tpl, $dataArr = [], $partial = false)
    {
        $this->initCSRF();
        // 向视图传入通用的变量
        $this->addGVar('_GET', $_GET);
        $this->addGVar('site_url', ROOT_URL);
        $this->addGVar('attachment_url', ATTACHMENT_URL);
        $this->addGVar('_version', MASTERLAB_VERSION);
        $this->addGVar('csrf_token', $this->csrfToken);
        $user = [];
        $curUid = UserAuth::getInstance()->getId();
        if ($curUid) {
            $user = UserModel::getInstance($curUid)->getUser();
            $user = UserLogic::format($user);
        }
        $this->addGVar('user', $user);

        $dataArr = array_merge(self::$gTplVars, $dataArr);
        ob_start();
        ob_implicit_flush(false);
        extract($dataArr, EXTR_PREFIX_SAME, 'tpl_');

        require_once PLUGIN_PATH .'activity/view/'. $tpl;

        echo ob_get_clean();
    }

    /**
     * @param $tpl
     * @param array $dataArr
     * @param bool $partial
     * @throws \Exception
     */
    public function twigRender($tpl, $dataArr = [], $partial = false)
    {
        $this->initCSRF();
        // 向视图传入通用的变量
        $this->addGVar('_GET', $_GET);
        $this->addGVar('site_url', ROOT_URL);
        $this->addGVar('attachment_url', ATTACHMENT_URL);
        $this->addGVar('_version', MASTERLAB_VERSION);
        $this->addGVar('app_name', SITE_NAME);
        $this->addGVar('csrf_token', $this->csrfToken);

        //  加载管理插件
        $model = new PluginModel();
        $pluginArr = $model->getRows('*');
        $this->addGVar('_pluginArr', $pluginArr);
        $this->addGVar('_plugin_admin_type', PluginModel::TYPE_ADMIN);

        $user = [];
        $curUid = UserAuth::getInstance()->getId();
        if ($curUid) {
            $user = UserModel::getInstance($curUid)->getUser();
            $user = UserLogic::format($user);
        }
        $this->addGVar('user', $user);

        $dataArr = array_merge(self::$gTplVars, $dataArr);
        ob_start();
        ob_implicit_flush(false);
        extract($dataArr, EXTR_PREFIX_SAME, 'tpl_');

        $pluginName = $this->dirName;

        $twigLoader = new \Twig\Loader\FilesystemLoader([PLUGIN_PATH .$pluginName.'/view', VIEW_PATH]);
        $debug =  XPHP_DEBUG ? true : false;
        $twigTpl = new \Twig\Environment($twigLoader, [
            'debug' => $debug
        ]);
        if($debug){
            $twigTpl->addExtension(new \Twig\Extension\DebugExtension());
        }


        echo $twigTpl->render($tpl, $dataArr);
        echo ob_get_clean();
    }

    public function pageIndex()
    {

    }


}
