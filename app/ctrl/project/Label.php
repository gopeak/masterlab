<?php

namespace main\app\ctrl\project;

use main\app\async\email;
use main\app\classes\LogOperatingLogic;
use main\app\classes\ProjectModuleFilterLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseUserCtrl;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\ProjectLogic;
use main\app\model\ActivityModel;

/**
 *
 * Class Label 项目标签操作
 * @package main\app\ctrl\project
 */
class Label extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    public function pageEdit()
    {
    }

    /**
     * @param $title
     * @param $bg_color
     * @throws \Exception
     */
    public function add($title, $bg_color)
    {
        if (isPost()) {
            $uid = $this->getCurrentUid();
            $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);
            $title = trim($title);
            $projectLabelModel = new ProjectLabelModel();

            if ($projectLabelModel->checkNameExist($project_id, $title)) {
                $this->ajaxFailed('name is exist.', array(), 500);
            }

            $row = [];
            $row['project_id'] = $project_id;
            $row['title'] = $title;
            $row['color'] = '#FFFFFF';
            $row['bg_color'] = $bg_color;

            $ret = $projectLabelModel->insert($row);
            if ($ret[0]) {
                $activityModel = new ActivityModel();
                $activityInfo = [];
                $activityInfo['action'] = '创建了标签';
                $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
                $activityInfo['obj_id'] = $ret[1];
                $activityInfo['title'] = $title;
                $activityModel->insertItem($uid, $project_id, $activityInfo);

                //写入操作日志
                $logData = [];
                $logData['user_name'] = $this->auth->getUser()['username'];
                $logData['real_name'] = $this->auth->getUser()['display_name'];
                $logData['obj_id'] = 0;
                $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
                $logData['page'] = $_SERVER['REQUEST_URI'];
                $logData['action'] = LogOperatingLogic::ACT_ADD;
                $logData['remark'] = '添加标签';
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
     * @param $title
     * @param $bg_color
     * @throws \Exception
     */
    public function update($id, $title, $bg_color)
    {
        $id = intval($id);
        $uid = $this->getCurrentUid();
        $project_id = intval($_REQUEST[ProjectLogic::PROJECT_GET_PARAM_ID]);

        $row = [];
        if (isset($title) && !empty($title)) {
            $title = trim($title);
            $row['title'] = $title;
        }
        if (isset($bg_color) && !empty($bg_color)) {
            $row['bg_color'] = $bg_color;
        }

        $projectLabelModel = new ProjectLabelModel();
        $info = $projectLabelModel->getById($id);

        if (empty($info)) {
            $this->ajaxFailed('update_failed:null');
        }

        if ($info['title'] != $title) {
            if ($projectLabelModel->checkNameExist($project_id, $title)) {
                $this->ajaxFailed('title is exist.', array(), 500);
            }
        }

        if (count($row) < 2) {
            $this->ajaxFailed('param_error:form_data_is_error ' . count($row));
        }
        $ret = $projectLabelModel->updateById($id, $row);
        if ($ret[0]) {
            $activityModel = new ActivityModel();
            $activityInfo = [];
            $activityInfo['action'] = '更新了标签';
            $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
            $activityInfo['obj_id'] = $id;
            $activityInfo['title'] = $title;
            $activityModel->insertItem($uid, $project_id, $activityInfo);

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改标签';
            $logData['pre_data'] = $info;
            $logData['cur_data'] = $row;
            LogOperatingLogic::add($uid, $project_id, $logData);

            $this->ajaxSuccess('update_success');
        } else {
            $this->ajaxFailed('update_failed');
        }
    }


    /**
     * @param $project_id
     * @throws \Exception
     */
    public function listData($project_id)
    {
        $projectLabelModel = new ProjectLabelModel();
        $list = $projectLabelModel->getByProject($project_id);

        $data['labels'] = $list;
        $this->ajaxSuccess('success', $data);
    }

    /**
     * @param $project_id
     * @param $label_id
     * @throws \Exception
     */
    public function delete($project_id, $label_id)
    {
        $projectLabelModel = new ProjectLabelModel();
        $info = $projectLabelModel->getById($label_id);
        if ($info['project_id'] != $project_id) {
            $this->ajaxFailed('参数错误,非当前项目的标签无法删除');
        }
        $projectLabelModel->deleteItem($label_id);
        $currentUid = $this->getCurrentUid();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了标签';
        $activityInfo['type'] = ActivityModel::TYPE_PROJECT;
        $activityInfo['obj_id'] = $label_id;
        $activityInfo['title'] = $info['title'];
        $activityModel->insertItem($currentUid, $project_id, $activityInfo);


        $callFunc = function ($value) {
            return '已删除';
        };
        $info2 = array_map($callFunc, $info);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除标签';
        $logData['pre_data'] = $info;
        $logData['cur_data'] = $info2;
        LogOperatingLogic::add($currentUid, $project_id, $logData);

        $this->ajaxSuccess('success');
    }
}
