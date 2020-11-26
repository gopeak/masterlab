<?php


namespace main\app\api\issue;


use main\app\api\BaseAuth;
use main\app\api\Constants;
use main\app\classes\IssueFilterLogic;
use main\app\classes\IssueLogic;
use main\app\classes\LogOperatingLogic;
use main\app\classes\NotifyLogic;
use main\app\classes\PermissionLogic;
use main\app\classes\ProjectGantt;
use main\app\classes\UserAuth;
use main\app\classes\UserLogic;
use main\app\classes\WorkflowLogic;
use main\app\event\CommonPlacedEvent;
use main\app\event\Events;
use main\app\model\agile\SprintModel;
use main\app\model\field\FieldModel;
use main\app\model\issue\ExtraWorkerDayModel;
use main\app\model\issue\HolidayModel;
use main\app\model\issue\IssueEffectVersionModel;
use main\app\model\issue\IssueFileAttachmentModel;
use main\app\model\issue\IssueFilterModel;
use main\app\model\issue\IssueFixVersionModel;
use main\app\model\issue\IssueFollowModel;
use main\app\model\issue\IssueLabelDataModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueRecycleModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\issue\IssueUiModel;
use main\app\model\project\ProjectGanttSettingModel;
use main\app\model\project\ProjectLabelModel;
use main\app\model\project\ProjectModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\project\ProjectVersionModel;
use main\app\model\user\UserModel;

class Issues extends BaseAuth
{
    /**
     * 项目事项接口
     * @return array
     */
    public function v1()
    {
        if (in_array($this->requestMethod, self::$method_type)) {
            $handleFnc = $this->requestMethod . 'Handler';
            return $this->$handleFnc();
        }
        return self::returnHandler('api方法错误');
    }


    /**
     * Restful GET , 获取事项列表 | 单个事项信息
     * 获取列表: {{API_URL}}/api/issue/issues/v1/?project=1&access_token==xyz
     * 获取单个: {{API_URL}}/api/issue/issues/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function getHandler()
    {
        $uid = $this->masterUid;
        $projectId = 0;
        $issueId = 0;

        if (isset($_GET['_target'][4])) {
            $issueId = intval($_GET['_target'][4]);
        }

        if ($issueId > 0) {
            $final = $this->format($issueId);
        } else {
            if (!isset($_GET['project'])) {
                //$projectId = intval($_GET['project']);
                return self::returnHandler('获取事项列表需要project参数', [], Constants::HTTP_BAD_REQUEST);
            }
            $final = $this->filter();
        }

        return self::returnHandler('OK', $final);
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    private function deleteHandler()
    {
        $uid = $this->masterUid;
        $issueId = null;

        if (isset($_GET['_target'][4])) {
            $issueId = intval($_GET['_target'][4]);
        }
        if (empty($issueId)) {
            return self::returnHandler('事项id不能为空', [], Constants::HTTP_BAD_REQUEST);
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);
        if (empty($issue)) {
            return self::returnHandler('参数错误:事项不存在', [], Constants::HTTP_BAD_REQUEST);
        }

        try {
            $issueModel->db->beginTransaction();
            $ret = $issueModel->deleteById($issueId);
            if ($ret) {
                // 将子任务的关系清除
                $issueModel->update(['master_id' => '0'], ['master_id' => $issueId]);
                // 将父任务的 have_children 减 1
                if (!empty($issue['master_id'])) {
                    $masterId = $issue['master_id'];
                    $issueModel->dec('have_children', $masterId, 'id', 1);
                }
                unset($issue['id']);
                $issue['delete_user_id'] = $uid;
                $issueRecycleModel = new IssueRecycleModel();
                $info = [];
                $info['issue_id'] = $issueId;
                $info['project_id'] = $issue['project_id'];
                $info['delete_user_id'] = $uid;
                $info['summary'] = $issue['summary'];
                $info['data'] = json_encode($issue);
                $info['time'] = time();
                list($deleteRet, $msg) = $issueRecycleModel->insert($info);
                unset($info);
                if (!$deleteRet) {
                    $issueModel->db->rollBack();
                    return self::returnHandler('服务器错误 新增删除的数据失败,详情:' . $msg, [], Constants::HTTP_BAD_REQUEST);
                }
            }
            $issueModel->db->commit();
        } catch (\PDOException $e) {
            $issueModel->db->rollBack();
            return self::returnHandler('服务器错误 数据库异常,详情:' . $e->getMessage(), [], Constants::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
        }
        $issue['id'] = $issueId;
        $event = new CommonPlacedEvent($this, $issue);
        $this->dispatcher->dispatch($event, Events::onIssueDelete);


        return self::returnHandler('删除成功');
    }

    /**
     * Restful PATCH ,更新事项
     * {{API_URL}}/api/issue/issues/v1/36?access_token==xyz
     * @return array
     * @throws \Exception
     */
    private function patchHandler()
    {
        $uid = $this->masterUid;
        $issueId = null;

        if (isset($_GET['_target'][4])) {
            $issueId = intval($_GET['_target'][4]);
        }
        if (empty($issueId)) {
            return self::returnHandler('事项id不能为空', [], Constants::HTTP_BAD_REQUEST);
        }

        $patch = self::_PATCH();
        $params = $patch;

        $info = [];
        if (isset($params['summary'])) {
            $info['summary'] = htmlentities($params['summary']);
        }

        $info = $info + $this->getUpdateFormInfo($params);
        if (empty($info)) {
            return self::returnHandler('参数错误,数据为空', [], Constants::HTTP_BAD_REQUEST);
        }

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        $event = new CommonPlacedEvent($this, $_REQUEST);
        $this->dispatcher->dispatch($event, Events::onIssueUpdateBefore);

        $issueType = $issue['issue_type'];
        if (isset($params['issue_type'])) {
            $issueType = $params['issue_type'];
        }


        /* API不需要校验所有字段
        // 事项UI配置判断输入是否为空
        $issueUiModel = new IssueUiModel();
        $fieldModel = new FieldModel();
        $fieldsArr = $fieldModel->getAll();
        $uiConfigs = $issueUiModel->getsByUiType($issueType, 'edit');
        //print_r($uiConfigs);
        // 迭代字段不会判断输入
        $excludeFieldArr = ['sprint'];
        foreach ($uiConfigs as $uiConfig) {
            if ($uiConfig['required'] && isset($fieldsArr[$uiConfig['field_id']])) {
                $field = $fieldsArr[$uiConfig['field_id']];
                $fieldName = $field['name'];
                if (in_array($fieldName, $excludeFieldArr)) {
                    continue;
                }
                if (isset($info[$fieldName]) && isset($params[$fieldName]) && empty(trimStr($params[$fieldName]))) {
                    $err[$fieldName] = $field['title'] . '不能为空';
                }
            }
        }
        */



        if (!empty($err)) {
            return self::returnHandler('表单验证失败', $err, Constants::HTTP_BAD_REQUEST);
        }

        foreach ($info as $k => $v) {
            if ($v == $issue[$k]) {
                unset($info[$k]);
            }
        }

        // 实例化邮件通知
        $notifyLogic = new NotifyLogic();
        $notifyFlag = NotifyLogic::NOTIFY_FLAG_ISSUE_UPDATE;

        $info['modifier'] = $uid;

        // 状态 如果是关闭状态则要检查权限
        if (isset($info['status']) && $issue['status'] != $info['status']) {
            $notifyFlag = $notifyLogic->getEmailNotifyFlag($info['status']);
        }

        // 解决结果 如果是关闭状态则要检查权限
        if (isset($info['resolve']) && $issue['resolve'] != $info['resolve']) {

        }

        list($ret, $affectedRows) = $issueModel->updateById($issueId, $info);
        if (!$ret) {
            return self::returnHandler('更新数据失败,详情:' . $affectedRows, [], Constants::HTTP_BAD_REQUEST);
        }

        // 更新用时
        if (isset($info['start_date']) || isset($info['due_date'])) {
            $holidays = (new HolidayModel())->getDays($issue['project_id']);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($issue['project_id']);
            $updatedIssue = $issueModel->getById($issueId);
            $updateDurationArr = [];
            $ganttSetting = (new ProjectGanttSettingModel())->getByProject($issue['project_id']);
            $workDates = json_decode($ganttSetting['work_dates'], true);
            $updateDurationArr['duration'] = getWorkingDays(
                $updatedIssue['start_date'],
                $updatedIssue['due_date'],
                $workDates,
                $holidays,
                $extraWorkerDays
            );
            // print_r($updateDurationArr);
            list($ret) = $issueModel->updateById($issueId, $updateDurationArr);
            if ($ret) {
                $updatedIssue['duration'] = $updateDurationArr['duration'];
            }

        }

        //写入操作日志
        $curIssue = $issue;
        foreach ($curIssue as $k => $v) {
            if (isset($info[$k])) {
                $curIssue[$k] = $info[$k];
            }
        }
        $issueLogic = new IssueLogic();
        // 协助人
        if (isset($params['assistants'])) {
            if (empty($params['assistants'])) {
                $issueLogic->emptyAssistants($issueId);
            } else {
                $issueLogic->updateAssistants($issueId, $params['assistants']);
            }
        }
        // fix version
        if (isset($params['fix_version'])) {
            $model = new IssueFixVersionModel();
            $model->delete(['issue_id' => $issueId]);
            $issueLogic->addChildData($model, $issueId, $params['fix_version'], 'version_id');
        }
        // effect version
        if (isset($params['effect_version'])) {
            $model = new IssueEffectVersionModel();
            $model->delete(['issue_id' => $issueId]);
            $issueLogic->addChildData($model, $issueId, $params['effect_version'], 'version_id');
        }
        // labels
        if (isset($params['labels'])) {
            $model = new IssueLabelDataModel();
            if (empty($params['labels'])) {
                $model->delete(['issue_id' => $issueId]);
            } else {
                $issueLogic->addChildData($model, $issueId, $params['labels'], 'label_id');
            }
        }
        // FileAttachment
        $this->updateFileAttachment($issueId, $params);
        // 自定义字段值
        $issueLogic->updateCustomFieldValue($issueId, $params, $issue['project_id']);

        // 记录活动日志
        $fromModule = null;
        if (isset($params['from_module'])) {
            $fromModule = strtolower(trim($params['from_module']));
        } elseif (isset($_GET['from_module'])) {
            $fromModule = strtolower(trim($_GET['from_module']));
        }

        // 操作日志
        $logData = [];
        $logData['user_name'] = $this->masterAccount;
        $logData['real_name'] = $this->masterAccount;
        $logData['obj_id'] = $issueId;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_EDIT;
        $logData['remark'] = '修改事项';
        $logData['pre_data'] = $issue;
        $logData['cur_data'] = $curIssue;
        LogOperatingLogic::add($uid, $issue['project_id'], $logData);

        // email通知
        if (isset($notifyFlag)) {
            $notifyLogic->send($notifyFlag, $issue['project_id'], $issueId);
        }
        $updatedIssue = $issueModel->getById($issueId);
        $event = new CommonPlacedEvent($this, $updatedIssue);
        $this->dispatcher->dispatch($event, Events::onIssueUpdateAfter);

        return self::returnHandler('更新成功', array_merge($updatedIssue, ['id' => $issueId]));
    }



    /**
     * Restful POST 添加事项
     * {{API_URL}}/api/issue/issues/v1/?access_token==xyz
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Exception
     */
    private function postHandler()
    {
        $uid = $this->masterUid;
        $params = $_POST;

        $err = [];
        if (!isset($params['summary']) || empty(trimStr($params['summary']))) {
            $err['summary'] = '标题不能为空';
        }
        if (!isset($params['issue_type']) || empty(trimStr($params['issue_type']))) {
            $err['issue_type'] = '事项类型不能为空';
        }
        if (!isset($params['project_id']) || empty(trimStr($params['project_id']))) {
            $err['project_id'] = '需要项目ID';
        }

        // 分发事件
        $event = new CommonPlacedEvent($this, $params);
        $this->dispatcher->dispatch($event, Events::onIssueCreateBefore);

        // 优先级 , @todo 数据库字段增加一个默认值，管理页面可以修改
        $getDefaultPriorityId = function () {
            return (new IssuePriorityModel())->getIdByKey('normal');
        };


        $priorityId = null;
        if (isset($params['priority'])) {
            $priorityId = (int)$params['priority'];
            $model = new IssuePriorityModel();
            $issuePriority = $model->getById($priorityId);
            if (!$issuePriority) {
                $priorityId = $getDefaultPriorityId();
            }
        } else {
            $priorityId = $getDefaultPriorityId();
        }

        /* API不需要校验所有字段
        // 事项UI配置判断输入是否为空
        $issueUiModel = new IssueUiModel();
        $fieldModel = new FieldModel();
        $fieldsArr = $fieldModel->getAll();
        $uiConfigs = $issueUiModel->getsByUiType($params['issue_type'], 'create');
        //print_r($uiConfigs);
        // 迭代字段不会判断输入
        $excludeFieldArr = ['sprint', 'priority'];
        foreach ($uiConfigs as $uiConfig) {
            if ($uiConfig['required'] && isset($fieldsArr[$uiConfig['field_id']])) {
                $field = $fieldsArr[$uiConfig['field_id']];
                $fieldName = $field['name'];
                if (in_array($fieldName, $excludeFieldArr)) {
                    continue;
                }
                if (!isset($params[$fieldName]) || empty(trimStr($params[$fieldName]))) {
                    $err[$fieldName] = $field['title'] . '不能为空';
                }
            }
        }
        */

        if (!empty($err)) {
            return self::returnHandler('表单验证失败', $err, Constants::HTTP_BAD_REQUEST);
        }

        // 所属项目
        $projectId = (int)$params['project_id'];
        $projectModel = new ProjectModel();
        $project = $projectModel->getById($projectId);
        if (!isset($project['id'])) {
            return self::returnHandler('项目ID不存在', [], Constants::HTTP_BAD_REQUEST);
        }

        // issue 类型
        $issueTypeId = (int)$params['issue_type'];
        $model = new IssueTypeModel();
        $issueTypes = $model->getAll();
        if (!isset($issueTypes[$issueTypeId])) {
            return self::returnHandler('事项类型参数错误', [], Constants::HTTP_BAD_REQUEST);
        }
        unset($issueTypes);

        $info = [];
        $info['summary'] = $params['summary'];
        $info['creator'] = $uid;
        $info['reporter'] = $uid;
        $info['created'] = time();
        $info['updated'] = time();
        $info['project_id'] = $projectId;
        $info['issue_type'] = $issueTypeId;
        $info['priority'] = $priorityId;

        $info = $info + $this->getAddFormInfo($params);

        $model = new IssueModel();


        list($ret, $issueId) = $model->insert($info);
        if (!$ret) {
            return self::returnHandler('服务器执行错误,原因:' . $issueId, [], Constants::HTTP_BAD_REQUEST);
        }
        $issueUpdateInfo = [];
        $issueUpdateInfo['pkey'] = $project['key'];
        $issueUpdateInfo['issue_num'] = $issueId;
        // print_r($params);
        if (isset($params['master_issue_id'])) {
            $masterId = (int)$params['master_issue_id'];
            $master = $model->getById($masterId);
            if (!empty($master)) {
                $info['id'] = $issueId;
                $event = new CommonPlacedEvent($this, ['master'=>$master,'child'=>$info]);
                $this->dispatcher->dispatch($event, Events::onIssueCreateChild);
            }
        }
        $model->updateById($issueId, $issueUpdateInfo);

        unset($project);
        //写入操作日志
        $logData = [];
        $logData['user_name'] = $this->masterAccount;
        $logData['real_name'] = $this->masterAccount;
        $logData['obj_id'] = $issueId;
        $logData['module'] = LogOperatingLogic::MODULE_NAME_ISSUE;
        $logData['page'] = $_SERVER['REQUEST_URI'];
        $logData['action'] = LogOperatingLogic::ACT_ADD;
        $logData['remark'] = '新增事项';
        $logData['pre_data'] = [];
        $logData['cur_data'] = $info;
        LogOperatingLogic::add($uid, $projectId, $logData);

        $issueLogic = new IssueLogic();
        // 协助人
        if (isset($params['assistants'])) {
            $issueLogic->addAssistants($issueId, $params['assistants']);
        }
        // fix version
        if (isset($params['fix_version'])) {
            $model = new IssueFixVersionModel();
            $issueLogic->addChildData($model, $issueId, $params['fix_version'], 'version_id');
        }
        // effect version
        if (isset($params['effect_version'])) {
            $model = new IssueEffectVersionModel();
            $issueLogic->addChildData($model, $issueId, $params['effect_version'], 'version_id');
        }
        // labels
        if (isset($params['labels'])) {
            $model = new IssueLabelDataModel();
            $issueLogic->addChildData($model, $issueId, $params['labels'], 'label_id');
        }
        // FileAttachment
        $this->updateFileAttachment($issueId, $params);
        // 自定义字段值
        // @todo这里表结构有bug需要测试
        $issueLogic->addCustomFieldValue($issueId, $projectId, $params);

        // email
        $notifyLogic = new NotifyLogic();
        $notifyLogic->send(NotifyLogic::NOTIFY_FLAG_ISSUE_CREATE, $projectId, $issueId);

        // 分发事件
        $info['id'] = $issueId;
        $event = new CommonPlacedEvent($this, $info);
        $this->dispatcher->dispatch($event, Events::onIssueCreateAfter);


        return self::returnHandler('添加成功', ['id' => $issueId]);
    }

    /**
     * @param array $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getUpdateFormInfo($params = [])
    {
        $info = [];
        // 标题
        if (isset($params['summary'])) {
            $info['summary'] = htmlentities($params['summary']);
        }

        if (isset($params['issue_type'])) {
            $info['issue_type'] = (int)$params['issue_type'];
        }

        // 状态
        if (isset($params['status'])) {
            $statusId = (int)$params['status'];
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAll();
            if (!isset($issueStatusArr[$statusId])) {
                throw new \Exception('param_error:status_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($issueStatusArr);
            $info['status'] = $statusId;
        }

        // 优先级
        if (isset($params['priority'])) {
            $priorityId = (int)$params['priority'];
            $model = new IssuePriorityModel();
            $issuePriority = $model->getAll();
            if (!isset($issuePriority[$priorityId])) {
                throw new \Exception('param_error:priority_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($issuePriority);
            $info['priority'] = $priorityId;
        }

        // 解决结果
        if (isset($params['resolve']) && !empty($params['resolve'])) {
            $resolveId = (int)$params['resolve'];
            $model = new IssueResolveModel();
            $issueResolves = $model->getAll();
            if (!isset($issueResolves[$resolveId])) {
                throw new \Exception('param_error:resolve_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($issueResolves);
            $info['resolve'] = $resolveId;
        }

        // 负责人
        if (isset($params['assignee']) && !empty($params['assignee'])) {
            $assigneeUid = (int)$params['assignee'];
            $model = new UserModel();
            $user = $model->getByUid($assigneeUid);
            if (!isset($user['uid'])) {
                throw new \Exception('param_error:assignee_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($user);
            $info['assignee'] = $assigneeUid;
        }

        // 报告人
        if (isset($params['reporter']) && !empty($params['reporter'])) {
            $reporterUid = (int)$params['reporter'];
            $model = new UserModel();
            $user = $model->getByUid($reporterUid);
            if (!isset($user['uid'])) {
                throw new \Exception('param_error:reporter_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($user);
            $info['reporter'] = $reporterUid;
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        }

        if (isset($params['module'])) {
            $info['module'] = $params['module'];
        }

        if (isset($params['environment'])) {
            $info['environment'] = htmlentities($params['environment']);
        }


        if (isset($params['milestone'])) {
            $info['milestone'] = (int)$params['milestone'];
        }

        if (isset($params['sprint'])) {
            $info['sprint'] = (int)$params['sprint'];
        }
        //print_r($info);
        if (isset($params['weight'])) {
            $info['weight'] = (int)$params['weight'];
        }

        $this->getGanttInfo($params, $info);
        // print_r($info);
        return $info;
    }

    /**
     * 取新增或编辑时提交上来的事项内容
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function getAddFormInfo(&$params = [])
    {
        $info = [];

        // 标题
        if (isset($params['summary'])) {
            $info['summary'] = htmlentities($params['summary']);
        }

        if (isset($params['issue_type'])) {
            $info['issue_type'] = (int)$params['issue_type'];
        } else {
            $issueTypeId = (new IssueTypeModel())->getIdByKey('task');
            $info['issue_type'] = $issueTypeId;
        }

        // 状态
        if (isset($params['status'])) {
            $statusId = (int)$params['status'];
            $model = new IssueStatusModel();
            $issueStatusArr = $model->getAll();
            if (!isset($issueStatusArr[$statusId])) {
                throw new \Exception('param_error:status_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($issueStatusArr);
            $info['status'] = $statusId;
        } else {
            $statusId = (new IssueStatusModel())->getIdByKey('open');
            $info['status'] = $statusId;
        }

        // 解决结果, @todo 数据库字段增加一个默认值，管理页面可以修改
        $getDefaultResolveId = function () {
            $resolveId = (new IssueResolveModel())->getIdByKey('not_fix');
            $info['resolve'] = $resolveId;
            return $resolveId;
        };
        if (isset($params['resolve']) && !empty($params['resolve'])) {
            $resolveId = (int)$params['resolve'];
            $model = new IssueResolveModel();
            $issueResolves = $model->getAll();
            if (!isset($issueResolves[$resolveId])) {
                $resolveId = $getDefaultResolveId();
            }
            unset($issueResolves);
            $info['resolve'] = $resolveId;
        } else {
            $info['resolve'] = $getDefaultResolveId();
        }

        // 负责人
        if (isset($params['assignee']) && !empty($params['assignee'])) {
            $assigneeUid = (int)$params['assignee'];
            $model = new UserModel();
            $user = $model->getByUid($assigneeUid);
            if (!isset($user['uid'])) {
                //self::echoJson('param_error:assignee_not_found', [], Constants::HTTP_BAD_REQUEST);
                throw new \Exception('param_error:assignee_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($user);
            $info['assignee'] = $assigneeUid;
        } else {
            $info['assignee'] = $this->masterUid;
        }

        // 报告人
        if (isset($params['reporter']) && !empty($params['reporter'])) {
            $reporterUid = (int)$params['reporter'];
            $model = new UserModel();
            $user = $model->getByUid($reporterUid);
            if (!isset($user['uid'])) {
                throw new \Exception('param_error:reporter_not_found', Constants::HTTP_BAD_REQUEST);
            }
            unset($user);
            $info['reporter'] = $reporterUid;
        } else {
            $info['reporter'] = $this->masterUid;
        }

        if (isset($params['description'])) {
            $info['description'] = $params['description'];
        } else {
            $info['description'] = '';
        }

        if (isset($params['module'])) {
            $projectModuleModel = new ProjectModuleModel();
            $modulesArr = $projectModuleModel->getByProject($params['project_id'], true);
            $moduleIdsArr = array_keys($modulesArr);
            if (in_array($params['module'], $moduleIdsArr)) {
                $info['module'] = $params['module'];
            }
        }

        if (isset($params['environment'])) {
            $info['environment'] = htmlentities($params['environment']);
        }


        if (isset($params['milestone'])) {
            $info['milestone'] = (int)$params['milestone'];
        }

        if (array_key_exists('sprint', $params)) {
            $info['sprint'] = (int)$params['sprint'];
        }
        //print_r($info);
        if (isset($params['weight'])) {
            $info['weight'] = (int)$params['weight'];
        }
        $this->getGanttInfo($params, $info);
        if (!empty($params['start_date']) && !empty($params['due_date'])) {
            $holidays = (new HolidayModel())->getDays($params['project_id']);
            $extraWorkerDays = (new ExtraWorkerDayModel())->getDays($params['project_id']);
            $ganttSetting = (new ProjectGanttSettingModel())->getByProject($params['project_id']);
            $workDates = json_decode($ganttSetting['work_dates'], true);
            $info['duration'] = getWorkingDays(
                $params['start_date'],
                $params['due_date'],
                $workDates,
                $holidays,
                $extraWorkerDays
            );
        }

        $this->initAddGanttWeight($params, $info);
        // print_r($info);
        return $info;
    }

    /**
     * @param $params
     * @param $info
     * @throws \Doctrine\DBAL\DBALException
     */
    private function getGanttInfo(&$params, &$info)
    {
        if (isset($params['start_date'])) {
            $info['start_date'] = $params['start_date'];
        }

        if (isset($params['due_date'])) {
            $info['due_date'] = $params['due_date'];
        }
        if (isset($params['gant_hide'])) {
            $info['gant_hide'] = (int)$params['gant_hide'];
        }

        if (isset($params['progress'])) {
            $info['progress'] = max(0, (int)$params['progress']);
        }

        if (isset($params['depends'])) {
            $info['depends'] = (int)$params['depends'];
        }

        if (isset($_GET['from_gantt']) && $_GET['from_gantt'] == '1') {
            if (isset($params['is_start_milestone'])) {
                $info['is_start_milestone'] = (int)$params['is_start_milestone'] > 0 ? 1 : 0;
            } else {
                $info['is_start_milestone'] = 0;
            }
            if (isset($params['is_end_milestone'])) {
                $info['is_end_milestone'] = (int)$params['is_end_milestone'] > 0 ? 1 : 0;
            } else {
                $info['is_end_milestone'] = 0;
            }
            // 如果是在某一事项之下,排序值是两个事项之间二分之一
            if (isset($params['below_id']) && !empty($params['below_id'])) {
                $belowIssueId = (int)$params['below_id'];
                $model = new IssueModel();
                $table = $model->getTable();
                $belowIssue = $model->getRow("gant_sprint_weight,sprint,master_id", ['id' => $belowIssueId]);
                $fieldWeight = 'gant_sprint_weight';
                $aboveWeight = (int)$belowIssue[$fieldWeight];
                $sprintId = $belowIssue['sprint'];
                $sql = "Select {$fieldWeight} From {$table} Where `$fieldWeight` < {$aboveWeight}  AND `sprint` = {$sprintId} Order by {$fieldWeight} DESC  limit 1";

                $nextWeight = (int)$model->getFieldBySql($sql);
                if (empty($nextWeight)) {
                    $nextWeight = 0;
                }
                $info[$fieldWeight] = max(0, $nextWeight + intval(($aboveWeight - $nextWeight) / 2));

                if (!empty($belowIssue['master_id'])) {
                    $params['master_issue_id'] = $belowIssue['master_id'];
                }
                // print_r($params);
                unset($model, $belowIssue);
            }
            // 如果是在某一事项之上,排序值是两个事项之间二分之一
            if (isset($params['above_id']) && !empty($params['above_id'])) {
                $aboveIssueId = (int)$params['above_id'];
                $model = new IssueModel();
                $table = $model->getTable();
                $aboveIssue = $model->getRow("gant_sprint_weight, sprint,master_id", ['id' => $aboveIssueId]);
                $fieldWeight = 'gant_sprint_weight';
                $belowWeight = (int)$aboveIssue[$fieldWeight];
                $sprintId = $aboveIssue['sprint'];
                $sql = "Select {$fieldWeight} From {$table} Where $fieldWeight>$belowWeight  AND sprint=$sprintId Order by {$fieldWeight} DESC limit 1";
                // echo $sql;
                $prevWeight = (int)$model->getFieldBySql($sql);
                if (empty($prevWeight)) {
                    $prevWeight = 0;
                }
                $info[$fieldWeight] = max(0, $belowWeight + intval(($prevWeight - $belowWeight) / 2));
                unset($model, $belowIssue);
            }
            // print_r($info);
        }
    }

    /**
     * 更新事项的附件
     * @param $issueId
     * @param $params
     * @throws \Exception
     */
    private function updateFileAttachment($issueId, $params)
    {
        if (isset($params['attachment'])) {
            $model = new IssueFileAttachmentModel();
            $attachments = json_decode($params['attachment'], true);
            if (empty($attachments)) {
                $model->delete(['issue_id' => $issueId]);
            } else {
                foreach ($attachments as $file) {
                    $uuid = $file['uuid'];
                    $model->update(['issue_id' => $issueId], ['uuid' => $uuid]);
                }
            }
        }
    }

    /**
     * @param array $params
     * @param $info
     * @throws \Doctrine\DBAL\DBALException
     */
    private function initAddGanttWeight($params = [], &$info)
    {
        // 如果是不在甘特图提交的
        $fieldWeight = 'gant_sprint_weight';
        $model = new IssueModel();
        $table = $model->getTable();
        $sprintId = 0;
        if (isset($params['sprint'])) {
            $sprintId = intval($params['sprint']);
        }
        if (@empty($params['above_id']) && @empty($params['below_id'])) {
            $model = new IssueModel();
            if (isset($params['master_issue_id']) && !empty($params['master_issue_id'])) {
                // 如果是子任务
                $masterId = (int)$params['master_issue_id'];
                $sql = "Select {$fieldWeight} From {$table} Where master_id={$masterId}  AND sprint={$sprintId} Order by {$fieldWeight} ASC limit 1";

                $prevWeight = (int)$model->getFieldBySql($sql);
                $sql = "Select {$fieldWeight} From {$table} Where $prevWeight>{$fieldWeight} AND sprint={$sprintId} Order by {$fieldWeight} DESC limit 1";
                //echo $sql;

                $nextWeight = (int)$model->getFieldBySql($sql);
                if (($prevWeight - $nextWeight) > (ProjectGantt::$offset * 2)) {
                    $info[$fieldWeight] = $prevWeight - ProjectGantt::$offset;
                } else {
                    $info[$fieldWeight] = max(0, intval($prevWeight - ($prevWeight - $nextWeight) / 2));
                }
            } else {
                // 如果是普通任务
                $sql = "Select {$fieldWeight} From {$table} Where   sprint={$sprintId} Order by {$fieldWeight} ASC limit 1";

                $minWeight = (int)$model->getFieldBySql($sql);
                if ($minWeight > (ProjectGantt::$offset * 2)) {
                    $info[$fieldWeight] = $minWeight - ProjectGantt::$offset;
                } else {
                    $info[$fieldWeight] = max(0, intval($minWeight / 2));
                }
            }

        }
    }

    /**
     * @param $issueId
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    private function format($issueId)
    {
        $data['issue_id'] = $issueId;

        $issueModel = new IssueModel();
        $issue = $issueModel->getById($issueId);

        if (empty($issue)) {
            return [];
        }
        $issueTypeId = (int)$issue['issue_type'];
        $projectId = (int)$issue['project_id'];
        $model = new ProjectModel();
        $data['project'] = $model->getById($projectId);

        $model = new ProjectModuleModel();
        $module = $model->getById($issue['module']);
        $issue['module_name'] = isset($module['name']) ? $module['name'] : '';
        unset($module);

        $model = new SprintModel();
        $sprint = $model->getById($issue['sprint']);
        $issue['sprint_info'] = isset($sprint['name']) ? $sprint : new \stdClass();
        if (isset($_GET['from']) && $_GET['from']=='gantt') {
            if (isset($sprint['start_date']) && !empty($sprint['start_date']) && empty($issue['start_date'])) {
                $issue['start_date'] = $sprint['start_date'];
            }
            if (isset($sprint['end_date']) && !empty($sprint['end_date']) && empty($issue['due_date'])) {
                $issue['due_date'] = $sprint['end_date'];
            }
        }
        unset($sprint);

        $model = new ProjectVersionModel();
        $projectVersions = $model->getByProjectPrimaryKey($projectId);

        // 修复版本
        $model = new IssueFixVersionModel();
        $issueFixVersion = $model->getItemsByIssueId($issueId);
        $issue['fix_version_names'] = [];
        foreach ($issueFixVersion as $version) {
            $versionId = $version['version_id'];
            $issue['fix_version_names'][] = isset($projectVersions[$versionId]) ? $projectVersions[$versionId] : null;
        }
        unset($issueFixVersion);

        // 影响版本
        $model = new IssueEffectVersionModel();
        $issueEffectVersion = $model->getItemsByIssueId($issueId);
        $issue['effect_version_names'] = [];
        //print_r($projectVersions);
        foreach ($issueEffectVersion as $version) {
            $versionId = $version['version_id'];
            $issue['effect_version_names'][] = isset($projectVersions[$versionId]) ? $projectVersions[$versionId] : null;
        }
        unset($issueEffectVersion, $projectVersions);

        // issue 类型
        $issueTypeModel = new IssueTypeModel();
        $issueTypes = $issueTypeModel->getAll(true);
        $issue['issue_type_info'] = new \stdClass();
        if (isset($issueTypes[$issueTypeId])) {
            $issue['issue_type_info'] = $issueTypes[$issueTypeId];
        }
        unset($issueTypes);

        $model = new IssueResolveModel();
        $issueResolve = $model->getAll();
        $resolveId = $issue['resolve'];
        $issue['resolve_info'] = new \stdClass();
        if (isset($issueResolve[$resolveId])) {
            $issue['resolve_info'] = $issueResolve[$resolveId];
        }

        $model = new IssueStatusModel();
        $issueStatus = $model->getAll();
        $statusId = $issue['status'];
        $issue['status_info'] = new \stdClass();
        if (isset($issueStatus[$statusId])) {
            $issue['status_info'] = $issueStatus[$statusId];
        }

        $model = new IssuePriorityModel();
        $priority = $model->getAll();
        $priorityId = $issue['priority'];
        $issue['priority_info'] = new \stdClass();
        if (isset($priority[$priorityId])) {
            $issue['priority_info'] = $priority[$priorityId];
        }

        // 当前事项应用的标签id
        $model = new ProjectLabelModel();
        $issueLabels = $model->getAll();
        $model = new IssueLabelDataModel();
        $issueLabelData = $model->getItemsByIssueId($issueId);
        $issue['labels_names'] = [];
        foreach ($issueLabelData as $label) {
            $labelId = $label['label_id'];
            $issue['labels_names'][$labelId] = isset($issueLabels[$labelId]) ? $issueLabels[$labelId] : null;
        }
        sort($issue['labels_names']);
        $issue['labels'] = $issueLabelData;
        unset($issueLabels);

        $model = new IssueFileAttachmentModel();
        $attachmentDatas = $model->getsByIssueId($issueId);
        $issue['attachment'] = [];
        foreach ($attachmentDatas as $f) {
            $file = [];
            $file['thumbnailUrl'] = ATTACHMENT_URL . $f['file_name'];
            $file['size'] = $f['file_size'];
            $file['name'] = $f['origin_name'];
            $file['uuid'] = $f['uuid'];
            $issue['attachment'][] = $file;
        }
        unset($attachmentDatas);

        IssueFilterLogic::formatIssue($issue);

        $userLogic = new UserLogic();
        $users = $userLogic->getAllUser();

        $emptyObj = new \stdClass();

        if (empty($issue['assistants_arr'])) {
            $issue['assistants_info_arr'] = [];
        } else {
            foreach ($issue['assistants_arr'] as $assistantUserId) {
                $issue['assistants_info_arr'][] = $users[$assistantUserId];
            }
        }


        $issue['assignee_info'] = isset($users[$issue['assignee']])?$users[$issue['assignee']]:$emptyObj;

        $issue['reporter_info'] = isset($users[$issue['reporter']])?$users[$issue['reporter']]:$emptyObj;

        $issue['modifier_info'] = isset($users[$issue['modifier']])?$users[$issue['modifier']]:$emptyObj;

        $issue['creator_info'] = isset($users[$issue['creator']])?$users[$issue['creator']]:$emptyObj;


        $issue['master_info'] = new \stdClass();
        if (!empty($issue['master_id'])) {
            $masterInfo = $issueModel->getById($issue['master_id']);
            if (!empty($masterInfo)) {
                $masterInfo['show_title'] = mb_substr(ucfirst($masterInfo['summary']), 0, 20, 'utf-8');
                $issue['master_info'] = $masterInfo;
            }
        }

        $wfLogic = new WorkflowLogic();
        $issue['allow_update_status'] = $wfLogic->getStatusByIssue($issue);

        $issueResolveModel = new IssueResolveModel();
        $allResolveArr = $issueResolveModel->getAll(true);
        if (isset($allResolveArr[$issue['resolve']])) {
            unset($allResolveArr[$issue['resolve']]);
        }
        sort($allResolveArr);
        $issue['allow_update_resolves'] = $allResolveArr;

        // 当前用户是否关注
        $followModel = new IssueFollowModel();
        $followRow = $followModel->getItemsByIssueUserId($issueId, UserAuth::getId());
        $issue['followed'] = empty($followRow) ? '0' : '1';

        $followRows = $followModel->getItemsByIssueId($issueId);
        $issue['followed_users_arr'] = [];
        $issue['followed_users_info_arr'] = [];
        if ($followRows) {
            foreach ($followRows as $item) {
                $issue['followed_users_arr'][] = $item['user_id'];
                $issue['followed_users_info_arr'][] = $users[$item['user_id']];
            }
        }
        $issue['followed_users_arr'] = array_unique($issue['followed_users_arr']);
        unset($followModel);

        // 自定义字段
        $issueLogic = new IssueLogic();
        $issue['custom_field_values'] = $issueLogic->getCustomFieldValue($issueId);

        // 子任务
        $issue['child_issues'] = $issueLogic->getChildIssue($issueId);
        //IssueFilterLogic::formatIssue($issue);

        $data['issue'] = $issue;

        //下一个 上一个事项
        $data['next_issue_id'] = 0;
        $data['prev_issue_id'] = 0;
        list($ret, $nextId) = $issueLogic->getNextIssueId($issueId, $issueModel);
        if ($ret) {
            $data['next_issue_id'] = (int)$nextId;
        }
        list($ret, $prevId) = $issueLogic->getPrevIssueId($issueId, $issueModel);
        //var_export($prevId);
        if ($ret) {
            $data['prev_issue_id'] = (int)$prevId;
        }

        return $data;
    }


    /**
     * @return array|void
     * @throws \Doctrine\DBAL\DBALException
     */
    private function filter()
    {
        $issueFilterLogic = new IssueFilterLogic();

        $pageSize = 20;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);
        if (isset($_GET['page'])) {
            $page = max(1, intval($_GET['page']));
        }
        if (isset($_GET['fav_filter'])) {
            $favFilterId = $_GET['fav_filter'];
            $filterModel = IssueFilterModel::getInstance();
            $favArr = $filterModel->getRowById($favFilterId);
            if ($favArr['is_adv_query']=='1') {
                $_GET['adv_query_json'] = $favArr['filter'];
                $this->advFilter();
                return;
            }

        }
        list($ret, $data['issues'], $total) = $issueFilterLogic->getList($page, $pageSize);

        return ['data' => $data, 'total' => $total, 'page' => $page, 'page_size' => $pageSize];
    }
}
