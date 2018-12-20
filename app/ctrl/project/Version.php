<?php
/**
 * Created by PhpStorm. 
 */

namespace main\app\ctrl\project;
use main\app\classes\LogOperatingLogic;
use main\app\classes\ProjectVersionLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\ActivityModel;
use main\app\classes\ProjectLogic;

/**
 * 项目版本
 */
class Version extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function pageNew()
    {
        $data = [];
        $data['title'] = '项目版本';
        $this->render('gitlab/project/version_form.php', $data);
    }

    public function pageEdit($id)
    {
        // @todo 判断权限:全局权限和项目角色
        $id = intval($id);
        if (empty($id)) {
            $this->error('Param Error', 'id_is_empty');
        }

        $uid = $this->getCurrentUid();
        $projectVersionModel = new ProjectVersionModel($uid);

        $version =  $projectVersionModel->getRowById($id);
        if (!isset($version['name'])) {
            $this->error('Param Error', 'id_not_exist');
        }

        $data = [];
        $data['title'] = '项目分类';
        $data['version'] = $version;
        $this->render('gitlab/project/version_form.php', $data);
    }

    private function param_valid($projectVersionModel, $project_id, $name)
    {
        if (empty(trimStr($name))) {
            $this->ajaxFailed('param_error:name_is_null');
        }

        $uid = $this->getCurrentUid();
        $version =  $projectVersionModel->getByProjectIdName($project_id, $name);
        if (isset($version['name'])) {
            $this->ajaxFailed('param_error:name_exist');
        }
    }

    public function add($name, $description = '', $start_date = '2018-02-17', $release_date = '2018-02-17', $url = '')
    {
        if (isPost()) {
            $uid = $this->getCurrentUid();
            $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
            $projectVersionModel = new ProjectVersionModel($uid);
            $this->param_valid($projectVersionModel, $project_id, $name);

            $info = [];
            $info['project_id']   =  $project_id;
            $info['name']   =  $name;
            $info['description']   =  $description ;
            $info['sequence']   =  0;
            $info['start_date']   =  strtotime($start_date) ;
            $info['release_date'] = strtotime($release_date);
            $info['url']   =  $url ;

            $ret= $projectVersionModel->insert($info);
            if ($ret[0]) {
                $activityModel = new ActivityModel();
                $activityInfo = [];
                $activityInfo['action'] = '创建了版本';
                $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
                $activityInfo['obj_id'] = $ret[1];
                $activityInfo['title'] = $name;
                $activityModel->insertItem($uid, $project_id, $activityInfo);

                //写入操作日志
                $logData = [];
                $logData['user_name'] = $this->auth->getUser()['username'];
                $logData['real_name'] = $this->auth->getUser()['display_name'];
                $logData['obj_id'] = 0;
                $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
                $logData['page'] = $_SERVER['REQUEST_URI'];
                $logData['action'] = LogOperatingLogic::ACT_ADD;
                $logData['remark'] = '添加项目版本';
                $logData['pre_data'] = [];
                $logData['cur_data'] = $info;
                LogOperatingLogic::add($uid, $project_id, $logData);

                $this->ajaxSuccess('add_success');
            } else {
                $this->ajaxFailed('add_failed', array(), 500);
            }
        }
        $this->ajaxFailed('add_failed', array(), 500);
        return;
    }

    public function release($version_id)
    {
        $uid = $this->getCurrentUid();
        $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $projectVersionModel = new ProjectVersionModel($uid);
        $version =  $projectVersionModel->getRowById($version_id);

        $versionReleaseStatus = 1;
        if ($projectVersionModel->updateReleaseStatus($project_id, $version_id, $versionReleaseStatus)) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '发布了版本';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $version_id;
            $activityInfo['title'] = $version ['name'] ;
            $activityModel->insertItem($uid, $project_id, $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '发布项目版本';
            $logData['pre_data'] = $version;
            $logData['cur_data'] = array('released' => $versionReleaseStatus);
            LogOperatingLogic::add($uid, $project_id, $logData);

            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('update_failed', array(), 500);
        }
    }

    public function remove($version_id)
    {
        $uid = $this->getCurrentUid();
        $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
        $projectVersionModel = new ProjectVersionModel($uid);
        if ($projectVersionModel->deleteByVersinoId($project_id, $version_id)) {

            $version = $projectVersionModel->getRowById($version_id);
            $callFunc = function ($value) {
                return '已删除' ;
            };
            $version2 = array_map($callFunc, $version);
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_DELETE;
            $logData['remark'] = '删除项目版本';
            $logData['pre_data'] = $version;
            $logData['cur_data'] = $version2;
            LogOperatingLogic::add($uid, $project_id, $logData);

            $this->ajaxSuccess('success');
        } else {
            $this->ajaxFailed('failed', array(), 500);
        }
    }

    public function update($id, $name, $description = '', $sequence = 0, $start_date = '2018-02-17', $release_date = '2018-02-17', $url = '')
    {
        $id = intval($id);
        $uid = $this->getCurrentUid();
        $projectVersionModel = new ProjectVersionModel($uid);

        $version =  $projectVersionModel->getRowById($id);
        if (!isset($version['name'])) {
            $this->ajaxFailed('param_error:id_not_exist');
        }


        $row = [];

        if (isset($name) && !empty($name)) {
            $project_id = $version['project_id'];
            if ($projectVersionModel->checkNameExistExcludeCurrent($id, $project_id, $name)) {
                $this->ajaxFailed('param_error:name_exist');
            }
            $row['name']   =  $name;
        }

        if (isset($description) && !empty($description)) {
            $row['description'] = $description;
        }

        if (isset($sequence)) {
            $row['sequence'] = intval($sequence);
        }

        if (isset($start_date) && !empty($start_date)) {
            $row['start_date'] = strtotime($start_date);
        } else {
            $this->ajaxFailed('param_error:start_date is empty');
        }

        if (isset($release_date) && !empty($release_date)) {
            $row['release_date'] = strtotime($release_date);
        } else {
            $this->ajaxFailed('param_error:release_date is empty');
        }

        if (isset($url)) {
            $row['url']   =  $url;
        }

        if (empty($row)) {
            $this->ajaxFailed('param_error:data_is_empty');
        }


        $ret = $projectVersionModel->updateById($id, $row);
        if ($ret[0]) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了版本';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $name ;
            $activityModel->insertItem($uid, $version['project_id'], $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目版本';
            $logData['pre_data'] = $version;
            $logData['cur_data'] = $row;
            LogOperatingLogic::add($uid, $version['project_id'], $logData);

            $this->ajaxSuccess('add_success');
        } else {
            $this->ajaxFailed('add_failed');
        }
    }

    public function fetchVersion($version_id)
    {
        $projectVersionModel = new ProjectVersionModel();
        $final = $projectVersionModel->getRowById($version_id);
        $final['start_date'] = date("Y-m-d", $final['start_date']);
        $final['release_date'] = date("Y-m-d", $final['release_date']);
        if (empty($final)) {
            $this->ajaxFailed('non data...');
        } else {
            $this->ajaxSuccess('success', $final);
        }
    }

    public function filterSearch($project_id, $name = '')
    {
        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }

        $projectVersionLogic = new ProjectVersionLogic();
        list($ret, $list, $total) = $projectVersionLogic->getVersionByFilter($project_id, $name, $page, $pageSize);

        if ($ret) {
            array_walk($list, function (&$value, $key) {
                $time = time();
                $value['start_date'] = date("Y-m-d", $value['start_date']);//format_unix_time($value['start_date'], $time);
                $value['release_date'] = date("Y-m-d", $value['release_date']);//format_unix_time($value['release_date'], $time);
            });
        }

        $data['total'] = $total;
        $data['pages'] = ceil($total / $pageSize);
        $data['page_size'] = $pageSize;
        $data['page'] = $page;
        $data['versions'] = $list;
        $this->ajaxSuccess('success', $data);
    }

    public function delete($project_id, $version_id)
    {
        $projectVersionModel = new ProjectVersionModel();
        $version =  $projectVersionModel->getRowById($version_id);
        $projectVersionModel->deleteByVersinoId($project_id, $version_id);
        $activityModel = new ActivityModel();
        $uid = $this->getCurrentUid();
        $activityInfo = [];
        $activityInfo['action'] = '删除了版本';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $version_id;
        $activityInfo['title'] = $version['name'] ;
        $activityModel->insertItem($uid, $project_id, $activityInfo);


        $callFunc = function ($value) {
            return '已删除' ;
        };
        $version2 = array_map($callFunc, $version);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除项目版本';
        $logData['pre_data'] = $version;
        $logData['cur_data'] = $version2;
        LogOperatingLogic::add($uid, $project_id, $logData);

        $this->ajaxSuccess('success');
    }





}
