<?php

namespace main\app\plugin;

use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\RewriteUrl;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
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

    public function __construct()
    {
        parent::__construct();

        // 载入插件配置
    }

    /**
     * @param $tpl
     * @param array $dataArr
     * @param bool $partial
     * @throws \Exception
     */
    public function myRender($tpl, $dataArr = [], $partial = false)
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

    public function pageIndex()
    {

    }


}
