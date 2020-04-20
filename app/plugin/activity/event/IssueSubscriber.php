<?php

namespace main\app\plugin\activity\event;

use main\app\event\CommonPlacedEvent;
use main\app\model\ActivityModel;
use main\app\model\agile\SprintModel;
use main\app\model\issue\IssueModel;
use main\app\model\issue\IssuePriorityModel;
use main\app\model\issue\IssueResolveModel;
use main\app\model\issue\IssueStatusModel;
use main\app\model\issue\IssueTypeModel;
use main\app\model\project\ProjectModuleModel;
use main\app\model\user\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use main\app\event\Events;
use main\app\classes\UserAuth;

/**
 * 接收事项的事件
 * Class IssueSubscriber
 */
class IssueSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::onIssueCreateBefore => 'onIssueCreateBefore',
            Events::onIssueCreateAfter => 'onIssueCreateAfter',
            Events::onIssueCreateChild => 'onIssueCreateChild',
            Events::onIssueUpdateBefore => 'onIssueUpdateBefore',
            Events::onIssueUpdateAfter => 'onIssueUpdateAfter',
            Events::onIssueDelete => 'onIssueDelete',
            Events::onIssueClose => 'onIssueClose',
            Events::onIssueFollow => 'onIssueFollow',
            Events::onIssueUnFollow => 'onIssueUnFollow',
            Events::onIssueConvertChild => 'onIssueConvertChild',
            Events::onIssueBatchDelete => 'onIssueBatchDelete',
            Events::onIssueBatchUpdate => 'onIssueBatchUpdate',
            Events::onIssueImportByExcel => 'onIssueImportByExcel',
            Events::onIssueRemoveChild => 'onIssueRemoveChild',
            Events::onIssueJoinSprint => 'onIssueJoinSprint',
            Events::onIssueJoinClose => 'onIssueJoinClose',
            Events::onIssueJoinBacklog => 'onIssueJoinBacklog',
            Events::onIssueAddAdvFilter => 'onIssueAddAdvFilter',
            Events::onIssueAddFilter => 'onIssueAddFilter',
            Events::onIssueAddComment => 'onIssueAddComment',
            Events::onIssueDeleteComment => 'onIssueDeleteComment',
            Events::onIssueUpdateComment => 'onIssueUpdateComment',
            Events::onIssueUpload => 'onIssueUpload',
            Events::onIssueMobileUpload => 'onIssueMobileUpload',
            Events::onIssueDeleteUpload => 'onIssueDeleteUpload',

        ];
    }


    /**
     * 生成事项活动日志的活动名称
     *
     * @param $fromModule string 来源操作模块
     * @return string
     */
    private function makeActionInfo($fromModule)
    {
        // 生成日志备注详情
        $moduleNames = [
            'issue_list' => '事项列表',
            'issue_detail' => '事项详情',
            'gantt' => '甘特图',
            'mind' => '事项分解',
            'kanban' => '看板',
            'sprint' => '迭代',
            'backlog' => '待办事项'
        ];

        $actionInfo = "修改事项";
        if ($fromModule && isset($moduleNames[$fromModule]) && !in_array($fromModule, ['issue_list', 'issue_detail'])) {
            $moduleName = $moduleNames[$fromModule];
            $actionInfo = "在 \"{$moduleName}\" 模块中修改事项";
        }

        return $actionInfo;
    }

    /**
     * 组装事项活动日志的备注信息
     *
     * @param $issueOldValues
     * @param $issueNewValues
     * @return string
     * @throws \Exception
     */
    private function makeActionContent($issueOldValues, $issueNewValues)
    {
        $fieldLabels = [
            'issue_type' => '事项类型',
            'priority' => '优先级',
            'module' => '模块',
            'summary' => '标题',
            'assignee' => '经办人',
            'status' => '状态',
            'resolve' => '解决结果',
            'start_date' => '开始日期',
            'due_date' => '结束日期',
            'assistants' => '协助人'
        ];

        $fields = array_keys($fieldLabels);

        $userModel = new UserModel();
        $users = $userModel->getAll();

        $issueTypeModel = new IssueTypeModel();
        $types = $issueTypeModel->getAll();

        $issuePriorityModel = new IssuePriorityModel();
        $priorities = $issuePriorityModel->getAll();

        $projectModuleModel = new ProjectModuleModel();
        $modules = $projectModuleModel->getByProject($issueOldValues['project_id'], true);

        $issueStatusModel = new IssueStatusModel();
        $status = $issueStatusModel->getAll();

        $issueResolveModel = new IssueResolveModel();
        $resolves = $issueResolveModel->getAll();

        $changes = [];
        foreach ($issueNewValues as $field => $issueNewValue) {
            if (in_array($field, $fields)) {
                $issueOldValue = $issueOldValues[$field];
                if ($issueNewValue != $issueOldValue) {
                    if ($field == 'assignee' || $field == 'assistants') {
                        $issueNewValue = isset($users[$issueNewValue]) ? '<span style="color:#337ab7">' . $users[$issueNewValue]['display_name'] . '</span>' : '<span>未分配</span>';
                        $issueOldValue = isset($users[$issueOldValue]) ? '<span style="color:#337ab7">' . $users[$issueOldValue]['display_name'] . '</span>' : '<span>未分配</span>';
                    } elseif ($field == 'issue_type') {
                        $issueNewValue = isset($types[$issueNewValue]) ? '<span style="color:#337ab7">' . $types[$issueNewValue]['name'] . '</span>' : '<span>无</span>';
                        $issueOldValue = isset($types[$issueOldValue]) ? '<span style="color:#337ab7">' . $types[$issueOldValue]['name'] . '</span>' : '<span>无</span>';
                    } elseif ($field == 'priority') {
                        $issueNewValue = isset($priorities[$issueNewValue]) ? '<span style="color:' . $priorities[$issueNewValue]['status_color'] . '">' . $priorities[$issueNewValue]['name'] . '</span>' : '<span>无</span>';
                        $issueOldValue = isset($priorities[$issueOldValue]) ? '<span style="color:' . $priorities[$issueOldValue]['status_color'] . '">' . $priorities[$issueOldValue]['name'] . '</span>' : '<span>无</span>';
                    } elseif ($field == 'module') {
                        $issueNewValue = isset($modules[$issueNewValue]) ? '<span style="color:#337ab7">' . $modules[$issueNewValue]['name'] . '</span>' : '<span>无</span>';
                        $issueOldValue = isset($modules[$issueOldValue]) ? '<span style="color:#337ab7">' . $modules[$issueOldValue]['name'] . '</span>' : '<span>无</span>';
                    } elseif ($field == 'status') {
                        $issueNewValue = isset($status[$issueNewValue]) ? '<span class="label label-' . $status[$issueNewValue]['color'] . '">' . $status[$issueNewValue]['name'] . '</span>' : '<span>无</span>';
                        $issueOldValue = isset($status[$issueOldValue]) ? '<span class="label label-' . $status[$issueOldValue]['color'] . '">' . $status[$issueOldValue]['name'] . '</span>' : '<span>无</span>';
                    } elseif ($field == 'resolve') {
                        $issueNewValue = isset($resolves[$issueNewValue]) ? '<span style="color:' . $resolves[$issueNewValue]['color'] . '">' . $resolves[$issueNewValue]['name'] . '</span>' : '<span>无</span>';
                        $issueOldValue = isset($resolves[$issueOldValue]) ? '<span style="color:' . $resolves[$issueOldValue]['color'] . '">' . $resolves[$issueOldValue]['name'] . '</span>' : '<span>无</span>';
                    } elseif ($field == 'start_date' || $field == 'due_date') {
                        $issueNewValue = trim($issueNewValue);
                        if (!$issueNewValue && (!$issueOldValue || ($issueOldValue == '0000-00-00'))) {
                            continue;
                        }

                        $issueNewValue = $issueNewValue ? '<span style="color:#337ab7">' . $issueNewValue . '</span>' : '<span>无</span>';
                        if ($issueOldValue && ($issueOldValue != '0000-00-00')) {
                            $issueOldValue = '<span style="color:#337ab7">' . $issueOldValue . '</span>';
                        } else {
                            $issueOldValue = '<span>无</span>';
                        }
                    } else {
                        $issueNewValue = '<span style="color:#337ab7">' . $issueNewValue . '</span>';
                        $issueOldValue = '<span style="color:#337ab7">' . $issueOldValue . '</span>';
                    }

                    $change = $fieldLabels[$field] . '：' . $issueOldValue . ' --> ' . $issueNewValue;
                    if ($field == 'summary') {
                        $change = '标题 变更为 ' . $issueNewValue;
                    }
                    $changes[] = $change;
                }
            }
        }

        if ($changes) {
            return join('，', $changes);
        } else {
            return '';
        }
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueCreateBefore(CommonPlacedEvent $event)
    {
        // ...
        // var_dump($event);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueCreateAfter(CommonPlacedEvent $event)
    {
        $info = $event->pluginDataArr;
        $activityInfo = [];
        $activityInfo['action'] = '创建了事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $info['id'];
        $activityInfo['title'] = $info['summary'];
        (new ActivityModel())->insertItem(UserAuth::getId(), $info['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueCreateChild(CommonPlacedEvent $event)
    {
        $master = $event->pluginDataArr['master'];
        $child = $event->pluginDataArr['child'];
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '创建了 #' . $master['issue_num'] . ' 的子任务';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $master['id'];
        $activityInfo['title'] = $child['summary'];
        $activityModel->insertItem($currentUid, $master['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueUpdateBefore(CommonPlacedEvent $event)
    {
        // 不记录活动日志
    }


    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueUpdateAfter(CommonPlacedEvent $event)
    {
        $info = $event->pluginDataArr;
        // 使用 post 取不到
        $params = $_REQUEST['params'];
        // 记录活动日志
        $fromModule = null;
        if (isset($params['from_module'])) {
            $fromModule = strtolower(trim($params['from_module']));
        } elseif (isset($_GET['from_module'])) {
            $fromModule = strtolower(trim($_GET['from_module']));
        }
        $actionInfo = $this->makeActionInfo($fromModule);
        $issue = (new IssueModel())->getById($info['id']);
        $actionContent = $this->makeActionContent($issue, $info);

        $currentUid = UserAuth::getId();
        $activityInfo = [];
        $activityInfo['action'] = $actionInfo;
        $activityInfo['content'] = $actionContent;
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $info['id'];
        $activityInfo['title'] = $issue['summary'];
        (new ActivityModel())->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueDelete(CommonPlacedEvent $event)
    {
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $event->pluginDataArr['id'];
        $activityInfo['title'] = $event->pluginDataArr['summary'];
        $activityModel->insertItem($currentUid, $event->pluginDataArr['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueClose(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '关闭了事项:' . $issue['summary'];
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueFollow(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '关注了事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueUnFollow(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '取消关注事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueConvertChild(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr['issue_id'];
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '转为子任务';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueBatchDelete(CommonPlacedEvent $event)
    {
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '批量删除了事项: ';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = json_encode($event->pluginDataArr['issue_id_arr']);
        $activityInfo['title'] = $event->pluginDataArr['title'];
        $activityModel->insertItem($currentUid, $event->pluginDataArr['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueBatchUpdate(CommonPlacedEvent $event)
    {
        $issueIdArr = $event->pluginDataArr['issue_id_arr'];
        $projectId = $event->pluginDataArr['project_id'];
        $field = $event->pluginDataArr['field'];
        $value = $event->pluginDataArr['value'];
        $info = [];
        $activityModel = new ActivityModel();

        // 获取模块、迭代、解决结果等的动态名称
        $getModuleOrSprintName = function ($field, $value) {
            $name = '';
            if ($field === 'module') {
                //获取模块名称
                $statusName = ProjectModuleModel::getInstance()->getById($value);
                $name = '模块:' . $statusName["name"];
            }
            if ($field === 'sprint') {
                //获取迭代名称
                $ResolveName = SprintModel::getInstance()->getById($value);
                $name = '迭代:' . $ResolveName["name"];
            }
            if ($field === 'resolve') {
                $ResolveName = IssueResolveModel::getInstance()->getById($value);
                $name = '解决结果:' . $ResolveName["name"];
            }
            return $name;
        };
        foreach ($issueIdArr as $issueId) {
            $info[$field] = $value;
            $currentUid = UserAuth::getId();
            $activityAction = $getModuleOrSprintName($field, $value);
            $activityInfo = [];
            $activityInfo['action'] = '批量更新事项';
            $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
            $activityInfo['obj_id'] = $issueId;
            $activityInfo['title'] = $activityAction;
            $activityModel->insertItem($currentUid, $projectId, $activityInfo);
        }
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueImportByExcel(CommonPlacedEvent $event)
    {
        $successRows = $event->pluginDataArr;
        $activityModel = new ActivityModel();
        foreach ($successRows as $issue) {
            $currentUid = UserAuth::getId();
            $activityInfo = [];
            $activityInfo['action'] = '批量导入事项';
            $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
            $activityInfo['obj_id'] = $issue['id'];
            $activityInfo['title'] = $issue['summary'];
            $projectId = (int)@$_REQUEST['project_id'];
            if (isset($issue['project_id'])) {
                $projectId = $issue['project_id'];
            }
            $activityModel->insertItem($currentUid, $projectId, $activityInfo);
        }
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueRemoveChild(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '取消了子任务';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueJoinSprint(CommonPlacedEvent $event)
    {

        $issueId = $event->pluginDataArr['issue_id'];
        $sprint = $event->pluginDataArr['sprint'];
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '加入迭代';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'] . '-->' . $sprint['name'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueJoinClose(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr['issue_id'];
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '加入“已关闭”事项';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueJoinBacklog(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr['issue_id'];
        $issue = IssueModel::getInstance()->getById($issueId);
        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '加入“待办事项”';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $issue['summary'];
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueAddAdvFilter(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     */
    public function onIssueAddFilter(CommonPlacedEvent $event)
    {

    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueAddComment(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr['issue_id'];
        $currentUid = UserAuth::getId();
        $issue = IssueModel::getInstance()->getById($issueId);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '为' . $issue['summary'] . '添加了评论 ';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
        $activityInfo['obj_id'] = $event->pluginDataArr['id'];
        $issueId = $issue['id'];
        $summary = $issue['summary'];
        $activityInfo['title'] = "<a href='/issue/detail/index/{$issueId}' >{$summary}</a>";
        $activityInfo['content'] = $event->pluginDataArr['content_html'] ;

        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueDeleteComment(CommonPlacedEvent $event)
    {
        $timeline = $event->pluginDataArr;
        $currentUid = UserAuth::getId();
        $issue = IssueModel::getInstance()->getById($timeline['issue_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '删除了评论 ';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
        $activityInfo['obj_id'] = $timeline['id'];
        $activityInfo['title'] = $timeline['content'];
        $issueId = $issue['id'];
        $summary = $issue['summary'];
        $activityInfo['title'] = "<a href='/issue/detail/index/{$issueId}' >{$summary}</a>";
        $activityInfo['content'] = $timeline['content_html'] ;
        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueUpdateComment(CommonPlacedEvent $event)
    {
        $timeline = $event->pluginDataArr;
        $currentUid = UserAuth::getId();
        $issue = IssueModel::getInstance()->getById($timeline['issue_id']);
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = '更新了评论 ';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE_COMMIT;
        $activityInfo['obj_id'] = $timeline['id'];

        $issueId = $issue['id'];
        $summary = $issue['summary'];
        $activityInfo['title'] = "<a href='/issue/detail/index/{$issueId}' >{$summary}</a>";
        $activityInfo['content'] = $timeline['content_html'];

        $activityModel->insertItem($currentUid, $issue['project_id'], $activityInfo);
        unset($issue);
    }


    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueUpload(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;

        $summary = '';
        if (isset($_REQUEST['summary']) && !empty($_REQUEST['summary'])) {
            $summary = $_REQUEST['summary'];
        } else {
            if (!empty($issueId)) {
                $summary = IssueModel::getInstance()->getField('summary', ['id' => $issueId]);
            }
        }

        $originName = '';
        if (isset($_REQUEST['qqfilename'])) {
            $originName = $_REQUEST['qqfilename'];
        }
        $preAction = '';
        if ($summary != '') {
            $preAction = '为 ' . $summary;
        }

        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $activityInfo['action'] = $preAction . ' 添加了一个附件';;
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $originName;
        $activityModel->insertItem($currentUid, $issueId, $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueMobileUpload(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;

        $summary = '';
        if (isset($_REQUEST['summary']) && !empty($_REQUEST['summary'])) {
            $summary = $_REQUEST['summary'];
        } else {
            if (!empty($issueId)) {
                $summary = IssueModel::getInstance()->getField('summary', ['id' => $issueId]);
            }
        }

        $originName = '';
        if (isset($_REQUEST['qqfilename'])) {
            $originName = $_REQUEST['qqfilename'];
        }

        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $preAction = '';
        if ($summary != '') {
            $preAction = '为 ' . $summary;
        }
        $activityInfo['action'] = $preAction . ' 添加了一个附件';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $originName;
        $activityModel->insertItem($currentUid, $issueId, $activityInfo);
    }

    /**
     * @param CommonPlacedEvent $event
     * @throws \Exception
     */
    public function onIssueDeleteUpload(CommonPlacedEvent $event)
    {
        $issueId = $event->pluginDataArr;

        $summary = '';
        if (isset($_REQUEST['summary']) && !empty($_REQUEST['summary'])) {
            $summary = $_REQUEST['summary'];
        } else {
            if (!empty($issueId)) {
                $summary = IssueModel::getInstance()->getField('summary', ['id' => $issueId]);
            }
        }

        $originName = '';
        if (isset($_REQUEST['qqfilename'])) {
            $originName = $_REQUEST['qqfilename'];
        }

        $currentUid = UserAuth::getId();
        $activityModel = new ActivityModel();
        $activityInfo = [];
        $preAction = '';
        if ($summary != '') {
            $preAction = '为 ' . $summary;
        }
        $activityInfo['action'] = $preAction . ' 删除附件';
        $activityInfo['type'] = ActivityModel::TYPE_ISSUE;
        $activityInfo['obj_id'] = $issueId;
        $activityInfo['title'] = $originName;
        $activityModel->insertItem($currentUid, $issueId, $activityInfo);
    }

}