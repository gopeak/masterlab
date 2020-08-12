<?php

namespace main\app\ctrl\project;

use main\app\async\email;
use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectModuleFilterLogic;
use main\app\classes\UserAuth;
use main\app\ctrl\BaseCtrl;
use main\app\ctrl\BaseUserCtrl;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\project\ProjectCatalogLabelModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectRoleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\classes\ProjectLogic;
use main\app\model\ActivityModel;

/**
 *
 * Class  项目分类控制器
 * @package main\app\ctrl\project
 */
class Catalog extends BaseUserCtrl
{

    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function fetch($id)
    {
        if (!isset($id)) {
            $this->ajaxFailed('提示', '缺少参数');
        }
        $model = new ProjectCatalogLabelModel();
        $arr = $model->getById($id);
        $this->ajaxSuccess('success', $arr);
    }

    public function fetchAll()
    {
        $projectId = null;
        if (isset($_GET['_target'][3])) {
            $projectId = (int)$_GET['_target'][3];
        }
        if (isset($_GET['project_id'])) {
            $projectId = (int)$_GET['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }
        $model = new ProjectCatalogLabelModel();
        $data['catalogs'] = $model->getByProject($projectId);
        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function add()
    {
        $uid = $this->getCurrentUid();
        $projectId = null;
        if (isset($_POST['project_id'])) {
            $projectId = (int)$_POST['project_id'];
        }
        if (empty($projectId)) {
            $this->ajaxFailed('参数错误', '项目id不能为空');
        }

        $errorMsg = [];
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (!isset($_POST['label_id_arr']) || empty($_POST['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }

        if (!isset($_POST['font_color']) || empty($_POST['font_color'])) {
            $_POST['font_color'] = 'blueviolet';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }
        $projectCatalogLabelModel = new ProjectCatalogLabelModel();

        if ($projectCatalogLabelModel->checkNameExist($projectId, $_POST['name'])) {
            $this->ajaxFailed('分类名称已存在.', array(), 500);
        }
        $insertArr = [];
        $insertArr['project_id'] = $projectId;
        $insertArr['name'] = $_POST['name'];
        $insertArr['font_color'] = $_POST['font_color'];
        $insertArr['label_id_json'] = json_encode($_POST['label_id_arr']);
        if (isset($_POST['description'])) {
            $insertArr['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $insertArr['order_weight'] = (int)$_POST['order_weight'];
        }

        list($ret, $errMsg) = $projectCatalogLabelModel->insert($insertArr);
        if ($ret) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = $errMsg;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_ADD;
            $logData['remark'] = '添加分类';
            $logData['pre_data'] = [];
            $logData['cur_data'] = $insertArr;
            LogOperatingLogic::add($uid, $projectId, $logData);

            $insertArr['id'] = $errMsg;
            $event = new CommonPlacedEvent($this, $insertArr);
            $this->dispatcher->dispatch($event,  Events::onCataloglCreate);

            $this->ajaxSuccess('提示', '分类添加成功');
        } else {
            $this->ajaxFailed('提示', '服务器执行失败:'.$errMsg);
        }
    }


    /**
     * @param $id
     * @param $title
     * @param $bg_color
     * @param $description
     * @throws \Exception
     */
    public function update()
    {
        $currentUserId = $this->getCurrentUid();
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (empty($id)) {
            $this->ajaxFailed('提示', '参数错误,id不能为空');
        }

        $errorMsg = [];
        if (isset($_POST['name']) && empty($_POST['name'])) {
            $errorMsg['name'] = '名称不能为空';
        }
        if (isset($_POST['label_id_arr']) && empty($_POST['label_id_arr'])) {
            $errorMsg['label_id_arr'] = '包含标签不能为空';
        }
        if (!empty($errorMsg)) {
            $this->ajaxFailed('参数错误', $errorMsg, BaseCtrl::AJAX_FAILED_TYPE_FORM_ERROR);
        }

        $updateArr = [];
        if (isset($_POST['name'])) {
            $updateArr['name'] = $_POST['name'];
        }
        if (isset($_POST['label_id_arr'])) {
            $updateArr['label_id_json'] = json_encode($_POST['label_id_arr']);
        }
        if (isset($_POST['font_color'])) {
            $updateArr['font_color'] = $_POST['font_color'];
        }
        if (isset($_POST['description'])) {
            $updateArr['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $updateArr['order_weight'] = (int)$_POST['order_weight'];
        }

        $model = new ProjectCatalogLabelModel();
        $catalog = $model->getById($id);
        if (empty($catalog)) {
            $this->ajaxFailed('提示', '参数错误, 数据为空');
        }
        if (!isset($this->projectPermArr[PermissionLogic::ADMINISTER_PROJECTS])) {
            $this->ajaxFailed('提示', '您没有权限访问该页面,需要项目管理权限');
        }
        if ($catalog['project_id'] != $this->projectId) {
            $this->ajaxFailed('提示', '参数错误, 非当前项目的数据');
        }
        if ($catalog['name'] != $updateArr['name']) {
            if ($model->checkNameExist($catalog['project_id'], $updateArr['name'])) {
                $this->ajaxFailed('提示', '分类名已存在');
            }
        }
        $ret = $model->updateById($id, $updateArr);
        if ($ret[0]) {

            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = $id;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改分类';
            $logData['pre_data'] = $catalog;
            $logData['cur_data'] = $updateArr;
            LogOperatingLogic::add($currentUserId, $catalog['project_id'], $logData);

            $updateArr['id'] = $id;
            $event = new CommonPlacedEvent($this, $updateArr);
            $this->dispatcher->dispatch($event,  Events::onCatalogUpdate);
            $this->ajaxSuccess('提示','修改成功');
        } else {
            $this->ajaxFailed('提示','更新失败');
        }
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        $id = null;
        if (isset($_POST['id'])) {
            $id = (int)$_POST['id'];
        }
        if (!$id) {
            $this->ajaxFailed('参数错误', 'id不能为空');
        }
        $id = intval($id);
        $model = new ProjectCatalogLabelModel();
        $info = $model->getById($id);
        if ($info['project_id'] != $this->projectId) {
            $this->ajaxFailed('提示', '参数错误,非当前项目的分类无法删除');
        }
        $model->deleteItem($id);

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
        $logData['remark'] = '删除分类';
        $logData['pre_data'] = $info;
        $logData['cur_data'] = $info2;
        LogOperatingLogic::add(UserAuth::getId(), $this->projectId, $logData);

        $event = new CommonPlacedEvent($this, $info);
        $this->dispatcher->dispatch($event,  Events::onCatalogDelete);
        $this->ajaxSuccess('提示','操作成功');
    }
}
