<?php

namespace main\app\ctrl\admin;

use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\model\issue\IssueModel;
use main\app\model\OrgModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\ConfigLogic;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\ProjectTemplateModel;
use main\app\model\user\UserModel;
use main\app\classes\UploadLogic;
use main\app\model\user\UserSettingModel;

/**
 * 项目列表
 * Class Projects
 * @package main\app\ctrl
 */
class ProjectTpl extends BaseAdminCtrl
{

    /**
     * Projects constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $userId = UserAuth::getId();
        $this->addGVar('top_menu_active', 'project_tpl');
        $check = PermissionGlobal::check($userId, PermissionGlobal::MANAGER_USER_PERM_ID);

        if (!$check) {
            $this->error('权限错误', '您还未获取此模块的权限！');
            exit;
        }
    }

    /**
     * @throws \Exception
     */
    public function pageIndex()
    {
        $userId = UserAuth::getId();

        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project_tpl';

        $outProjectTypeList = [];
        $data['type_list'] = $outProjectTypeList;

        $data['projects'] = ConfigLogic::getJoinProjects();

        $this->render('gitlab/admin/project_tpl/list.twig', $data);
    }

    /**
     * @param int $typeId
     * @throws \Exception
     */
    public function fetchAll()
    {
        $projectTplModel = new ProjectTemplateModel();
        $projectTpls = $projectTplModel->getAllItems();
        $data['project_tpls'] = $projectTpls;

        $this->ajaxSuccess('success', $data);
    }

    /**
     * 项目的上传文件接口
     * @throws \Exception
     */
    public function upload()
    {
        $uuid = '';
        if (isset($_POST['qquuid'])) {
            $uuid = $_POST['qquuid'];
        }

        $originName = '';
        if (isset($_POST['qqfilename'])) {
            $originName = $_POST['qqfilename'];
        }

        $fileSize = 0;
        if (isset($_POST['qqtotalfilesize'])) {
            $fileSize = (int)$_POST['qqtotalfilesize'];
        }

        $uploadLogic = new UploadLogic();
        $ret = $uploadLogic->move('qqfile', 'project_image', $uuid, $originName, $fileSize);
        header('Content-type: application/json; charset=UTF-8');

        $resp = [];
        if ($ret['error'] == 0) {
            $resp['success'] = true;
            $resp['error'] = '';
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
            $resp['relate_path'] = $ret['relate_path'];
        } else {
            $resp['success'] = false;
            $resp['error'] = $ret['message'];
            $resp['error_code'] = $ret['error'];
            $resp['url'] = $ret['url'];
            $resp['filename'] = $ret['filename'];
        }
        echo json_encode($resp);
        exit;
    }


    public function test()
    {
        echo (new SettingsLogic)->dateTimezone();
    }


    /**
     * 初始化项目角色
     * @throws \Exception
     */
    public function initRole()
    {
        $ret = [];
        $projectArr = (new ProjectModel())->getAll(false);
        foreach ($projectArr as $item) {
            $ret[] = ProjectLogic::initRole($item['id']);
        }
        $this->ajaxSuccess('ok', $ret);
    }
}
