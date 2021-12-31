<?php

namespace main\app\ctrl\project;

use main\app\classes\LogOperatingLogic;
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
use main\app\model\issue\IssueTypeSchemeItemsModel;
use main\app\model\OrgModel;
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
}
