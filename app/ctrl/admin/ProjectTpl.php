<?php

namespace main\app\ctrl\admin;

use Doctrine\Common\Inflector\Inflector;
use main\app\classes\PermissionGlobal;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\ctrl\BaseCtrl;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueUiSchemeModel;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\OrgModel;
use main\app\model\PluginModel;
use main\app\model\project\ProjectModel;
use main\app\classes\UserLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\ConfigLogic;
use main\app\model\project\ProjectUserRoleModel;
use main\app\model\ProjectTemplateDisplayCategoryModel;
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

    public static  $defaultSubSystem = [
        'issue'=>['title'=>'事项','fix'=>true,'color'=>'blue','is_system'=>'1'],
        'gantt'=>['title'=>'甘特图','fix'=>false,'color'=>'red','is_system'=>'1'],
        'mind'=>['title'=>'事项分解','fix'=>false,'color'=>'gray','is_system'=>'1'],
        'backlog'=>['title'=>'待办事项','fix'=>false,'color'=>'gray','is_system'=>'1'],
        'sprint'=>['title'=>'冲刺','fix'=>false,'color'=>'red','is_system'=>'1'],
        'kanban'=>['title'=>'看板','fix'=>false,'color'=>'blue','is_system'=>'1'],
        'chart'=>['title'=>'图表','fix'=>false,'color'=>'blue','is_system'=>'1'],
        'stat'=>['title'=>'统计','fix'=>false,'color'=>'blue','is_system'=>'1'],

    ];

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
        $data['title'] = '项目模板';
        $data['nav_links_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['category_id'] = isset($_GET['category_id']) ? $_GET['category_id'] :'';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $data['category_arr'] = $categoryModel->getAllItems();
        $data['projects'] = ConfigLogic::getJoinProjects();
        $this->render('gitlab/admin/project_tpl/index.twig', $data);
    }

    /**
     * @throws \Exception
     */
    public function get()
    {
        $data = [];
        $data['id'] = isset($_GET['id']) ? $_GET['id'] :'';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        if($tpl){
            $tpl['subsystem_json'] = json_decode($tpl['subsystem_json'], true);
        }
        $data['tpl'] = $tpl;
        $data['category_arr'] = $categoryModel->getAllItems();

        $this->ajaxSuccess('success', $data);
    }

    /**
     * @throws \Exception
     */
    public function pageEdit()
    {
        $data = [];
        $data['title'] = '项目';
        $data['nav_links_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['id'] = isset($_GET['id']) ? $_GET['id'] :'';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        if($tpl){
            $tpl['subsystem_json'] = json_decode($tpl['subsystem_json'], true);
        }
        $data['tpl'] = $tpl;
        $data['action'] = 'update';
        $data['category_arr'] = $categoryModel->getAllItems();

        $subSystemArr = self::$defaultSubSystem;
        $model = new PluginModel();
        $pluginArr = $model->getEnableItem();
        foreach ($pluginArr as $item) {
            $subSystemArr[$item['name']] = $item;
        }
        $noSubSystemArr = [];
        $addedSubSystemArr = [];
        foreach ($tpl['subsystem_json'] as $subsystem) {
            if(isset($subSystemArr[$subsystem])){
                $subSystemArr[$subsystem]['name'] = $subsystem;
                $addedSubSystemArr[$subsystem] = $subSystemArr[$subsystem];
                unset($subSystemArr[$subsystem]);
            }
        }

        $data['no_subsystem'] = $subSystemArr;
        $data['added_subsystem'] = $addedSubSystemArr;

        // 工作流方案
        $data['workflowSchemesArr'] = WorkflowSchemeModel::getInstance()->getAllItems(false);
        // 事项类型方案
        $data['issueTypeSchemesArr'] = (new IssueTypeSchemeModel())->getAllItems(false);
        // 事项表单配置方案
        $data['issueUiSchemesArr'] = (new IssueUiSchemeModel())->getAllItems(false);

        $this->render('gitlab/admin/project_tpl/form.twig', $data);
    }

    public function pageDetail()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['id'] = isset($_GET['id']) ? $_GET['id'] :'';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        $data['tpl'] = $tpl;
        $data['action'] = 'update';
        $data['category_arr'] = $categoryModel->getAllItems();
        $this->render('gitlab/admin/project_tpl/detail.twig', $data);
    }

    public function pageCopy()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['id'] = isset($_GET['id']) ? $_GET['id'] :'';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        $data['tpl'] = $tpl;
        $data['action'] = 'add';
        $data['category_arr'] = $categoryModel->getAllItems();
        $this->render('gitlab/admin/project_tpl/form.twig', $data);
    }


    /**
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function add()
    {
        if (empty($_POST)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $_POST['name'] = trimStr($_POST['name']);
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (isset($_POST['category_id']) && empty($_POST['category_id'])) {
            $errorMsg['category_id'] = '类型不能为空';
        }
        $model = new ProjectTemplateModel();
        if (isset($model->getByName($_POST['name'])['id'])) {
            $errorMsg['name'] = '名称已经被使用';
        }

        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $name = trimStr($_POST['name']);
        $info = [];
        $info['name'] = $name;
        $info['category_id'] = $_POST['category_id'];
        $info['is_system'] = '0';
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['image_bg'])) {
            $info['image_bg'] = $_POST['image_bg'];
        }
        list($ret ,$msg) = $model->insertItem($info);
        if ($ret) {
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }

    /**
     * 更新插件数据
     * @param $id
     * @param $params
     * @throws \Exception
     */
    public function update()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = (int)$id;
        $model = new ProjectTemplateModel();
        $row = $model->getById($id);
        if (!isset($row['id'])) {
            $this->ajaxFailed('参数错误,数据不存在');
        }
        unset($row);
        $info = [];
        if (isset($_POST['name'])) {
            $info['name'] = $_POST['name'];
        }
        if (isset($_POST['category_id'])) {
            $info['category_id'] = (int)$_POST['category_id'];
        }
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['image_bg'])) {
            $info['image_bg'] = $_POST['image_bg'];
        }
        if (isset($_POST['sub_system'])) {
            $subSystemArr = json_decode($_POST['sub_system'], true);
            $sortArr = [];
            foreach ($subSystemArr as $item) {
                $weight = max(0, intval($item['top']/150)*1120 ) + (int)$item['left'] ;
                $sortArr[$item['name']] = $weight ;
            }
            asort ($sortArr, SORT_NUMERIC );
            $sortArr = array_keys($sortArr);
            $info['subsystem_json'] = json_encode($sortArr);

        }
        if (isset($_POST['page_layout'])) {
            $info['page_layout'] = $_POST['page_layout'];
        }
        if (isset($_POST['project_view'])) {
            $info['project_view'] = $_POST['project_view'];
        }
        if (isset($_POST['issue_view'])) {
            $info['issue_view'] = $_POST['issue_view'];
        }
        if (isset($_POST['issue_type_scheme_id'])) {
            $info['issue_type_scheme_id'] = $_POST['issue_type_scheme_id'];
        }
        if (isset($_POST['issue_workflow_scheme_id'])) {
            $info['issue_workflow_scheme_id'] = $_POST['issue_workflow_scheme_id'];
        }
        if (isset($_POST['issue_ui_scheme_id'])) {
            $info['issue_ui_scheme_id'] = $_POST['issue_ui_scheme_id'];
        }

        if (!empty($info)) {
            $model->updateById($id, $info);
        }
        $this->ajaxSuccess('操作成功');
    }


    /**
     * 删除插件，包括插件目录,谨慎操作
     * @param $id
     * @throws \Exception
     */
    public function delete()
    {
        $name = null;
        if (isset($_POST['name'])) {
            $name = trimStr($_POST['name']);
        }
        if (!$name) {
            $this->ajaxFailed('参数错误', '名称不能为空');
        }
        $model = new PluginModel();
        $pluginRow = $model->getByName($name);
        if (!empty($pluginRow)) {
            $model->deleteById($pluginRow['id']);
        }
        $this->ajaxSuccess('操作成功');

    }

    /**
     * @param int $typeId
     * @throws \Exception
     */
    public function fetchAll()
    {
        $categoryId = isset($_GET['category_id']) && !empty($_GET['category_id']) ? $_GET['category_id'] :null;
        $projectTplModel = new ProjectTemplateModel();
        $projectTpls = $projectTplModel->getItems( $categoryId );
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
