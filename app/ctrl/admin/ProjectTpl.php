<?php

namespace main\app\ctrl\admin;

use main\app\classes\PermissionGlobal;
use main\app\classes\ProjectLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseAdminCtrl;
use main\app\ctrl\BaseCtrl;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueTypeSchemeModel;
use main\app\model\issue\IssueUiSchemeModel;
use main\app\model\issue\WorkflowSchemeModel;
use main\app\model\permission\DefaultRoleModel;
use main\app\model\PluginModel;
use main\app\model\project\ProjectModel;
use main\app\classes\ConfigLogic;
use main\app\model\ProjectTemplateDisplayCategoryModel;
use main\app\model\ProjectTemplateModel;
use main\app\model\ProjectTplCatalogLabelModel;
use main\app\model\ProjectTplLabelModel;
use main\app\model\ProjectTplModuleModel;
use main\app\classes\UploadLogic;

/**
 * 项目列表
 * Class Projects
 * @package main\app\ctrl
 */
class ProjectTpl extends BaseAdminCtrl
{

    public static $defaultSubSystem = [
        'issues' => ['title' => '事项', 'name'=>'issues', 'fix' => true, 'color' => 'blue', 'is_system' => '1','description'=>''],
        'gantt' => ['title' => '甘特图','name'=>'gantt',  'fix' => false, 'color' => 'red', 'is_system' => '1','description'=>'以甘特图的方式进行整个项目或迭代的事项计划'],
        'mind' => ['title' => '事项分解','name'=>'mind',  'fix' => false, 'color' => 'gray', 'is_system' => '1','description'=>'将思维导图和事项进行整个，可直观图形化树状化的方式管理事项'],
        'backlog' => ['title' => '待办事项', 'name'=>'backlog', 'fix' => false, 'color' => 'gray', 'is_system' => '1','description'=>'待办事项是一个排序的列表,包含所有产品需要的事项,也是产品需求变动的唯一来源。产品负责人负责产品待办事项列表的内容、可用性和优先级'],
        'sprint' => ['title' => '冲刺', 'name'=>'sprints', 'fix' => false, 'color' => 'red', 'is_system' => '1','description'=>'迭代即是冲刺，是将项目分成多个阶段，每个阶段按短迭代周期工作，每次迭代交付一些成功，关注业务优先级，检查与调整，能够得到早期用户的反馈，及时进行对产品的更改，降低风险'],
        'kanban' => ['title' => '看板','name'=>'kanban', 'fix' => false, 'color' => 'blue', 'is_system' => '1','description'=>'看板的方式跟踪整个项目或某一迭代的事项'],
        'chart' => ['title' => '图表', 'name'=>'stat', 'fix' => false, 'color' => 'blue', 'is_system' => '1','description'=>'图形化的方式展示整个项目或迭代的汇总信息'],
        'stat' => ['title' => '统计','name'=>'chart',  'fix' => false, 'color' => 'blue', 'is_system' => '1','description'=>'数字化的方式展示整个项目或迭代的汇总信息'],
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
        $data = [];
        $data['title'] = '项目模板';
        $data['nav_links_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['category_id'] = isset($_GET['category_id']) ? $_GET['category_id'] : '';
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
        $data['id'] = isset($_GET['id']) ? $_GET['id'] : '';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        if ($tpl) {
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
        $data['id'] = isset($_GET['id']) ? $_GET['id'] : '';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        if ($tpl) {
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
            if (isset($subSystemArr[$subsystem])) {
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
        // 事项类型
        $data['issueTypeArr'] = (new IssueTypeModel())->getAllItems(false);

        $this->render('gitlab/admin/project_tpl/form.twig', $data);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function pageDetail()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['id'] = isset($_GET['id']) ? $_GET['id'] : '';
        $categoryModel = new ProjectTemplateDisplayCategoryModel();
        $model = new ProjectTemplateModel();
        $tpl = $model->getById($data['id']);
        $data['tpl'] = $tpl;
        $data['action'] = 'update';
        $data['category_arr'] = $categoryModel->getAllItems();
        $this->render('gitlab/admin/project_tpl/detail.twig', $data);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function pageCopy()
    {
        $data = [];
        $data['title'] = '项目';
        $data['sub_nav_active'] = 'project_tpl';
        $data['left_nav_active'] = 'all';
        $data['id'] = isset($_GET['id']) ? $_GET['id'] : '';
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
        list($ret, $msg) = $model->insertItem($info);
        if ($ret) {
            $this->ajaxSuccess('操作成功', $msg);
        } else {
            $this->ajaxFailed('服务器错误:', $msg);
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function copy()
    {
        if (empty($_POST)) {
            $this->ajaxFailed('错误', '没有提交表单数据');
        }
        $copyId = null;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $copyId = $_POST['id'];
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
        $info['category_id'] =  $_POST['category_id'] ?? 0;
        $info['is_system'] = '0';
        if (isset($_POST['description'])) {
            $info['description'] = $_POST['description'];
        }
        if (isset($_POST['image_bg'])) {
            $info['image_bg'] = $_POST['image_bg'];
        }
        if ($copyId) {
            $copyProjectTpl = $model->getById($copyId);
            $info['issue_type_scheme_id'] = $copyProjectTpl['issue_type_scheme_id'];
            $info['issue_workflow_scheme_id'] = $copyProjectTpl['issue_workflow_scheme_id'];
            $info['issue_ui_scheme_id'] = $copyProjectTpl['issue_ui_scheme_id'];
            $info['nav_type'] = $copyProjectTpl['nav_type'];
            $info['ui_style'] = $copyProjectTpl['ui_style'];
            $info['theme_color'] = $copyProjectTpl['theme_color'];
            $info['is_fix_header'] = $copyProjectTpl['is_fix_header'];
            $info['is_fix_left'] = $copyProjectTpl['is_fix_left'];
            $info['subsystem_json'] = $copyProjectTpl['subsystem_json'];
            $info['page_layout'] = $copyProjectTpl['page_layout'];
            $info['project_view'] = $copyProjectTpl['project_view'];
            $info['issue_view'] = $copyProjectTpl['issue_view'];
        }
        list($ret, $msg) = $model->insertItem($info);
        if ($ret) {
            $projectTplId = $msg;
            if ($copyId && $copyProjectTpl) {
                $projectTplLabelModel = new ProjectTplLabelModel();
                $projectTplDataArr = $projectTplLabelModel->getByProject($copyId);
                if ($projectTplDataArr) {
                    foreach ($projectTplDataArr as $item) {
                        $arr = $item;
                        unset($arr['id']);
                        $arr['project_tpl_id'] = $projectTplId;
                        if(isset($arr['k'])){
                            unset($arr['k']);
                        }
                        $projectTplLabelModel->insertItem($arr);
                    }
                }
                $model = new ProjectTplCatalogLabelModel();
                $projectTplDataArr = $model->getByProject($copyId);
                if ($projectTplDataArr) {
                    foreach ($projectTplDataArr as $item) {
                        $arr = $item;
                        unset($arr['id']);
                        if(isset($arr['k'])){
                            unset($arr['k']);
                        }
                        $arr['project_tpl_id'] = $projectTplId;
                        $model->insertItem($arr);
                    }
                }
                $model = new ProjectTplModuleModel();
                $projectTplDataArr = $model->getByProject($copyId);
                if ($projectTplDataArr) {
                    foreach ($projectTplDataArr as $item) {
                        $arr = $item;
                        unset($arr['id']);
                        if(isset($arr['k'])){
                            unset($arr['k']);
                        }
                        $arr['created_at'] = time();
                        $arr['project_tpl_id'] = $projectTplId;
                        $model->insert($arr);
                    }
                }
                $model = new DefaultRoleModel();
                $projectTplDataArr = $model->getsByProject($copyId);
                if ($projectTplDataArr) {
                    foreach ($projectTplDataArr as $item) {
                        $arr = $item;
                        unset($arr['id']);
                        if(isset($arr['k'])){
                            unset($arr['k']);
                        }
                        $arr['project_tpl_id'] = $projectTplId;
                        $model->insert($arr);
                    }
                }
            }
            $this->ajaxSuccess('操作成功', $msg);
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
                $weight = max(0, intval($item['top'] / 150) * 1120) + (int)$item['left'];
                $sortArr[$item['name']] = $weight;
            }
            asort($sortArr, SORT_NUMERIC);
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
        if (isset($_POST['default_issue_type_id'])) {
            $info['default_issue_type_id'] = $_POST['default_issue_type_id'];
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
     * 删除模板，包括子数据
     * @param $id
     * @throws \Exception
     */
    public function delete()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = trimStr($_POST['id']);
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $model = new ProjectTemplateModel();
        $row = $model->getById($id);
        if (!empty($row)) {
            $deletedNum = $model->deleteById($row['id']);
            if($deletedNum>0){
                $model = new ProjectTplCatalogLabelModel();
                $model->deleteByProject($id);
                $model = new ProjectTplLabelModel();
                $model->deleteByProject($id);
                $model = new ProjectTplModuleModel();
                $model->deleteByProject($id);
                $model = new DefaultRoleModel();
                $model->deleteByProject($id);
            }
        }
        $this->ajaxSuccess('操作成功');
    }

    /**
     * @throws \Exception
     */
    public function fetchAll()
    {
        $categoryId = isset($_GET['category_id']) && !empty($_GET['category_id']) ? $_GET['category_id'] : null;
        $projectTplModel = new ProjectTemplateModel();
        $projectTpls = $projectTplModel->getItems($categoryId);
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

    /**
     * 初始化项目角色
     * @throws \Exception
     */
    public function initRole($projectTplId)
    {
        $ret = [];
        $projectArr = (new ProjectModel())->getAll(false);
        foreach ($projectArr as $item) {
            $ret[] = ProjectLogic::initRole($item['id'], $projectTplId);
        }
        $this->ajaxSuccess('ok', $ret);
    }
}
