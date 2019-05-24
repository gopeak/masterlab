<?php
/**
 * Created by PhpStorm.
 */

namespace main\app\ctrl\project;

use main\app\async\email;
use main\app\classes\LogOperatingLogic;
use main\app\classes\ProjectModuleFilterLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\ActivityModel;
use main\app\classes\ProjectLogic;

/**
 * 项目模块
 */
class Module extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function pageIndex()
    {
        $data = [];
        $data['title'] = '浏览 版本';
        $data['nav_links_active'] = 'module';
        $this->render('gitlab/project/module.php', $data);
    }


    public function pageNew()
    {
        $data = [];
        $data['title'] = '项目分类';
        $this->render('gitlab/project/module_form.php', $data);
    }

    public function pageEdit($id)
    {
        // @todo 判断权限:全局权限和项目角色
        $id = intval($id);
        if (empty($id)) {
            $this->error('Param Error', 'id_is_empty');
        }

        $uid = $this->getCurrentUid();
        $projectVersionModel = new ProjectModuleModel($uid);

        $version = $projectVersionModel->getRowById($id);
        if (!isset($version['name'])) {
            $this->error('Param Error', 'id_not_exist');
        }

        $data = [];
        $data['title'] = '项目分类';
        $data['version'] = $version;
        $this->render('gitlab/project/version_form.php', $data);
    }

    /**
     * @param $module_name
     * @param string $description
     * @param int $lead
     * @param int $default_assignee
     * @throws \Exception
     */
    public function add($module_name, $description = '', $lead = 0, $default_assignee = 0)
    {
        if (isPost()) {
            $uid = $this->getCurrentUid();
            $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
            $module_name = trim($module_name);
            $projectModuleModel = new ProjectModuleModel($uid);

            if ($projectModuleModel->checkNameExist($project_id, $module_name)) {
                $this->ajaxFailed('name is exist.', array(), 500);
            }

            $row = [];
            $row['project_id'] = $project_id;
            $row['name'] = $module_name;
            $row['description'] = $description;
            $row['lead'] = $lead;
            $row['default_assignee'] = $default_assignee;
            $row['ctime'] = time();

            $ret = $projectModuleModel->insert($row);
            if ($ret[0]) {
                $currentUid = $this->getCurrentUid();
                $activityModel = new ActivityModel();
                $activityInfo = [];
                $activityInfo['action'] = '创建了模块';
                $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
                $activityInfo['obj_id'] = $ret[1];
                $activityInfo['title'] = $module_name;
                $activityModel->insertItem($currentUid, $project_id, $activityInfo);

                //写入操作日志
                $logData = [];
                $logData['user_name'] = $this->auth->getUser()['username'];
                $logData['real_name'] = $this->auth->getUser()['display_name'];
                $logData['obj_id'] = 0;
                $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
                $logData['page'] = $_SERVER['REQUEST_URI'];
                $logData['action'] = LogOperatingLogic::ACT_ADD;
                $logData['remark'] = '新建项目模块';
                $logData['pre_data'] = [];
                $logData['cur_data'] = $row;
                LogOperatingLogic::add($uid, $project_id, $logData);

                $this->ajaxSuccess('add_success');
            } else {
                $this->ajaxFailed('add_failed', array(), 500);
            }
        }
        $this->ajaxFailed('add_failed', array(), 500);
    }

    /**
     * @param $id
     * @param $name
     * @param $description
     * @throws \Exception
     */
    public function update($id, $name, $description)
    {
        $id = intval($id);
        $uid = $this->getCurrentUid();
        $projectModuleModel = new ProjectModuleModel($uid);

        $module = $projectModuleModel->getRowById($id);
        if (!isset($module['name'])) {
            $this->ajaxFailed('param_error:id_not_exist');
        }

        $row = [];

        if (isset($name) && !empty($name)) {
            $row['name'] = $name;
        }
        if (isset($description) && !empty($description)) {
            $row['description'] = $description;
        }

        if (count($row) < 2) {
            $this->ajaxFailed('param_error:form_data_is_error ' . count($row));
        }

        $moduleInfo = $projectModuleModel->getById($id);

        $ret = $projectModuleModel->updateById($id, $row);
        if ($ret[0]) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了模块';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $name;
            $activityModel->insertItem($uid, $module['project_id'], $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目模块';
            $logData['pre_data'] = $moduleInfo;
            $logData['cur_data'] = $row;
            LogOperatingLogic::add($uid, $moduleInfo['project_id'], $logData);

            $this->ajaxSuccess('update_success');
        } else {
            $this->ajaxFailed('update_failed');
        }
    }

    /**
     * @param $module_id
     * @throws \Exception
     */
    public function fetchModule($module_id)
    {
        $projectModuleModel = new ProjectModuleModel();
        $final = $projectModuleModel->getById($module_id);
        if (empty($final)) {
            $this->ajaxFailed('non data...');
        } else {
            $this->ajaxSuccess('success', $final);
        }
    }

    /**
     * @param $project_id
     * @param string $name
     * @throws \Exception
     */
    public function filterSearch($project_id, $name = '')
    {
        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }

        $projectModuleFilterLogic = new ProjectModuleFilterLogic();
        list($ret, $list, $total) = $projectModuleFilterLogic->getModuleByFilter($project_id, $name, $page, $pageSize);

        if ($ret) {
            array_walk($list, function (&$value, $key) {
                $value['ctime'] = format_unix_time($value['ctime'], time());
            });
        }

        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['modules'] = $list;
        $this->ajaxSuccess('success', $data);
    }

    /**
     * 删除模块
     * @param $project_id
     * @param $module_id
     * @throws \Exception
     */
    public function delete($project_id, $module_id)
    {
        $uid = $this->getCurrentUid();
        $projectModuleModel = new ProjectModuleModel();
        $module = $projectModuleModel->getRowById($module_id);
        $projectModuleModel->removeById($project_id, $module_id);
        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了模块';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $module_id;
        $activityInfo['title'] = $module["name"];
        $activityModel->insertItem($currentUid, $project_id, $activityInfo);

        $callFunc = function ($value) {
            return '已删除';
        };
        $module2 = array_map($callFunc, $module);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除项目模块';
        $logData['pre_data'] = $module;
        $logData['cur_data'] = $module2;
        LogOperatingLogic::add($uid, $project_id, $logData);

        $this->ajaxSuccess('success');
    }
}
