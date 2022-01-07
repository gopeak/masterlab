<?php

namespace main\app\ctrl\project;

use main\app\classes\IssueFavFilterLogic;
use main\app\classes\LogOperatingLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectListCountLogic;
use main\app\classes\ProjectLogic;
use main\app\classes\IssueTypeLogic;
use main\app\classes\SettingsLogic;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\ctrl\BaseUserCtrl;
use main\app\ctrl\Org;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\OrgModel;
use main\app\model\project\ProjectFlagModel;
use main\app\model\project\ProjectIssueTypeSchemeDataModel;
use main\app\model\project\ProjectMainExtraModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\user\UserModel;

/**
 * Class Setting
 * @package main\app\ctrl\project
 */
class Setting extends BaseUserCtrl
{
    public function __construct()
    {
        parent::__construct();
        parent::addGVar('top_menu_active', 'project');
    }

    /**
     * 修改项目信息
     * @throws \Exception
     */
    public function saveSettingsProfile()
    {
        $isUpdateLeader = false;
        $projectParamkey = ProjectLogic::PROJECT_GET_PARAM_ID;
        if (isPost()) {
            $projectId = $_GET[ProjectLogic::PROJECT_GET_PARAM_ID];
            $params = $_POST['params'];
            $uid = $this->getCurrentUid();
            $projectModel = new ProjectModel($uid);
            $preData = $projectModel->getRowById($_GET[$projectParamkey]);

            $settingLogic = new SettingsLogic();
            $maxLengthProjectName = $settingLogic->maxLengthProjectName();

            if (!isset($params['name'])) {
                // $this->ajaxFailed('表单错误', '需要填写项目名称');
            }
            if (isset($params['name']) && empty(trimStr($params['name']))) {
                $this->ajaxFailed('表单错误失败,需要填写项目名称。');
            }
            if (isset($params['name']) && strlen($params['name']) > $maxLengthProjectName) {
                $this->ajaxFailed('表单错误失败,名称长度太长,长度应该小于' . $maxLengthProjectName);
            }
            if (isset($params['name']) && $projectModel->checkIdNameExist($projectId, $params['name'])) {
                $this->ajaxFailed('表单验证失败,项目名称已经被使用了,请更换一个吧');
            }
            if (!isset($params['lead'])  && empty($preData['lead'])) {
                $params['lead'] = $uid;
            }
            $info = [];
            if (isset($params['name'])) {
                $info['name'] = $params['name'];
            }
            if (isset($params['lead'])) {
                // 修改项目leader
                if ($preData['lead'] != $params['lead']) {
                    $info['lead'] = $params['lead'];
                    $isUpdateLeader = true;
                }
            }
            // var_dump($isUpdateLeader);
            if (isset($params['description'])) {
                $info['description'] = $params['description'];
            }
            if (isset($params['url'])) {
                $info['url'] = $params['url'];
            }
            if (isset($params['avatar_relate_path'])) {
                $info['avatar'] = $params['avatar_relate_path'];
            }
            //$info['detail'] = $params['detail'];
            if (isset($params['workflow_scheme_id'])) {
                $info['workflow_scheme_id'] = (int)$params['workflow_scheme_id'];
            }
            if (isset($params['is_strict_status'])) {
                $info['is_strict_status'] = (int)$params['is_strict_status'];
            }
            if (isset($params['default_issue_type_id'])) {
                $info['default_issue_type_id'] = (int)$params['default_issue_type_id'];
            }
            if (isset($params['is_remember_last_issue'])) {
                $info['is_remember_last_issue'] = (int)$params['is_remember_last_issue'];
            }
            if (isset($params['remember_last_issue_field'])) {
                $info['remember_last_issue_field'] = json_encode($params['remember_last_issue_field']);
            }
            // 管理员可以变更项目所属的组织
            if (isset($params['org_id']) && $preData['org_id'] != $params['org_id'] && $this->isAdmin) {
                $orgModel = new OrgModel();
                $orgInfo = $orgModel->getById($params['org_id']);
                $info['org_id'] = $params['org_id'];
                $info['org_path'] = $orgInfo['path'];
            }
            try {
                $projectModel->db->beginTransaction();
                //print_r($info);
                $ret1 = $projectModel->update($info, array('id' => $projectId));
                if ($ret1[0]) {
                    if ($isUpdateLeader) {
                        $retModifyLeader = ProjectLogic::assignProjectRoles($projectId, $info['lead']);
                        if (!$retModifyLeader) {
                            $projectModel->db->rollBack();
                            $this->ajaxFailed('错误服务器执行错误,更新项目负责人失败');
                        }
                    }
                    if (isset($params['is_table_display_avatar'])) {
                        $isTableDisplayAvatar= (int)$params['is_table_display_avatar'];
                        $projectFlagModel = new ProjectFlagModel();
                        $flagRow = $projectFlagModel->getByFlag($projectId, "is_table_display_avatar");
                        if (!isset($flagRow['flag'])){
                            $projectFlagModel->add($projectId, 'is_table_display_avatar' , $isTableDisplayAvatar);
                        }else{
                            $projectFlagModel->updateById($flagRow['id'], ['value'=>$isTableDisplayAvatar]);
                        }
                    }
                    if (isset($params['detail'])) {
                        $projectMainExtra = new ProjectMainExtraModel();
                        if ($projectMainExtra->getByProjectId($projectId)) {
                            $ret3 = $projectMainExtra->updateByProjectId(array('detail' => $params['detail']), $projectId);
                        } else {
                            $ret3 = $projectMainExtra->insert(array('project_id' => $projectId, 'detail' => $params['detail']));
                        }
                        if (!$ret3[0]) {
                            $projectModel->db->rollBack();
                            $this->ajaxFailed('服务器执行错误,更新项目描述失败');
                        }
                    }
                    // 保存项目事项类型方案
                    if (isset($params['issue_type_scheme_id'])) {
                        $issueTypeSchemeId = $params['issue_type_scheme_id'];
                        $projectIssueTypeSchemeDataModel = new ProjectIssueTypeSchemeDataModel();
                        $projectIssueTypeSchemeData = $projectIssueTypeSchemeDataModel->getRow('*', ['project_id' => $projectId]);
                        if ($projectIssueTypeSchemeData) {
                            $rowId = $projectIssueTypeSchemeData['id'];
                            $updates = ['issue_type_scheme_id' => $issueTypeSchemeId];
                            $projectIssueTypeSchemeDataModel->update($updates, ['id' => $rowId]);
                        } else {
                            $new = ['issue_type_scheme_id' => $issueTypeSchemeId, 'project_id' => $projectId];
                            $projectIssueTypeSchemeDataModel->insert($new);
                        }
                        // 判断默认事项类型是否在类型方案中
                        $schemeTypeItems = (new IssueTypeSchemeItemsModel())->getItemsBySchemeId($issueTypeSchemeId);
                        $typeIdArr = array_column($schemeTypeItems, "type_id");
                        $defaultIssueTypeId = $info['default_issue_type_id']  ?? $preData['default_issue_type_id'];
                        if  (!in_array($defaultIssueTypeId, $typeIdArr)) {
                            $defaultIssueTypeId = $typeIdArr[0] ?? 1;
                            $projectModel->update(['default_issue_type_id'=>$defaultIssueTypeId], array('id' => $projectId));
                        }
                    }
                    $projectModel->db->commit();
                    //写入操作日志
                    $logData = [];
                    $logData['user_name'] = $this->auth->getUser()['username'];
                    $logData['real_name'] = $this->auth->getUser()['display_name'];
                    $logData['obj_id'] = 0;
                    $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT;
                    $logData['page'] = $_SERVER['REQUEST_URI'];
                    $logData['action'] = LogOperatingLogic::ACT_EDIT;
                    $logData['remark'] = '修改项目信息';
                    $logData['pre_data'] = $preData;
                    $logData['cur_data'] = $info;
                    LogOperatingLogic::add($uid, $_GET[ProjectLogic::PROJECT_GET_PARAM_ID], $logData);
                    // 分发事件
                    $info['id'] = $projectId;
                    $event = new CommonPlacedEvent($this, ['pre_data' => $preData, 'cur_data' => $info]);
                    $this->dispatcher->dispatch($event, Events::onProjectUpdate);
                    $this->ajaxSuccess("success");
                } else {
                    $projectModel->db->rollBack();
                    $this->ajaxFailed('错误', '更新数据失败');
                }
            } catch (\Exception $e) {
                $projectModel->db->rollBack();
                $this->ajaxFailed('数据库执行失败', $e->getMessage());
            }
        } else {
            $this->ajaxFailed('错误', '请求方式ERR');
        }
    }

    public function updateProjectKey()
    {
        if (isPost()) {
            $params = $_POST['params'];
            $uid = $this->getCurrentUid();
            $projectModel = new ProjectModel($uid);

            if (!isset($params['key']) || !isset($params['new_key'])) {
                $this->ajaxFailed('param_error:need key name');
            }

            $params['new_key'] = trim($params['new_key']);
            if ($params['key'] == $params['new_key']) {
                $this->ajaxFailed('param_error:key repetition');
            }

            $isNotKey = $projectModel->checkIdKeyExist($_GET[ProjectLogic::PROJECT_GET_PARAM_ID], $params['new_key']);
            if ($isNotKey) {
                $this->ajaxFailed('param_error:KEY Exist.');
            }

            $info = [];
            $info['key'] = $params['new_key'];
            $ret = $projectModel->update($info, array("id" => $_GET[ProjectLogic::PROJECT_GET_PARAM_ID]));

            if ($ret[0]) {
                $this->ajaxSuccess("success");
            } else {
                $this->ajaxFailed('错误', '更新数据失败,详情:' . $ret[1]);
            }
        } else {
            $this->ajaxFailed('错误', '请求方式错误');
        }
    }


    /**
     * @throws \Exception
     */
    public function issueType()
    {
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $logic = new IssueTypeLogic();
        $data['issue_types'] = $logic->getIssueType($projectId);
        $this->ajaxSuccess('success', $data);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function fetchIssueTypeBySchemeID()
    {
        $schemeId = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $logic = new IssueTypeLogic();
        $data['issue_types'] = $logic->getIssueTypeBySchemeID($schemeId);
        $this->ajaxSuccess('success', $data);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function togglePreDefinedFilter()
    {
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $key = isset($_POST['key']) ? $_POST['key'] : null;
        $action = isset($_POST['action']) ? $_POST['action'] : null;
        $uid = $this->getCurrentUid();
        $project = (new ProjectModel())->getById($projectId);
        if(empty($project)){
            $this->ajaxFailed("参数错误:project_id不存在");
        }
        if (!$action){
            $this->ajaxFailed("参数错误:action缺失");
        }

        if (!isset(IssueFavFilterLogic::$preDefinedFilter[$key])){
            $this->ajaxFailed("参数错误:key不存在");
        }
        $dbPreDefinedFilterArr = [];
        $projectFlagModel = new ProjectFlagModel();
        $filterFlagRow = $projectFlagModel->getByFlag($projectId, "filter_json");
        if (!isset($filterFlagRow['flag'])){
            if($action=='show'){
                $filterJsonArr = array_keys(IssueFavFilterLogic::$preDefinedFilter);
            }else{
                $filterJsonArr = array_keys(IssueFavFilterLogic::$preDefinedFilter);
                $index = array_search($key, $filterJsonArr);
                if($index!==false){
                    unset($filterJsonArr[$index]);
                }
            }
            $ret = $projectFlagModel->add($projectId, 'filter_json' , json_encode($filterJsonArr));

        }else{
            $dbPreDefinedFilterArr = json_decode($filterFlagRow['value'], true);
            if (is_null($dbPreDefinedFilterArr)){
                $dbPreDefinedFilterArr = [];
            }
            if($action=='show') {
                if (!in_array($key, $dbPreDefinedFilterArr)) {
                    $dbPreDefinedFilterArr[] = $key;
                }
            }else{
                if (in_array($key, $dbPreDefinedFilterArr)) {
                    $index = array_search($key, $dbPreDefinedFilterArr);
                    if($index!==false){
                        unset($dbPreDefinedFilterArr[$index]);
                    }
                }
            }
            $filterJsonArr = $dbPreDefinedFilterArr;
            $ret = $projectFlagModel->updateById($filterFlagRow['id'], ['value'=>json_encode($filterJsonArr)]);
        }

        if ($ret[0]) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT_SETTING;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目的过滤器';
            $logData['pre_data'] = $dbPreDefinedFilterArr;
            $logData['cur_data'] = $filterJsonArr;
            LogOperatingLogic::add($uid, $projectId, $logData);
            // 发布事件通知
            $event = new CommonPlacedEvent($this, ['pre_data' => $dbPreDefinedFilterArr, 'cur_data' => $filterJsonArr]);
            $this->dispatcher->dispatch($event,  Events::onProjectFilterUpdate);
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器执行失败，请重试');
        }
    }

    /**
     * @throws \Exception
     */
    public function updateFilter()
    {
        $id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : null;
        $id = intval($id);
        $uid = $this->getCurrentUid();
        $issueFilterModel = new IssueFilterModel();

        $filter = $issueFilterModel->getRowById($id);
        if (!isset($filter['name'])) {
            $this->ajaxFailed('param_error:id_not_exist');
        }
        $row = [];
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $row['name'] = $_POST['name'];
        }
        if (isset($_POST['description'])) {
            $row['description'] = $_POST['description'];
        }
        if (isset($_POST['order_weight'])) {
            $row['order_weight'] = intval($_POST['order_weight']);
        }
        if (isset($_POST['is_show'])) {
            $row['is_show'] = intval($_POST['is_show']);
        }
        if (empty($row)) {
            $this->ajaxFailed('param_error:data_is_empty');
        }

        $ret = $issueFilterModel->updateById($id, $row);
        if ($ret[0]) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT_SETTING;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目的过滤器';
            $logData['pre_data'] = $filter;
            $logData['cur_data'] = $row;
            LogOperatingLogic::add($uid, $filter['projectid'], $logData);

            $event = new CommonPlacedEvent($this, ['pre_data' => $filter, 'cur_data' => $row]);
            $this->dispatcher->dispatch($event,  Events::onProjectFilterUpdate);
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器执行失败，请重试');
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    public function deleteFilter()
    {
        $id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : null;
        $issueFilterMode = new IssueFilterModel();
        $filter = $issueFilterMode->getRowById($id);
        if (!isset($filter['name'])) {
            $this->ajaxFailed('param_error:id_not_exist');
        }
        $projectId = $filter['projectid'];
        $updatePerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::ADMINISTER_PROJECTS);
        if (!$updatePerm) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要管理项目权限');
        }

        $deleted = $issueFilterMode->deleteItemById($id);
        if (!$deleted){
            $this->ajaxFailed('服务器执行失败');
        }
        $uid = $this->getCurrentUid();
        $callFunc = function ($value) {
            return '已删除';
        };
        $filter2 = array_map($callFunc, $filter);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->auth->getUser()['username'];
        $logData['real_name'] = $this->auth->getUser()['display_name'];
        $logData['obj_id'] = 0;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT_SETTING;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_DELETE;
        $logData['remark'] = '删除项目过滤器';
        $logData['pre_data'] = $filter;
        $logData['cur_data'] = $filter2;
        LogOperatingLogic::add($uid, $projectId, $logData);

        $event = new CommonPlacedEvent($this, $filter);
        $this->dispatcher->dispatch($event,  Events::onProjectFilterDelete);
        $this->ajaxSuccess('操作成功');
    }

    /**
     * @throws \Exception
     */
    public function fetchFilter()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $issueFilterModel = new IssueFilterModel();
        $userFilter =  $issueFilterModel->getItemById($id);
        if(empty($userFilter)){
            $this->ajaxFailed('数据不存在,可能已经被删除了,请刷新页面重试');
        }
        $this->ajaxSuccess('ok', $userFilter);
    }

    /**
     * @throws \Exception
     */
    public function fetchFilters()
    {
        $data['filters'] = [];
        $projectId = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;
        $project = (new ProjectModel())->getById($projectId);
        if(empty($project)){
           $this->ajaxSuccess('ok', $data);
        }
        $data['filters'] = IssueFavFilterLogic::fetchProjectFilters($projectId);

        $this->ajaxSuccess('ok', $data);
    }

    /**
     * @throws \Exception
     */
    public function updateDisplayField()
    {
        $projectId = isset($_REQUEST['project_id']) ? (int)$_REQUEST['project_id'] : null;
        $projectId = intval($projectId);
        $updatePerm = PermissionLogic::check($projectId, UserAuth::getId(), PermissionLogic::ADMINISTER_PROJECTS);
        if (!$updatePerm) {
            $this->ajaxFailed('当前项目中您没有权限进行此操作,需要管理项目权限');
        }
        $isUserDisplayField = isset($_POST['is_user_display_field']) ? $_POST['is_user_display_field'] : null;
        $fieldArr = [];
        if (!empty($_POST['display_fields'])) {
            $fieldArr = $_POST['display_fields'];
        }
        $uid = $this->getCurrentUid();
        $project = (new ProjectModel())->getById($projectId);
        if(empty($project)){
            $this->ajaxFailed("参数错误:project_id不存在");
        }
        $projectFlagModel = new ProjectFlagModel();
        $flagRow = $projectFlagModel->getByFlag($projectId, "display_field_json");
        if (!isset($flagRow['flag'])){
            $ret = $projectFlagModel->add($projectId, 'display_field_json' , json_encode($fieldArr));
        }else{
            $ret = $projectFlagModel->updateById($flagRow['id'], ['value'=>json_encode($fieldArr)]);
        }
        $flagRow = $projectFlagModel->getByFlag($projectId, "is_user_display_field");
        if (!isset($flagRow['flag'])){
            $ret = $projectFlagModel->add($projectId, 'is_user_display_field' , $isUserDisplayField);
        }else{
            $ret = $projectFlagModel->updateById($flagRow['id'], ['value'=>$isUserDisplayField]);
        }
        if ($ret[0]) {
            //写入操作日志
            $logData = [];
            $logData['user_name'] = $this->auth->getUser()['username'];
            $logData['real_name'] = $this->auth->getUser()['display_name'];
            $logData['obj_id'] = 0;
            $logData['module'] = LogOperatingLogic::MODULE_NAME_PROJECT_SETTING;
            $logData['page'] = $_SERVER['REQUEST_URI'];
            $logData['action'] = LogOperatingLogic::ACT_EDIT;
            $logData['remark'] = '修改项目的表格字段';
            $logData['pre_data'] = $flagRow;
            $logData['cur_data'] = [];
            LogOperatingLogic::add($uid, $projectId, $logData);
            $event = new CommonPlacedEvent($this, ['pre_data' => $flagRow, 'cur_data' => []]);
            $this->dispatcher->dispatch($event,  Events::onProjectDisplayFieldUpdate);
            $this->ajaxSuccess('操作成功');
        } else {
            $this->ajaxFailed('服务器执行失败，请重试');
        }
    }

}
